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

$page_title = "CK Editor";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["pages"]["sub"]["page".$_GET["page_id"]]["active"] = true;





include("inc/nav.php");


$pagetext="";
$pagetitle="";

if ($result = mysqli_query($conn, "SELECT * FROM pages WHERE id=".$_REQUEST["page_id"])) {
$result->fetch_array(MYSQLI_ASSOC);
foreach ($result as $row)	
{
	$pagetext=$row["html"];
	$short_name=$row["short_name"];
	$is_new_page=$row["is_new_page"];
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
		$breadcrumbs["Misc"] = "";
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		
	
	

		<!-- widget grid -->
		<section id="widget-grid" class="">
		
			<!-- row -->
			<div class="row">
				
			
				
				
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		
					<!-- <div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">CKEditor Warning!</h4>
						If you plan to use CKEditor in your project for this theme, please be sure to read full documentation of its use on their website. It is important to note that CKEditor may conflict with other editors and textareas. You must destroy the CKeditor instance before pulling it into another object.
		
					</div> -->
					
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-fullscreenbutton="false" data-widget-sortable="false" data-widget-deletebutton="false">
						<!-- widget options:
							usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
							
							data-widget-colorbutton="false"	
							data-widget-editbutton="false"
							data-widget-togglebutton="false"
							data-widget-deletebutton="false"
							data-widget-fullscreenbutton="false"
							data-widget-custombutton="false"
							data-widget-collapsed="true" 
							data-widget-sortable="false"
							
						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-pencil"></i> </span>
							<h2><?=$short_name;?></h2>				
							<input type="hidden" value="<?=$_REQUEST["page_id"];?>" id="page_id"/>
						</header>
		
		
						
				
		
		
		
						<!-- widget div-->
						<div>
							
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								
							</div>
							<!-- end widget edit box -->
							
							<!-- widget content -->
							<div class="widget-body no-padding">
								
									<textarea name="ckeditor"><?=$pagetext;?></textarea>						
								
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
		
				</article>
				<!-- WIDGET END -->
				
			</div>
		
			<!-- end row -->
			<div class="row" id="test">
			</div>
		
		</section>
		<!-- end widget grid -->
	<a onclick="UpdatePage();" class="btn btn-info btn-lg">Сохранить</a>
	<?php if ($is_new_page==1) { ?>
	<a onclick="DeletePage();" class="btn btn-danger btn-lg pull-right">Удалить</a>
	<?php } ?>
	
	<div id="delete_dialog">
	<p>
		Вы уверены в том, чтобы удалить эту страницу?
	</p>
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
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/ckeditor/ckeditor.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jqgrid/grid.locale-en.min.js"></script>


<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function() {
	
	CKEDITOR.replace( 'ckeditor', { height: '580px', startupFocus : false, filebrowserUploadUrl:"/romir_upload.php?foo=1"} );
	
	
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
	console.log(page_id);
	var data={"page_id":page_id, "oper":"delete_page"};
	$.ajax({
		  type: "POST",
		  url: "http://romir18530.nichost.ru/ajax.php",
		  cache: false,
		  dataType:"json",
		  data: data,
		  success: function(msg){
			 if (msg.result===true) {
				 location.href="/?page_deleted";
			 } 
			//console.log( msg );
		  }
		});
	
}


function UpdatePage() {
	var data={};
	
	data.page=1;
	
	data.page_id=<?=$_GET["page_id"]?>;
	
	
	//data.html=encodeURIComponent(CKEDITOR.instances.ckeditor.getData());
	data.html=CKEDITOR.instances.ckeditor.getData();
		$.ajax({
		  type: "POST",
		  url: "http://romir18530.nichost.ru/ajax.php",
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
			//console.log( msg );
		  }
		});
	
	
	
	
	
	
				// $.bigBox({
						// title : "Успех",
						// content : "Страница обновлена",
						// color : "#739E73",
						// timeout: 3000,
						// icon : "fa fa-check"
						
						// //number : "4"
					// });

}
</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>