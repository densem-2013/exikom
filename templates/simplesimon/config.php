<?php
/**
* @package			SD Simple Simon Template V2.5.0 for SEBLOD 3.x - www.seblod.com
* @license 			GNU General Public License version 2 or later
* @author       	Simon Dowdles - http://www.simondowdles.com
* @copyright		Copyright (C) 2013 Simon Dowdles New Media Holdings (Pty) Ltd. All Rights Reserved.
**/

// No Direct Access
global $user;
defined( '_JEXEC' ) or die;
$app		=	JFactory::getApplication();
$rend_path	=	JPATH_SITE.'/libraries/cck/rendering/rendering.php';
$user		=	JCck::getUser();

if (!file_exists($rend_path)){
	echo  '<h2>Cannot find CCK rendering files. Are you sure you have SEBLOD CCK installed?</h2>';
	die();
}

// Require Rendering Class
require_once $rend_path;

// Extend rendering class & overide public functions
class SdRendering extends CCK_Rendering{
	
	// renderField
	public function renderField( $fieldname = '', $options = NULL )
	{
		$html	=	'';
		$field	=	$this->get( $fieldname );
		if ( !$field ) {
			return $html;
		}
		
		if ( $field->display ) {
			$html	=	JCck::callFunc_Array( 'plgCCK_Field'.$field->type, $this->methodRender, array( $field, &$this->config ) );
			
			if ( $field->display > 1 && $html ) {
				if ( ! $options ) {
					$options	= new JRegistry;
				}
				
				if ( $this->markup ) {
					$call	=	$this->markup;
					$html	=	$call( $this, $html, $field, $options );
				} else {
					$style	=	'';
					if ( $this->methodRender == 'onCCK_FieldRenderForm' && @$field->conditional ) {
						$conditions					=	explode( ',', $field->conditional );
						$field->conditional_options	=	str_replace( '#form#', '#'.$field->name, $field->conditional_options );
						if ( count( $conditions ) > 1 ) {
							$this->addJS( '$j("#'.$this->id.'_'.$fieldname.'").conditionalStates('.$field->conditional_options.');' );
						} else {
							$this->addJS( '$j("#'.$this->id.'_'.$fieldname.'").conditionalState('.$field->conditional_options.');' );
						}
					}
					
					$desc	=	'';
					if ( $this->getStyleParam( 'field_description', 0 ) ) {
						$desc	=	( $field->description != '' ) ? '<div id="'.$this->id.'_desc_'.$fieldname.'" class="cck_desc cck_desc_'.$field->type.'">'.$field->description.'</div>' : '';
					}
					
					$label	=	'';
					if ( $options->get( 'field_label', $this->getStyleParam( 'field_label', 1 ) ) ) {
						$label	=	$this->getLabel( $fieldname, true, ( $field->required ? '*' : '' ) );
						$label	=	( $label != '' ) ? '<div id="'.$this->id.'_label_'.$fieldname.'" class="cck_label cck_label_'.$field->type.'">'.$label.'</div>' : '';
					}
					
				}
			}
		}
		
		return $html;
	}
	
	public function renderPositions( $position = '', $variation = '', $n = 0, $w = '', $h = '' )
	{
		$doc	=	JFactory::getDocument();
		$html	=	'';
		
		for ( $i = 0; $i < 6; $i++ ) {
			$p		=	chr( $i + 97 );
			$pos	=	$position.'-'.$p;
			$width	=	'';
			$height	=	'';
			if ( @$this->positions_m[$pos]->width != '' ) {
				if ( strpos( $this->positions_m[$pos]->width, 'px' ) !== false ) {
					$width	=	$this->positions_m[$pos]->width;
					$doc->addStyleDeclaration( '.cck-w'.$width.'{width:'.$width.';}' );
				} else {
					$width	=	str_replace( '%', '', $this->positions_m[$pos]->width);
				}
			} else {
				$width	=	$w;
			}
			if ( @$this->positions_m[$pos]->height != '' ) {
				$height	=	$this->positions_m[$pos]->height;
			} else if ( $h != '' ) {
				$height	=	$h;
			}
			if ( $this->countFields( $pos ) ) {
				$html	.=	$this->renderPosition( $pos, '', $height );
            }
		}
		if ( $variation ) {
			$options	=	new JRegistry;
			$html		=	$this->renderVariation( $variation, $legend, $html, $options, $position.'_line', '', false );
		}

		echo $html;
	}
}
?>