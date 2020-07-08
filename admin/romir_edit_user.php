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



if ($userinfo["role"]!=1) {
		header("Location: ".APP_URL."/login.php"); 
		exit;
}



/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Редактирование пользователя";




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

 
 if ($result = mysqli_query($conn, "SELECT users.*
	FROM users 
	WHERE users.id=".$editid)) {
		$result->fetch_array(MYSQLI_ASSOC);
		foreach ($result as $row)	
		{
			$fio=$row["fio"];
			$email=$row["email"];
			$password=$row["password"];
			$phone=$row["phone"];
			$role=$row["role"];
			
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
						<a href="<?=APP_URL?>/romir_user.php">Пользователи</a>
					<span>>  
						<?=$fio?>	
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
						
                        						
				
                 <form id="add-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_update_user.php">
				 <input type="hidden" value="1" id="adduser" name="adduser"/>
				 <fieldset>
				
						 <section>
						 <label class="label">ФИО</label>
							 <label class="input "><input type="text" id="fio" name="fio" value="<?=$fio?>" placeholder="ФИО"></label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
				
						 <section>
						 <label class="label">Email</label>
							 <label class="input "><input type="text" id="email" name="email" value="<?=$email?>" placeholder="Email"></label>
						  </section>
					
				 </fieldset>
				 
				 
				  <fieldset>
				
						 <section>
						 <label class="label">Пароль</label>
							 <label class="input "><input type="text" id="password" name="password" value="<?=$password?>" placeholder="Пароль"></label>
						  </section>
					
				 </fieldset>
				 
				 
				  <fieldset>
				
						 <section>
						 <label class="label">Телефон</label>
							 <label class="input "><input type="text" id="phone" name="phone" value="<?=$phone?>" placeholder="Телефон"></label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Роль</label>
							 
							<label class="select">
							<select name="role" id="role" onchange="RoleChange();">
							<option  value="1" <? if ($role==1) {echo "selected";} ?>>Админ</option>
							<option  value="2" <? if ($role==2) {echo "selected";} ?>>Пользователь</option>
							</select><i></i>
							</label>
							 
							 
						  </section>
					
				 </fieldset>
				 
			
				 
				  <? $menu_fieldset_display="none";   if ($role==2) { $menu_fieldset_display="block";}?>
				  
				  <fieldset id="menu_fieldset" style="display:<?=$menu_fieldset_display?>;">
										<section> 
											<label class="label">Пункты меню</label>
											<div class="row">
												<div class="col col-4">
												<? 
												$allmenuid=array();
												if ($result = mysqli_query($conn, "SELECT menu_id
											FROM user_menu_visibility 
											WHERE user_id=".$editid)) {
												$result->fetch_array(MYSQLI_ASSOC);
												foreach ($result as $row)	
												{
													$allmenuid[]=$row["menu_id"];
												}
												$result->close();
											}
												
												
												
												
												if ($user_menu = mysqli_query($conn, "SELECT user_menu.*
											FROM user_menu 
											ORDER BY user_menu.id")) {
												$user_menu->fetch_array(MYSQLI_ASSOC);
												foreach ($user_menu as $row)	
												{
													// checked="checked"
													$addtxt='';
													if (in_array($row["id"], $allmenuid)) {
													  $addtxt=' checked="checked" ';
													}
													
													?><label class="checkbox">
														<input type="checkbox" id="<?=$row["id"]?>" name="user_menu_id" <?=$addtxt?>>
														<i></i><?=$row["title"]?></label>
													<?
													
												}
												$user_menu->close();
											} 	?>
												
												</div>
											</div>	
										</section>
					
				 </fieldset>
				  
				 
			
				 
				 
				 
				 
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="SaveUser();" class="btn btn-info btn-lg">Сохранить</a>	 
				 <a onclick="DeleteUser();" class="btn btn-danger btn-lg pull-right">Удалить</a>
					  </section>
					
				 </fieldset>
					 
					 
				 </form>
						
				
				<div id="delete_dialog">
					<p>
					Вы уверены в том, чтобы удалить этого пользователя?
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
<!-- PAGE RELATED PLUGIN(S) -->



<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->


<script src="<?php echo ASSETS_URL; ?>/js/plugin/jqgrid/grid.locale-en.min.js"></script>

<script type="text/javascript">
	



	$(document).ready(function() {
		
		$('#delete_dialog').dialog({
				autoOpen : false,
				width : 600,
				resizable : false,
				modal : true,
				title : "Удаление пользователя",
				buttons : [{
					html : "<i class='fa fa-trash-o'></i>&nbsp; Удалить",
					"class" : "btn btn-danger",
					click : function() {
						
						$(this).dialog("close");
						RealUserDelete();
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

	 
	
	function RoleChange()
	{
	  if ($("#role").val()==="2"){
		  $("#menu_fieldset").show();
	  }	
	  else
	  {
		  $("#menu_fieldset").hide();
	  } 
	}
	
	
	
	function  DeleteUser()
	{
		$('#delete_dialog').dialog('open');
	}
	
	
	function RealUserDelete()
	{
		
		//console.log(page_id);
		var data={"user":1, "user_id":<?=$_GET["id"]?>, "oper":"delete_user"};
		$.ajax({
			  type: "POST",
			  url: "<?=APP_URL?>/ajax.php",
			  cache: false,
			  dataType:"json",
			  data: data,
			  success: function(msg){
				 if (msg.result===true) {
					 location.href="<?=APP_URL?>/?user_deleted";
				 } 
				//console.log( msg );
			  }
			});
		
	}
	
	
	
	
	
	function SaveUser() {
		var data={};
		
		data.user=1;
		data.oper="update_user";
		
		
		
		
		var fio=$("#fio").val();
		fio=$.trim(fio);
		
		if (fio.length===0){
			Alert("Введите ФИО"); return;
		}
		data.fio=fio;
		
		
		
		var email=$("#email").val();
		email=$.trim(email);
		if (email.length===0){
			Alert("Введите Email"); return;
		}
		data.email=email;
		
		var password=$("#password").val();
		password=$.trim(password);
		if (password.length===0){
			Alert("Введите пароль"); return;
		}
		data.password=password;
		
		var phone=$("#phone").val();
		phone=$.trim(phone);
		data.phone=phone;
		
		var role=$("#role").val();
		data.role=role;
		
		
		data.user_id=<?=$_GET["id"]?>;
		
		
		var elem = $('input[name^=user_menu_id]');
		if (elem.length>0){
			
			for (var i = 0; i < elem.length; i++){
				if ($(elem[i]).is(':checked')===true && $(elem[i]).is(':visible')===true)
				{
					
					if (typeof data.user_menu_id==="undefined"){
						data.user_menu_id=[];
					}
					data.user_menu_id.push(elem[i].id);
				}
				
			}
		}
		
		//console.log(data);
		//return;
			$.ajax({
			  type: "POST",
			  url: "<?=APP_URL?>/ajax.php",
			  cache: false,
			  dataType:"json",
			  data: data,
			  success: function(msg){
				  //console.log(msg);
				 if (msg.result===true) {
					 
						$.bigBox({
							title : "Успех",
							content : "Пользователь обновлен",
							color : "#739E73",
							timeout: 3000,
							icon : "fa fa-check"
							
						
						});
						
						
						
						

					 
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