<?php
//initilize the page
require_once 'init.web.php';
clear_cookie();
/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include("inc/header.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header">
	<!--<span id="logo"></span>-->

	<div id="logo-group">
		<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

		<!-- END AJAX-DROPDOWN -->
	</div>

	<!-- <span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Необходимо зарегистрироваться в системе?</span> <a href="<?php echo APP_URL; ?>/register.php" class="btn btn-danger">Создать учетную запись</a> </span>-->

</header>

<div id="main" role="main">

	<!-- MAIN CONTENT -->
	<div id="content" class="container">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
				<h1 class="txt-color-red login-header-big">SmartAdmin</h1>
				<div class="hero">

					<div class="pull-left login-desc-box-l">
						<h4 class="paragraph-header">Добро пожаловать в административую чать сайта medianagroup.ru!</h4>
						<!--<div class="login-app-icons">
							<a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
							<a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
						</div>-->
					</div>

					<img src="<?php echo ASSETS_URL; ?>/img/demo/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">

				</div>

				<!--<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>
						<p>
							Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
						</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<h5 class="about-heading">Not just your average template!</h5>
						<p>
							Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
						</p>
					</div>
				</div>-->

			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding">
					<form action="<?php echo APP_URL."/logindata.php"; ?>" id="login-form" class="smart-form client-form" method="post">
						<header>
							Вход
						</header>

						<fieldset>

							<section>
								<label class="label">E-mail</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="email" name="email">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Введите электронный адрес пользователя</b></label>
							</section>

							<section>
								<label class="label">Пароль</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Введите пароль</b> </label>
								<!--<div class="note">
									<a href="<?php echo APP_URL; ?>/forgotpassword.php">Forgot password?</a>
								</div>-->
							</section>

							<section>
								<label class="checkbox">
									<input type="checkbox" name="remember" checked="">
									<i></i>Запомнить</label>
							</section>
						</fieldset>
						<footer>
							<button type="submit" class="btn btn-primary">
								Войти
							</button>
						</footer>
					</form>

				</div>

				<!--<h5 class="text-center"> - Or sign in using -</h5>

								<ul class="list-inline text-center">
									<li>
										<a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-info btn-circle"><i class="fa fa-twitter"></i></a>
									</li>
									<li>
										<a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
									</li>
								</ul>-->

			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
	//include required scripts
	include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S)
<script src="..."></script>-->

<script type="text/javascript">
	runAllForms();

	$(function() {
		
		$.removeCookie('sa_u'); 
		
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				email : {
					required : 'Введите адрес своей электронной почты',
					email : 'Введите правильный адрес своей электронной почты'
				},
				password : {
					required : 'Введите пароль'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>

<?php
	//include footer
	//include("inc/google-analytics.php");
?>