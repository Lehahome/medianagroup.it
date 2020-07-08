<?php



// if (!isset($editid)) {
	// include("romir_edit_new.php"); exit;
// }	

//initilize the page
require_once 'init.web.php';

$page_menu_id=9;

$addvacancy=$_REQUEST["addvacancy"];

if (!empty($addvacancy)) {

 
 $title=$_REQUEST["title"];
 $ckeditor=$_REQUEST["ckeditor"];
 $sort=$_REQUEST["sort"];
 $category=$_REQUEST["category"];
 
 
 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
 $title = mysqli_real_escape_string($conn, $title);
 
  
 
 
  $query="INSERT INTO vacancy (title,sort,category_id,html) VALUE ('".$title."',".$sort.",".$category.",'".$ckeditor."')";
		 if ($result = mysqli_query($conn, $query)) {
	
		} else {
		//error;
		}
 //echo $query;
 //exit;
 header("Location: ".APP_URL."/romir_vacancy.php"); 
 
}



$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}



if ($userinfo["role"]==2) {
	$user_redirect=0;
	
	if (count($userinfo["menu_id"])==0){
		$user_redirect=1;
	} else
	{
		$user_redirect=1;
		if (in_array($page_menu_id, $userinfo["menu_id"])) {
			$user_redirect=0;
		}
	}	
	
	if ($user_redirect==1) {
		header("Location: ".APP_URL."/login.php"); 
		exit;
	}
}




/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Добавление вакансии";

$sample_html='<div class="text_block">

<p>Личные интервью как самый распространенный способ изучения какой-либо темы основан на непосредственном контакте интервьюера с респондентом. Личное общение позволяет не только отвечать на сложные вопросы анкеты, но и применять наглядные материалы (карточки, фотографии, упаковки, логотипы).</p>

	<p><strong>В зависимости от целей и задач исследования Ромир предлагает проведение различных видов личных интервью:</strong></p>

	<ul>
		<li>интервью по месту жительства респондента,</li>
		<li>интервью на рабочем месте респондента,</li>
		<li>уличные интервью,</li>
		<li>интервью в местах продаж.</li>
	</ul>
	
	</div>';


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
						<a href="<?=APP_URL?>/romir_vacancy.php">Вакансии</a>
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
						
                        						
				
                 <form id="add-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_add_vacancy.php">
				 <input type="hidden" value="1" id="addvacancy" name="addvacancy"/>
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
							 <label class="label">Категория</label>
							 
							<label class="select">
							<select name="category" id="category">
							<option  value="0">Категория</option>
							<option  value="1">Профи</option>
							<option  value="2">Стажер</option>
							<option  value="3">Студент</option>
							</select><i></i>
							</label>
							 
							 
						  </section>
					
				 </fieldset>
				 
			
				 
				  <fieldset>
				
						 <section>
						 <label class="label">Сортировка</label>
							 <label class="input "><input type="number" id="sort" name="sort" value="" placeholder="Сортировка"></label>
						  </section>
					
				 </fieldset>
				 
			
				 
				 
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст вакансии</label>
								
									<textarea name="ckeditor"><?=$sample_html?></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="AddNewVacancy();" class="btn btn-info btn-lg">Сохранить</a>	 
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

	function AddNewVacancy()
	{
		
		var title=$("#title").val();
		title=$.trim(title);
		if (title.length===0){
			Alert("Введите название");
			return;
		}
		
		var category=$("#category").val();
		if (category==="0"){
			Alert("Выберите категорию");
			return;
		}
		
	
		
		
		var sort=$("#sort").val();
		sort=$.trim(sort);
		if (sort.length===0){
			Alert("Введите сортировку");
			return;
		}
		
		
		var data=CKEDITOR.instances.ckeditor.getData();
		data=$.trim(data);
		if (data.length===0){
			Alert("Введите текст вакансии");
			return;
		}
		
		
		
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
	
	
	function Alert(txt)
	{
		$.bigBox({
						title : "Внимание",
						content : txt,
						color : "#F50824",
						timeout: 2000,
						icon : "fa fa-warning"
					});
	}
	

</script>


<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>