<?php



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




$pagetext="";
$page_url="";
$is_new_page=0;

if ($result = mysqli_query($conn, "SELECT pages.*, short_url.short_url 
FROM pages 
LEFT JOIN short_url ON short_url.page_id=pages.id
WHERE pages.id=".$_REQUEST["page_id"])) {
$result->fetch_array(MYSQLI_ASSOC);

foreach ($result as $row)	
{
	//print_array($row);
	$pagetext=$row["html"];
	$short_name=$row["short_name"];
	$keywords=$row["keywords"];
	$description=$row["description"];
	$language_id=$row["language_id"];
	$is_new_page=$row["is_new_page"];
	//$page_url = str_replace('/','',$row["url"]);
	$page_url = $row["url"];
	$short_url=$row["short_url"];

}
$result->close();
} 



/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = $short_name;

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
						<?=$short_name;?>
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
				
				if ($result = mysqli_query($conn, "SELECT * FROM pages WHERE language_id=2 AND parent_page_id=".$_REQUEST["page_id"]." LIMIT 1")) {
					//$result->fetch_array(MYSQLI_ASSOC);
					if (mysqli_num_rows($result)==0 && $language_id!=2) {
							
								?>
								
								<a href="<?=APP_URL?>/romir_add_page.php?lang=2&parent_page_id=<?php echo $_REQUEST["page_id"]; ?>" style="margin-bottom:20px; display:block; width:450px;" class="btn btn-info btn-lg">Добавить страницу на английском языке</a>	
								
								<?php

							
							$result->close();
						}
				}
				?>
				
												
				
                 <form id="add-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_add_page.php">
				 <input type="hidden" value="<?=$_GET["page_id"]?>" id="page_id" name="page_id"/>
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Название</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="title" name="title" placeholder="Название"><?=$short_name;?></textarea>
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
							 <label class="label">УРЛ страницы (необязательное поле)</label>
							 <label class="input">
							<input type="text" value="<?=$page_url;?>" placeholder="УРЛ страницы" id="page_url" name="page_url" />
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 
				 
				 
				 
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст страницы</label>
								
									<textarea name="ckeditor"><?=$pagetext;?></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="UpdatePage();" class="btn btn-info btn-lg">Сохранить</a>
				<?php if ($is_new_page==1) { ?>
					<a onclick="DeletePage();" class="btn btn-danger btn-lg pull-right">Удалить</a>
				<?php } ?>				 
					  </section>
					
				 </fieldset>
					 
					 
				 </form>
				
				<div id="delete_dialog">
					<p>
					Вы уверены в том, чтобы удалить эту страницу?
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
//	include("inc/scripts.php"); 
?>
<!-- PAGE RELATED PLUGIN(S) -->



<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->


<script src="<?php echo ASSETS_URL; ?>/js/plugin/ckeditor/ckeditor.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jqgrid/grid.locale-en.min.js"></script>

<script type="text/javascript">
	



	$(document).ready(function() {

		CKEDITOR.replace( 'ckeditor', { height: '680px', startupFocus : false, filebrowserUploadUrl:"<?=APP_URL?>/romir_upload.php?foo=1"} );
		
		
		$('#delete_dialog').dialog({
				autoOpen : false,
				width : 600,
				resizable : false,
				modal : true,
				title : "Удаление страницы",
				buttons : [{
					html : "<i class='fa fa-trash-o'></i>&nbsp; Удалить",
					"class" : "btn btn-danger",
					click : function() {
						
						$(this).dialog("close");
						RealPageDelete();
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




	function  DeletePage()
	{
		$('#delete_dialog').dialog('open');
	}
	
	
	function RealPageDelete()
	{
		var page_id=$("#page_id").val();
		//console.log(page_id);
		var data={"page_id":page_id, "oper":"delete_page"};
		$.ajax({
			  type: "POST",
			  url: "<?=APP_URL?>/ajax.php",
			  cache: false,
			  dataType:"json",
			  data: data,
			  success: function(msg){
				 if (msg.result===true) {
					 location.href="<?=APP_URL?>/?page_deleted";
				 } 
				//console.log( msg );
			  }
			});
		
	}
	
	
	
	
	
	function UpdatePage() {
	var data={};
	
	data.page=1;
	
	
	
	
	
	var short_url=$("#short_url").val();
	short_url=$.trim(short_url);
	data.short_url=short_url;
	
	
	
	var title=$("#title").val();
	title=$.trim(title);
	data.title=title;
	
	var keywords=$("#keywords").val();
	keywords=$.trim(keywords);
	data.keywords=keywords;
	
	var description=$("#description").val();
	description=$.trim(description);
	data.description=description;
	
	var page_url=$("#page_url").val();
	page_url=$.trim(page_url);
	data.page_url=page_url;
	
	
	data.page_id=<?=$_GET["page_id"]?>;
	data.html=CKEDITOR.instances.ckeditor.getData();
	
		$.ajax({
		  type: "POST",
		  url: "<?=APP_URL?>/ajax.php",
		  cache: false,
		  dataType:"json",
		  data: data,
		  success: function(msg){
			 if (msg.result===true) {
				 
				 
				 	$.bigBox({
						title : "Успех",
						content : "Страница обновлена",
						color : "#739E73",
						timeout: 3000,
						icon : "fa fa-check"
						
					
					});
					
					
					
					

				 
				 } 
			
		  }
		});
	
	

	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	function AddNewPage()
	{
		var title=$("#title").val();
		title=$.trim(title);
		
		
		var page_url=$("#page_url").val();
		page_url=page_url.replace(/\\/g, '');
		page_url=$.trim(page_url);
		
		
		
		
		$.ajax({
                type: 'POST',
                url: "<?=APP_URL?>/ajax.php",
                data: {title: title, page_url:page_url, oper: "check_url"},
                dataType: "json",
                success: function (data) {
					if (data.goturl===false) {
						$("#add-form").submit();
					}
					else
					{
						SameUrl();
					}	

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    
                },
                cache: false
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
	
	function SameUrl()
	{
		$.bigBox({
						title : "Внимание",
						content : "Данное название страницы уже используется, выберите другое",
						color : "#F95151",
						timeout: 3000,
						icon : "fa fa-bell"
					});
	}
	
	
	

</script>


<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>