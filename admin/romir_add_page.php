<?php



// if (!isset($editid)) {
	// include("romir_edit_new.php"); exit;
// }	

//initilize the page
require_once 'init.web.php';


$addnew=$_REQUEST["addnew"];

if (!empty($addnew)) {

  $short_url=$_REQUEST["short_url"];	

 
 $title=$_REQUEST["title"];
 $language=$_REQUEST["language"];
 $new_url=translit($title);
 
 
 
 $keywords="";
 if (isset($_REQUEST["keywords"]) && $_REQUEST["keywords"]!="") {
	$keywords=$_REQUEST["keywords"];
 }
 
 $description="";
 if (isset($_REQUEST["description"]) && $_REQUEST["description"]!="") {
	$description=$_REQUEST["description"];
 }	
 
 
 
 $page_url=$_REQUEST["page_url"];
 $page_url = str_replace('/','',$page_url);
 if (isset($page_url) && $page_url!="") {
	 $new_url=$page_url;
 }
 
 
 $ckeditor=$_REQUEST["ckeditor"];
  
 $parent_page_id=$_REQUEST["parent_page_id"];
 
 $ckeditor = mysqli_real_escape_string($conn, $ckeditor);
 $title = mysqli_real_escape_string($conn, $title);
 
 
 if ($parent_page_id=="") {
	 $parent_page_id=0;
	  $ckeditor='<nav class="breadcrumbs">
	<div class="wrap"><a href=""><i class="home-icon"></i></a> / <span>'.$title.'</span></div>
	</nav>

	<section class="content">
	<div class="wrap">
	<h1>'.$title.'</h1>

	<div class="content_block">'.$ckeditor.'</div>

	<a class="up anchor" href="#header"><svg enable-background="new 0 0 9 16.5" viewBox="0 0 9 16.5" xmlns="http://www.w3.org/2000/svg"><path class="arrow-line" d="m8.5 10v3c0 1.7-1.3 3-3 3s-3-1.3-3-3v-10" fill="none"></path><path class="arrow-triangle" d="m5 3h-5l2.5-3z"></path></svg> </a>


	</div>
	</section>';
 }
 
 
  $title = mysqli_real_escape_string($conn, $title);
 
 
 $new_url="/".$new_url;
 
  $query="INSERT INTO pages (keywords, description, short_name,url,html,language_id, parent_page_id) VALUE ('".$keywords."', '".$description."','".$title."','".$new_url."','".$ckeditor."',".$language.",".$parent_page_id." )";
		 if ($result = mysqli_query($conn, $query)) {
			 
			 
			 	 if (isset($short_url) && !empty($short_url)) {
					$last_id=mysqli_insert_id($conn);
					
					  $query_short_url="INSERT INTO short_url (short_url,page_id) VALUE ('".$short_url."', ".$last_id.")";
					 if ($result_short_url = mysqli_query($conn, $query_short_url)) {
							
					} else {
					//error;
					}
				}
			 
	
		} else {
		//error;
		}
 //echo $query;
 //exit;
 header("Location: ".APP_URL."/?ty=1"); 
 
}


$lang=1;
if (isset($_GET["lang"])) {
	$lang=$_GET["lang"];
}


$userinfo=CheckUserFromCookie();
if ($userinfo["loggin"]==false) {
	header("Location: ".APP_URL."/login.php"); 
	exit;
}
/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Новая страница";

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
						Новая страница	
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
						
                        						
				
                 <form id="add-form" class="smart-form" enctype="multipart/form-data"  method="post" action="<?=APP_URL?>/romir_add_page.php">
				 <input type="hidden" value="1" id="addnew" name="addnew"/>
				 <fieldset>
					
					 
						 <section>
						
							<?php 
							$short_name="";
							$html="";
							if (isset($_GET["parent_page_id"])) {
							
								if ($result = mysqli_query($conn, "SELECT * FROM pages WHERE id=".$_GET["parent_page_id"])) {
									$result->fetch_array(MYSQLI_ASSOC);

									foreach ($result as $row)	
									{
										$short_name=$row["short_name"];
										$html=$row["html"];
									}
									$result->close();
								}
								
								echo "<label class='label'>Название на русском - <b>".$short_name."</b></label><br>";
							}							
							?>							
						
						
							 <label class="label">Название</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="title" name="title" placeholder="Название"></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Короткая ссылка</label>
							 <label class="input"><input readonly type="text" id="short_url"  name="short_url" value="<?=CreateShortUrl()?>" placeholder="Короткая ссылка"/></label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 <fieldset>
							<section>
							 <label class="label">Keywords</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="keywords" name="keywords" placeholder="Keywords"></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Description</label>
							 <label class="textarea ">
							 <textarea class="custom-scroll" rows="3" id="description" name="description" placeholder="Description"></textarea>
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">Язык</label>
							 
							<label class="select">
							<select name="language" id="language">
							<option <?php if ($lang==1) {echo "selected";}?> value="1">Rus</option>
							<option <?php if ($lang==2) {echo "selected";}?> value="2">Eng</option>
							
							</select><i></i>
							</label>
							 
							 
						  </section>
					
				 </fieldset>
				 
				 <input type="hidden" value="<?php if (isset($_GET["parent_page_id"])) {echo $_GET["parent_page_id"];} ?>" id="parent_page_id" name="parent_page_id"/>
				 
				 
				 
				 <fieldset>
					
					 
						 <section>
							 <label class="label">УРЛ страницы (необязательное поле)</label>
							 <label class="input">
							<input type="text" placeholder="УРЛ страницы" id="page_url" name="page_url" />
							 </label>
						  </section>
					
				 </fieldset>
				 
				 
				 
				 
				 
				 
				 
				 <fieldset>
				
						 <section>
								    <label class="label">Текст страницы</label>
								
									<textarea name="ckeditor"><?=$html?></textarea>						
								
							
						  </section>
					
				 </fieldset>
					 
				  

				  <fieldset>
				
						 <section>
				 <a onclick="AddNewPage();" class="btn btn-info btn-lg">Сохранить</a>	 
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
		
		
		
		
		
		
	  
	})

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