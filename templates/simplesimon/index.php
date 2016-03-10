<?php
/**
* @package			SD Simple Simon Template V2.5.0 for SEBLOD 3.x - www.seblod.com
* @license 			GNU General Public License version 2 or later
* @author       	Simon Dowdles - http://www.simondowdles.com
* @copyright		Copyright (C) 2013 Simon Dowdles New Media Holdings (Pty) Ltd. All Rights Reserved.
**/

// No Direct Access
defined( '_JEXEC' ) or die;

require_once dirname(__FILE__).'/config.php';
$cck = new SdRendering;
$cck->getInstance( $this->template );
if ( $cck->initialize() === false ) { return; }

foreach($this->positions as $position => $fields){
	if($cck->countFields($position)){
		echo "<div class=\"SdPosition ".trim(strtolower($position))."\">";
		echo $cck->renderPosition($position);
		echo "</div>";
	};
};

$cck->finalize();

?>