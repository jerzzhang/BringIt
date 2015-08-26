<?php

require_once __DIR__.'/includes/all.php';

$cookies = new Cookies();
$user    = $cookies->user_from_cookie();
if ($user === 0) {
	header("Location: /index.php?m=9");
    exit;
}
$permission = $user->data["permission"];
if ($permission < 2) {
	header("Location: /index.php?m=9");
    exit;
}
$cookies->renew_cookie($user->id);
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
        <script src="js/featherlight.js"></script>
		<script src="js/init.js"></script>
        <script src="js/cam.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/admin.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
        <link rel="stylesheet" href="css/flightbox.css">
        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
			<header id="header-admin">
				<h1><a href="index.php"><?php echo getSetting("sitename"); ?></a></h1>
				<nav id="nav">
					<ul>
						<li><a class="admin-name" href="#">Welcome, <?php echo displayCurrentUserName();?>!</a></li>
						<li class="special">
<!--							<a href="#" class="skel-layers-include icon fa-shopping-cart" data-action="toggleLayer" data-args="menuPanel"></a>-->
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
			<div id="orderContainer">
			<div id="admin-switch" class="section group">
                <div id="switch-left" class="col span_1_of_2">
                    <a href="admin.php"><span id="switch-underline">admin view</span></a>
                </div>
                <div id="switch-right" class="col span_1_of_2">
                    <a href="index.php"><span id="switch-underline">customer view</span></a>
                </div>
					</div>
				<div id="adminItems">
					<div id="adminSelections">
						<ul>
							<li id="sidebar-0">order feed</li>
							<li id="sidebar-1">accounts</li>
							<li id="sidebar-2">schedule</li>
							<li id="sidebar-3">services</li>
							<li id="sidebar-4">analytics</li>
							<li id="sidebar-5">settings</li>
						</ul>
					</div>
				</div>
				<div id="adminPanel">
                    <div id="panel-0">
                        <div id="admin-bar">
                            <?php
                                echo displayAdminOrderFeedFilters();
                            ?>
                        </div>
                        <div id="order-feed">
                             <!--empty until jquery fills it with ajax post results-->
                        </div>
                    </div>
                    <div id="panel-1">
                        <div id="account-table" class="table-wrapper">
                            <table>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Permissions</th>
                                    <th>Service Access</th>
                                </tr>
                                </thead>
                                <tbody>
<?php echo displayAdminAccountsPage();?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="panel-2">Coming Soon</div>
                    <div id="panel-3"><?php echo displayAdminServicesPage();?></div>
                    <div id="panel-4">Coming Soon</div>
                    <div id="panel-5"><?php displayAdminSettingsPage(); ?></div>
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
            $("#select_service_id").children("[value=<?php echo isset($sid) && $sid != "" ? $sid : 0; ?>]").prop("selected","selected")


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

    num_menu = 6

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
                echo sprintf("var message=\"%s\";", $messages[$_GET["m"]]);
            } else {
                echo "var message=null;";
            }
            if (isset($_GET["p"])) {
                echo sprintf("var page=\"%s\";", $_GET["p"]);
            } else {
                echo "var page=0;";
            }
            if (isset($_GET['sv'])){
                echo sprintf("var servedit=\"%s\";\n", $_GET["sv"]);
            }
            else{
                echo "var servedit=null\n";
            }
            echo "var permission=" . $permission . ";";
            echo 'var sdorder=' . $sorder . ";";

    ?>

    if (permission == 2){
        // employee
        var panels_v = [0,2];
    }
    if (permission == 3){
        var panels_v = [0,2,3];
    }
    if (permission == 4){
        var panels_v = [0,1,2,3,4,5];
    }
    for (var ip = 0; ip<num_menu; ip++){
        if (panels_v.indexOf(ip) == -1){
            $("#sidebar-{0}".format(ip)).remove()
            $("#panel-{0}".format(ip)).remove()
        }
    }

    if (page > num_menu || panels_v.indexOf(parseFloat(page)) == -1){
        page = 0
    }
    $("#panel-{0}".format(page)).show();


    $(".adminAccountsPermissionsSelect").children().eq(0).first().attr("selected", true)
    $(".adminAccountsServicesSelect").children().eq(0).first().attr("selected", true);

    function get_all_params(){
        params = {};
        $("#admin-bar div select").each(function (i,v){
            params[i] = $(v).children(":selected").val()
        })
        return params;
    }

    function drawOrderFeed(d){

    }

    $(document.body).on('change','#select_service_id', function(e){
        var sel = $(this).children("option:selected");
//        console.log(sel.val())
        if (sel.val() == "0"){return;}
        window.location = "admin.php?p=3&sid=" + sel.val()
    })

    $("#admin-bar div select").each(function(i,v){
        $(v).children().first().attr("selected",true);

        var orderFeed = function(e){
            params = get_all_params()
            $.post("/includes/admin/feed.php", params, function(data){
                if (data.result === 1){
                    var d = data.data;
                    $("#order-feed").empty();
                    $("#order-feed").append(d);
                }
            }, "json").fail(function(){
                $("#order-feed").empty()
            })
        };

        $(v).ready(orderFeed);
        $(v).change(orderFeed);
    })

    $(".adminAccountsServicesSelect, .adminAccountsPermissionsSelect").change(function(e){
        keys = {"Permissions":"permission", "Services":"service_id"}

        raw_value = $("option:selected", this).val().split("-")

        vkey = keys[$(this).attr("class").split("Accounts")[1].split("Select")[0]]
        uuid = raw_value[0]
        value = raw_value[1]

        params = {key: vkey, uid: uuid, newval: value}
        $.post("/includes/accounts/exec-admin-change-account.php", params, function(data){})
    })


    // change setting
    $(".ulform").each(function(i){
        var name = $(this).attr("id").split("-")[1]
        $(this).children('input[name=name]').val(name);
    })

    $(".setting-save-text").on('click', function(e){
        var parent = $(this).parent()
        var name = $(parent).attr("id").split("-")[1]
        var value = $(parent).children(".setting-value-input").val()
        changeSettingText(name, value)
    })
    function changeSettingText(name, value){
        params = {"name":name, "value":value, type:"1"};
        $.post("includes/accounts/exec-admin-change-setting.php", params, changeSettingCallbackText, "json");
    }

    function changeSettingCallbackText(data){
        if (data.result == 1){
            var name = data.data.name;
            var value = data.data.value;
            $("#setting-{0}".format(name)).children(".setting-value").text(value);
            $("#setting-{0}".format(name)).children(".setting-value-input").val("")
        }
        if (data.result == 0){
            console.log("Message: " + data.message)
            console.log("Data: " + data.data)
        }
    }

    function openServiceEditMenu(servid){
        params = {"id":servid}
//        $.post("/service_edit.php", params, function(data){})
        $.featherlight("service_edit.php?id=" + servid)
    }

    if (servedit != null){
        openServiceEditMenu(servedit)
    }

    // add / modify service callbacks
    $("#addService").on('click', function(e){
//        openServiceEditMenu(-1)
        var srv_id = parseInt($("#select_service_id :selected").val())
//        console.log(srv_id)
        openServiceEditMenu(-1 * srv_id)
    })
    $(".col.gen_1_of_3").on('click', function(e){
        openServiceEditMenu($(this).prop('id').split('-')[1])
    })

    $('#category-save').click(function(e) {
        var catId = $('.general-info input[name="category_id"]').val();
        var name = $('#general-select input[name="sitename"]').val();
        var active = $('#active-check input[name="active"]').prop('checked') ? '1' : '0';
        var displayorder= $('#placement-select select').val();

        var params = {
            'name': name,
            'active': active,
            'displayorder': displayorder,
        };
        $.post('/admin/category/' + catId, params, function(err) {
            window.location = "admin.php?p=3&sid=" + catId;
        });
    });

    $('#category-new').click(function(e) {
        var name = $('#general-select input[name="sitename"]').val();
        var active = $('#active-check input[name="active"]').prop('checked') ? '1' : '0';

        var params = {
            'name': name,
            'active': active,
        };
        $.post('/admin/category', params, function(catId) {
            window.location = "admin.php?p=3&sid=" + catId;
        });
    });

    $('#category-delete').click(function(e) {
        var catId = $('.general-info input[name="category_id"]').val();

        $.post('/admin/category/' + catId + '/delete', params, function(err) {
            window.location = "admin.php?p=3";
        });
    });

</script>
	</body>
</html>
