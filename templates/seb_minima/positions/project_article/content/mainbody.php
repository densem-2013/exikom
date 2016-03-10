<?php
/**
* @copyright		Copyright (C) 2011 SEBLOD. All Rights Reserved.
**/
define('_JEXEC', 1);
// No Direct Access
defined( '_JEXEC' ) or die;

if($cck->get( 'project_image' )->value){
	echo $cck->renderField( 'project_image' );
}
else{
	echo "<div style=\"height:180px\"></div>";
}
//echo $cck->renderField( 'project_year' );
//echo $cck->renderField( 'project_customers_site' );
//echo $cck->renderField( 'project_company' );
?>
<div class="cck-year">
	<div class="year-label"><label><?php echo $cck->getLabel('project_year'); ?></label></div>
	<div class="year-value"><span><?php echo $cck->getValue('project_year'); ?></span></div>
</div>
<div class="cck-company">
	<div class="company-label"><span><?php echo $cck->get("project_company")->label. str_repeat('&nbsp;', 5); ?></span></div>
	<div class="company-value"><span><?php echo $cck->getValue("project_company"); ?></span></div>
</div>
<div class="cck-site" >
	<div class="site-value"><p><span style="float:left; "><?php echo $cck->get("project_customers_site")->label . str_repeat('&nbsp;', 5); ?></span><span style="float:left; "><a href="<?php echo $cck->get("project_customers_site")->link; ?>" class="link-action" target="_blank"><?php echo $cck->get("project_customers_site")->link; ?></a></span></div>
</div>
<!--<div class="cck-intro">
	<div class="intro-label"><label><?php echo $cck->getLabel('art_introtext'); ?>:</label></div>
	<div class="intro-value"><?php echo $introtext; ?></div>
</div> -->
<?php

echo $cck->renderField( 'art_fulltext' );


?>