<?php

require_once __DIR__.'/includes/all.php';

$vars = set_vars($_GET, array("type", "id"));
if (!$vars) {
	header("Location: /index.php");
    exit;
}
$cookies = new Cookies();
$user    = $cookies->user_from_cookie();
if ($user === 0) {
	header("Location: /index.php");
    exit;
}
$cookies->renew_cookie($user->id);
$user_id = $user->data["uid"];
$menu    = new Menu($_GET["type"], $_GET["id"]);
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
<!--        <script src="js/jquery.cookie.js"></script>-->

<!--        <script src="js/skel-layers.min.js"></script>-->
		<script src="js/init.js"></script>
        <script src="js/featherlight.js"></script>
        <script src="js/jquery.tooltipster.min.js"></script>
        <script src="js/cam.js"></script>
		<noscript>
            <link rel="stylesheet" href="css/skel.css" />
            <link rel="stylesheet" href="js/jquery.remodal.css">
            <link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
        </noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
        <link rel="stylesheet" href="css/flightbox.css">
        <link rel="stylesheet" href="css/tooltipster.css" />
        <link rel="stylesheet" href="css/themes/tooltipster-light.css" />

        <script>
            $(document).ready(function() {
//                $(".tooltip").tooltipster({
//                    theme:"tooltipster-light",
//                    positionTracker: true,
//                    delay:25,
//                    arrow:false,
//                    position:'bottom',
//                    maxWidth:200,
////                    offsetY:-35,
//                    offsetX:-80
//                })
            })
        </script>

    </head>
	<body>
		<!-- Header -->
			<header id="header">
				<h1><a href="index.php"><?php echo getSetting("sitename");?></a></h1>
				<nav id="nav">
					<ul>
                        <li><a href="profile.php"><?php echo displayCurrentUserName(); ?></a></li>
						<li><a href="profile.php">My Account</a></li>
						<li class="special">
							<a href="#" class="skel-layers-include icon fa-shopping-cart" data-action="toggleLayer" data-args="menuPanel"></a>
							<div id="menuPanel-content">
								<table class="alt">
								<thead>
									<tr>
										<th>Item Name</th>
										<th>Quantity</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Food Choice</td>
										<td>x1</td>
										<td>29.99</td>
									</tr>
									<tr>
										<td>Food Choice</td>
										<td>x1</td>
										<td>19.99</td>
									</tr>
									<tr>
										<td>Food Choice</td>
										<td>x1</td>
										<td>29.99</td>
									</tr>
									<tr>
										<td>Food Choice</td>
										<td>x1</td>
										<td>19.99</td>
									</tr>
									<tr>
										<td>Food Choice</td>
										<td>x1</td>
										<td>29.99</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2"></td>
										<td>100.00</td>
									</tr>
								</tfoot>
								</table>
								<ul class="actions vertical">
									<li><a href="#" class="button fit">Checkout</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</nav>
			</header>

		<!-- Main -->
		<div id="restCon">
			<div id="restName"><?php echo $menu->name?></div>
				<div id="openSign"><?php echo $menu->isOpen()?"OPEN":"CLOSED"?></div><br>
                <div id="description">
<?php echo $menu->description;?>
</div>
				<div id="type">
					<div class="section group">
						<div class="col span_type">
						    Type
						</div>
						<div class="col span_info">
<?php
echo $menu->type;
?>
</div>
				    </div>
				    <div id="hours">
					<div class="section group">
						<div class="col span_type">
						Hours
						</div>
						<div class="col span_info">
<?php
$hours = $menu->getHours();
if (empty($hours)) {
	echo "Not Specified";
} else {
    foreach ($hours as $hour) {
        echo $hour, "<br>\n";
    }
}
?>
</div>
<!--						<div class="col span_type">-->
<!--						&nbsp;-->
<!--						</div>-->
<!--						<div class="col span_info">-->
<!--						11pm - 2pm-->
<!--						</div>-->
				</div>
				</div>
			</div>
		</div>
			<div id="orderContainer">
				<div id="menuItems">
					<div id="sectionTitle">Menu</div>
					<div id="menuSelections">
                        <ul>
<?php
echo displayMenuCategories($menu);
?>
</ul>
					</div>
				</div>
				<div id="menuApps">
					<div id="sectionTitle">Appetizers</div>
					<div id="menuFoods">
					<ul>
<?php
echo displayAllMenuCategoryItems($menu);
?>
					</ul>
					</div>
				</div>
				<div id="myOrder">
					<div id="sectionTitle">My order</div>
					<ul id="subtotal-ul">

                    </ul>
    					<ul id="totalOrderPrice">
                        <li>
                            <span class="right" style="text-align: right;">&nbsp;
</span>
                            <span id="orderPriceDelivery" class="left" style="text-align: left;"><b>Delivery Fee</b></span>
                            <span id="orderPriceDeliverySpan" class="right" style="text-align: right;"><?php echo sprintf("%.02f", intval($menu->deliveryfee));
?></span>
                        </li>
    					<li>
							<span class="right" style="text-align: right;">&nbsp;
</span>
    					    <span id="orderPriceTotal" class="left" style="text-align: left;"><b>TOTAL</b></span>
    					    <span id="orderPriceSpan" class="right" style="text-align: right;">7.50</span>
    					</li>
						<li><a href="#" id="placeOrderButton" class="button special fit" style="width:80%;">PLACE ORDER</a></li>
						</ul>
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
    $("#restCon").css("background-image", "url('images/overlay.png'), url('http://i.imgur.com/ohvnBOJ.jpg')")

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
<?php
echo sprintf("numCategories=%d;", count($menu->get_categories()));
echo sprintf('userID="%s";', $user_id);
?>

    for (i=0; i<numCategories; i++){ // only show the first category
        $("#menucat-{0}".format(i)).hide();
        $("#cat-{0}".format(i)).on('click', function (e){
                $("#menuApps #sectionTitle").text($(this).text())
                $(".selected").removeClass("selected")
                $(this).addClass("selected")
                for (j=0; j<numCategories; j++){
                    if (j != (this).id.split("-")[1]){ // hide all else
                        $("#menucat-{0}".format(j)).hide();
                    }
                    else{
                        $("#menucat-{0}".format(j)).show();

                    }
                }})
    }
    $("#cat-0").addClass('selected'); // select first menu
    $("#menucat-0").show(); // show first menu pagex
    var getvars = <?php echo json_encode($_GET);
?>;
	var flow = getvars["flow"] || null;
	if (flow){
		resume_place_order_flow(flow);
	}


$(".menuItem").click( function(e){
    var id = $(this).attr("id").split("-item")[1];
    var config = {variant:"fixwidth"}
    $.featherlight("extras.php?itemid=" + id, config)
//    params = {"item":$(this).attr("id").split("-item")[1]}
//    $.post("/includes/accounts/exec-add-item-cart.php", params, add_cart_callback, "json")
});


    function add_cart_callback(data){
        init_price = 0;
        $("#subtotal-ul").empty(); //clear old results
        if (data.result == -1){return this;}
        var cart = data["data"]["cart"];
        for (i=0; i < cart.length; i++){
            item=cart[i];
            order_id = "order-item-" + item["id"].toString();
            name = item["name"]// + (item["quantity"] == 1 ? "" : " (" + item["quantity"].toString() + ") ");
            totalitemprice = parseFloat(item["price"])
            var span1 = $("<span>", {id: item["cid"], class: "right removeOrderItem", style: "text-align: left; font-family: ProximaNova-Light;"}).text("x");
            var span2 = $("<span>", {class: "left", style: "text-align: left;"}).text(name);
            var span3 = $("<span>", {class: "right", style: "text-align: right;"})
            var br = $("<br>");
            var sideswrapper = $("<div>", {class:"sideOrder"})
            sideswrapper.append($("<span>"))
            sides_str = ""
            sides = item["side"]
            sidesprice = 0
            for (j=0; j<sides.length; j++){
                side = sides[j];
                sideprice = parseFloat(side["price"]) * parseFloat(side["quantity"])
//                sides_str += " {0} ({1}), ".format(side["name"], side["quantity"]);
                sides_str += side["name"] + ", ";
                sidesprice += sideprice
            }
            sideswrapper.append($("<span>").text(sides_str.slice(0,-2)))
            totalitemprice += sidesprice
            span3.append($("<b>").text(totalitemprice.toFixed(2)));
            span1.click(function(e){
                params = {"item":$(this).attr("id")}
//                console.log(params)
                $.post("/includes/accounts/exec-del-item-cart.php", params, add_cart_callback, "json");
            });
            if (j == sides.length && j != 0){
                $("#subtotal-ul").append($("<li>").append(span1, span2, span3, sideswrapper));
            }
            else{
                $("#subtotal-ul").append($("<li>").append(span1, span2, span3));
            }
            init_price += totalitemprice
        }
        init_price += parseFloat(data["data"]["deliveryprice"])

        $("#orderPriceSpan").empty();
//        $("#orderPriceTotal").text("TOTAL + Delivery Fee ({0})".format(parseFloat(data["data"]["deliveryprice"]).toFixed(2)))
        $("#orderPriceSpan").append($("<span>").text(init_price.toFixed(2)));
    }


    params = {"cart_type":getvars["id"]};
    $.post("/includes/accounts/exec-get-cart.php", params, add_cart_callback, "json");

    $("#placeOrderButton").on("click", start_place_order_flow
//        params = {"cart_type":getvars["type"]};
//        $.post("/includes/accounts/exec-get-cart.php", params, start_place_order_flow, "json");
    );

    function start_place_order_flow(e){
        $.featherlight("order_flow.php?page=1&userid={0}&carttype={1}&pid={2}".format(userID, getvars["type"], getvars["id"]))
    }
	function resume_place_order_flow(page){
		$.featherlight("order_flow.php?page={0}&userid={1}&carttype={2}&pid={3}".format(page, userID, getvars["type"], getvars["id"]))

	}



</script>
	</body>
</html>
