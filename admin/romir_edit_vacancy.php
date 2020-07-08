<?php


$editid=$_GET["id"];
// if (!isset($editid)) {
	// include("romir_edit_new.php"); exit;
// }	

//initilize the page
require_once 'init.web.php';

$page_menu_id=9;

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

$page_title = "Вакансия";

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
	
	if ($result = mysqli_query($conn, "SELECT * FROM vacancy WHERE id=".$editid)) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			$title=$row["title"];
			$sort=$row["sort"];
			$active=$row["active"];
			$html=$row["html"];
			$category_id=$row["category_id"];
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
						<a href="<?=APP_URL?>/romir_vacancy.php">Вакансии</a>
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
						
                        						
				
                 <form id="edit-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_update_vacancy.php">
				 <input type="hidden" id="editid" name="editid" value="<?=$editid;?>" />
				 <input type="hidden" id="back_url" name="back_url" value="<?=$_SERVER['REQUEST_URI']?>" />
				 <fieldset>
					
					 
					 
						 <section>
							 <label class="label">Вакансия</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="title" name="title" placeholder="Вакансия"><?=$title;?></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Категория</label>
							 
							<label class="select">
							<select name="category" id="category">
							<option <?php if ($category_id==1) {echo "selected";} ?> value="1">Профи</option>
							<option <?php if ($category_id==2) {echo "selected";} ?> value="2">Стажер</option>
							<option <?php if ($category_id==3) {echo "selected";} ?> value="3">Студент</option>
							</select><i></i>
							</label>
							 
							 
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
							 <label class="label">Видимость</label>
							 
							<label class="select">
							<select name="active" id="active">
							<option <?php if ($active==1) {echo "selected";} ?> value="1">Вкл</option>
							<option <?php if ($active==0) {echo "selected";} ?> value="0">Выкл</option>
							</select><i></i>
							</label>
						  </section>
					
				 </fieldset>
				 
				  <fieldset>
				
						 <section>
						 <label class="label">Сортировка</label>
							 <label class="input "><input type="number" name="sort" name="sort" value="<?=$sort;?>" placeholder="Сортировка"></label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст вакансии</label>
								
									<textarea name="ckeditor"><?=$html;?></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
							 <a onclick="UpdateVacancy();" class="btn btn-info btn-lg">Сохранить</a>
							 <a onclick="DeleteVacancy();" class="btn btn-danger btn-lg pull-right">Удалить</a>				 
					  </section>
					
				 </fieldset>
					 
					 
				 </form>
						
				 
				 <div id="delete_dialog">
					<p>
					Вы уверены в том, чтобы удалить эту вакансию?
					</p>
				</div>		
						
			

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
	// function fechaReg(el) {
        // jQuery(el).datepicker({
            // dateFormat: 'yy-mm-dd',
            // timeFormat: 'hh:mm:ss',
            // changeYear: true,
            // changeMonth: true,
            // numberOfMonths: 1,
            // timeOnlyTitle: 'Выберите дату/время',
            // timeText: 'Выбранное время',
            // hourText: 'Час',
            // minuteText: 'Минута',
            // secondText: 'Секунда',
            // millisecText: 'Милисекунда',
            // currentText: 'Текущее время',
            // closeText: 'Закрыть',
            // ampm: false
        // }).datepicker("setDate", $(el).val());
    // }




	$(document).ready(function() {
		

		CKEDITOR.replace( 'ckeditor', { height: '480px', startupFocus : false, filebrowserUploadUrl:"<?=APP_URL?>/romir_upload.php?foo=1"} );
		
		
		
		$('#delete_dialog').dialog({
				autoOpen : false,
				width : 600,
				resizable : false,
				modal : true,
				title : "Удаление вакансии",
				buttons : [{
					html : "<i class='fa fa-trash-o'></i>&nbsp; Удалить",
					"class" : "btn btn-danger",
					click : function() {
						
						$(this).dialog("close");
						RealVacancyDelete();
					}
				}, {
					html : "<i class='fa fa-times'></i>&nbsp; Отмена",
					"class" : "btn btn-default",
					click : function() {
						$(this).dialog("close");
					}
				}]
			});
		
		
			
	  
	})

	function UpdateVacancy()
	{
		$('#edit-form').submit();
	}
    
	
	
	function  DeleteVacancy()
	{
		$('#delete_dialog').dialog('open');
	}
	
	
	function RealVacancyDelete()
	{
		var vacancy_id=$("#editid").val();
		var data={"vacancy_id":vacancy_id, "oper":"delete_vacancy"};
		$.ajax({
			  type: "POST",
			  url: "<?=APP_URL?>/ajax.php",
			  cache: false,
			  dataType:"json",
			  data: data,
			  success: function(msg){
				 if (msg.result===true) {
					 location.href="<?=APP_URL?>/?vacancy_deleted";
				 } 
				//console.log( msg );
			  }
			});
		
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