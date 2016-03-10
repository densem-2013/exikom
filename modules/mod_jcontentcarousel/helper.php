<?php
/*------------------------------------------------------------------------
# J Content Carousel
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2013 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

class modJcontentCarouselHelper
{
	static function getJcontentCarouselOptions($id)
	{
		$db	    =   & JFactory::getDBO();
        $where  =   "";
        if($id!=0){
          $where    =   "AND a.catid = ".(int)$id."";
        }

		$query = 'SELECT a.id, a.title, a.introtext, a.fulltext, a.images' .
			' FROM #__content AS a' .
			' WHERE a.state="1" '.$where.'  ORDER BY a.id';
		$db->setQuery($query);

		if (!($options = $db->loadObjectList())) {
			echo "MD ".$db->stderr();
			return;
		}

		return $options;
	}
}
?>