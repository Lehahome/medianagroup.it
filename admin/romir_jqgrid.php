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

$page_title = "Индексы";

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




$indextext="";
if ($result = mysqli_query($conn, "SELECT * FROM indexes WHERE language_id=".$lang." ORDER BY sort ASC")) {
$result->fetch_array(MYSQLI_ASSOC);
foreach ($result as $row)	
{
	

	
	$indextext.="{
			id : \"".$row["id"]."\",
			title : \"".$row["title"]."\",
			count : \"".$row["count"]."\",
			time : \"".$row["time"]."\",
			amount : \"".$row["amount"]."\",
			amount_year : \"".$row["amount_year"]."\",
			amount_start_year : \"".$row["amount_start_year"]."\",
			active : \"".$row["active"]."\",
			sort : \"".$row["sort"]."\",
			language_id : \"".$row["language_id"]."\",
			media : \"".addslashes($row["media"])."\"
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
						Индексы
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
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">
				
				
				
				
				
				
				
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form class="smart-form">	
								<fieldset >
									<section>
										<label class="label">Язык</label>
										<div class="inline-group">
											<label class="radio">
												<input type="radio" onclick="location.href='<?=APP_URL?>/romir_jqgrid.php?lang=1'" name="radio-inline" <?php if ($lang==1){ ?> checked="checked" <?php } ?>>
												<i></i>RUS</label>
											<label class="radio">
												<input type="radio" onclick="location.href='<?=APP_URL?>/romir_jqgrid.php?lang=2'" name="radio-inline" <?php if ($lang==2){ ?> checked="checked" <?php } ?>>
												<i></i>ENG</label>
											
										</div>
									</section>
								</fieldset>
					</form>
					
						<input type="hidden" value="<?=$lang?>" id="lang" name="lang" />	
				
			
						<table id="jqgrid"></table>
							 <div id="pjqgrid"></div>
						
						<br>
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
		<?=$indextext?>];

		
		var editParams = {
    
    successfunc: function(response) {
       console.log(response);
    }
}; 
 //   var zipEditParams = $.extend(true, {}, editParams, {url: 'ajax.php'});



		
		
		
		
		var lastcell; 
		jQuery("#jqgrid").jqGrid({
			data : jqgrid_data,
			datatype : "local",
			height : 'auto',
			colNames : ['Операции', 'ID', 'Сортировка', 'Язык',  'Название', 'Число', 'Время', 'Изменение к предыдущему месяцу,% ', 'Изменение к текущему месяцу предыдущего года,% ', 'Изменение с начала года,% ', 'Видимость', 'Медиа'],
			colModel : [
				{ name : 'act', index:'act', sortable:false }, 
				{ name : 'id', index : 'id', hidden:true }, 
				{ name : 'sort', index : 'sort', editable : true },
				{ name : 'language_id', index : 'language_id', sortable : false, editable : true, edittype: "select", editoptions: {value: "1:RUS;2:ENG", defaultValue: "<?=$lang_txt?>"} },
				{ name : 'title', index : 'title', editable : true }, 
				{ name : 'count', index : 'count', editable : true }, 
				{ name : 'time', index : 'time', align : "right", editable : true }, 
				{ name : 'amount', index : 'amount', align : "right", editable : true }, 
				{ name : 'amount_year', index : 'amount_year', align : "right", editable : true }, 
				{ name : 'amount_start_year', index : 'amount_start_year', align : "right", editable : true },
				{ name : 'active', index : 'active', sortable : false, editable : true, edittype: "select", editoptions: {value: "1:Вкл.;0:Выкл."} },
				{ name : 'media', index : 'media', editable : true }
				
				],
			rowNum : 10,
			rowList : [10, 20, 30],
			pager : '#pjqgrid',
			sortname : 'id',
			toolbarfilter: true,
			viewrecords : true,
			sortorder : "asc",
			gridComplete: function(){
				var ids = jQuery("#jqgrid").jqGrid('getDataIDs');
				for(var i=0;i < ids.length;i++){
					var cl = ids[i];
					be = "<button class='btn btn-xs btn-default' data-original-title='Edit Row' onclick=\"jQuery('#jqgrid').editRow('"+cl+"');\"><i class='fa fa-pencil'></i></button>"; 
					se = "<button class='btn btn-xs btn-default' data-original-title='Save Row' onclick=\"jQuery('#jqgrid').jqGrid('saveRow', '"+cl+"',{    aftersavefunc: function (id, response, options) { var rez=JSON.parse(response.responseText); console.log(rez); if (rez.result===true){Success();} }});\"><i class='fa fa-save'></i></button>";
					ca = "<button class='btn btn-xs btn-default' data-original-title='Cancel' onclick=\"jQuery('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>";  
					//ce = "<button class='btn btn-xs btn-default' onclick=\"jQuery('#jqgrid').restoreRow('"+cl+"');\"><i class='fa fa-times'></i></button>"; 
					//jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ce});
					jQuery("#jqgrid").jqGrid('setRowData',ids[i],{act:be+se+ca});
				}	
			},
			onSelectRow: function(id){    
                //if(id && id!==lastcell){
                    // jQuery('#jqgrid').jqGrid('restoreRow',lastcell);
                    // jQuery('#jqgrid').jqGrid('editRow',id,true);
					//$("#jqgrid").jqGrid('editRow', id, true, null, null, null, {}, aftersavefunc);
					//$("#jqgrid").editRow(id, true, false, false, false, false, aftersavefunc);
					// $('#jqgrid').editGridRow(id, { afterSubmit: function(response, postdata) {
						   // //alert('got here');
						    // //console.log(response);
							// //console.log(postdata);
						// } 
					 // });
                    //lastcell=id;
                  //  }
                }, 
			editurl : "ajax.php",
			
			//caption : "Индексы",
			multiselect : false,
			autowidth : true
			
	

			});
			
			
			//$("#jqgrid").jqGrid('editRow', rowid, true, null, null, null, {}, aftersavefunc);
			
			
			
			 jQuery("#jqgrid").jqGrid('navGrid', "#pjqgrid", {
				edit : false,
				add : true,
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
	
	// function aftersavefunc(rowid, result) {
       // console.log(rowid);
	   // console.log(result);
    // }

</script>


<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>