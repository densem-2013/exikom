<?php

/*------------------------------------------------------------------------
# J Content Carousel
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2013 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;
require_once dirname(__FILE__).'/helper.php';

    $catid   = $params->get( 'catid', 0 );

    $layout = JModuleHelper::getLayoutPath('mod_jcontentcarousel');
    $options = modJcontentCarouselHelper::getJcontentCarouselOptions($catid);

	require($layout);

?>