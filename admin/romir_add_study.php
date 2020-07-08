<?php



// if (!isset($editid)) {
	// include("romir_edit_new.php"); exit;
// }	

//initilize the page
require_once 'init.web.php';


$lang=1;
if (isset($_GET["lang"])) {
	$lang=$_GET["lang"];
}


$addpress=$_REQUEST["addpress"];

if (!empty($addpress)) {


 $short_url=$_REQUEST["short_url"];	

 
 $title=$_REQUEST["title"];
 $new_url=translit($title);
 
 
 $keywords="";
 if (isset($_REQUEST["keywords"]) && $_REQUEST["keywords"]!="") {
	$keywords=$_REQUEST["keywords"];
 }
 
 $description="";
 if (isset($_REQUEST["description"]) && $_REQUEST["description"]!="") {
	$description=$_REQUEST["description"];
 }
 
 
 
 $ckeditor=$_REQUEST["ckeditor"];
  
 $publish_date=$_REQUEST["publish_date"];
 
 
 
 
 $parent_study_id=0;
 if (isset($_REQUEST["parent_study_id"]) && $_REQUEST["parent_study_id"]!="") {
	$parent_study_id=(int)$_REQUEST["parent_study_id"]; 
 }
 
 
 $language_id=1;
 $study_link="/studies";
 if (isset($_REQUEST["language"]) && $_REQUEST["language"]!="") {
	$language_id=(int)$_REQUEST["language"]; 
 }
 if ($language_id==2) {
	$study_link="/studies-eng"; 
 }
 
 
 
 
 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
 $title = mysqli_real_escape_string($conn, $title);
 
 
  $keywords = mysqli_real_escape_string($conn, $keywords);
 $description = mysqli_real_escape_string($conn, $description);
 
 
 if (isset($_FILES) && isset($_FILES['small_pic']) && !empty($_FILES['small_pic']['name']) ) {
    $file_name = $_FILES['small_pic']['name'];
    $file_name_tmp = $_FILES['small_pic']['tmp_name'];
    //$file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
	//$url='http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$url='/upload/pics/'.$file_name;
    $http_path = $url;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
		$small_pic=$url;
		
   }
 } 
   
   
   
   if (isset($_FILES) && isset($_FILES['big_pic']) && !empty($_FILES['big_pic']['name']) ) {
    $file_name = $_FILES['big_pic']['name'];
    $file_name_tmp = $_FILES['big_pic']['tmp_name'];
    //$file_new_name = '/home/romir18530/f.romir18530.nichost.ru/docs/upload/pics/';
	$file_new_name = PICS_UPLOAD_FOLDER;
    $full_path = $file_new_name.$file_name;
	//$url='http://f.romir18530.nichost.ru/upload/pics/'.$file_name;
	$url='/upload/pics/'.$file_name;
    $http_path = $url;
    $error = '';
    if( move_uploaded_file($file_name_tmp, $full_path) ) {
		$big_pic=$url;
   }
   }
 
 
 //$new_url="/studies/".$new_url;
 
 $new_url=$study_link."/".$new_url;
 
  $query="INSERT INTO studies (keywords, description, title,publish_date,url,small_pic,big_pic,html,parent_study_id,language_id) VALUE ('".$keywords."', '".$description."','".$title."','".$publish_date."','".$new_url."','".$small_pic."','".$big_pic."','".$ckeditor."',".$parent_study_id.",".$language_id.")";
		 if ($result = mysqli_query($conn, $query)) {
				if (isset($short_url) && !empty($short_url)) {
					$last_id=mysqli_insert_id($conn);
					
					  $query_short_url="INSERT INTO short_url (short_url,study_id) VALUE ('".$short_url."', ".$last_id.")";
					 if ($result_short_url = mysqli_query($conn, $query_short_url)) {
							
					} else {
					//error;
					}
				}
				
				
		} else {
		//error;
		}
 //echo $query;
 //exit;
 header("Location: ".APP_URL."/romir_studies.php"); 
 
}



$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}
/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Пресс релиз";

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
						<a href="<?=APP_URL?>/romir_studies.php">Исследования</a>
					<span>>  
						Новая	
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
						
                        						
				
                 <form id="add-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_add_study.php">
				 <input type="hidden" value="1" id="addpress" name="addpress"/>
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Название</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="title" name="title" placeholder="Название"></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Короткая ссылка</label>
							 <label class="input"><input readonly type="text" id="short_url"  name="short_url" value="<?=CreateShortUrl()?>" placeholder="Короткая ссылка"/></label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 
				 
				 <fieldset>
							<section>
							 <label class="label">Keywords</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="keywords" name="keywords" placeholder="Keywords"></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Description</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="description" name="description" placeholder="Description"></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Язык</label>
							 
							<label class="select">
							<select name="language" id="language">
							<option <?php if ($lang==1) {echo "selected";}?> value="1">Rus</option>
							<option <?php if ($lang==2) {echo "selected";}?> value="2">Eng</option>
							
							</select><i></i>
							</label>
							 
							 
						  </section>
					
				 </fieldset>
				 
				 
				 <input type="hidden" value="<?php if (isset($_GET["parent_study_id"])) {echo $_GET["parent_study_id"];} ?>" id="parent_study_id" name="parent_study_id"/>
				 
				 
				 
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Дата публикации</label>
							 <label class="input ">
							 <input readonly="readonly"  class="input"  id="publish_date" name="publish_date" placeholder="Дата публикации" value=""/></label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
							 <label class="label">Малая картинка</label>
							
							 <label class="input input-file"><span class="button"><input type="file" id="small_pic" name="small_pic" onchange="this.parentNode.nextSibling.value = this.value" value="">Открыть</span><input type="text" name="file-display" readonly="" value="">	</label>
						  </section>
					
				 </fieldset>
				 
				  <fieldset>
				
						 <section>
							 <label class="label">Большая картинка</label>
							 
							 <label class="input input-file"><span class="button"><input type="file" id="big_pic" name="big_pic" onchange="this.parentNode.nextSibling.value = this.value" value="">Открыть</span><input type="text" name="file-display" readonly="" value="">	</label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст исследования</label>
								
									<textarea name="ckeditor"></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="AddNewStudy();" class="btn btn-info btn-lg">Сохранить</a>	 
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
		$("#publish_date").datepicker({
		dateFormat: 'yy-mm-dd',
            timeFormat: 'hh:mm:ss',
            changeYear: true,
            changeMonth: true,
            numberOfMonths: 1,
            timeOnlyTitle: 'Выберите дату/время',
            timeText: 'Выбранное время',
            hourText: 'Час',
            minuteText: 'Минута',
            secondText: 'Секунда',
            millisecText: 'Милисекунда',
            currentText: 'Текущее время',
            closeText: 'Закрыть',
		ampm: false}
		);

		CKEDITOR.replace( 'ckeditor', { height: '480px', startupFocus : false, filebrowserUploadUrl:"<?=APP_URL?>/romir_upload.php?foo=1"} );
		
		
		
		
		
		
	  
	})

	function AddNewStudy()
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