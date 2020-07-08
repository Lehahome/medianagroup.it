<?php


$editid=$_GET["id"];

// if (!isset($editid)) {
	// include("romir_edit_new.php"); exit;
// }	

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

$page_title = "Слайдер";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["tables"]["sub"]["jqgrid"]["active"] = true;
include("inc/nav.php");

 $title="";
	
	if ($result = mysqli_query($conn, "SELECT * FROM slider WHERE id=".$editid)) {
		$result->fetch_array(MYSQLI_ASSOC);
		//print_array($result->fetch_array(MYSQLI_ASSOC));
		foreach ($result as $row)	
		{
			$title=$row["title"];
			$text=$row["text"];
			$page_url=$row["page_url"];
			$background_image_url=$row["background_image_url"];
			
		}
		$result->close();
	} 
	



?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Tables"] = "";
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		<!-- row -->
		<div class="row">
			
			<!-- col -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h1 class="page-title txt-color-blueDark">
					
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-home"></i> 
						Главная 
					<span>>  
						<a href="<?=APP_URL?>/romir_slider.php">Слайдер</a>
					<span>>  
						<?=$title;?>	
					</span>
				</h1>
			</div>
			<!-- end col -->
			
			<!-- right side of the page with the sparkline graphs -->
			<!-- col -->
	
			<!-- end col -->
			
		</div>
		<!-- end row -->

		<!--
			The ID "widget-grid" will start to initialize all widgets below 
			You do not need to use widgets if you dont want to. Simply remove 
			the <section></section> and you can use wells or panels instead 
			-->

		<!-- widget grid -->
		

			<!-- row -->
			<div class="row">
				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
                        						
				
                 <form id="edit-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_update_slider.php">
				 <input type="hidden" id="editid" name="editid" value="<?=$editid;?>" />
				 <input type="hidden" id="back_url" name="back_url" value="<?=$_SERVER['REQUEST_URI']?>" />
				 <fieldset>
					
					 
					 <!-- <section class="col col-10">
					 <label class="input "><i class="icon-prepend fa fa-leaf"></i><input type="text" id="title" name="title" value="<?=$title;?>" placeholder="Название"></label>
					 
					 </section>	-->
					 
						 <section>
							 <label class="label">Название</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="title" name="title" placeholder="Название"><?=$title;?></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Ссылка на страницу</label>
							 <label class="input ">
							 <input  class="input"  id="page_url" name="page_url" placeholder="Ссылка на страницу" value="<?=$page_url;?>"/></label>
							 <span><?=$url;?></span>
						  </section>
					
				 </fieldset>
				 
				 
				 
				  <fieldset>
				
						 <section>
							 <label class="label">Фоновая картинка</label>
							 <? if (!empty($background_image_url)) { ?>
							 <img style="width:100%;" src="<?=$background_image_url;?>"/><div style="clear:both; height:15px;"></div>
							 <? } ?>
							 <label class="input input-file"><span class="button"><input type="file" id="background_image_url" name="background_image_url" onchange="this.parentNode.nextSibling.value = this.value" value="">Открыть</span><input type="text" name="file-display" readonly="" value="">	</label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст</label>
								
									<textarea name="ckeditor"><?=$text;?></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="UpdateSlider();" class="btn btn-info btn-lg">Сохранить</a>	 
					  </section>
					
				 </fieldset>
					 
					 
				 </form>
						
						
						
			

			<!-- end row -->

		
		<!-- end widget grid -->
			</div>
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



<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>
<!-- PAGE RELATED PLUGIN(S) -->



<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->


<script src="<?php echo ASSETS_URL; ?>/js/plugin/ckeditor/ckeditor.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jqgrid/grid.locale-en.min.js"></script>

<script type="text/javascript">
	


	$(document).ready(function() {
		
		CKEDITOR.replace( 'ckeditor', { height: '480px', startupFocus : false, filebrowserUploadUrl:"<?=APP_URL?>/romir_upload.php?foo=1"} );
	
	  
	})

	function UpdateSlider()
	{
		$('#edit-form').submit();
	}
  	
	function Success()
	{
		$.bigBox({
						title : "Успех",
						content : "Информация обновлена",
						color : "#739E73",
						timeout: 2000,
						icon : "fa fa-check"
					});
	}
	
	

</script>


<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>