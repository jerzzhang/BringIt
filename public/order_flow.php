<?php

require_once __DIR__.'/includes/all.php';

$vars = array("page","userid","carttype");
if (!set_vars($_GET, $vars)){
    echo '<script>$.featherlight.close(); //tryharder.jpg</script>';
}
$cookies = new Cookies();
$usr = $cookies->user_from_cookie();

$page = $_GET['page'];
$uid = $_GET['userid'];
$ctype = $_GET['carttype'];


$name = $usr->data['name'];
$email = $usr->data['email'];
$phone = $usr->data['phone'];
$has_addr = 0;
$total = 0;

if ($page === "1"){
    $address = $usr->getAddress();
    if ($address){
        $has_addr = 1;
        $changeaddr = sprintf("<p>
                    <a href='profile.php?p=2&return=1,%s,%s'>Change Address</a>
                </p>", $_GET["carttype"], $_GET["pid"]);
        $address_str = sprintf("%s (%s) <br>%s, %s. %s", $address["street"], $address["apartment"], $address["city"], $address["state"], $address["zip"]) . $changeaddr;
    }
    else{
        $has_addr = 0;
        $address_str = "You have no address saved, please visit <a href='profile.php?p=2'>your account</a> to add one";
    }

    $html = "<div data-remodal-id='modal2'>
              <h1>Place order (details)</h1>
              <div class='section group'>
                  <div class='col span_1_of_3 selected'><div class='step'>1. DETAILS</div></div>
                  <div class='col span_1_of_3'><div class='step'>2. PAYMENT</div></div>
                  <div class='col span_1_of_3'><div class='step'>3. CONFIRM</div></div>
              </div>
              <p>$name</p>
              <p>$email</p>
              <p>$phone</p>
              <p>$address_str</p><br>
              <a id='orderflow1_next' class='remodal-confirm' href='#'>NEXT</a>
            </div>
            ";
    echo $html;
}
$default_source = '';
$credit_cards = array();
if ($page === "2"){
    if ($usr->data['stripe_cust_id']) {
        \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET'));

        if ($customer = \Stripe\Customer::retrieve($usr->data['stripe_cust_id'])) {
            $default_source = $customer->default_source;
            $credit_cards = $customer->sources->all(array('object' => 'card'))->data;
        }
    }
?>
            <div data-remodal-id="modal2">
              <h1>Place Order (payment)</h1>
              <div class="section group">
                  <div class="col span_1_of_3"><div class="step">1. DETAILS</div></div>
                  <div class="col span_1_of_3 selected"><div class="step">2. PAYMENT</div></div>
                  <div class="col span_1_of_3"><div class="step">3. CONFIRM</div></div>
              </div>
              <br>
              <form id="payment_selection">
                  <p>
                      <input type="radio" id="payment_dc" name="payment" value="duke_card">
                      <label for="payment_dc">Duke Card</label>
                  </p>
<?php if (empty($credit_cards)): ?>
                  <p>You have no credit cards saved, please visit <a href="/profile.php">your account</a> to add one</p>
<?php endif; ?>
<?php foreach ($credit_cards as $credit_card): ?>
                  <p>
                      <input type="radio" id="payment_cc" name="payment" value="<?php echo $credit_card->id; ?>"<?php echo ($credit_card->id === $default_source ? ' checked': ''); ?>>
                      <label for="payment_cc">Credit Card (XXXX <?php echo $credit_card->last4; ?>)</label>
                  </p>
<?php endforeach; ?>
              </form>
              <div id="required"></div>
              <a id="orderflow2_next" class="remodal-confirm" href="#">NEXT</a>
            </div>
<?php
}
if ($page === "3"){
    $fmt = "
        <p>
            <div id='item1'>%(name)s<span id='item-price'> $%(tprice)s</span></div>
            <div>%(sidestr)s</div>
        </p>
    ";
    $minprice = DB::queryOneRow("SELECT * FROM category_items WHERE id=%s", $ctype);
    $minprice = floatval($minprice["minimum_price"]);

    $tcart = json_decode($usr->get_cart($ctype), true)["data"];
    $cart = $tcart["cart"];
    $order_html = htmlLoopNamed($cart, "", $fmt, "");
    foreach ($cart as $item){
        $total += $item["tprice"];
    }
    if (isset($item)){
        $total += floatval(DB::queryOneRow("SELECT * FROM category_items WHERE id=%s", $item["service_id"])["delivery_fee"]);
    }
    if ($total < $minprice){
        $validPrice = false;
    }
    else{
        $validPrice = true;
    }
    $total = strval(sprintf("%0.2f", $total));
    $minprice_f = sprintf("%0.2f",$minprice);
    $validPriceHTML = !$validPrice ? "<div>This order does not meet the minimum price of \$$minprice_f, please add more items to place your order</div>" : "";
    $button_text = $validPrice ? "CONFIRM ORDER" : "CONTINUE ORDERING";

    $html = "
        <div data-remodal-id='modal2'>
            <h1>Place order (confirm)</h1>
                  <div class='section group'>
                      <div class='col span_1_of_3'><div class='step'>1. DETAILS</div></div>
                      <div class='col span_1_of_3'><div class='step'>2. PAYMENT</div></div>
                      <div class='col span_1_of_3 selected'><div class='step'>3. CONFIRM</div></div>
                  </div>
            <p>
                <span id='my-order'>MY ORDER</span>
                $validPriceHTML
            </p>
            $order_html
            <p>
            <div id='total'>TOTAL <span id='total-price'>\$$total</span></div>
            </p>
            <br>
            <a id='orderflow3_next' href='#'>$button_text</a>
        </div>
    ";
    $payment = $_GET["payment"];
    echo $html;

}

if ($page === "4"){
    $html = "
        <div data-remodal-id='modal2'>
            <h1>Your order has been placed!</h1>
            <p>
                <img src='../images/checkmark.png' width='50%'>
            </p>
            <p>
                Be sure to check your email for confirmation.<br>Your delivery should arrive in about <b>40 MINUTES</b>
            </p>
            <br>
            <a id='orderflow4_close' class='remodal-confirm' href='#'>CLOSE</a>
        </div>
    ";
    echo $html;
}

?>

<script>
    var validprice = <?php echo isset($validPrice) ? json_encode($validPrice) : "false"; ?>;
    var getvars = <?php echo json_encode($_GET);?>;
    $("#orderflow1_next").on("click", function(e){
        var has_addr = <?php echo $has_addr; ?>;
        if (has_addr == 1){
            $.featherlight.close();
            $.featherlight("order_flow.php?page=2&userid={0}&carttype={1}".format(getvars["userid"], getvars["carttype"]))
        }
        else{
            $.featherlight("message.php?msg=10")
        }
    })
    $("#orderflow2_next").on("click", function(e){
        var payment = $("#payment_selection").serialize();
        if (payment == ""){
            // -.-
            $("#required").text("Selecting a payment option is required")
        }
        else{
            $.featherlight.close();
            $.featherlight("order_flow.php?page=3&userid={0}&carttype={1}&{2}".format(getvars["userid"], getvars["carttype"], payment))
        }
    })
    $("#orderflow3_next").on("click", function(e){
        params = {
            "uid":getvars["userid"],
            "cid":getvars["carttype"],
            "pmt":getvars["payment"],
            "amount":<?php echo $total * 100; ?>
        }
//        params_s = JSON.stringify(params)
        if (validprice){
            $.post("/includes/accounts/exec-place-order.php", params, function(data){
                $.featherlight.close()
                $.featherlight("order_flow.php?page=4&userid={0}&carttype={1}".format(getvars["userid"], getvars["carttype"]))
            })
        }
        else{
            $.featherlight.close();
        }
    })

    $("#orderflow4_close").on("click", function(e){
        $.featherlight.close();
    })

</script>
