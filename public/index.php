<?php

require_once __DIR__.'/includes/all.php';

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> </title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.scrolly.min.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/jquery.cookie.js"></script>

        <script src="js/skel-layers.min.js"></script>
        <script src="js/init.js"></script>
        <script src="js/featherlight.js"></script>
        <script src="js/cam.js"></script>
        <noscript>
			<link rel="stylesheet" href="css/skel.css" />
            <link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
        <link rel="stylesheet" href="js/jquery.remodal.css">
        <link rel="stylesheet" href="css/flightbox.css">

        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>

		<!-- Header -->
		<div class="remodal-bg">
			<header id="header">
				<h1><a href="index.php"><?php echo getSetting("sitename"); ?></a></h1>
				<nav id="nav">
					<ul>
                        <?php
                        echo displayMainPageAccountDetails();
                        ?>
                        <li class="special">
                            <?php  //echo displayFavoriteOrders(); ?>
							<div id="menuPanel-content">
								<table class="alt">
								<thead>
									<tr>
										<th>&nbsp;</th>
										<th>Item Name</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Select</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>x</td>
										<td>Food Choice</td>
										<td>x1</td>
										<td>29.99</td>
										<td>
											<input type="checkbox" id="copy" name="copy">
											<label class="fave-check" for="copy"></label>
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

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h2>YOU ORDER, WE BRING IT</h2>
					<h3>Food, groceries, cleaning, laundry, all right to you.</h3>
					<div id="whatchawant">What would you like?</div>

					<div id="blank-right"></div>
					<div id="home-tab">
<?php
echo displayMainPageCategories(Category::getCategories());
?>
</div>
					<div id="blank-left"></div>

					<div id="shadow-right"></div>
					<div id="home-select">
<?php
echo displayAllMainPageCategoryItems();
?>
</div>
					<div id="shadow-left"></div>
				</div>
			</section>
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
    <div data-remodal-id="sign-up">
        <span class="message"></span>
    <form method="POST" action="/includes/accounts/exec-signup.php">
      <h1 class="modalTitle">Sign up</h1>
      <p>
        <input type="text" name="name" placeholder="NAME" class="modal">
      </p>
      <p>
        <input type="text" name="email" placeholder="EMAIL" class="modal">
      </p>
      <p>
        <input type="password" name="password" placeholder="PASSWORD" class="modal">
      </p>
      <p>
        <input type="text" name="phone" placeholder="PHONE #" class="modal">
      </p>
      <br>
      <input class="remodal-confirm" type="submit" value="SIGN UP">
      <a class="remodal-facebook" href="/accounts/facebook">SIGN UP WITH FACEBOOK</a>
        <div id="orlogin">Already have an account? <a href="#login">Log in!</a></div>
        <div id="terms">By signing up you agree to our <a href="info@gobring.it">Terms &amp; Conditions</a></div>

      </form>
    </div>
    <div data-remodal-id="login">
        <form method="POST" action="/includes/accounts/exec-login.php">
            <h1 class="modalTitle">Login</h1>
            <p>
                <input type="text" name="username" placeholder="EMAIL" class="modal">
            </p>
            <p>
                <input type="password" name="password" placeholder="PASSWORD" class="modal">
            </p>
            <br>
            <input type="hidden" id="login_redirect" name="redirect" value="0">
            <input class="remodal-confirm" type="submit" value="LOGIN">
            <a class="remodal-facebook" href="/accounts/facebook">LOGIN WITH FACEBOOK</a>
            <div id="orlogin">Need an account? <a href="#sign-up">Sign up!</a></div>
            <div id="terms">Forgot <a href="#forgot-password">password</a>?</div>
        </form>
    </div>
    <div data-remodal-id="forgot-password">
        <form method="POST" action="/accounts/forgot-password">
            <h1 class="modalTitle">Forgot Password?</h1>
            <p>
                <input type="text" name="reset-email" placeholder="EMAIL" class="modal" required>
            </p>
            <br>
            <input class="remodal-confirm confirm-email" type="submit" value="CONFIRM EMAIL">
            <div id="orlogin">Already have a password? <a href="#login">Log in!</a></div>
        </form>
    </div>
    <div data-remodal-id="reset-password">
        <form method="POST" action="/accounts/reset-password">
            <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">
            <input type="hidden" name="expiry" value="<?php echo isset($_GET['expiry']) ? $_GET['expiry'] : ''; ?>">
            <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
            <h1 class="modalTitle">Reset Password</h1>
            <p>
                <input type="password" name="password" placeholder="PASSWORD" class="modal">
            </p>
            <br>
            <input class="remodal-confirm reset-password" type="submit" value="RESET PASSWORD">
        </form>
    </div>
    <div data-remodal-id="facebook-connect">
        <form method="POST" action="/accounts/facebook/connect">
            <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>">
            <input type="hidden" name="facebook_id" value="<?php echo isset($_GET['facebook_id']) ? $_GET['facebook_id'] : ''; ?>">
            <h1 class="modalTitle">Connect To Facebook</h1>
            <p>
                <input type="password" name="password" placeholder="PASSWORD" class="modal">
            </p>
            <br>
            <input class="remodal-confirm" type="submit" value="CONNECT TO FACEBOOK">
        </form>
    </div>

<!--<script src="js/jquery.min.js"></script>-->
<!--<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>-->
        <script src="js/jquery.remodal.js"></script>

<!-- Events -->
<script>

  $(document).on('confirm', '.remodal', function () {
      $(this).find("form").submit();
  });

 var signup_remodal = $("[data-remodal-id=sign-up]").remodal();
$("[data-remodal-id=login]").remodal();
$("[data-remodal-id=forgot-password]").remodal();
$("[data-remodal-id=reset-password]").remodal();
$("[data-remodal-id=facebook-connect]").remodal();
</script>
	</body>
<script type="text/javascript">
 $(document).ready(function() {
    <?php
        $cookies = new Cookies();
        $user = $cookies->user_from_cookie();
        if (isset($_GET["m"])) {
            echo sprintf("var message=\"%s\";\n", $_GET["m"]);
        } else {
            echo "var message=null;\n";
        }

        if ($user === 0){
            echo "var loggedin=false;\n";
        }
        else{
            echo "var loggedin=true;\n";
        }
    ?>

     if (message != null){
         $.featherlight("message.php?msg=" + message);
     }

     $(".section").children("a").on('click', function (e){
         if (!loggedin){
             e.preventDefault();
             var redir_url = $(this).attr("href")
             $("#login_redirect").attr("value", redir_url);
             $("[data-remodal-id=sign-up] span").text("You need to make an account before proceeding with your order")
             signup_remodal.open();
         }
     })

    // initialize first tab
    $('.tab-items.col[data-tab="1"]').click();
});

// toggle tabs and panels
$('.tab-items.col').on('click', function() {
    // reset tabs and panels
    $('.tab-items').removeClass('main-tabs-selected');
    $('.category-items').hide();

    // activate selected
    var tabId = $(this).data('tab');
    $(this).toggleClass('main-tabs-selected');
    $('.category-items[data-tab="' + tabId + '"]').show();
});

</script>
</html>
