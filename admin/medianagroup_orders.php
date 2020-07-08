<?php

//initilize the page
require_once 'init.web.php';

$page_menu_id=9;

$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}

 


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Заказы";

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


	$status_arr=array(1=>"новый",2=>"обработан");
	$payment_arr=array(0=>"онлайн / нет оплаты",1=>"онлайн / оплата прошла",2=>"наложенным платежом",3=>"наличными");

	$ordertxt="";

	$newstext="";
	if ($result = mysqli_query($conn, "SELECT orders.*, customers.fio as customer_name 
	FROM orders 
	LEFT JOIN customers ON customers.id = orders.customer_id
	ORDER BY orders.order_time DESC")) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			//$title = mysqli_real_escape_string($conn, $row["title"]);
			$newstext.="{
					id : \"".$row["id"]."\",
					customer_name : \"".addslashes($row["customer_name"])."\",
					order_time : \"".addslashes($row["order_time"])."\",
					status : \"".$status_arr[$row["status_id"]]."\",
					payment : \"".$payment_arr[$row["payment"]]."\"
				},";
		}
		$result->close();
	} 
	
	
	if ($result = mysqli_query($conn, "SELECT order_items.*, goods.title as good_title, goods.price as good_price, order_items.quantity as good_quantity
	FROM order_items
	JOIN goods ON goods.id = order_items.good_id
	ORDER BY order_items.order_id, goods.id
	")) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			$title = mysqli_real_escape_string($conn, $row["good_title"]);
			$ordertxt.="{
					id : \"".$row["id"]."\",
					order_id : \"".addslashes($row["order_id"])."\",
					good_title : \"".$title."\",
					good_price : \"".addslashes($row["good_price"])."\",
					good_quantity : \"".$row["good_quantity"]."\"
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
						Заказы
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
						
						
						<table id="jqgrid"></table>
							 <div id="pjqgrid"></div>
						
						<br>
						

				</article>
				
				
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

	
		order_data = [
		<?=$ordertxt?>];
	
		var jqgrid_data = [
		<?=$newstext?>];

		
		// var editParams = {
    
    // successfunc: function(response) {
       // console.log(response);
    // }
// }; 
 //   var zipEditParams = $.extend(true, {}, editParams, {url: 'ajax.php'});


					// id : \"".$row["id"]."\",
					// customer_name : \"".addslashes($row["customer_name"])."\",
					// order_time : \"".addslashes($row["order_time"])."\",
					// status_id : \"".addslashes($row["status_id"])."\",
					// payment : \"".addslashes($row["payment"])."\"
		
		
		
		
		var lastcell; 
		jQuery("#jqgrid").jqGrid({
			data : jqgrid_data,
			datatype : "local",
			height : 'auto',
			colNames : ['Номер заказа', 'Покупатель', 'Время заказа', 'Статус',  'Тип оплаты'],
			colModel : [
				
				{ name : 'id', index : 'id',  editable : false, sortable : true,  hidden:false  }, 
				{ name : 'customer_name', index : 'customer_name', editable : false, sortable : true }, 
				{ name : 'order_time', index : 'order_time', editable : true, sortable : true }, 
				{ name : 'status', index : 'status', sortable : true, editable : true },
				{ name : 'payment', index : 'payment', sortable : true, editable : true }
				],
			rowNum : 10,
			rowList : [10, 20, 30],
			pager : '#pjqgrid',
			//sortname : 'id',
			toolbarfilter: true,
			viewrecords : true,
			//sortorder : "asc",
			gridComplete: function(){
				
								
			},
			onSelectRow: function(id){    
			        console.log(id);
					showOrder(id);
			      //window.location.href="<?=APP_URL?>/romir_edit_subscribe.php?id="+id;
			     
                }, 
			editurl : "ajax.php",
			
			caption : "Заказы",
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
	
	
	function showOrder(id)
	{
		var tsum = 0;
		var otxt = "<table class='mtable'><tr class='mheader'><td>Название</td><td>Кол-во</td><td>Цена</td></tr>";
		for (var i = 0; i < order_data.length; i++) {
			
			if (order_data[i].order_id === id) {
				console.log(order_data[i]);
				otxt +=  "<tr class='mdata'><td>" + order_data[i].good_title + "</td><td>" + order_data[i].good_quantity + "</td><td>" + order_data[i].good_price + "</td></tr>";
				
				tsum += parseInt(order_data[i].good_quantity,10) * parseInt(order_data[i].good_price,10)
			}
		}
		
		otxt +=  "<tr class='mdata'><td>ИТОГО:</td><td></td><td>" + tsum + "</td></tr>";
		
		otxt +=  "</table>";
		
		$.bigBox({
						title : "Заказ № " + id,
						content : otxt,
						color : "#3d3d3b",
						//timeout: 2000,
						//icon : false,
						sound: false
					});
			
		$("#divbigBoxes .bigboxicon").hide();
		$("#divMiniIcons").hide();		
	}
	
	// function aftersavefunc(rowid, result) {
       // console.log(rowid);
	   // console.log(result);
    // }

</script>
<style>

.mtable {width:100%;}

.mtable td{padding:2px;}
</style>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>