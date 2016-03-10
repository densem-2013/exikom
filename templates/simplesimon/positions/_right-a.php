<?php
/**
* @package			SD Simple Simon Template V2.5.0 for SEBLOD 3.x - www.seblod.com
* @license 			GNU General Public License version 2 or later
* @author       	Simon Dowdles - http://www.simondowdles.com
* @copyright		Copyright (C) 2013 Simon Dowdles New Media Holdings (Pty) Ltd. All Rights Reserved.
**/

// No Direct Access
defined( '_JEXEC' ) or die;
?>

<?php
// Each position can be Overrided separately.
// Remove the underscore [_] from the Filename. (filename = position name)
// Write your Custom Position code. (see examples below)


// -------- // 1st example
echo $cck->renderField( 'art_title' );


// -------- // 2nd example
//echo '<li>';
//echo $cck->getLabel( 'art_title', true );
//echo $cck->getForm( 'art_title' );
//echo '</li>';


// -------- // 3rd example
//echo '<li>';
//echo '<label>';
//echo $cck->getLabel( 'art_title' );
//echo '</label>';
//echo $cck->getForm( 'art_title' );
//echo '</li>';


// -------- // 4th example
// $cck->getFields( 'top-a' ) );


// -------- // 5th example
//if ( $cck->countFields( 'top-a' ) ) {
//	echo $cck->forcePosition( 'top-a' );
//}


// -------- // 6th example
//$f	=	$cck->get( 'art_title' );
//echo $f->label .' '. $f->title;

// -------- // 7th example
//echo $cck->get( 'art_title' )->value;
?>