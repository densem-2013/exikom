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
	echo "<div class=\"cck_project_image\"></div>";
}
$sitelink = (strlen($cck->get("project_customers_site")->link)<27)? $cck->get("project_customers_site")->link : substr(substr($cck->get("project_customers_site")->link,0,27),0,25)."...";

$company = $cck->get("project_company")->value;
$company = (strlen($company)<120)? $company : substr($company,0,strpos(company,' ',120));

$needtrim=strlen($cck->get("art_introtext")->value)<190;
$introtext=$cck->getValue("art_introtext");
$introtext= ($needtrim)?  $introtext : substr($introtext,0,strpos($introtext,' ',189)) . '...';
?>
<div class="cck-year">
	<div class="year-label"><label><?php echo $cck->getLabel('project_year'); ?></label></div>
	<div class="year-value"><span><?php echo $cck->getValue('project_year'); ?></span></div>
</div>
<div class="cck-company">
	<div class="company-value"><span><?php echo $company.'.'; ?></span></div>
</div>
<div class="cck-site">
	<div class="site-value"><p><span style="float:left; ">Сайт: </span><span style="float:right; "><a href="<?php echo $cck->get("project_customers_site")->link; ?>" class="link-action" target="_blank"><?php echo $sitelink ?></a></span></div>
</div>
<div class="cck-intro">
	<div class="intro-label"><label><?php echo $cck->getLabel('art_introtext'); ?>:</label></div>
	<div class="intro-value"><?php echo $introtext; ?></div>
</div>
<?php

if($cck->get('art_fulltext')->value )
{
	echo $cck->renderField( 'art_readmore' );
}else{
	if($cck->get('project_reed_more')->value && strlen($cck->get('project_reed_more')->link)>8){
	
	echo $cck->renderField( 'project_reed_more' );
}
}

?>