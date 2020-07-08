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

$page_title = "Новость";

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
	
	if ($result = mysqli_query($conn, "SELECT news.*, short_url.short_url
	FROM news 
	LEFT JOIN short_url ON short_url.new_id=news.id
	WHERE news.id=".$editid)) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			$title=$row["title"];
			$keywords=$row["keywords"];
			$description=$row["description"];
			$small_pic=$row["small_pic"];
			$big_pic=$row["big_pic"];
			$html=$row["html"];
			$publish_date=$row["publish_date"];
			$language_id=$row["language_id"];
			$new_active=$row["active"];
			$short_url=$row["short_url"];
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
						<a href="<?=APP_URL?>/romir_news.php">Новости</a>
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
						
				<?php 
				
				if ($result = mysqli_query($conn, "SELECT * FROM news WHERE language_id=2 AND parent_new_id=".$_REQUEST["id"]." LIMIT 1")) {
					if (mysqli_num_rows($result)==0 && $language_id!=2) {
							
								?>
								
								<a href="<?=APP_URL?>/romir_add_new.php?lang=2&parent_new_id=<?php echo $_REQUEST["id"]; ?>" style="margin-bottom:20px; display:block; width:450px;" class="btn btn-info btn-lg">Добавить новость на английском языке</a>	
								
								<?php

							
							$result->close();
						}
				}
				?>			
						
						
						
						
                        						
				
                 <form id="edit-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_update_new.php">
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
							 <label class="label">Короткая ссылка</label>
							 
							 <table cellpadding="0" cellspacing="0" style="width:100%">
							 <tr><td><label class="input"><input readonly type="text" id="short_url"  name="short_url" value="<?=$short_url?>" placeholder="Короткая ссылка"/></label></td>
							 <td style="width:150px;text-align:center;"><a onclick="GetShortUrl();" class="btn btn-info btn-lg">Получить</a></td></tr>
							 </table>
						  </section>
					
				 </fieldset>
				 
				 
				  <fieldset>
					
					 
						 <section>
							 <label class="label">Видимость</label>
							 
							<label class="select">
							<select name="active" id="active">
							<option <?php if ($new_active==1) {echo "selected";}?> value="1">Вкл</option>
							<option <?php if ($new_active==2) {echo "selected";}?> value="2">Выкл</option>
							
							</select><i></i>
							</label>
							 
							 
						  </section>
					
				 </fieldset>
				 
				 
				 
				 
				 
				 <fieldset>
					<section>
							 <label class="label">Keywords</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="keywords" name="keywords" placeholder="Keywords"><?=$keywords;?></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Description</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="description" name="description" placeholder="Description"><?=$description;?></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Дата публикации</label>
							 <label class="input ">
							 <input readonly="readonly"  class="input"  id="publish_date" name="publish_date" placeholder="Дата публикации" value="<?=$publish_date;?>"/></label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
							 <label class="label">Малая картинка</label>
							 <? if (!empty($small_pic)) { ?>
							 <img src="<?=$small_pic;?>"/><div style="clear:both; height:15px;"></div>
							 <? } ?>
							 <label class="input input-file"><span class="button"><input type="file" id="small_pic" name="small_pic" onchange="this.parentNode.nextSibling.value = this.value" value="">Открыть</span><input type="text" name="file-display" readonly="" value="">	</label>
						  </section>
					
				 </fieldset>
				 
				  <fieldset>
				
						 <section>
							 <label class="label">Большая картинка</label>
							 <? if (!empty($big_pic)) { ?>
							 <img src="<?=$big_pic;?>"/><div style="clear:both; height:15px;"></div>
							 <? } ?>
							 <label class="input input-file"><span class="button"><input type="file" id="big_pic" name="big_pic" onchange="this.parentNode.nextSibling.value = this.value" value="">Открыть</span><input type="text" name="file-display" readonly="" value="">	</label>
						  </section>
					
				 </fieldset>
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст новости</label>
								
									<textarea name="ckeditor"><?=$html;?></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
								<a onclick="UpdateNew();" class="btn btn-info btn-lg">Сохранить</a>	 
								<a onclick="DeleteNew();" class="btn btn-danger btn-lg pull-right">Удалить</a>
					  </section>
					
				 </fieldset>
					 
					 
				 </form>
				 
				 <div id="delete_dialog">
					<p>
					Вы уверены в том, чтобы удалить эту новость?
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
		
		$('#delete_dialog').dialog({
				autoOpen : false,
				width : 600,
				resizable : false,
				modal : true,
				title : "Удаление новости",
				buttons : [{
					html : "<i class='fa fa-trash-o'></i>&nbsp; Удалить",
					"class" : "btn btn-danger",
					click : function() {
						
						$(this).dialog("close");
						RealNewDelete();
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

	function UpdateNew()
	{
		$('#edit-form').submit();
	}
    
	
	
	
	function  DeleteNew()
	{
		$('#delete_dialog').dialog('open');
	}
	
	
	function RealNewDelete()
	{
		var new_id=$("#editid").val();
		var data={"new_id":new_id, "oper":"delete_new"};
		$.ajax({
			  type: "POST",
			  url: "<?=APP_URL?>/ajax.php",
			  cache: false,
			  dataType:"json",
			  data: data,
			  success: function(msg){
				 if (msg.result===true) {
					 location.href="<?=APP_URL?>/?new_deleted";
				 } 
				//console.log( msg );
			  }
			});
		
	}
	
	
	function GetShortUrl()
	{
		
		var data={"oper":"GetShortUrl"};
		$.ajax({
			  type: "POST",
			  url: "<?=APP_URL?>/ajax.php",
			  cache: false,
			  dataType:"json",
			  data: data,
			  success: function(msg){
				 if (msg.result===true) {
					 $("#short_url").val(msg.short_url);
				 } 
				
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