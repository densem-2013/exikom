<?php

/*------------------------------------------------------------------------
# J Content Carousel
# ------------------------------------------------------------------------
# author                Md. Shaon Bahadur
# copyright             Copyright (C) 2013 j-download.com. All Rights Reserved.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
-------------------------------------------------------------------------*/

    defined('_JEXEC') or die('Restricted access');
    $title              =       $params->get( 'showtitle', 0 );
    $width              =       $params->get( 'width', 0 );
    $height             =       $params->get( 'height', 0 );
    $backgroundcolor    =       $params->get( 'backgroundcolor', 0 );
    $titlecolor         =       $params->get( 'titlecolor', 0 );
    $textcolor          =       $params->get( 'textcolor', 0 );
    $textlength         =       $params->get( 'textlength', 100 );
    $showreadmore       =       $params->get( 'showreadmore', 0 );
    $navigation         =       $params->get( 'navigation', 0 );
    $socialicon         =       $params->get( 'socialicon', 0 );
    $customcss          =       $params->get( 'customcss', 0 );
    $autoscroll         =       $params->get( 'autoscroll', 1 );
    $scrollspeed        =       $params->get( 'scrollspeed', 6000 );
    $detailwidth        =       $width-330;
?>
    <link rel="stylesheet" type="text/css" href="modules/mod_jcontentcarousel/tmpl/css/jcontentcarousel_site.css" />
    <link rel="stylesheet" type="text/css" href="modules/mod_jcontentcarousel/tmpl/css/jcontentcarousel_style.css" />
	<link rel="stylesheet" type="text/css" href="modules/mod_jcontentcarousel/tmpl/css/jcontentcarousel_jquery.jscrollpane.css" media="all" />
    <style>
        <?php echo $customcss; ?>
        #j_content_wrapper{
          color: <?php echo $textcolor; ?>;
        }
        #j_content_wrapper .ca-container{
	        width: <?php echo $width; ?>px;
	        height: <?php echo $height; ?>px;
        }
        #j_content_wrapper .ca-content{
	        width: <?php echo $detailwidth; ?>px;
        }
        #j_content_wrapper .ca-item h3{
        	color: <?php echo $titlecolor; ?>;
        }
        #j_content_wrapper .ca-item-main{
        	background: <?php echo $backgroundcolor; ?>;
        }
        #j_content_wrapper .ca-nav{
            <?php if($navigation==0){ echo 'display:none;'; }?>
        }


    </style>

    <div id="j_content_wrapper">
    	<div id="ca-container" class="ca-container">
    		<div class="ca-wrapper">
                <?php for ($i = 0, $n = count($options); $i < $n; $i ++) : ?>
        			<div class="ca-item ca-item-<?php echo $i; ?>">
        				<div class="ca-item-main">
                            <?php
                                $images = json_decode($options[$i]->images);
								if($images->image_intro){
                            ?>						
        					<div class="ca-icon">
                                <img src="<?php echo $images->image_intro; ?>" border="0" alt="<?php echo $images->image_intro_alt; ?>" />
                            </div>
							<?php } ?>
        					<h3><?php echo $options[$i]->title; ?></h3>
        					<h4>
        						<span class="ca-quote">&ldquo;</span>
        						<span>
                                  <?php
                                        if($options[$i]->introtext){
                                            if (strlen($options[$i]->introtext) >= 14){
                                                echo (substr($options[$i]->introtext, 0, $textlength). "...");
                                            }
                                              else
                                            {
                                                echo($options[$i]->introtext);
                                            }
                                        }
                                        else{
                                            if (strlen($options[$i]->fulltext) >= 14){
                                                echo (substr($options[$i]->fulltext, 0, $textlength). "...");
                                            }
                                              else
                                            {
                                                echo($options[$i]->fulltext);
                                            }
                                        }
                                    ?>
                                </span>
        					</h4>
        						<a href="javascript:void" class="ca-more">more...</a>
        				</div>
        				<div class="ca-content-wrapper">
        					<div class="ca-content">
                                <?php if($title==1){ ?>
        						    <h6><?php echo $options[$i]->title; ?></h6>
                                <?php } ?>
        						<a href="javascript:void" class="ca-close">close</a>
        						<div class="ca-content-text">
                                    <?php
                                          if($options[$i]->introtext){
                                            echo $options[$i]->introtext;
                                          }
                                          else{
                                            echo $options[$i]->fulltext;
                                          }
                                      ?>
        						</div>
        						<ul>
                                    <?php if($showreadmore==1){ ?>
        							<li><a href="index.php?option=com_content&view=article&id=<?php echo $options[$i]->id; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">Read more</a></li>
                                    <?php } ?>
                                    <?php if($socialicon==1){ ?>
        							<li><a href="http://www.facebook.com/sharer.php?u=<?php echo JURI::base(); ?>index.php?option=com_content&view=article&id=<?php echo $options[$i]->id; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">Facebook</a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url=<?php echo JURI::base(); ?>index.php?option=com_content&view=article&id=<?php echo $options[$i]->id; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>">Tweet</a></li>
                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo JURI::base(); ?>index.php?option=com_content&view=article&id=<?php echo $options[$i]->id; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>&source=LinkedIn">Linkedin</a></li>
                                    <?php } ?>
        						</ul>
        					</div>
        				</div>
        			</div>
                   <?php endfor; ?>
    		</div>
    	</div>
    </div>
    <script type="text/javascript" src="modules/mod_jcontentcarousel/tmpl/js/jquery.min.js"></script>
    <script type="text/javascript" src="modules/mod_jcontentcarousel/tmpl/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="modules/mod_jcontentcarousel/tmpl/js/jquery.mousewheel.js"></script>
    <script language="JavaScript">
    (function($) {
        var aux     = {
        navigate    : function( dir, $el, $wrapper, opts, cache ) {

            var scroll      = opts.scroll,
                factor      = 1,
                idxClicked  = 0;

            if( cache.expanded ) {
                scroll      = 1;
                factor      = 3;
                idxClicked  = cache.idxClicked;
            }

            if( dir === 1 ) {
                $wrapper.find('div.ca-item:lt(' + scroll + ')').each(function(i) {
                    $(this).clone(true).css( 'left', ( cache.totalItems - idxClicked + i ) * cache.itemW * factor + 'px' ).appendTo( $wrapper );
                });
            }
            else {
                var $first  = $wrapper.children().eq(0);

                $wrapper.find('div.ca-item:gt(' + ( cache.totalItems  - 1 - scroll ) + ')').each(function(i) {
                    $(this).clone(true).css( 'left', - ( scroll - i + idxClicked ) * cache.itemW * factor + 'px' ).insertBefore( $first );
                });
            }

            $wrapper.find('div.ca-item').each(function(i) {
                var $item   = $(this);
                $item.stop().animate({
                    left    :  ( dir === 1 ) ? '-=' + ( cache.itemW * factor * scroll ) + 'px' : '+=' + ( cache.itemW * factor * scroll ) + 'px'
                }, opts.sliderSpeed, opts.sliderEasing, function() {
                    if( ( dir === 1 && $item.position().left < - idxClicked * cache.itemW * factor ) || ( dir === -1 && $item.position().left > ( ( cache.totalItems - 1 - idxClicked ) * cache.itemW * factor ) ) ) {
                        $item.remove();
                    }
                    cache.isAnimating   = false;
                });
            });

        },

        openItem    : function( $wrapper, $item, opts, cache ) {
            cache.idxClicked    = $item.index();
            cache.winpos        = aux.getWinPos( $item.position().left, cache );
            $wrapper.find('div.ca-item').not( $item ).hide();
            $item.find('div.ca-content-wrapper').css( 'left', cache.itemW + 'px' ).stop().animate({
                width   : '<?php echo $detailwidth; ?>px',
                left    : cache.itemW + 'px'
            }, opts.itemSpeed, opts.itemEasing)
            .end()
            .stop()
            .animate({
                left    : '0px'
            }, opts.itemSpeed, opts.itemEasing, function() {
                cache.isAnimating   = false;
                cache.expanded      = true;

                aux.openItems( $wrapper, $item, opts, cache );
            });

        },

        openItems   : function( $wrapper, $openedItem, opts, cache ) {
            var openedIdx   = $openedItem.index();

            $wrapper.find('div.ca-item').each(function(i) {
                var $item   = $(this),
                    idx     = $item.index();

                if( idx !== openedIdx ) {
                    $item.css( 'left', - ( openedIdx - idx ) * ( cache.itemW * 3 ) + 'px' ).show().find('div.ca-content-wrapper').css({
                        left    : cache.itemW + 'px',
                        width   : '<?php echo $detailwidth; ?>px'
                    });

                    aux.toggleMore( $item, false );
                }
            });
        },
        toggleMore  : function( $item, show ) {
            ( show ) ? $item.find('a.ca-more').show() : $item.find('a.ca-more').hide();
        },
        closeItems  : function( $wrapper, $openedItem, opts, cache ) {
            var openedIdx   = $openedItem.index();

            $openedItem.find('div.ca-content-wrapper').stop().animate({
                width   : '0px'
            }, opts.itemSpeed, opts.itemEasing)
            .end()
            .stop()
            .animate({
                left    : cache.itemW * ( cache.winpos - 1 ) + 'px'
            }, opts.itemSpeed, opts.itemEasing, function() {
                cache.isAnimating   = false;
                cache.expanded      = false;
            });

            aux.toggleMore( $openedItem, true );

            $wrapper.find('div.ca-item').each(function(i) {
                var $item   = $(this),
                    idx     = $item.index();

                if( idx !== openedIdx ) {
                    $item.find('div.ca-content-wrapper').css({
                        width   : '0px'
                    })
                    .end()
                    .css( 'left', ( ( cache.winpos - 1 ) - ( openedIdx - idx ) ) * cache.itemW + 'px' )
                    .show();

                    aux.toggleMore( $item, true );
                }
            });
        },

        getWinPos   : function( val, cache ) {
            switch( val ) {
                case 0                  : return 1; break;
                case cache.itemW        : return 2; break;
                case cache.itemW * 2    : return 3; break;
            }
        }
    },
    methods = {
        init        : function( options ) {

            if( this.length ) {

                var settings = {
                    sliderSpeed     : 500,
                    sliderEasing    : 'easeOutExpo',
                    itemSpeed       : 500,
                    itemEasing      : 'easeOutExpo',
                    scroll          : 1
                };

                return this.each(function() {

                    if ( options ) {
                        $.extend( settings, options );
                    }

                    var $el             = $(this),
                        $wrapper        = $el.find('div.ca-wrapper'),
                        $maincontainer  = $el.find('div.container'),
                        $isopen         = 0,
                        $autoscroll     = <?php echo $autoscroll; ?>,
                        $asspeed        = <?php echo $scrollspeed; ?>,
                        $items          = $wrapper.children('div.ca-item'),
                        cache           = {};

                    cache.itemW         = $items.width();
                    cache.totalItems    = $items.length;

                    if( cache.totalItems > 3 )
                        $el.prepend('<div class="ca-nav"><span class="ca-nav-prev">Previous</span><span class="ca-nav-next">Next</span></div>')

                    if( settings.scroll < 1 )
                        settings.scroll = 1;
                    else if( settings.scroll > 3 )
                        settings.scroll = 3;

                    var $navPrev        = $el.find('span.ca-nav-prev'),
                        $navNext        = $el.find('span.ca-nav-next');

                    $wrapper.css( 'overflow', 'hidden' );

                    $items.each(function(i) {
                        $(this).css({
                            position    : 'absolute',
                            left        : i * cache.itemW + 'px'
                        });
                    });

                    $el.find('a.ca-more').live('click.contentcarousel', function( event ) {
                        if( cache.isAnimating ) return false;
                        cache.isAnimating   = true;
                        $isopen = 1;
                        $(this).hide();
                        var $item   = $(this).closest('div.ca-item');
                        aux.openItem( $wrapper, $item, settings, cache );
                        clearTimeout(tid);
                        return false;
                    });

                    $el.find('a.ca-close').live('click.contentcarousel', function( event ) {
                        if( cache.isAnimating ) return false;
                        cache.isAnimating   = true;
                        var $item   = $(this).closest('div.ca-item');
                        aux.closeItems( $wrapper, $item, settings, cache );
                        $isopen = 0;
                        return false;
                    });

                    if ($autoscroll == 1){
                        var tid = setTimeout(ascroll, $asspeed);

                        $wrapper.bind('mouseover.contentcarousel', function( event ) {
                            clearTimeout(tid);
                        });

                        $wrapper.bind('mouseout.contentcarousel', function( event ) {
                            if ($isopen == 0){
                            tid = setTimeout(ascroll, $asspeed);
                            };
                        });

                    };

                    function ascroll() {
                        if( cache.isAnimating ) return false;
                        cache.isAnimating   = true;
                        aux.navigate( 1, $el, $wrapper, settings, cache );
                        tid = setTimeout(ascroll, $asspeed);
                    };

                    $navPrev.bind('click.contentcarousel', function( event ) {
                        if( cache.isAnimating ) return false;
                        cache.isAnimating   = true;
                        aux.navigate( -1, $el, $wrapper, settings, cache );
                    });

                    $navNext.bind('click.contentcarousel', function( event ) {
                        if( cache.isAnimating ) return false;
                        cache.isAnimating   = true;
                        aux.navigate( 1, $el, $wrapper, settings, cache );
                    });

                    $el.bind('mousewheel.contentcarousel', function(e, delta) {
                        if(delta > 0) {
                            if( cache.isAnimating ) return false;
                            cache.isAnimating   = true;
                            aux.navigate( -1, $el, $wrapper, settings, cache );
                        }
                        else {
                            if( cache.isAnimating ) return false;
                            cache.isAnimating   = true;
                            aux.navigate( 1, $el, $wrapper, settings, cache );
                        }
                        return false;
                    });

                });
            }
        }
    };

    $.fn.contentcarousel = function(method) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.contentcarousel' );
        }
    };

})(jQuery);
    </script>
    <script type="text/javascript">
    	$('#ca-container').contentcarousel();
    </script>
