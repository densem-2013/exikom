<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_userdata
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
// check if the tag cloud is selected to be animated
if($params->get( 'animated' )=="1") { 
	$doc =& JFactory::getDocument();
	$doc->addScript(JURI::root(true).'/modules/mod_zstagcloud/js/swfobject.js');
	}
?>

<input type="hidden" id="root_path" value="<?php echo JURI::root(true);?>" />
<input type="hidden" id="width" value="<?php echo $params->get( 'width' );?>" />
<input type="hidden" id="height" value="<?php echo $params->get( 'height' );?>" />
<input type="hidden" id="speed" value="<?php echo $params->get( 'speed' );?>" />
<input type="hidden" id="tcolor1" value="<?php echo $params->get( 'tcolor1' );?>" />
<input type="hidden" id="tcolor2" value="<?php echo $params->get( 'tcolor2' );?>" />
<input type="hidden" id="hcolor" value="<?php echo $params->get( 'hcolor' );?>" />
<input type="hidden" id="bcolor" value="<?php echo $params->get( 'bcolor' );?>" />
<input type="hidden" id="transparent" value="<?php echo $params->get( 'transparent' );?>" />
<div id="yoblako" style="outline:0;">
<tags>
	<?php 
	//generating tag links
		for($i=1; $i<=30; $i++) {
			$name = htmlspecialchars (trim($params->get("name_".$i)));				
			$url = htmlspecialchars (trim($params->get("url_".$i)));
			if ($name !="" && $url !="") {
				//check for http or https infront of the url				
				//if(substr($url, 0, 7)!="http://") {
				//	$url = "/exikom/".$url;					
				//	}
				echo "<a href='".$url."' class='tag-link-1' rel='tag' style='font-size: ".$params->get("size_".$i)."pt;'>".$name."</a> ";				
				}
							
			}	
	?> 
</tags>
</div>
<script type="text/javascript"> 
var flashvars = {}; 
flashvars.mode = 'tags'; 
flashvars.minFontSize = '8'; 
flashvars.maxFontSize = '15'; 
flashvars.tcolor = '0x'+document.getElementById('tcolor1').value; 
flashvars.tcolor2 = '0x'+document.getElementById('tcolor2').value; 
flashvars.hicolor = '0x'+document.getElementById('hcolor').value; 
flashvars.distr = 'true'; 
flashvars.tspeed = ''+document.getElementById('speed').value; 

eTagz = document.getElementById('yoblako').getElementsByTagName('A'); 
flashvars.tagcloud = '<tags>'; 
for (var i=0; eTagz[i]; ++i) { 

flashvars.tagcloud += '<a href=\'' + eTagz[i].getAttribute('href').replace(/&/g, '%26') 
+ '\' style=\'' + parseInt(eTagz[i].style.fontSize) 
+ '\'>' + eTagz[i].innerHTML.replace(/&amp;/g, '%26') + '</a>';
} 
delete eTagz; 
flashvars.tagcloud += '</tags>';
var params = {};

//Transparent
if(document.getElementById('transparent').value=="1") 
	params.wmode = 'transparent'; 

//Background color
if(document.getElementById('bcolor').value != "")
	params.bgcolor = '#'+document.getElementById('bcolor').value;
else
	params.bgcolor = '#FFFFFF';
 
params.allowscriptaccess = 'always'; 
var attributes = {}; 
attributes.id = 'yoblako'; 
attributes.name = 'tagcloud'; 
swfobject.embedSWF(document.getElementById('root_path').value+'/modules/mod_zstagcloud/swf/tagcloud.swf', 
						 'yoblako', 
						 document.getElementById('width').value, 
						 document.getElementById('height').value, 
						 '9.0.0', 
						 false, 
						 flashvars, 
						 params, 
						 attributes); 
</script> 
