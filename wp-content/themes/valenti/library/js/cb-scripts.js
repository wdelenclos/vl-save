/* global jQuery, cbScripts, cookie, 5.4 */
(function($) { "use strict";
    var cbBody = $('body'),
    cbWindow = $(window),
    cbDoc = $(document),
    cbWindowWidth = cbWindow.width(),
    cbWindowHeight = cbWindow.height() + 1,
    cbContainer = $('#cb-container'),
    cbContent = $('#cb-content'),
    cbNavBar = $('#cb-nav-bar'),
    cbMain = $('#main'),
    cbAdminBar = false,
    cbBGOverlay = $('#cb-overlay'),
    cbStickyOb = $('.cb-sticky-sidebar'),
    cbDistStuckParent =[],
    cbSib,
    cbWindowScrollTop,
    cbWindowScrollTopCache = 0,
    cbWindowScrollTopSS,
    cbWindowScrollDir,
    cbStickyAjax,
    cbWindowScrollTopSM,
    cbTimer = 0,
    cbStickyBotCache = 0,
    cbStickyTopCache = 0,
    cbInfiniteScroll = $('#cb-blog-infinite-scroll'),
    cbCheckerI = false,
    cbFooterEl = $('#cb-footer'),
    cbStickyHeightCache,
    cbLoad = false,
    cbReady = true,
    cbSlider1Post = $('.cb-slider-b'),
    cbStickyTopVal,
    cbMenuHeight,
    cbNavBarDiv = cbNavBar.find(' > div'),
    cbNavBarFirstLI = cbNavBarDiv.find(' > ul li').first(),
    cbMSearchTrig = $('#cb-s-trigger'),
    cbMSearchTrigSM = $('#cb-s-trigger-sm'),
    cbLWA = $('#cb-lwa'),
    cbLWATrigger = $('#cb-lwa-trigger'),
    cbLWARTriggerSM = $('#cb-lwa-trigger-sm'),
    cbLWARTrigger = $('.cb-lwa-r-trigger'),
    cbLWAForms = cbLWA.find('.lwa-form'),
    cbLWAinputuser = cbLWAForms.find('.cb-form-input-username'),
    cbBodyRTL = false,
    cbcloser = $('.cb-close-m').add(cbBGOverlay),
    cbMSearch = $('#cb-search-modal'),
    cbMSearchI = cbMSearch.find('input'),
    cbMenuItemWrap = $('#cb-icons-wrap'),
    cbReviewCont = $('#cb-review-container'),
    cbRatingBars = cbReviewCont.find('.cb-overlay span'),
    cbRatingStars = cbReviewCont.find('.cb-overlay-stars span'),
    cbMenuOffset,
    cbOverlaySpan,
    cbTMS = $('#cb-top-menu'),
    cbTMSWrap = cbTMS.find('.cb-top-menu-wrap'),
    cbVote = $('#cb-vote'),
    cbFeaturedMain = $('#cb-full-background-featured'),
    cbFBFISAttr = cbFeaturedMain.attr('data-cb-bs-fis'),
    cbSSAttr = cbFeaturedMain.attr('data-cb-ss-fis'),
    cbParallaxMain = $('#cb-parallax-featured'),
    cbFWFIS = $("#cb-full-width-featured-img"),
    cbFWFISAttr = cbFWFIS.attr('data-cb-bs-fis'),
    cbBodyBGAttr = cbBody.attr('data-cb-bg'),
    cbCatTitleBg = $('#cb-cat-header'),
    cbCatTitleBgAttr = cbCatTitleBg.attr('data-cb-bg'),
    cbParallaxImg = cbParallaxMain.find('.cb-image'),
    cbParallaxBG = $('#cb-parallax-bg'),
    cbMobOp = $('#cb-mob-open'),
    cbMobCl = $('#cb-mob-close'),
    cbWindowHeightTwo,
    cbFlexFW = $('.flexslider-1-fw'),
    cbFlexSW = $('.flexslider-1'),
    cbToTop = $('#cb-to-top'),
    cbNonce,
    cbFlag = false,
    cbNavLogo = $('#cb-nav-logo'),
    cbcloser = $('.cb-close-m').add(cbBGOverlay),
    cbMobileTablet = false,
    cbMobilePhone = false;

    if ( ( cbBody.hasClass('cb-body-tabl') ) || ( cbBody.hasClass('cb-body-mob') ) ) {
        cbMobileTablet = true;
    }

    if ( cbBody.hasClass('cb-body-mob') ) {
        cbMobilePhone = true;
    }

    if ( cbBody.hasClass('rtl') ) { cbBodyRTL = true; }
    if ( typeof cbFWFISAttr !== 'undefined' ) {
        cbFWFIS.backstretch( cbFWFISAttr, {speed: 350});
    }

    if ( typeof cbFBFISAttr !== 'undefined' ) {
        $.backstretch( cbFBFISAttr, {speed: 350});
        if ( cbMobileTablet === false ) {
            $(".backstretch").css("position", "absolute" );
        }
    }

    if ( typeof cbBodyBGAttr !== 'undefined' ) {

        if ( cbBodyBGAttr.indexOf(',') > -1 ) {
            $.backstretch( cbBodyBGAttr.split(","), {fade: 750, duration: 5000});
        } else {
            cbBody.backstretch( cbBodyBGAttr, {fade: 750} );
        }


        cbBody.removeAttr('data-cb-bg');
    }

    if ( typeof cbCatTitleBgAttr !== 'undefined' ) {
        cbCatTitleBg.backstretch( cbCatTitleBgAttr, {fade: 750} );
    }

    if ( typeof cbSSAttr !== 'undefined' ) {

        $.backstretch( cbSSAttr.split(","), {fade: 750, duration: 5000});
        if ( cbMobileTablet === false ) {
            $(".backstretch").css("position", "absolute" );
        }
    }

    if ( cbNavBar.length ) {
        if  ( cbWindowWidth > 767 ) {
            cbMenuHeight = cbNavBarDiv.outerHeight();
        }

        cbNavBar.css( 'height', cbMenuHeight );
        cbMenuItemWrap.add(cbNavLogo).css( 'height', cbNavBarFirstLI.outerHeight() );
    }

    if ( cbBody.hasClass('admin-bar') ) { cbAdminBar = true; }

    cbSlider1Post.each( function() {
        var cbThis = $(this);

        if ( cbThis.hasClass('cb-module-fw') || cbThis.hasClass('cb-full-slider' ) ) {
            cbThis.find('.slides > li').css( 'height', ( cbThis.width() / 2.3076923 ) );
        } else if ( cbThis.hasClass('cb-slider-widget') ) {
            cbThis.find('.slides > li').css( 'height', ( cbThis.width() / 1.6 ) );
        } else {
            cbThis.find('.slides > li').css( 'height', ( cbThis.width() / 1.876923 ) );
        }

    });

    cbMobOp.click( function(e) {

        e.preventDefault();
        cbBody.addClass('cb-mob-op');

    });

    cbMobCl.click( function(e) {

        e.preventDefault();
        cbBody.removeClass('cb-mob-op');

    });

    cbLWATrigger.click( function( e ) {
        e.preventDefault();
        cbBody.addClass('cb-lwa-modal-on');
        if ( cbMobileTablet === false ) {
            cbLWAinputuser.focus();
        }

    });

    cbLWARTrigger.click( function( e ) {
        e.preventDefault();
        cbBody.addClass('cb-lwa-r-modal-on');
    });

    cbLWARTriggerSM.click( function( e ) {
        e.preventDefault();
        cbBody.addClass('cb-lwa-modal-on');
        if ( cbMobileTablet === false ) {
            cbLWAinputuser.focus();
        }

    });

    cbcloser.click( function() {
        cbBody.removeClass('cb-lwa-modal-on cb-lwa-r-modal-on cb-s-modal-on cb-m-modal-on cb-m-em-modal-on');
        cbPauseYTVideo();
    });

     cbDoc.keyup(function(e) {

        if (e.keyCode == 27) {
            cbBody.removeClass('cb-lwa-modal-on cb-lwa-r-modal-on cb-s-modal-on cb-m-modal-on cb-m-em-modal-on');
            cbPauseYTVideo();
        }
    });

    cbMSearchTrig.click( function( e ) {
        e.preventDefault();

        cbBody.addClass('cb-s-modal-on');
        if ( cbMobileTablet === false ) {
            cbMSearchI.focus();
        }
    });

    cbMSearchTrigSM.click( function( e ) {
        e.preventDefault();

        cbBody.addClass('cb-s-modal-on');
        if ( cbMobileTablet === false ) {
            cbMSearchI.focus();
        }
    });
    function cbOnScroll() {

        if ( cbAdminBar === true ) {
            if ( cbWindowWidth > 781 ) {
                cbWindowScrollTop = cbWindow.scrollTop() + 32;
            } else {
                cbWindowScrollTop = cbWindow.scrollTop() + 46;
            }
        } else {
            cbWindowScrollTop = cbWindow.scrollTop();
        }
        
        if ( cbWindowScrollTop > cbWindowScrollTopCache ) {
            cbWindowScrollDir = 2;
        } else {
            cbWindowScrollDir = 1;
        }

        cbWindowScrollTopSS = cbWindowScrollTop;
        if ( cbBody.hasClass('cb-stuck') && ( cbWindowScrollDir === 1 ) ) {
            cbWindowScrollTopSS = cbWindowScrollTop + cbNavBar.outerHeight();
        }

        if ( cbBody.hasClass('cb-stuck') ) {
            cbWindowScrollTopSM = cbWindowScrollTop + cbNavBar.outerHeight();
        }

        cbWindowScrollTopCache = cbWindowScrollTop;

        cbChecker();

    }

    function cbChecker() {

        if ( ! cbCheckerI ) {
            requestAnimationFrame(cbScrolls);
            cbCheckerI = true;
        }
    }

    function cbFixdSidebarLoad() {

        if ( cbLoad === false ) {
            cbScrolls();
            cbScrolls();
            cbLoad = true;
        }
    }

    function cbScrolls() {

        if ( cbBody.hasClass( 'cb-sticky-mm' ) ) {

            if ( ! cbBody.hasClass('cb-sticky-menu-up') ) {
                if ( cbWindowScrollTop >= cbMenuOffset ) {

                    cbBody.addClass('cb-stuck');

                } else {
                    cbBody.removeClass('cb-stuck');
                }
            } else {

                if ( ( cbWindowScrollTop >= cbMenuOffset ) && ( cbWindowScrollDir === 1 ) ) {

                    cbBody.addClass('cb-stuck');

                } else {
                    cbBody.removeClass('cb-stuck');
                }

            }

        }

        if ( ( cbWindowWidth > 767 ) && ( cbMobileTablet === false ) ) {
            if ( cbStickyOb.length ) {

                cbStickyOb.each( function( index ) {
                    var cbThis = $(this),
                        cbStickySBEL = cbThis.find('.cb-sidebar'),
                        cbStickyHeight = cbStickySBEL.outerHeight(true),
                        cbStickyTop = cbThis.offset().top,
                        cbStickySBELTop = cbStickySBEL.offset().top,
                        cbStickySBELBot = cbStickySBELTop + cbStickyHeight,
                        cbStickySBELMT = parseInt( cbStickySBEL.css('margin-top'), 10 ),
                        cbStickyBot = cbStickyTop + cbStickyHeight,
                        cbCurScrollBot = cbWindowHeight + cbWindowScrollTopSS,
                        cbParent = cbThis.parent(),
                        cbFirstChildCheck = cbParent.children(':first'),
                        cbParentPadTop = parseInt( cbParent.css('padding-top'), 10 ),
                        cbParentTop = cbParent.offset().top  + cbParentPadTop,
                        cbParentHeight = cbParent.outerHeight(),
                        cbParentBot = cbParentTop + cbParentHeight;
                        cbDistStuckParent = cbWindowScrollTopSS - cbStickyTop;

                    if ( ( ! cbBody.hasClass('home') &&  ! cbBody.hasClass('page')  ) && ( cbFirstChildCheck.hasClass('cb-module-fw') || cbFirstChildCheck.hasClass('cb-grid-block') ) ) {
                        cbParentTop = cbParentTop + cbFirstChildCheck.outerHeight();
                    }
                    if ( cbThis.prev().length === 1 ) {
                        cbSib = cbThis.prev().outerHeight(true);
                    } else {
                        cbSib = cbThis.next().outerHeight(true);
                    }

                    if ( cbStickyHeight < cbSib ) {
                        cbThis.css('height', cbSib );
                    } else {
                        return;
                    }

                    if ( cbStickyHeight > cbWindowHeight ) {

                        if ( cbDistStuckParent <= 0 ) {
                            cbStickySBEL.removeClass('cb-is-stuck cb-is-stuck-t cb-is-stuck-perm cb-is-stuck-frozen');
                            cbStickySBEL.css('top', '' );
                        } else if ( cbCurScrollBot > cbParentBot ) {
                            cbStickySBEL.removeClass('cb-is-stuck cb-is-stuck-t');
                            cbStickySBEL.addClass('cb-is-stuck-perm');
                        } else if ( cbWindowScrollDir == 1 ) {

                            if ( cbStickySBEL.hasClass('cb-is-stuck-frozen') ) {

                                if ( (cbWindowScrollTopSS + cbStickySBELMT ) >= cbStickySBELTop ) {
                                    cbStickySBEL.addClass('cb-is-stuck-frozen');
                                    cbStickySBEL.removeClass('cb-is-stuck cb-is-stuck-t');
                                 } else {
                                    cbStickySBEL.removeClass('cb-is-stuck-perm cb-is-stuck cb-is-stuck-frozen');
                                    cbStickySBEL.addClass('cb-is-stuck-t');
                                    cbStickySBEL.css('top', '' );
                                 }

                            } else {

                                if ( cbStickySBEL.hasClass('cb-is-stuck') ) {
                                    cbStickySBEL.addClass('cb-is-stuck-frozen');
                                    cbStickySBEL.removeClass('cb-is-stuck cb-is-stuck-t');
                                    cbStickySBEL.css('top', ( cbStickySBELTop - cbParentTop - cbStickySBELMT ) );
                                } else {
                                    if ( cbStickySBEL.hasClass('cb-is-stuck') || cbStickySBEL.hasClass('cb-is-stuck-t')  || cbStickySBEL.hasClass('cb-is-stuck-perm' ) ) {
                                        if ( ( cbStickyTop < cbWindowScrollTopSS ) && ( cbStickySBELTop > cbStickyTop ) ) {
                                            cbStickySBEL.addClass('cb-is-stuck-t');
                                            cbStickySBEL.removeClass('cb-is-stuck-perm cb-is-stuck');
                                        } else {
                                            cbStickySBEL.removeClass('cb-is-stuck-t cb-is-stuck-perm cb-is-stuck cb-is-stuck-frozen');
                                            cbStickySBEL.css('top', '' );
                                        }
                                    }

                                    if ( cbParentBot < ( cbWindowScrollTopSS + cbStickyHeight )  ) {
                                        cbStickySBEL.removeClass('cb-is-stuck-t cb-is-stuck');
                                        cbStickySBEL.addClass('cb-is-stuck-perm');
                                    }
                                }

                            }

                        } else {

                            if ( cbStickySBEL.hasClass('cb-is-stuck-frozen') ) {

                                if ( cbStickySBELBot < (cbCurScrollBot + cbStickySBELMT ) ) {
                                    cbStickySBEL.removeClass('cb-is-stuck-frozen');
                                    cbStickySBEL.css('top', '' );
                                    cbStickySBEL.addClass('cb-is-stuck');
                                    cbStickySBEL.removeClass('cb-is-stuck-perm cb-is-stuck-t');
                                }

                            } else {

                                if ( cbStickySBEL.hasClass('cb-is-stuck-t') ) {
                                    cbStickySBEL.addClass('cb-is-stuck-frozen');
                                    cbStickySBEL.removeClass('cb-is-stuck cb-is-stuck-t');
                                    cbStickySBEL.css('top', ( cbStickySBELTop - cbParentTop - cbStickySBELMT ) );
                                } else {

                                    if ( cbStickySBEL.hasClass('cb-is-stuck-perm') && (  ( cbStickyTop < cbWindowScrollTopSS ) && ( cbStickySBELTop > cbStickyTop ) ) ) {

                                    } else if ( cbStickyBot < cbCurScrollBot ) {
                                        cbStickySBEL.addClass('cb-is-stuck');
                                        cbStickySBEL.removeClass('cb-is-stuck-perm cb-is-stuck-t');
                                    } else {
                                        cbStickySBEL.removeClass('cb-is-stuck cb-is-stuck-t cb-is-stuck-perm cb-is-stuck-frozen');
                                        cbStickySBEL.css('top', '' );
                                    }
                                }

                            }
                        }

                    } else {

                        if ( cbStickyTop < cbWindowScrollTopSM ) {
                            cbStickySBEL.addClass('cb-is-stuck-t');
                            cbStickySBEL.removeClass('cb-is-stuck-perm');
                        } else {
                            cbStickySBEL.removeClass('cb-is-stuck-t cb-is-stuck-perm');
                        }

                        if ( cbParentBot < ( cbWindowScrollTopSM + cbStickyHeight )  ) {
                            cbStickySBEL.removeClass('cb-is-stuck-t');
                            cbStickySBEL.addClass('cb-is-stuck-perm');
                        }

                    }

                });

            }
        }

        if ( ( cbBody.hasClass( 'cb-m-sticky' ) ) && ( cbWindowWidth < 768 ) ) {
            if ( cbTMS.length ) {
                var cbTMLoc = cbTMS.offset().top;

                if ( ( cbWindowScrollTop - $('#wpadminbar').outerHeight(true) ) > cbTMLoc ) {
                    cbBody.addClass('cb-tm-stuck');
                } else {
                    cbBody.removeClass('cb-tm-stuck');
                }
            }
        }

        if ( ( cbParallaxImg.length !== 0 ) && ( cbMobileTablet === false ) ) {

            if ( cbWindowScrollTop <  cbWindowHeight ) {
                cbBody.removeClass('cb-par-hidden');
                if ( cbAdminBar === true) {
                    cbWindowScrollTop = cbWindowScrollTop - 32;
                }

                var cbyPos = ( ( cbWindowScrollTop / 2    ) ),
                    cbCoords = cbyPos + 'px';

                    $('#cb-par-wrap img').css({ '-webkit-transform': 'translate3d(0, ' + cbCoords + ', 0)', 'transform': 'translate3d(0, ' + cbCoords + ', 0)' });
            } else {
                cbBody.addClass('cb-par-hidden');
            }

        }

        if ( cbInfiniteScroll.length ) {

            if ( cbReady === true ) {

                var cbLastChild = $('#main').children().last(),
                    cbLoadHasAd = $('#main').children().first().hasClass('cb-category-top'),
                    cbLastChildID = cbLastChild.attr('id'),
                    cbLastArticle = cbLastChild.prev();

                if ( ( cbLastChildID === 'cb-blog-infinite-scroll' ) && ( cbLastArticle.visible(true) ) ) {

                    cbReady = false;

                    var cbCurrentPagination = $('#cb-blog-infinite-scroll').find('a').attr('href');
                    cbMain.addClass('cb-loading');

                    $.get( cbCurrentPagination, function( data ) {

                        var cbExistingPosts, cbExistingPostsRaw;

                        if ( cbLoadHasAd === true ) {
                                cbExistingPostsRaw = $(data).filter('#cb-outer-container').find('#main');
                                $(cbExistingPostsRaw).find('.cb-category-top').remove();
                                cbExistingPosts = cbExistingPostsRaw.html();

                        } else {
                            cbExistingPosts = $(data).filter('#cb-outer-container').find('#main').html();
                        }

                        $('#main').children().last().remove();
                        $('#main').append(cbExistingPosts);
                        cbMain.removeClass('cb-loading');
                        cbStickyAjax = cbMain.next().find('.cb-is-stuck-perm');
                        if ( cbStickyAjax.length ) {
                            cbStickyAjax.removeClass('cb-is-stuck-perm');
                            cbStickyAjax.addClass('cb-is-stuck');
                        }

                    });

                }

            }
        }

        if( ( cbWindowScrollTop > 750 ) &&  ( cbWindowWidth > 768 ) ) {
            cbBody.addClass('cb-to-top-vis');
        } else {
            cbBody.removeClass('cb-to-top-vis');
        }

        cbCheckerI = false;
    }


    if (window.addEventListener) {
        window.addEventListener( 'scroll', cbOnScroll, false );
    }
    else {
        window.attachEvent('scroll', cbOnScroll);
    }

    $.each(cbRatingBars, function(i, value) {

        var cbValue = $(value);
        if ( cbValue.visible(true) ) {

            cbValue.removeClass('cb-zero-trigger');
            cbValue.addClass('cb-bar-ani');

        }
    });

    $.each(cbRatingStars, function(i, value) {

        var cbValue = $(value);
        if ( cbValue.visible(true) ) {

            cbValue.removeClass('cb-zero-stars-trigger');
            cbValue.addClass('cb-bar-ani-stars');

        }
    });

    cbWindow.scroll(function(event) {

        $.each(cbRatingBars, function(i, value) {

            var cbValue = $(value);
            if ( ( cbValue.visible(true) ) && ( cbValue.hasClass('cb-zero-trigger') ) ) {

              cbValue.removeClass('cb-zero-trigger');
              cbValue.addClass('cb-bar-ani');
            }
        });

          $.each(cbRatingStars, function(i, value) {

            var cbValue = $(value);
            if ( ( cbValue.visible(true) ) && ( cbValue.hasClass('cb-zero-stars-trigger') ) ) {

                cbValue.removeClass('cb-zero-stars-trigger');
                cbValue.addClass('cb-bar-ani-stars');
            }
        });

    });


    jQuery(document).ready(function($) {
        if ( cbBody.hasClass('admin-bar') && ( ! $('#wpadminbar').length ) ) {
            cbAdminBar = false;
            cbBody.addClass('cb-no-admin-bar');
        }
        if ( cbNavBar.length ) {
            if  ( cbWindowWidth > 767 ) {
                cbMenuOffset = cbNavBar.offset().top;
            }
        }

        $('.hentry').find('a').has('img').each(function () {

            var cbImgTitle = $('img', this).attr( 'title' ),
                cbAttr = $(this).attr('href');

            var cbWooLightbox = $(this).attr('rel');

            if (typeof cbImgTitle !== 'undefined') {
                $(this).attr('title', cbImgTitle);
            }

            if ( ( typeof cbAttr !== 'undefined' )  && ( cbWooLightbox !== 'prettyPhoto[product-gallery]' ) ) {
                var cbHref = cbAttr.split('.');
                var cbHrefExt = $(cbHref)[$(cbHref).length - 1];

                if ((cbHrefExt === 'jpg') || (cbHrefExt === 'jpeg') || (cbHrefExt === 'png') || (cbHrefExt === 'gif') || (cbHrefExt === 'tif')) {
                    $(this).addClass('cb-lightbox');
                }
            }

        });

        $('.tiled-gallery').find('a').attr('rel', 'tiledGallery');
        $('.gallery').find('a').attr('rel', 'tiledGallery');

        var cbMain = $('#main'),
            cbIFrames = cbMain.find('iframe');

        cbIFrames.each( function() {
            var CbThisSrc = $(this).attr('src');

            if( CbThisSrc && ( ( CbThisSrc.indexOf("yout") > -1 ) || ( CbThisSrc.indexOf("vimeo") > -1 ) || ( CbThisSrc.indexOf("daily") > -1 ) ) ) {
                $(this).wrap('<div class="cb-video-frame"></div>');
            }
        });

        $('.tiled-gallery, .gallery').find('a').attr('data-lightbox-gallery', 'tiledGallery');

         if ( !!$.prototype.lightbox ) {
            $(".cb-lightbox").lightbox({ fixed: true });
        }


        // Toggle
        $('.cb-toggler').find('.cb-toggle').click(function(e) {
               $(this).next().stop().slideToggle();
               $(this).prev().stop().toggle();
               $(this).prev().prev().stop().toggle();
               e.preventDefault();
        });

        var cbFirstGrid = cbContent.first('.cb-grid-block');

        $(cbFirstGrid).imagesLoaded( function() {
            cbBody.addClass('cb-imgs-loaded');
        });

        $(window).load(function() {
            if ( cbNavBar.length ) {
                cbNavBar.css( 'height', '' );
                cbMenuItemWrap.css( 'height', '' );
                if  ( cbWindowWidth > 767 ) {
                    cbMenuHeight = cbNavBarDiv.outerHeight();
                }
                cbNavBar.css( 'height', cbMenuHeight );
                cbMenuItemWrap.add(cbNavLogo).css( 'height', cbNavBarFirstLI.outerHeight() );
            }
            cbFixdSidebarLoad();
            var cbTabber = $('.tabbernav'),
                cb_amount = cbTabber.children().length;
            if ( cb_amount === 4 ) { cbTabber.addClass("cb-fourtabs"); }
            if ( cb_amount === 3 ) { cbTabber.addClass("cb-threetabs"); }
            if ( cb_amount === 2 ) { cbTabber.addClass("cb-twotabs"); }
            if ( cb_amount === 1 ) { cbTabber.addClass("cb-onetab"); }

        });

        // Clear half modules
        $('.cb-module-half:odd').each(function(){
            $(this).prev().addBack().wrapAll($('<div/>',{'class': 'cb-double-block clearfix'}));
        });

        cbFlexSW.flexslider({
            animation: "slide",
            itemWidth: 280,
            itemMargin: 3,
            pauseOnHover: true,
            maxItems: 3,
            minItems: 1,
            controlNav: false,
            slideshow: cbScripts.cbSlider[1],
            slideshowSpeed: cbScripts.cbSlider[2],
            animationSpeed: cbScripts.cbSlider[0],
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
        });
        cbFlexFW.flexslider({
            animation: "slide",
            itemWidth: 280,
            itemMargin: 3,
            pauseOnHover: true,
            maxItems: 4,
            minItems: 1,
            controlNav: false,
            slideshow: cbScripts.cbSlider[1],
            slideshowSpeed: cbScripts.cbSlider[2],
            animationSpeed: cbScripts.cbSlider[0],
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
        });

        $('#cb-carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            directionlNav: true,
            itemWidth: 150,
            itemMargin: 15,
            asNavFor: '#cb-gallery',
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
          });

        $('#cb-gallery').flexslider({
            animation: "slide",
            controlNav: false,
            directionlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#cb-carousel",
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
        });

        $('.flexslider-1-menu').flexslider({
            animation: "slide",
            itemWidth: 210,
            itemMargin: 3,
            slideshow: false,
            pauseOnHover: true,
            maxItems: 2,
            minItems: 1,
            controlNav: false,
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
        });

        $('.flexslider-2').flexslider({
            animation: "slide",
            minItems: 1,
            pauseOnHover: true,
            maxItems: 1,
            controlNav: false,
            slideshow: cbScripts.cbSlider[1],
            slideshowSpeed: cbScripts.cbSlider[2],
            animationSpeed: cbScripts.cbSlider[0],
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
        });
         $('.flexslider-2-fw').flexslider({
            animation: "slide",
            pauseOnHover: true,
            minItems: 1,
            maxItems: 1,
            controlNav: false,
            slideshow: cbScripts.cbSlider[1],
            slideshowSpeed: cbScripts.cbSlider[2],
            animationSpeed: cbScripts.cbSlider[0],
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
        });


        $('#messages_search').removeAttr('placeholder');

        var cbMainNav = $('.main-nav li');

        // Show sub menus
        $('.main-nav > li').hoverIntent(function() {

            $(this).find('.cb-big-menu').stop().slideDown('fast');
            $(this).find('.cb-mega-menu').stop().slideDown('fast');
            $(this).find('.cb-links-menu .cb-sub-menu').stop().fadeIn();

        }, function() {

           $(this).find('.cb-big-menu').slideUp('fast');
           $(this).find('.cb-mega-menu').slideUp('fast');
           $(this).find('.cb-links-menu .cb-sub-menu').fadeOut();

        });

        cbMainNav.find('.cb-big-menu .cb-sub-menu li').hoverIntent(function(){

            $(this).find('> .cb-grandchild-menu').stop().slideDown('fast');

        }, function() {

           $(this).find('> .cb-grandchild-menu').slideUp('fast');

        });

        cbMainNav.find('.cb-links-menu .cb-sub-menu li').hoverIntent(function(){

            $(this).children('.cb-grandchild-menu').stop().fadeIn();

        }, function() {

           $(this).children('.cb-grandchild-menu').fadeOut();

        });

        var hideSpan = $('.cb-accordion > span').hide();
        $('.cb-accordion > a').click(function() {

            if ( $(this).next().css('display') == 'none') {
                hideSpan.slideUp('fast');
                $(this).next().slideDown('fast');
            } else {
                $(this).next().slideUp('fast');
            }
            return false;

        });

        cbToTop.click(function(event) {
            $('html, body').animate({scrollTop:0}, 600);
            event.preventDefault();
        });

        $('.cb-video-frame').fitVids();

        $('.cb-tabs' ).tabs();

        $('#cb-ticker').totemticker({
            row_height  :   '33px',
            mousestop   :   true
        });

        $(".cb-tip-bot").tipper({
            direction: "bottom"
        });

        $(".cb-tip-top").tipper({
            direction: "top"
        });

        $(".cb-tip-right").tipper({
            direction: "right"
        });

        $(".cb-tip-left").tipper({
            direction: "left"
        });

        cbDoc.ajaxStop(function() {
          cbReady = true;
          $('.cb-pro-load').removeClass('cb-pro-load');
        });

        cbContent.on('click', '#cb-blog-infinite-load a', function( e ){

            e.preventDefault();
            var cbCurrentPagination = $(this).attr('href'),
                cbCurrentParent = $(this).parent();

            cbMain.addClass('cb-loading');

            $.get( cbCurrentPagination, function( data ) {

                var cbExistingPosts, cbExistingPostsRaw,
                cbLoadHasAd = $('#main').children().first().hasClass('cb-category-top');

                if ( cbLoadHasAd === true ) {

                        cbExistingPostsRaw = $(data).filter('#cb-outer-container').find('#main');
                        $(cbExistingPostsRaw).find('.cb-category-top').remove();
                        cbExistingPosts = cbExistingPostsRaw.html();

                } else {
                    cbExistingPosts = $(data).filter('#cb-outer-container').find('#main').html();
                }

                $('#main').append(cbExistingPosts);
                cbMain.removeClass('cb-loading');
                cbCurrentParent.addClass( 'cb-hidden' );

                cbStickyAjax = cbMain.next().find('.cb-is-stuck-perm');
                if ( cbStickyAjax.length ) {
                    cbStickyAjax.removeClass('cb-is-stuck-perm');
                    cbStickyAjax.addClass('cb-is-stuck');
                }

            });

        });

        $('.cb-c-l').hoverIntent(function(){

            var cbThis = $(this),
                cbThisText = $(this).text(),
                cbBigMenu = cbThis.closest('div');

            if ( cbBigMenu.hasClass('cb-big-menu') ) {

                var cid = cbThis.attr('data-cb-c'),
                    chref = cbThis.attr('href'),
                    cbBigMenuEl = $(cbBigMenu[0].firstChild),
                    cbBigMenuUL = cbBigMenuEl.find('.cb-recent > ul');

                $.ajax({
                    type : "GET",
                    data : { action: 'cb_mm_a', cid: cid, acall: 1 },
                    url: cbScripts.cbUrl,
                    beforeSend : function(){
                        cbBigMenuEl.addClass('cb-pro-load');
                    },
                    success : function(data){
                        cbBigMenuUL.html($(data));
                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                        console.log("cbmm " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
                        }
                });
            }

        }, function() {});

    });


    if ( ( cbParallaxImg.length > 0 ) && ( cbMobileTablet === false ) ) {
        var cbParallaxMainOffTop = cbParallaxMain.offset().top;
            cbWindowHeightTwo = cbWindowHeight - cbParallaxMainOffTop - 90;

        cbParallaxBG.css("height", cbWindowHeight);
        cbParallaxMain.css("height", cbWindowHeightTwo);

    }

    if ( cbFeaturedMain.length > 0) {
        if ( cbMobilePhone === true ) {
            cbWindowHeightTwo =  cbWindowHeight - cbFeaturedMain.offset().top;
        } else {
            cbWindowHeightTwo =  cbWindowHeight - cbFeaturedMain.offset().top - 80;
        }

        cbFeaturedMain.css( 'height', cbWindowHeightTwo );
    }

    var cbFullWidth = $('#cb-full-background-featured'),
        cbFullCheck = true;
        var cbClickFlag = true;

    if ( cbFullWidth.length === 0 ) {
        cbFullWidth = $('#cb-full-width-featured');
        cbFullCheck = false;
    }

    if ( cbFullWidth.length === 0 ) {
        cbFullWidth = $('#cb-parallax-featured');
        cbFullCheck = true;
    }

    var cbFullWidthTitle = cbFullWidth.find('.cb-title-fi'),
        cbFullWidthTitleHeight = cbFullWidthTitle.height();

    if ( cbBody.hasClass('cb-fis-tl-overlay') ) {
        cbFullWidthTitleHeight = 0;
    }

    var cbMediaOverlay = $('#cb-media-overlay'),
        cbMediaIcon = $('#cb-m-trigger'),
        cbVimeoFrame = cbMediaOverlay.find('iframe[src^="//player.vimeo"]'),
        cbYouTubeMediaFrame = jQuery('#cbplayer'),
        cbFisWrap = $('#cb-fis-wrap');

    cbMediaIcon.click( function( e ) {
        e.preventDefault();
        if ( ! cbMediaIcon.hasClass('cb-lb') ) {
            cbBody.addClass('cb-m-em-modal-on');
        } else {
            cbBody.addClass('cb-m-modal-on');
        }

        cbPlayYTVideo();

    });

    var cbMediaOverlayWidth = cbFisWrap.width(),
        cbMediaFrameHeight = ( cbWindowHeightTwo - cbFullWidthTitleHeight ) * 0.9,
        cbMediaFrameTop = ( cbWindowHeightTwo - cbMediaFrameHeight - cbFullWidthTitleHeight ) / 2,
        cbMediaFrameWidth = cbMediaFrameHeight * 560 / 315,
        cbMediaFrameMarginLeft;

    if ( cbMediaFrameWidth >  cbMediaOverlayWidth ) {
        cbMediaFrameWidth = cbMediaOverlayWidth - 20;
        cbMediaFrameMarginLeft = 10;
    }  else {
        cbMediaFrameMarginLeft = ( cbMediaOverlayWidth - cbMediaFrameWidth ) / 2;
    }

    if ( cbClickFlag === true ) {

        cbVimeoFrame.attr('src', (cbVimeoFrame.attr('src') + '?autoplay=1'));
        cbClickFlag = false;
    }

    if ( ( cbMediaFrameTop !== 'undefined'  ) && ( ! cbMediaOverlay.hasClass('cb-audio-overlay') ) ) {
        cbMediaOverlay.css({'top' : cbMediaFrameTop, 'height' : cbMediaFrameHeight, 'width' : cbMediaFrameWidth, 'margin-left' : cbMediaFrameMarginLeft });

    }

    cbWindow.resize(function() {

        cbWindowWidth = cbWindow.width(),
        cbWindowHeight = cbWindow.height() + 1;

        if ( cbNavBar.length ) {
            cbNavBar.css( 'height', '' );
            cbMenuItemWrap.css( 'height', '' );
            if  ( cbWindowWidth > 767 ) {
                cbMenuHeight = cbNavBarDiv.outerHeight();
            }
            cbNavBar.css( 'height', cbMenuHeight );
            cbMenuItemWrap.add(cbNavLogo).css( 'height', cbNavBarFirstLI.outerHeight() );
        }

        if ( cbWindowWidth < 767 ) {
            cbStickySB.css( 'height', 'auto' );
        }

        if ( ( cbParallaxImg.length > 0 ) && ( cbMobileTablet === false ) ) {
            cbParallaxMainOffTop = cbParallaxMain.offset().top;
            cbWindowHeightTwo =  (cbWindowHeight) - (cbParallaxMainOffTop) - 90;
            cbParallaxBG.css("height", cbWindowHeight );
            cbParallaxMain.css("height", cbWindowHeightTwo );

        }

        if ( cbFeaturedMain.length > 0) {
            if ( cbMobilePhone === true ) {
                cbWindowHeightTwo =  cbWindowHeight - cbFeaturedMain.offset().top;
            } else {
                cbWindowHeightTwo =  cbWindowHeight - cbFeaturedMain.offset().top - 80;
            }

            cbFeaturedMain.css("height", cbWindowHeightTwo );
        }

        cbMediaOverlayWidth = cbFisWrap.width(),
        cbMediaFrameHeight = ( cbWindowHeightTwo - cbFullWidthTitleHeight ) * 0.9,
        cbMediaFrameTop = ( cbWindowHeightTwo - cbMediaFrameHeight - cbFullWidthTitleHeight ) / 2,
        cbMediaFrameWidth = cbMediaFrameHeight * 560 / 315;

        if ( cbMediaFrameWidth >  cbMediaOverlayWidth ) {
            cbMediaFrameWidth = cbMediaOverlayWidth - 20;
            cbMediaFrameMarginLeft = 10;
        }  else {
            cbMediaFrameMarginLeft = ( cbMediaOverlayWidth - cbMediaFrameWidth ) / 2;
        }

        if ( cbClickFlag === true ) {

            cbVimeoFrame.attr('src', (cbVimeoFrame.attr('src') + '?autoplay=1'));
            cbClickFlag = false;
        }

        if ( ( cbMediaFrameTop !== 'undefined'  ) && ( ! cbMediaOverlay.hasClass('cb-audio-overlay') ) ) {
            cbMediaOverlay.css({'top' : cbMediaFrameTop, 'height' : cbMediaFrameHeight, 'width' : cbMediaFrameWidth, 'margin-left' : cbMediaFrameMarginLeft });
        }

        cbSlider1Post.each( function() {
            var cbThis = $(this);

            if ( cbThis.hasClass('cb-module-fw') || cbThis.hasClass('cb-full-slider' )  ) {
                cbThis.find('.slides > li').css( 'height', ( cbThis.width() / 2.3076923 ) );
            } else if ( cbThis.hasClass('cb-slider-widget') ) {
                cbThis.find('.slides > li').css( 'height', ( cbThis.width() / 1.6 ) );
            } else {
                cbThis.find('.slides > li').css( 'height', ( cbThis.width() / 1.876923 ) );
            }

        });

        if ( cbFlexFW.length ) {
              cbFlexFW.flexslider(1);
        }
        if ( cbFlexSW.length ) {
                cbFlexSW.flexslider(1);
        }

    });

    if ( cbVote.length ) {

        var cbCriteriaAverage = $('.cb-criteria-score.cb-average-score'),
        cbVoteCriteria = cbVote.find('.cb-criteria'),
        cbYourRatingText = cbVoteCriteria.attr('data-cb-text'),
        cbVoteOverlay = cbVote.find('.cb-overlay'),
        cbExistingOverlaySpan,
        cbNotVoted,
        cbExistingOverlay,
        cbNotVote;

        if  ( cbVoteOverlay.length ) {

            cbExistingOverlaySpan = cbVoteOverlay.find('span');
            cbNotVoted = cbVote.not('.cb-voted').find('.cb-overlay');
            cbExistingOverlay = cbExistingOverlaySpan[0].style.width;

        } else {

            cbVoteOverlay = cbVote.find('.cb-overlay-stars');
            cbNotVote = cbNotVoted = cbVote.not('.cb-voted').find('.cb-overlay-stars');
            cbExistingOverlaySpan = cbVoteOverlay.find('span');
            cbExistingOverlay = cbExistingOverlaySpan[0].style.width;

            if (cbExistingOverlay !== '125px') {  cbExistingOverlaySpan.addClass('cb-zero-stars-trigger'); }
        }

        var cbExistingScore = cbCriteriaAverage.text(),
            cbExistingVoteLine = cbVoteCriteria.html();

        cbNotVoted.on('mousemove click mouseleave mouseenter', function(e) {

            var cbParentOffset = $(this).parent().offset(),
                cbStarOffset = $(this).offset(),
                cbFinalX,
                cbBaseX,
                cbWidthDivider = cbVote.width() / 100,
                cbStarWidthDivider = cbVoteOverlay.width() / 100;

            if ( cbVote.hasClass('stars') ) {

                if (Math.round(cbStarOffset.left) <= e.pageX) {

                    cbBaseX = Math.round( ( ( e.pageX - Math.round(cbStarOffset.left) ) / cbStarWidthDivider )   );
                    cbFinalX = ( Math.round( cbBaseX * 10 / 20) / 10 ).toFixed(1);

                    if ( cbFinalX < 0 ) { cbFinalX = 0; }
                    if ( cbFinalX > 5 ) { cbFinalX = 5; }

                    if ( cbBodyRTL === true ) {
                        cbOverlaySpan = cbBaseX ;
                    } else {
                        cbOverlaySpan = ( 100 - cbBaseX );
                    }
                }

            } else {

                cbBaseX = Math.ceil((e.pageX - cbParentOffset.left) / cbWidthDivider);
                if ( cbBodyRTL === true ) {
                    cbOverlaySpan = ( 100 - cbBaseX );
                } else {
                    cbOverlaySpan = cbBaseX;
                }
            }

            if ( cbVote.hasClass('points') ) {
                if ( cbBodyRTL === true ) {
                    cbFinalX = ( ( 100 - cbBaseX ) / 10).toFixed(1);
                } else {
                    cbFinalX = (cbBaseX / 10).toFixed(1);
                }
                cbCriteriaAverage.text(cbFinalX);
            } else if ( cbVote.hasClass('percentage') ) {

                if ( cbBodyRTL === true ) {
                    cbFinalX = ( 100 - cbBaseX ) + '%';
                } else {
                    cbFinalX = cbBaseX + '%';
                }

                cbCriteriaAverage.text(cbFinalX);
            }

            if ( cbExistingOverlaySpan.hasClass('cb-bar-ani') ) { cbExistingOverlaySpan.removeClass('cb-bar-ani'); }
            if ( cbExistingOverlaySpan.hasClass('cb-bar-ani-stars') ) { cbExistingOverlaySpan.removeClass('cb-bar-ani-stars').css( 'width', (100 - (cbBaseX) +'%') ); }
            if ( cbOverlaySpan > 100 ) { cbOverlaySpan = 100; }
            if ( cbOverlaySpan < 1 ) { cbOverlaySpan = 0; }

            cbExistingOverlaySpan.css( 'width', cbOverlaySpan + '%' );

            if ( e.type == 'mouseenter' ) {
                cbVoteCriteria.fadeOut(75, function () {
                    $(this).fadeIn(75).text( cbYourRatingText );
                });
            }
            if ( e.type == 'mouseleave' ) {
                cbExistingOverlaySpan.animate( {'width': cbExistingOverlay}, 300);
                cbCriteriaAverage.text(cbExistingScore);
                cbVoteCriteria.fadeOut(75, function () {
                    $(this).fadeIn(75).html(cbExistingVoteLine);
                });
            }

            if ( e.type == 'click' ) {
                cbNonce = cbVote.attr('data-cb-nonce');
                if ( cbVote.hasClass('points') ) { cbFinalX = cbFinalX * 10; }
                if ( cbVote.hasClass('stars') ) { cbFinalX = cbFinalX * 20; }

                cbParentOffset = $(this).parent().offset();

                cbVoteOverlay.off('mousemove click mouseleave mouseenter');

                $.ajax({
                    type : "POST",
                    data : { action: 'cb_a_s', cburNonce: cbNonce, cbNewScore: parseInt(cbFinalX), cbPostID: cbScripts.cbPostID },
                    url: cbScripts.cbUrl,
                    dataType:"json",
                    success : function( msg ){

                        var cb_score = msg[0],
                            cbVotesText = msg[2];

                        cbVoteCriteria.fadeOut(550, function () {  $(this).fadeIn(550).html(cbExistingVoteLine).find('.cb-votes-count').html(cbVotesText); });

                        if ( ( cb_score !== '-1' ) && ( cb_score !=='null' ) ) {

                            if ( cbVote.hasClass('points') ) {

                                cbCriteriaAverage.html( (cb_score / 10).toFixed(1) );

                            } else if ( cbVote.hasClass('percentage') ) {

                                cbCriteriaAverage.html(cb_score + '%');

                            } else {
                                cb_score = 100 - cb_score;
                        }
                            cbExistingOverlaySpan.css( 'width', cb_score +'%' );
                            cbVote.addClass('cb-voted cb-tip-bot').off('click');
                        }

                        cbVote.tipper({
                            direction: 'bottom',
                        });

                        if ( cookie.enabled() ) {
                            cookie.set( {cb_user_rating: '1' }, { expires: 28, });
                        }

                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                        console.log("cbur " + jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }
                });

                return false;
            }
        });
    }

    var CbYTPlayerCheck = jQuery('#cb-yt-player');

    function cbPlayYTVideo() {
        if ( ( cbMobileTablet === false ) && ( CbYTPlayerCheck.length > 0 ) ) {
            cbYTPlayerHolder.playVideo();
        }
    };

    function cbPauseYTVideo() {
        if ( ( cbMobileTablet === false )  && ( CbYTPlayerCheck.length > 0 ) ) {
            cbYTPlayerHolder.pauseVideo();
        }
    };

})(jQuery);


var cbYTPlayerHolder,
CbYTPlayer = jQuery('#cb-yt-player'),
cbYouTubeVideoID = CbYTPlayer.text();

if ( CbYTPlayer.length > 0 ) {
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function onYouTubeIframeAPIReady() {
    if ( CbYTPlayer.length > 0 ) {
        cbYTPlayerHolder = new YT.Player('cb-yt-player', {
            videoId: cbYouTubeVideoID
        });
    }
}