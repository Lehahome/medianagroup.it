<?php

//initilize the page
require_once 'init.web.php';
$page_menu_id=1;
$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}

$lang=1;
if (isset($_GET["lang"])&&$_GET["lang"]!=""){
	$lang=$_GET["lang"];
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

$page_title = "Верхнее меню";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["ui_elements"]["sub"]["tree_view"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["UI Elements"] = "";
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa fa-desktop fa-fw "></i> 
					Главная  
					<span>>
					Меню
					</span>
				</h1>
			</div>
			
		</div>
		<!-- widget grid -->
		<section id="widget-grid" class="">
		
			<!-- row -->
			<div class="row">
		
				<!-- NEW WIDGET START -->
				<article class="col-sm-24 col-md-24 col-lg-12">
		
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-blue" id="wid-id-1" data-widget-editbutton="false">
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
							<span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
							<h2>Верхнее меню </h2>
		
						</header>
		
						<!-- widget div-->
						<div>
		
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
		
							</div>
							<!-- end widget edit box -->
		
							<!-- widget content -->
							<div class="widget-body">
		
							<form class="smart-form">	
								<fieldset >
									<section>
										<label class="label">Язык</label>
										<div class="inline-group">
											<label class="radio">
												<input type="radio" onclick="location.href='<?=APP_URL?>/romir_header_treeview.php?lang=1'" name="radio-inline" <?php if ($lang==1){ ?> checked="checked" <?php } ?>>
												<i></i>RUS</label>
											<label class="radio">
												<input type="radio" onclick="location.href='<?=APP_URL?>/romir_header_treeview.php?lang=2'" name="radio-inline" <?php if ($lang==2){ ?> checked="checked" <?php } ?>>
												<i></i>ENG</label>
											
										</div>
									</section>
								</fieldset>
							</form>	
		
		
		
								<div class="tree smart-form">
									<ul>
										<li>
											<span><i class="fa fa-lg fa-folder-open"></i> Меню</span>
											
											
											
											
											
											
											
											
											<ul>
											
											
											<input type="hidden" value="<?=$lang?>" id="lang" name="lang" />
											
											<?php if ($result = mysqli_query($conn, "SELECT * FROM footer_menu WHERE active=1 AND parent=0 AND language_id=".$lang." ORDER BY sort")) {
											
												
											$result->fetch_array(MYSQLI_ASSOC);
											foreach ($result as $row)	
											{ ?><li>
												 
													
													<span><i class="fa fa-lg fa-plus-circle"></i> <?=$row["title"]?></span>
													<input class="parent_active" id="title_<?=$row["id"]?>" placeholder="Название" style="margin-left:15px;" value="<?=$row["title"]?>" type="text"/><input id="text_<?=$row["id"]?>" placeholder="Доп. текст" style="margin-left:15px;" value="<?=$row["text"]?>" type="text"/><input id="sort_<?=$row["id"]?>" placeholder="сортировка" style="margin-left:15px; width:90px; text-align:center; " value="<?=$row["sort"]?>" type="number"/>
													
													
													
												 
													 <ul>
														<?php if ($result_submenu = mysqli_query($conn, "SELECT * FROM footer_menu WHERE  parent=".$row["id"]." AND language_id=".$lang." ORDER BY sort")) {
														$result_submenu->fetch_array(MYSQLI_ASSOC);
														foreach ($result_submenu as $row_submenu)	
														{
															$chbox_checked="";
															if ($row_submenu["active"]==1) {
																$chbox_checked="checked=\"checked\"";
															}
														?>
														<li style="display:none"><span><label class="checkbox inline-block">
																	<input class="sub_active_checkbox" id="sub_<?=$row_submenu["id"]?>" type="checkbox" <?=$chbox_checked?> name="checkbox-inline"><i></i><?=$row_submenu["title"]?></label></span><input id="title_<?=$row_submenu["id"]?>"  placeholder="Название" style="margin-left:15px;" value="<?=$row_submenu["title"]?>" type="text"/><input id="url_<?=$row_submenu["id"]?>"  placeholder="ссылка" style="margin-left:15px;" value="<?=$row_submenu["url"]?>" type="text"/><input id="sort_<?=$row_submenu["id"]?>"  placeholder="сортировка" style="margin-left:15px; width:90px; text-align:center;" value="<?=$row_submenu["sort"]?>" type="number"/></li>
														<?php } ?> 
														<li style="display:none"><span><label class="checkbox inline-block">
																	<input class="new_sub" id="parent_<?=$row["id"]?>" type="checkbox"  name="checkbox-inline">
																	<i></i>Новый пункт меню</label></span><input id="new_title_<?=$row["id"]?>" placeholder="Название" style="margin-left:15px;" value="" type="text"/><input id="new_url_<?=$row["id"]?>" placeholder="ссылка" style="margin-left:15px;" value="" type="text"/><input id="new_sort_<?=$row["id"]?>" placeholder="сортировка" style="margin-left:15px; width:90px; text-align:center;" value="" type="number"/></li>
														<?php
														$result_submenu->close();
														}
														?>
													</ul> 
											</li>
											
											<?php } 
											$result->close();
											}
											?>
											
											</ul>
											
											
										</li>
										
									</ul>
									<a onclick="UpdateUpMenu();" class="btn btn-info btn-lg">Сохранить</a>
								</div>
		
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
		
			<!-- row -->
		
			<div class="row">
		
			</div>
		
			<!-- end row -->
		
		</section>
		<!-- end widget grid -->

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

<script type="text/javascript">
	
	$(document).ready(function() {
	
		$('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
		$('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function(e) {
			var children = $(this).parent('li.parent_li').find(' > ul > li');
			if (children.is(':visible')) {
				children.hide('fast');
				$(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-plus-circle');
			} else {
				children.show('fast');
				$(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-minus-circle');
			}
			e.stopPropagation();
		});			
	
	})
	
	function UpdateUpMenu ()
	{
		var data={"update_sub":[], "update_parent":[],insert_sub:[]};
		var sub_active_checkbox=$(".sub_active_checkbox");
		$.each(sub_active_checkbox, function(i, val) {
			
			var obj={};
			
			var qs=val.id.split("sub_");
			obj.id=qs[1];
			
			if ($(val).prop("checked")===true){
				
				obj.active=1;
			}
			else
			{
				obj.active=0;
			}
			
			obj.title=$("#title_"+obj.id).val();
			obj.url=$("#url_"+obj.id).val();
		    obj.sort=$("#sort_"+obj.id).val();
			
			data.update_sub.push(obj);			
		});
		
		
		
		
		var parent_active=$(".parent_active");
		$.each(parent_active, function(i, val) {
			
			var obj={};
			
			var qs=val.id.split("title_");
			obj.id=qs[1];
		
			
			obj.title=$("#title_"+obj.id).val();
			obj.text=$("#text_"+obj.id).val();
			obj.sort=$("#sort_"+obj.id).val();
		
			data.update_parent.push(obj);			
		});
		
		
		var new_sub=$(".new_sub");
		$.each(new_sub, function(i, val) {
			
			var obj={};
			
			var qs=val.id.split("parent_");
			
			
			if ($(val).prop("checked")===true){
				obj.parent_id=qs[1];
				obj.title=$("#new_title_"+obj.parent_id).val();
				obj.url=$("#new_url_"+obj.parent_id).val();
				obj.sort=$("#new_sort_"+obj.parent_id).val();
				data.insert_sub.push(obj);		
			}
		
				
		});
		data.upmenu=1;
		data.lang=$("#lang").val();
		$.ajax({
		  type: "POST",
		  url: "<?=APP_URL?>/ajax.php",
		  cache: false,
		  dataType:"json",
		  data: data,
		  success: function(msg){
			 if (msg.result===true) {
				 //location.reload();
				 
				 	$.bigBox({
						title : "Успех",
						content : "Информация обновлена",
						color : "#739E73",
						//timeout: 3000,
						icon : "fa fa-check"
						
						//number : "4"
					});
					
					
					
					var timerId = setTimeout(
					function(){
					   clearTimeout(timerId);
					  location.reload();
					}, 3000);
					
					
					

					//e.preventDefault();

				 
				 } 
			//console.log( msg );
		  }
		});
		
		
		
		
	}

</script>

<?php 
	//include footer
	include("inc/footer.php"); 
?>