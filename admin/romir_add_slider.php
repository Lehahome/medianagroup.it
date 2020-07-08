<?php



// if (!isset($editid)) {
	// include("romir_edit_new.php"); exit;
// }	

//initilize the page
require_once 'init.web.php';


$addnew=$_REQUEST["addnew"];

if (!empty($addnew)) {

 $language_id=$_REQUEST["language_id"];
 $title=$_REQUEST["title"];
 $ckeditor=$_REQUEST["ckeditor"];

 $page_url=$_REQUEST["page_url"];
 
 
 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
 $title = mysqli_real_escape_string($conn, $title);
 
    
   
   
   if (isset($_FILES) && isset($_FILES['background_image_url']) && !empty($_FILES['background_image_url']['name']) ) {
    $file_name = $_FILES['background_image_url']['name'];
    $file_name_tmp = $_FILES['background_image_url']['tmp_name'];
   // $file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
	//$url='http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$url='/upload/pics/'.$file_name;
    $http_path = $url;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
		$background_image_url=$url;
   }
   }
 
 
	if (isset($title) && $title!="" && isset($page_url) && $page_url!="" && isset($ckeditor) && $ckeditor!="" && isset($background_image_url) && $background_image_url!="") {
 
	  $query="INSERT INTO slider (title,text,page_url,background_image_url,language_id) VALUE ('".$title."','".$ckeditor."','".$page_url."','".$background_image_url."',".$language_id.")";
			 if ($result = mysqli_query($conn, $query)) {
		
			} else {
			//error;
			}
 }
 header("Location: ".APP_URL."/romir_slider.php?lang=".$language_id); 
 
}



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
						Новый	
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
						
                        						
				
                 <form id="add-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_add_slider.php">
				 <input type="hidden" value="1" id="addnew" name="addnew"/>
				 
				 <input type="hidden" value="<?=$_GET["lang"]?>" id="language_id" name="language_id"/>
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Название</label>
							  <label class="input"><input type="text" id="title"  name="title"  placeholder="Название" /></label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Ссылка</label>
							 <label class="input"><input type="text" id="page_url"  name="page_url" placeholder="Ссылка на страницу"/></label>
						  </section>
					
				 </fieldset>
				 
				
				 
				 
				 
				  <fieldset>
				
						 <section>
							 <label class="label">Фоновая картинка</label>
							 
							 <label class="input input-file"><span class="button"><input type="file" id="background_image_url" name="background_image_url" onchange="this.parentNode.nextSibling.value = this.value" value="">Открыть</span><input type="text" name="file-display" readonly="" value=""></label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст новости</label>
								
									<textarea name="ckeditor"></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="AddNewSlider();" class="btn btn-info btn-lg">Сохранить</a>	 
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

	function AddNewSlider()
	{
		$("#add-form").submit();
		
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