<?php

//initilize the page
require_once 'init.web.php';
$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}
/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Профиль";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["views"]["sub"]["profile"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Other Pages"] = "";
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- Bread crumb is created dynamically -->
		<!-- row -->
		<div class="row">
		
			<!-- col -->
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-file-o"></i> Другие страницы <span>>
					Профиль </span></h1>
			</div>
			<!-- end col -->
		
			<!-- right side of the page with the sparkline graphs -->
			<!-- col -->

			<!-- end col -->
		
		</div>
		<!-- end row -->
		
		<!-- row -->
		
		<div class="row">
		
			<div class="col-sm-12">
		
		
					<div class="well well-sm">
		
						<div class="row">
		
							<div class="col-sm-24 col-md-24 col-lg-12">
								<div class="well well-light well-sm no-margin no-padding">
		
									<div class="row">
		
										<div class="col-sm-12">
											<div id="myCarousel" class="carousel fade profile-carousel">
											
												<div class="air air-top-left padding-10">
													<h4 class="txt-color-white font-md"></h4>
												</div>
												<ol class="carousel-indicators">
													<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
													<li data-target="#myCarousel" data-slide-to="1" class=""></li>
													<li data-target="#myCarousel" data-slide-to="2" class=""></li>
												</ol>
												<div class="carousel-inner">
													<!-- Slide 1 -->
													<div class="item active">
														<img src="<?php echo ASSETS_URL; ?>/img/demo/s1.jpg" alt="">
													</div>
													<!-- Slide 2 -->
													<div class="item">
														<img src="<?php echo ASSETS_URL; ?>/img/demo/s2.jpg" alt="">
													</div>
													<!-- Slide 3 -->
													<div class="item">
														<img src="<?php echo ASSETS_URL; ?>/img/demo/m3.jpg" alt="">
													</div>
												</div>
											</div>
										</div>
		
										<div class="col-sm-12">
		
											<div class="row">
		
												<div class="col-sm-3 profile-pic">
													<img src="<?php echo ASSETS_URL; ?>/img/avatars/sunny-big.png">
													
												</div>
												<div class="col-sm-6">
													<h1>Пользователь <span class="semi-bold"><?=$userinfo["fio"]?></span>
													<br>
													<small>Ромир</small></h1>
		
													<ul class="list-unstyled">
														<li>
															<p class="text-muted">
																<i class="fa fa-phone"></i>&nbsp;&nbsp;<span class="txt-color-darken"><?=$userinfo["phone"]?></span>
															</p>
														</li>
														<li>
															<p class="text-muted">
																<i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="mailto:<?=$userinfo["email"]?>"><?=$userinfo["email"]?></a>
															</p>
														</li>
														
													
													</ul>
													<br>
													
													
		
												</div>
										
		
											</div>
		
										</div>
		
									</div>
		
									<div class="row">
		
										<div class="col-sm-12">
		
											<hr>
		
											
										</div>
		
									</div>
									<!-- end row -->
		
								</div>
		
							</div>
						</div>
		
					</div>
		
		
			</div>
		
		</div>
		
		<!-- end row -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
	// include page footer
	include("inc/footer.php");
?>

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script>

	$(document).ready(function() {
		// PAGE RELATED SCRIPTS
	})

</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>