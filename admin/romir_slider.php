<?php

//initilize the page
require_once 'init.web.php';
$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}


$lang=1;
$lang_txt="RUS";
if (isset($_GET["lang"])&&$_GET["lang"]!=""){
	$lang=$_GET["lang"];
}


if ($lang==2){
	$lang_txt="ENG";
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





	$newstext="";
	if ($result = mysqli_query($conn, "SELECT * FROM slider  WHERE language_id=".$lang." ORDER BY id DESC")) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			$newstext.="{
					id : \"".$row["id"]."\",
					title : \"".$row["title"]."\",
					active : \"".$row["active"]."\",
					url : \"".$row["page_url"]."\",
					language_id : \"".$row["language_id"]."\"
				},";
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
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-home"></i> 
						Главная 
					<span>>  
						Слайдер
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
		
		
		<form class="smart-form">	
					<fieldset >
						<section>
							<label class="label">Язык</label>
							<div class="inline-group">
								<label class="radio">
									<input type="radio" onclick="location.href='<?=APP_URL?>/romir_slider.php?lang=1'" name="radio-inline" <?php if ($lang==1){ ?> checked="checked" <?php } ?>>
									<i></i>RUS</label>
								<label class="radio">
									<input type="radio" onclick="location.href='<?=APP_URL?>/romir_slider.php?lang=2'" name="radio-inline" <?php if ($lang==2){ ?> checked="checked" <?php } ?>>
									<i></i>ENG</label>
								
							</div>
						</section>
					</fieldset>
		</form>
		<br>
		
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">
				
				<!-- NEW WIDGET START -->
				<?php
					$tail="";
					if ($lang==1){ $tail="?lang=1"; }
					if ($lang==2){ $tail="?lang=2"; }
				?>
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						
						
						<table id="jqgrid"></table>
							 <div id="pjqgrid"></div>
						
						<br>
						
						
						<a onclick="window.location.href='<?=APP_URL?>/romir_add_slider.php<?=$tail;?>'" class="btn btn-info btn-lg" style="margin-bottom:20px;">Добавить новый элемент слайдера</a>
						
						
						<!--<a href="javascript:void(0)" id="m1">Get Selected id's</a><br>
						<a href="javascript:void(0)" id="m1s">Select(Unselect) row 13</a>

				</article>
				<!-- WIDGET END -->
				
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


		
			
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jqgrid/jquery.jqGrid.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jqgrid/grid.locale-en.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		var jqgrid_data = [
		<?=$newstext?>];

		
		// var editParams = {
    
    // successfunc: function(response) {
       // console.log(response);
    // }
// }; 
 //   var zipEditParams = $.extend(true, {}, editParams, {url: 'ajax.php'});



		
		
		
		
		var lastcell; 
		jQuery("#jqgrid").jqGrid({
			data : jqgrid_data,
			datatype : "local",
			height : 'auto',
			colNames : [ 'ID', 'Название', 'Ссылка на страницу', 'Видимость'],
			colModel : [
				 
				{ name : 'id', index : 'id' }, 
				{ name : 'title', index : 'title', editable : false }, 
				{ name : 'url', index : 'url', editable : false }, 
			
				{ name : 'active', index : 'test', sortable : false, editable : true, edittype: "select", editoptions: { value: "1:Вкл.; 0:Выкл."} }],
			// rowNum : 10,
			// rowList : [10, 20, 30],
			// pager : '#pjqgrid',
			sortname : 'id',
			toolbarfilter: true,
			viewrecords : true,
			sortorder : "asc",
			gridComplete: function(){
					
			},
			onSelectRow: function(id){    
			      window.location.href="<?=APP_URL?>/romir_edit_slider.php?id="+id;
			     
                }, 
			editurl : "ajax.php",
			
			//caption : "Слайдер",
			multiselect : false,
			autowidth : true
			
	

			});
			
			
				
			
			
			 jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : false,
				del : false,
				search: false,
				refresh: false
				
			});
			/*
			jQuery("#jqgrid").jqGrid('inlineNav', "#pjqgrid");
			Add tooltips */
			$('.navtable .ui-pg-button').tooltip({
				container : 'body'
			});

			jQuery("#m1").click(function() {
				var s;
				s = jQuery("#jqgrid").jqGrid('getGridParam', 'selarrrow');
				alert(s);
			});
			jQuery("#m1s").click(function() {
				jQuery("#jqgrid").jqGrid('setSelection', "13");
			});
			
			// remove classes
			$(".ui-jqgrid").removeClass("ui-widget ui-widget-content");
		    $(".ui-jqgrid-view").children().removeClass("ui-widget-header ui-state-default");
		    $(".ui-jqgrid-labels, .ui-search-toolbar").children().removeClass("ui-state-default ui-th-column ui-th-ltr");
		    $(".ui-jqgrid-pager").removeClass("ui-state-default");
		    $(".ui-jqgrid").removeClass("ui-widget-content");
		    
		    // add classes
		    $(".ui-jqgrid-htable").addClass("table table-bordered table-hover");
		    $(".ui-jqgrid-btable").addClass("table table-bordered table-striped");
		   
		   
		    $(".ui-pg-div").removeClass().addClass("btn btn-sm btn-primary");
		    $(".ui-icon.ui-icon-plus").removeClass().addClass("fa fa-plus");
		    $(".ui-icon.ui-icon-pencil").removeClass().addClass("fa fa-pencil");
		    $(".ui-icon.ui-icon-trash").removeClass().addClass("fa fa-trash-o");
		    $(".ui-icon.ui-icon-search").removeClass().addClass("fa fa-search");
		    $(".ui-icon.ui-icon-refresh").removeClass().addClass("fa fa-refresh");
		    $(".ui-icon.ui-icon-disk").removeClass().addClass("fa fa-save").parent(".btn-primary").removeClass("btn-primary").addClass("btn-success");
		    $(".ui-icon.ui-icon-cancel").removeClass().addClass("fa fa-times").parent(".btn-primary").removeClass("btn-primary").addClass("btn-danger");
		  
			$( ".ui-icon.ui-icon-seek-prev" ).wrap( "<div class='btn btn-sm btn-default'></div>" );
			$(".ui-icon.ui-icon-seek-prev").removeClass().addClass("fa fa-backward");
			
			$( ".ui-icon.ui-icon-seek-first" ).wrap( "<div class='btn btn-sm btn-default'></div>" );
		  	$(".ui-icon.ui-icon-seek-first").removeClass().addClass("fa fa-fast-backward");		  	

		  	$( ".ui-icon.ui-icon-seek-next" ).wrap( "<div class='btn btn-sm btn-default'></div>" );
		  	$(".ui-icon.ui-icon-seek-next").removeClass().addClass("fa fa-forward");
		  	
		  	$( ".ui-icon.ui-icon-seek-end" ).wrap( "<div class='btn btn-sm btn-default'></div>" );
		  	$(".ui-icon.ui-icon-seek-end").removeClass().addClass("fa fa-fast-forward");
	  
	})

	$(window).on('resize.jqGrid', function () {
		$("#jqgrid").jqGrid( 'setGridWidth', $("#content").width() );
	})
	
	
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