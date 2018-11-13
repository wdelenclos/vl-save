<?php
define( 'CB_VER', '5.4' );
/************* GLOBAL CONTENT WIDTH ***************/
if ( ! isset( $content_width ) ) {
     $content_width = 750;
}

if ( ! function_exists( 'cb_adjust_cw' ) ) {
    function cb_adjust_cw() {

        global $content_width, $post;
        if ( $post != NULL ) {
            $cb_post_id = $post->ID;
            $cb_fw_post = get_post_meta( $cb_post_id, 'cb_full_width_post', true );
        } else {
            $cb_fw_post = NULL;
        }
        if ( ( is_page_template( 'template-full-width.php' ) ) || ( $cb_fw_post == 'nosidebar' ) ) {
            $content_width = 1140;
        }
    }
}

add_theme_support( 'woocommerce' );
add_action( 'template_redirect', 'cb_adjust_cw' );

/************* LOAD NEEDED FILES ***************/

require_once get_template_directory() . '/library/core.php';
require_once get_template_directory() . '/library/translation/translation.php';

// Fire Up The Framework
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
load_template(  get_template_directory()  . '/option-tree/ot-loader.php' );
load_template( get_template_directory() . '/library/admin/cb-meta-boxes.php' );
require_once get_template_directory().'/library/cb-to.php';
require_once get_template_directory().'/library/admin/cb-tgm.php';
require_once get_template_directory().'/library/extensions/github.php';


define('SK_PRODUCT_ID',460);
define('SK_ENVATO_PARTNER', 'Vu8tUoxWwBdp01iLujMhltG/XdFoj3QFlmNmeJ+H4LI=');
define('SK_ENVATO_SECRET', 'RqjBt/YyaTOjDq+lKLWhL10sFCMCJciT9SPUKLBBmso=');

/************* THUMBNAIL SIZE OPTIONS *************/

if ( ! function_exists( 'cb_image_thumbnails' ) ) {
    function cb_image_thumbnails() {
        if ( ot_get_option( 'cb_fi_80x60', 'on' ) == 'on' ) {
            add_image_size('cb-80-60', 80, 60, true); // Used on sidebar widgets and small thumbnails
        }

        if ( ot_get_option( 'cb_fi_300x250', 'on' ) == 'on' ) {
            add_image_size('cb-300-250', 300, 250, true ); // Used on grids, sliders
        }

        if ( ot_get_option( 'cb_fi_360x240', 'on' ) == 'on' ) {
            add_image_size('cb-360-240', 360, 240, true ); // Used on blog style B, Module B, Module C, Latest Post Widget Big Style
        }

        if ( ot_get_option( 'cb_fi_480x240', 'on' ) == 'on' ) {
            add_image_size('cb-480-240', 480, 240, true ); // Used on featured post in mega menu
        }

        if ( ot_get_option( 'cb_fi_400x250', 'on' ) == 'on' ) {
            add_image_size('cb-400-250', 400, 250, true ); // Used on grid 5
        }

        if ( ot_get_option( 'cb_fi_600x250', 'on' ) == 'on' ) {
            add_image_size('cb-600-250', 600, 250, true ); // Used on grid 4 and 6
        }

        if ( ot_get_option( 'cb_fi_600x400', 'on' ) == 'on' ) {
            add_image_size('cb-600-400', 600, 400, true ); // Used on grid 4, 5 and 6
        }

        if ( ot_get_option( 'cb_fi_750x400', 'on' ) == 'on' ) {
           add_image_size('cb-750-400', 750, 400, true ); // Used on standard featured image, slider 2 section b/d
        }

        if ( ot_get_option( 'cb_fi_1200x520', 'on' ) == 'on' ) {
            add_image_size('cb-1200-520', 1200, 520, true ); // Used on full-width featured image, slider 2 full-width
        }
    }
}

add_action( 'after_setup_theme', 'cb_image_thumbnails' );


if ( function_exists('buddypress') ) {

    if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) ) {
        define ( 'BP_AVATAR_FULL_WIDTH', 300 );
    }

    if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) ) {
        define ( 'BP_AVATAR_FULL_HEIGHT', 300 );
    }

    if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) ) {
        define ( 'BP_AVATAR_THUMB_HEIGHT', 80 );
    }

    if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) ) {
        define ( 'BP_AVATAR_THUMB_WIDTH', 80 );
    }

}

/*********************
SCRIPTS & ENQUEUEING
*********************/
if ( ! function_exists( 'cb_script_loaders' ) ) {
    function cb_script_loaders() {
        // enqueue base scripts and styles
        add_action('wp_enqueue_scripts', 'cb_scripts_and_styles', 999);
        // enqueue admin scripts and styles
        add_action('admin_enqueue_scripts', 'cb_post_admin_scripts_and_styles');
        // ie conditional wrapper
        add_filter( 'style_loader_tag', 'cb_ie_conditional', 10, 2 );
    }
}
add_action('after_setup_theme','cb_script_loaders', 15);

if ( ! function_exists( 'cb_scripts_and_styles' ) ) {
    function cb_scripts_and_styles() {
      if (!is_admin()) {
        if ( is_singular() ) {
            global $post;
            $cb_post_id = $post->ID;
        } else {
            $cb_post_id = NULL;
        }
        // Modernizr (without media query polyfill)
        wp_register_script( 'cb-modernizr',  get_template_directory_uri(). '/library/js/modernizr.custom.min.js', array(), '2.6.2', false );
        wp_enqueue_script('cb-modernizr'); // enqueue it

        $cb_responsive_style = ot_get_option( 'cb_responsive_onoff', 'on' );
         if ( ot_get_option( 'cb_sliders_autoplay', 'on' ) == 'off' ) {
            $cb_slider_1 = false;
        } else {
            $cb_slider_1 = true;
        }
        $cb_slider = array( ot_get_option( 'cb_sliders_animation_speed', '600' ), $cb_slider_1, ot_get_option( 'cb_sliders_speed', '7000' ) );
        if ( ot_get_option( 'cb_max_theme_width', 'default' ) == 'onesmaller') {
            $cb_site_size = '-1020px';
        } else {
            $cb_site_size = NULL;
        }

        if ( $cb_responsive_style == 'on' ) {
            if ( is_rtl() ) {
                $cb_style_name = 'style-rtl' . $cb_site_size;
            } else {
                $cb_style_name = 'style' . $cb_site_size;
            }
        } else {
            if ( is_rtl() ) {
                $cb_style_name = 'style-rtl-unresponsive' . $cb_site_size;
            } else {
                $cb_style_name = 'style-unresponsive' . $cb_site_size;
            }
        }

        wp_register_style( 'cb-main-stylesheet',  get_template_directory_uri() . '/library/css/' . $cb_style_name . '.css', array(), CB_VER, 'all' );
        wp_enqueue_style('cb-main-stylesheet'); // enqueue it
        // Register fonts
        $cb_font = cb_fonts();
        wp_register_style( 'cb-font-stylesheet',  $cb_font[0], array(), CB_VER, 'all' );
        wp_enqueue_style('cb-font-stylesheet'); // enqueue it
        // register font awesome stylesheet
        wp_register_style('fontawesome', get_template_directory_uri() . '/library/css/fontawesome/css/font-awesome.min.css', array(), '4.6.1', 'all');
        wp_enqueue_style('fontawesome'); // enqueue it
        // ie-only stylesheet
        wp_register_style( 'cb-ie-only',  get_template_directory_uri(). '/library/css/ie.css', array(), CB_VER );
        wp_enqueue_style('cb-ie-only'); // enqueue it
        if ( class_exists('Woocommerce') ) {
            wp_register_style( 'cb-woocommerce-stylesheet',  get_template_directory_uri() . '/woocommerce/css/woocommerce.css', array(), CB_VER, 'all' );
            wp_enqueue_style('cb-woocommerce-stylesheet'); // enqueue it
        }
        // comment reply script for threaded comments
        if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1) ) {
            global $wp_scripts;
            $wp_scripts->add_data( 'comment-reply', 'group', 1 );
            wp_enqueue_script( 'comment-reply' ); // enqueue it
        }
        if ( is_single() == true) {
            // Load Cookie
            if ( get_post_meta( $cb_post_id, 'cb_review_checkbox', true ) != NULL ) {
                wp_register_script( 'cb-cookie',  get_template_directory_uri() . '/library/js/cookie.min.js', array( 'jquery' ), CB_VER, true);
                wp_enqueue_script( 'cb-cookie' ); // enqueue it
            }
        }
        // Load Extra Needed Javascript
        wp_register_script( 'cb-js-ext',  get_template_directory_uri() . '/library/js/jquery.ext.js', array( 'jquery' ), CB_VER, true);
        wp_enqueue_script( 'cb-js-ext' ); // enqueue it
        wp_localize_script( 'cb-js-ext', 'cbExt', array( 'cbSS' => ot_get_option( 'cb_ss', 'off' ), 'cbLb' => ot_get_option( 'cb_lightbox_onoff', 'on' ) ) );
        // Load scripts
        if ( ot_get_option('cb_minify_js_onoff', 'on') != 'off' ) {
            wp_register_script( 'cb-js',  get_template_directory_uri()  . '/library/js/cb-scripts.min.js', array( 'jquery', 'cb-js-ext', 'jquery-ui-tabs'   ), CB_VER, true);
        } else {
            wp_register_script( 'cb-js',  get_template_directory_uri()  . '/library/js/cb-scripts.js', array( 'jquery', 'cb-js-ext', 'jquery-ui-tabs'  ), CB_VER, true);
        }
        wp_enqueue_script( 'cb-js' ); // enqueue it
        wp_localize_script( 'cb-js', 'cbScripts', array( 'cbUrl' => admin_url( 'admin-ajax.php' ), 'cbPostID' => $cb_post_id,  'cbSlider' => $cb_slider) );
      }
    }
}

if ( ! function_exists( 'cb_post_admin_scripts_and_styles' ) ) {
    function cb_post_admin_scripts_and_styles($hook) {

        // loading admin styles only on edit + posts + new posts
        if ( $hook == 'post.php' || $hook == 'post-new.php' || $hook == 'edit-tags.php' || $hook == 'profile.php' || $hook == 'appearance_page_ot-theme-options' || $hook == 'user-edit.php' || $hook == 'appearance_page_radium_demo_installer' || $hook == 'edit-tags.php' || $hook == 'widgets.php' ) {
            wp_register_script( 'admin-js',  get_template_directory_uri()  . '/library/admin/js/cb-admin.js', array(), CB_VER, true);
            wp_enqueue_script( 'admin-js' ); // enqueue it
            wp_register_style('fontawesome', get_template_directory_uri() . '/library/css/fontawesome/css/font-awesome.min.css', array(), '4.6.1', 'all');
            wp_enqueue_style('fontawesome'); // enqueue it
            wp_enqueue_script( 'suggest' ); // enqueue it
        }
    }
}

// adding the conditional wrapper around ie8 stylesheet
// source: Gary Jones - http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
// GPLv2 or newer license
if ( ! function_exists( 'cb_ie_conditional' ) ) {
    function cb_ie_conditional( $tag, $handle ) {
        if ( ( 'cb-ie-only' == $handle ) ) {
            $tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
        }
        return $tag;
    }
}

// Sidebars & Widgetizes Areas
if ( ! function_exists( 'cb_register_sidebars' ) ) {
    function cb_register_sidebars() {

        $cb_footer_layout = ot_get_option('cb_footer_layout', 'cb-footer-a');
        if ( $cb_footer_layout == 'cb-footer-b' ) {
            $cb_footer_count = 4;
        } elseif ( $cb_footer_layout == 'cb-footer-e' ) {
            $cb_footer_count = 2;
        } elseif ( $cb_footer_layout == 'cb-footer-f' ) {
            $cb_footer_count = 1;
        } else {
            $cb_footer_count = 3;
        }

        // Main Sidebar
        register_sidebar(array(
            'name' => 'Global Sidebar',
            'id' => 'sidebar-global',
            'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-sidebar-widget-title">',
            'after_title' => '</h3>'
        ));

        // Footer Widget 1
        register_sidebar( array(
            'name' => 'Footer 1',
            'id' => 'footer-1',
            'before_widget' => '<div id="%1$s" class="cb-footer-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="cb-footer-widget-title"><span>',
            'after_title' => '</span></h3>'
        ));

        if ( $cb_footer_count > 1 ) {
            // Footer Widget 2
            register_sidebar( array(
                'name' => 'Footer 2',
                'id' => 'footer-2',
                'before_widget' => '<div id="%1$s" class="cb-footer-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-footer-widget-title"><span>',
                'after_title' => '</span></h3>'
            ));
        }

        if ( $cb_footer_count > 2 ) {
            // Footer Widget 3
            register_sidebar( array(
                'name' => 'Footer 3',
                'id' => 'footer-3',
                'before_widget' => '<div id="%1$s" class="cb-footer-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-footer-widget-title"><span>',
                'after_title' => '</span></h3>'
            ));
        }

        if ( $cb_footer_count == 4 ) {
            // Footer Widget 4
            register_sidebar( array(
                'name' => 'Footer 4',
                'id' => 'footer-4',
                'before_widget' => '<div id="%1$s" class="cb-footer-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-footer-widget-title"><span>',
                'after_title' => '</span></h3>'
            ));
        }

        register_sidebar(
            array(
                'name' => 'Valenti Multi-Widgets Area',
                'id' => 'cb_multi_widgets',
                'description' => '1- Drag multiple widgets here 2- Drag the "Valenti Multi-Widget Widget" to the sidebar where you want to show the multi-widgets.',
                'before_widget' => '<div id="%1$s" class="widget cb-multi-widget tabbertab %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
        );

        if ( function_exists( 'bbpress' ) ) {
            register_sidebar( array(
                'name' => 'bbPress Sidebar',
                'id' => 'sidebar-bbpress',
                'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-sidebar-widget-title">',
                'after_title' => '</h3>'
            ));
        }

        if ( function_exists( 'buddypress' ) ) {
            register_sidebar( array(
                'name' => 'BuddyPress Sidebar',
                'id' => 'sidebar-buddypress',
                'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-sidebar-widget-title">',
                'after_title' => '</h3>'
            ));
        }

        if ( class_exists( 'Woocommerce' ) ) {
            register_sidebar( array(
                'name' => 'WooCommerce Sidebar',
                'id' => 'sidebar-woocommerce',
                'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="cb-sidebar-widget-title">',
                'after_title' => '</h3>'
            ));
        }

        $cb_pages = get_pages( array( 'post_status' =>  array('publish', 'pending', 'private', 'draft') ) );
        foreach ( $cb_pages as $page ) {

            $cb_page_sidebar = get_post_meta( $page->ID, 'cb_page_custom_sidebar', true );
            $cb_page_template = get_post_meta( $page->ID, '_wp_page_template', true );

                if ( ( ( $cb_page_sidebar == 'on' ) || ( $cb_page_sidebar == '2' ) ) && ( $cb_page_template != 'page-valenti-builder.php' ) ) {
                    register_sidebar( array(
                        'name' => $page->post_title .' (Page)',
                        'id' => 'page-'.$page->ID . '-sidebar',
                        'description' => 'This is the ' . $page->post_title . ' sidebar',
                        'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="cb-sidebar-widget-title">',
                      'after_title' => '</h3>'
                    ) );
                }
                if ( $cb_page_template == 'page-valenti-builder.php' ) {

                    // Homepage Section B Sidebar
                    register_sidebar(array(
                        'name' => 'Section B Sidebar ('.$page->post_title .' page)',
                        'id' => 'sidebar-hp-b-'.$page->ID,
                        'description' => 'Page: ' . $page->post_title,
                        'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="cb-sidebar-widget-title">',
                        'after_title' => '</h3>'
                    ));
                    // Homepage Section D Sidebar
                    register_sidebar(array(
                        'name' => 'Section D Sidebar (' . $page->post_title . ' page)',
                        'id' => 'sidebar-hp-d-' . $page->ID,
                        'description' => 'This is Sidebar D for ' . $page->post_title,
                        'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="cb-sidebar-widget-title">',
                        'after_title' => '</h3>'
                    ));
                }
        }

        $cb_qry = new WP_Query( array('post_status' =>  array('publish', 'pending', 'private', 'draft'),  'post_type' => 'post', 'posts_per_page' => 30, 'meta_key' => 'cb_post_custom_sidebar_type', 'meta_value' => 'cb_unique_sidebar' ) );
        if ( $cb_qry->have_posts() ) : while ( $cb_qry->have_posts() ) : $cb_qry->the_post();
            global $post;
            $cb_sidebar_type = get_post_meta( $post->ID, 'cb_post_sidebar', true );

            if ( $cb_sidebar_type == 'off' ) {
                $cb_post_title = get_the_title( $post->ID );

                register_sidebar( array(
                    'name' => $cb_post_title .' (Post)',
                    'id' => 'post-' . $post->ID . '-sidebar',
                    'description' => 'This is the ' . $cb_post_title . ' sidebar',
                    'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="cb-sidebar-widget-title cb-widget-title">',
                  'after_title' => '</h3>'
                ) );
            }

        endwhile;
        endif;
        wp_reset_postdata();

        if ( function_exists('get_tax_meta') ) {

            $cb_categories = get_categories( array( 'hide_empty'=> 0 ) );

            foreach ( $cb_categories as $cb_cat ) {

                $cb_cat_onoff = get_tax_meta( $cb_cat->cat_ID, 'cb_cat_sidebar');

                if ( $cb_cat_onoff == 'on' ) {
                    register_sidebar( array(
                            'name' => $cb_cat->cat_name,
                            'id' => $cb_cat->category_nicename . '-sidebar',
                            'description' => 'This is the ' . $cb_cat->cat_name . ' sidebar',
                            'before_widget' => '<div id="%1$s" class="cb-sidebar-widget %2$s">',
                            'after_widget' => '</div>',
                            'before_title' => '<h3 class="cb-sidebar-widget-title">',
                            'after_title' => '</h3>'
                        ) );
                }

           }
        }
    }
}

?>