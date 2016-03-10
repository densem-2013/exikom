<?php
/**
* @copyright		Copyright (C) 2011 SEBLOD. All Rights Reserved.
**/
define('_JEXEC', 1);
// No Direct Access
defined( '_JEXEC' ) or die;

$mainframe = JFactory::getApplication('administrator');
$mainframe->initialise();

$doc =& JFactory::getDocument(); //get instance of the global document instance

// Each position can be Overrided separately.
// Remove the underscore [_] from the Filename. (filename = position name)
// Write your Custom Position code. (see examples below)


// -------- // 1st example
echo $cck->renderField( 'art_catid' );
echo $cck->renderField( 'project_image' );
echo $cck->renderField( 'project_region' );

echo $cck->renderField( 'fild_value' );
echo $cck->renderField( 'project_field_commit' );
echo $cck->renderField( 'project_field' );
echo $cck->renderField( 'project_year' );
echo $cck->renderField( 'art_readmore' );
echo $cck->renderField( 'project_reed_more' );


$doc->addCustomTag('<script type="text/javascript" language="javascript" src="templates/isis/js/jquery.json.js"></script>'); 
$doc->addCustomTag('<script type="text/javascript" language="javascript">var $j = jQuery.noConflict();</script>'); //set jquery no conflict, selector is now $j instead of $

$doc->addCustomTag('
<script type="text/javascript" language="javascript">
  $j(document).ready(function(){
	  addCRUDbutton("region");
	  addCRUDbutton("field");
	  addCRUDbutton("year");
  
  });
  var addFadeDiv=function(parent_id,idinput,idbutCommit,idbutCancel){
	  var divnode=$j("<div>").appendTo(parent_id);
	  divnode.addClass(\'fade\');
	  $j(\'<input type="text"\/>\').appendTo(divnode).attr(\'id\',idinput);
	  $j(\'<input type="button"\/>\').appendTo(divnode).attr({\'id\':idbutCommit,value:"Commit"});
	  $j(\'<input type="button"\/>\').appendTo(divnode).attr({\'id\':idbutCancel,value:"Cancel"});
	  return divnode;
  };
  var addCRUDbutton = function(fieldname){
	  
	  addFuncByName("add",fieldname);
	  addFuncByName("edit",fieldname);
	  addFuncByName("delete",fieldname);
	  
  }
  var addFuncByName= function(btname,lockal_fieldname){
	  var parentnode=$j("#cck1r_project_" + lockal_fieldname);
	  var node="<input type=\'button\' id=\'" + btname + "_" + lockal_fieldname + "\' name=\'" + btname + "_" + lockal_fieldname + "\' value=\'" + btname + "\' />";
	  parentnode.append(node);
	  
	  var itsAdd=(btname==\'add\') ? true : false ;
	  var itsEdit=(btname==\'edit\') ? true : false ;
	  
	  var divnode=$j(\'<div>\').appendTo(parentnode).css({\'float\':\'left\',\'paddingLeft\':(!itsEdit)?\'60px\':\'0px\',\'display\':\'none\'});
	  divnode.attr(\'id\',btname+\'_\'+lockal_fieldname+\'_div\');
	  
	  $j("#" + btname + "_" + lockal_fieldname).on("click",function(){
		  var valueFieldId = btname + "_value_" + lockal_fieldname;
		  divnode.fadeIn();
	  });
	  if(!itsEdit)
	  {
		  $j("<span id=\'" + btname + "_label_" + lockal_fieldname + "\' name=\'" + btname + "_label_" + lockal_fieldname + "\'> " + btname + " " + lockal_fieldname + "</span>").appendTo(divnode).css(\'paddingRight\',\'10px\');
		  $j("<input type=\'text\' id=\'" + btname + "_value_" + lockal_fieldname + "\' name=\'" + btname + "_value_" + lockal_fieldname + "\'/>").appendTo(divnode);
	  }
	  else{
		  
		  $j("<span id=\'" + btname + "_old_label_" + lockal_fieldname + "\' name=\'" + btname + "_old_label_" + lockal_fieldname + "\'> Old value</span>").appendTo(divnode).css(\'paddingRight\',\'10px\');
		  $j("<input type=\'text\' id=\'" + btname + "_old_value_" + lockal_fieldname + "\' name=\'" + btname + "_old_value_" + lockal_fieldname + "\' class=\'EditInput\' />").appendTo(divnode);
		  $j("<span id=\'" + btname + "_label_" + lockal_fieldname + "\' name=\'" + btname + "_label_" + lockal_fieldname + "\'> New value</span>").appendTo(divnode).css(\'paddingRight\',\'10px\');
		  $j("<input type=\'text\' id=\'" + btname + "_value_" + lockal_fieldname + "\' name=\'" + btname + "_value_" + lockal_fieldname + "\' class=\'EditInput\'  />").appendTo(divnode);
	  }
	  $j("<input type=\'button\' id=\'" + btname + "_commit_" + lockal_fieldname + "\' name=\'" + btname + "_commit_" + lockal_fieldname + "\' value=\'Применить\'/>").appendTo(divnode).css(\'verticalAlign\',\'super\')
	  .click(function(){
			ajaxRequest(btname,lockal_fieldname);
		  });
	  $j("<input type=\'button\' id=\'" + btname + "_cancel_" + lockal_fieldname + "\' name=\'" + btname + "_cancel_" + lockal_fieldname + "\' value=\'Отмена\'/>").appendTo(divnode).css(\'verticalAlign\',\'super\');
	  $j("#" + btname + "_cancel_" + lockal_fieldname).on("click",function(){
			if(btname==\'edit\'){
				$j("#" + btname+"_old_value_"+lockal_fieldname).val(\'\');
			}
			$j("#" + btname+"_value_"+lockal_fieldname).val(\'\');
		  divnode.fadeOut();
	  });
  }
  var ajaxRequest=function(btname,lockal_fieldname){
	  var obj={
		  operation: btname,
		  tablepref: lockal_fieldname,
		  newvalue: $j("#" + btname + "_value_" + lockal_fieldname).val(),
		  oldvalue: $j("#" + btname + "_old_value_" + lockal_fieldname).val()
	  }
		console.log(obj);
		var values = $j.toJSON(obj);
		
        $j.ajax({
        url: "/exikom/test.php",
        type: "POST",
        data: values ,
		contentType: "application/json; charset=utf-8",
        success: function (response) {
			console.log();
			alert("OK! " + response);      
			
			if(btname==\'edit\'){
				$j("#" + btname+"_old_value_"+lockal_fieldname).val("");
			}
			$j("#" + btname + "_value_"+lockal_fieldname).val("");
			$j("#" + btname + "_" + lockal_fieldname  + "_div").fadeOut();
			       

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown,jqXHR.responseText);
        }


    });
  }
</script>
');
 