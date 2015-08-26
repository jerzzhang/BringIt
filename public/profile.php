<?php

require_once __DIR__.'/includes/all.php';

$cookies = new Cookies();
$user    = $cookies->user_from_cookie();
if ($user === 0) {
	header("Location: /index.php");
    exit;
}
$address = $user->getAddress();

// retrieve credit cards
$credit_cards = array();
if ($user->data['stripe_cust_id']) {
    \Stripe\Stripe::setApiKey(env('STRIPE_API_SECRET'));

    if ($customer = \Stripe\Customer::retrieve($user->data['stripe_cust_id'])) {
        $credit_cards = $customer->sources->all(array('object' => 'card'))->data;
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title> </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.scrolly.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/cam.js"></script>
    <script src="js/featherlight.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
    <link rel="stylesheet" type="text/css" href="assets/css/paymentInfo.css">
    <link rel="stylesheet" href="css/flightbox.css">

    <!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey('<?php echo (getenv('STRIPE_API_PUBLISH') ? getenv('STRIPE_API_PUBLISH') : ''); ?>');
    </script>
</head>
<body>

<!-- Header -->
<header id="header-admin">
    <h1><a href="index.php"><?php echo getSetting("sitename");?></a></h1>
    <nav id="nav">
        <ul>

            <li><a class="admin-name" href="#">Welcome, <?php echo $user->data["name"];?>!</a></li>
            <li class="special">
<!--                <a href="#" id="my-favorites-button" class="skel-layers-include" data-action="toggleLayer" data-args="menuPanel">Favorite Orders</a>-->
                <div id="menuPanel-content">
                    <table class="alt">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Service</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>x</td>
                            <td>Food Factory</td>
                            <td>Food Choice</td>
                            <td>29.99</td>
                            <td>
                                <form id='myform' method='POST' action='#'>
                                    <input type='button' value='-' class='qtyminus' field='quantity'>
                                    <input type='text' name='quantity' value='0' class='qty'>
                                    <input type='button' value='+' class='qtyplus' field='quantity'>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <ul class="actions vertical">
                        <li><a href="#" class="button place">Place Order</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</header>

<!-- Main -->
<div id="orderContainer">
    <div id="adminItems">
        <div id="adminSelections">
            <ul>
                <li id="sidebar-0">Details</li>
                <li id="sidebar-1">History</li>
                <li id="sidebar-2">Address</li>
            </ul>
        </div>
    </div>
    <div id="adminPanel">
        <div id="panel-0">
            <div id="admin-restaurants">
<!--                <span id="restaurant-title">Account</span>-->
            </div>
<!--            <br><br>-->
            <div id="user-details">
                <form action="/includes/accounts/exec-change-userinfo.php" method="POST">
                    <!---     $vars = array("firstname","lastname","email","oldpass","newpass","newpassconf");-->
                    <legend>User Information</legend>
                    <input type="text" id="account-firstname" name="wholename" placeholder="<?php echo "Name: " . $user->data["name"]?>">
                    <input type="text" id="account-email" name="email" placeholder="<?php echo "Email: " . $user->data["email"]?>">
                    <br>
                    <input type="password" id="account-newpassword" name="newpass" placeholder="New Password">
                    <input type="password" id="account-newpasswordconf" name="newpassconf" placeholder="Confirm Password">
                    <br><legend>Required</legend><br>
                    <input type="password" id="account-password" name="oldpass" placeholder="Current Password">


                    <input class="account-submit" type="submit" value="Save">
                </form>
            </div>
            <div id="card-details">
                <form id="credit-card-delete" action="/credit-card/delete" method="post">
                    <fieldset class="credit-card-group">
                        <legend>Credit Cards</legend>
<?php foreach ($credit_cards as $credit_card): ?>
                        <p>
                            <?php echo $credit_card->brand; ?> <?php echo $credit_card->funding; ?> <?php echo $credit_card->object; ?> (XXXX <?php echo $credit_card->last4; ?>)
                            <button type="submit" data-credit-card-id="<?php echo $credit_card->id; ?>">Delete</button>
                        </p>
<?php endforeach; ?>
                    </fieldset>
                </form>

                <form id="credit-card-add" action="/credit-card/save" method="post">
                    <fieldset class="credit-card-group">
                        <legend>Add New Credit Card</legend>
                        <label for="card-number">Credit Card Number</label>
                        <input placeholder="1234 5678 9012 3456" maxlength="16" pattern="[0-9]*" type="text" class="card-number" id="card-number" data-stripe="number">
                        <label for="card-number">Expiration Date</label>
                        <select data-stripe="exp-month">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <select data-stripe="exp-year">
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                        <label for="card-number">CVV Number</label>
                        <input placeholder="CVV" pattern="[0-9]*" type="text" class="card-cvv" id="card-cvv" data-stripe="cvc">

                        <br>
                        <input type="submit" value="Save">
                        <br>
                        <span class="payment-errors"></span>
                    </fieldset>
                </form>
            </div>
        </div>
        <div id="panel-1"><?php include_once "includes/accounts/exec-get-order-history.php";?></div>
        <div id="panel-2">
            <div id="user-details">
                <form action="/includes/accounts/exec-add-address.php" method="POST">
                    <!---     $vars = array("firstname","lastname","email","oldpass","newpass","newpassconf");-->
                    <legend>Delivery Information</legend>
                    <input type="hidden" name="redirect" value="<?php echo isset($_GET['return']) ? $_GET['return'] : ''; ?>">
                    <input type="text" id="account-firstname" name="address" placeholder="<?php echo $address["street"] ? "Street: " . $address["street"] : "Address";  ?>">
                    <input type="text" id="account-email" name="apartment" placeholder="<?php echo $address["apartment"] ? "Apartment: " . $address["apartment"] : "Apartment #";  ?>">
                    <input type="text" id="account-email" name="city" placeholder="<?php echo $address["city"] ? "City: " . $address["city"] : "City";  ?>">
                    <input type="text" id="account-email" name="state" placeholder="<?php echo $address["state"] ? "State: " . $address["state"] : "State";  ?>">
                    <input type="text" id="account-email" name="zipcode" placeholder="<?php echo $address["zip"] ? "ZIP: " . $address["zip"] : "Zip Code";  ?>">
                    <input class="account-submit" type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>
    <footer>
        <div id="footerLinks">
            <a href="mailto:info@gobring.it">about</a>
            <a href="mailto:info@gobring.it">terms</a>
            <a href="mailto:info@gobring.it">help</a>
            <a href="mailto:info@gobring.it">jobs</a>
            <a href="mailto:info@gobring.it">press</a>
        </div>
        <div id="footerCopyright">
            <a href="mailto:info@gobring.it">copyright 2015 <span style="text-decoration:underline;">campus enterprises</span></a>
        </div>
    </footer>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tb1').hide();
        $('#bt1').click(function() {
            $('#tb1').slideToggle("fast");
        });
        $('#tb2').hide();
        $('#bt2').click(function() {
            $('#tb2').slideToggle("fast");
        });
        $('#tb3').hide();
        $('#bt3').click(function() {
            $('#tb3').slideToggle("fast");
        });
    });

    num_menu = $("#adminSelections ul").children("li").length

    for (i=0; i<num_menu; i++){
        $("#panel-{0}".format(i)).hide();
        $("#sidebar-{0}".format(i)).on('click', function (e){
//        $("#menuApps #sectionTitle").text($(this).text())
            for (j=0; j<num_menu; j++){
                if (j != (this).id.split("-")[1]){ // hide all else
                    $("#panel-{0}".format(j)).hide();
                }
                else{
                    $("#panel-{0}".format(j)).show();
                }
            }})
    }




<?php
if (isset($_GET["m"])) {
            echo sprintf("var message=\"%s\";\n", $_GET["m"]);
        } else {
            echo "var message=null;\n";
        }
if (isset($_GET["p"])) {
	echo sprintf("var page=\"%s\";", $_GET["p"]);
} else {
	echo "var page=0;\n";
}
?>
    if (page > num_menu){
        page = 0
    }
    $("#panel-{0}".format(page)).show();

    //     if (message != null){
    //         alert(message);
    //     }
    if (message != null){
//        config = {root:"#orderContainer"}
        $.featherlight("message.php?msg=" + message);
    }

</script>
<script src="assets/scripts/libs/jquery.inputmask.js"></script>
<script src="assets/scripts/libs/jquery.inputmask.date.extensions.js"></script>
<script>
    jQuery(document).ready(function(){
        // This button will increment the value
        $('.qtyplus').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('field');
            // Get its current value
            var currentVal = parseInt($('input[name='+fieldName+']').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $('input[name='+fieldName+']').val(currentVal + 1);
            } else {
                // Otherwise put a 0 there
                $('input[name='+fieldName+']').val(0);
            }
        });
        // This button will decrement the value till 0
        $(".qtyminus").click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('field');
            // Get its current value
            var currentVal = parseInt($('input[name='+fieldName+']').val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 0) {
                // Decrement one
                $('input[name='+fieldName+']').val(currentVal - 1);
            } else {
                // Otherwise put a 0 there
                $('input[name='+fieldName+']').val(0);
            }
        });

        $('#credit-card-add').submit(function(event) {
            var $form = $(this);

            $form.find('.payment-errors').text('');
            $form.find('input[type="submit"]').prop('disabled', true);

            Stripe.card.createToken($form, function(status, response) {
                if (response.error) {
                    $form.find('.payment-errors').text(response.error.message);
                    $form.find('input[type="submit"]').prop('disabled', false);
                } else {
                    var token = response.id;
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                    $form.get(0).submit();
                }
            });

            return false;
        });

        $('#credit-card-delete button').click(function(event) {
            var card = $(this).data('credit-card-id');
            var $form = $('#credit-card-delete');
            $form.append($('<input type="hidden" name="credit-card-id" />').val(card));
            $form.get(0).submit();

            return false;
        });
    });
</script>
</body>
</html>
