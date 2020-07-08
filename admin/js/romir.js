$(document).ready(function () {
	
	if ($( "fieldset section label textarea#title" ).length>0){
		var obj = $("fieldset section label textarea#title"); 
		var total=70;
		var len=$(obj).val().length;
		var txt="Название "+len+" из "+total;
		$($(obj).parent().parent().find("label")[0]).text(txt);
	}
	
	$( "fieldset section label textarea#title" ).keyup(function() {
	  var obj = $("fieldset section label textarea#title"); 
	  var total=70;
	  var len=$(obj).val().length;
	  var txt="Название "+len+" из "+total;
	  $($(obj).parent().parent().find("label")[0]).text(txt);
	});

	
	
	if ($( "fieldset section label textarea#description" ).length>0){
		var obj = $("fieldset section label textarea#description"); 
		 var total=170;
		 var len=$(obj).val().length;
		 var txt="Description "+len+" из "+total;
		 $($( obj ).parent().parent().find("label")[0]).text(txt);
	}
	
	

	$( "fieldset section label textarea#description" ).keyup(function() {
	  var obj = $("fieldset section label textarea#description"); 
	  var total=170;
	  var len=$(obj).val().length;
	  var txt="Description "+len+" из "+total;
	  $($( obj ).parent().parent().find("label")[0]).text(txt);
	});
});	