<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array.
   */
  $saved_settings = get_option( 'option_tree_settings', array() );

  /**
   * Custom settings array that will eventually be
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'contextual_help' => array(
      'sidebar'       => 'Get help here'
    ),
    'sections'        => array(
      array(
        'id'          => 'ot_general',
        'title'       => '<i class="fa fa-pencil-square-o"></i> General'
      ),
      array(
        'id'          => 'cb_homepage',
        'title'       => '<i class="fa fa-home"></i> Homepage'
      ),
      array(
        'id'          => 'cb_menus',
        'title'       => '<i class="fa fa-bars"></i> Navigation Menus'
      ),
      array(
        'id'          => 'cb_post_settings',
        'title'       => '<i class="fa fa-newspaper-o"></i> Posts'
      ),
      array(
        'id'          => 'ot_styling',
        'title'       => '<i class="fa fa-eyedropper"></i> Global Styling'
      ),
      array(
        'id'          => 'ot_typography',
        'title'       => '<i class="fa fa-pencil"></i> Typography'
      ),
      array(
        'id'          => 'ot_gridsliders',
        'title'       => '<i class="fa fa-th-large"></i> Grids & Sliders'
      ),
       array(
        'id'          => 'ot_blogstyles',
        'title'       => '<i class="fa fa-th-list"></i> Blog Styles'
      ),
       array(
        'id'          => 'ot_footer',
        'title'       => '<i class="fa fa-th"></i> Footer'
      ),
      array(
        'id'          => 'ot_advertising',
        'title'       => '<i class="fa fa-bullhorn"></i> Advertisement'
      ),
      array(
        'id'          => 'ot_custom_code',
        'title'       => '<i class="fa fa-code"></i> Custom Code'
      ),
      array(
        'id'          => 'cb_bbpress',
        'title'       => '<i class="fa fa-comment-o"></i> bbPress'
      ),
      array(
        'id'          => 'cb_buddypress',
        'title'       => '<i class="fa fa-users"></i> BuddyPress'
      ),
      array(
        'id'          => 'cb_woocommerce',
        'title'       => '<i class="fa fa-shopping-cart"></i> WooCommerce'
      ),
      array(
        'id'          => 'ot_extras',
        'title'       => '<i class="fa fa-plus"></i> Extras'
      ),
      array(
        'id'          => 'ot_fi',
        'title'       => '<i class="fa fa-picture-o"></i> Image Thumbnails'
      ),
      array(
        'id'          => 'cb_theme_help',
        'title'       => '<i class="fa fa-question"></i> Theme Help'
      )
    ),
    'settings'        => array(
      array(
        'id'          => 'cb_logo_url',
        'label'       => 'Main Logo',
        'desc'        => 'Upload your logo (Recommended size: 260px x 70px). Automatically loads Retina version if available. See documentation for more details.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_logo_retina_url',
        'label'       => 'Main Logo (Retina Version)',
        'desc'        => 'Upload your logo (Retina version) for the Header area- Size must be exactly double the size of the original logo set above.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_logo_position',
        'label'       => 'Logo Position',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'left',
            'label'       => 'Left',
            'src'         => ''
          ),
          array(
            'value'       => 'center',
            'label'       => 'Centered',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_theme_style',
        'label'       => 'Theme Style',
        'desc'        => '',
        'std'         => 'cb_boxed',
        'type'        => 'radio-image',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_boxed',
            'label'       => 'Boxed',
            'src'         => '/theme_style_b.png'
          ),
          array(
            'value'       => 'cb_full',
            'label'       => 'Full-Width Layout',
            'src'         => '/theme_style_a.png'
          )
        ),
      ),
      array(
        'id'          => 'cb_to_top',
        'label'       => 'To Top Button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'std'         => 'on',
      ),
      array(
        'id'          => 'cb_lightbox_onoff',
        'label'       => 'Lightbox',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_breadcrumbs',
        'label'       => 'Breadcrumbs',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_responsive_onoff',
        'label'       => 'Responsive Theme',
        'desc'        => 'If set to "off" mobile devices will load the desktop version always (full-site)',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_max_theme_width',
        'label'       => 'Content Max Width',
        'desc'        => 'Default is 1200px (like demo site).',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'default',
            'label'       => 'Default',
            'src'         => ''
          ),
          array(
            'value'       => 'onesmaller',
            'label'       => '1020px',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_meta_onoff',
        'label'       => 'Show "By line" (By x on 01/01/01 in category)',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'on_posts',
            'label'       => 'Only under post titles',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_byline_author',
        'label'       => 'By Line: Show Author',
        'desc'        => 'Show user icon and author name in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_meta_onoff:not(off)',

      ),
      array(
        'id'          => 'cb_byline_date',
        'label'       => 'By Line: Show Date',
        'desc'        => 'Show clock icon and date in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_meta_onoff:not(off)',

      ),
      array(
        'id'          => 'cb_byline_category',
        'label'       => 'By Line: Show Categories',
        'desc'        => 'Show category icon and list all categories',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_byline_comments',
        'label'       => 'By Line: Show Comments',
        'desc'        => 'Show comments icon and number of comments in By Line',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
      array(
        'id'          => 'cb_byline_postviews',
        'label'       => 'By Line: Show Post View Count',
        'desc'        => 'Show post view count icon and number of post views in By Line',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_general',
        'rows'        => '',
        'post_type'   => '',
        'condition'   => 'cb_meta_onoff:not(off)',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
      ),
       array(
        'id'          => 'cb_hp_title',
        'label'       => 'Homepage Settings',
        'desc'        => 'The settings below only apply to homepages that are set to "Your latest posts" in the "Wordpress Settings -> Reading" section. To create a homepage with modules please read the documentation section "Valenti Homepage Builder',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_blog_style',
        'label'       => 'Blog Style',
        'desc'        => '',
        'std'         => 'style-a',
        'type'        => 'radio-image',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'style-a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'style-b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'style-c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'style-d',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
           array(
            'value'       => 'style-e',
            'label'       => 'Style E',
            'src'         => '/blog_style_e.png'
          ),
          array(
            'value'       => 'style-f',
            'label'       => 'Style F (A+D)',
            'src'         => '/blog_style_f.png'
          ),
          array(
            'value'       => 'style-g',
            'label'       => 'Style G (B+D)',
            'src'         => '/blog_style_g.png'
          ),
        ),
      ),
    array(
        'id'          => 'cb_hp_bs_color',
        'label'       => 'Blog Style Skin',
        'desc'        => '',
        'std'         => 'cb-light-blog',
        'type'        => 'select',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'choices'     => array(
          array(
            'value'       => 'cb-light-blog',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-dark-blog',
            'label'       => 'Dark',
            'src'         => ''
          ),
        ),
      ),
    array(
        'id'          => 'cb_hp_infinite',
        'label'       => 'Infinite Scroll',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'infinite-scroll',
            'label'       => 'Infinite Scroll',
            'src'         => ''
          ),
          array(
            'value'       => 'infinite-load',
            'label'       => 'Infinite Scroll With Load More Button',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_hp_gridslider',
        'label'       => 'Featured Posts',
        'desc'        => 'Show a grid or slider above your homepage\'s "Latest Posts" content.',
        'std'         => 'cb_full_off',
        'type'        => 'radio-image',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
            array(
                'value'       => 'cb_full_off',
                'label'       => 'Off',
                'src'         => '/off.png'
              ),
            array(
                'value'       => 'grid-4',
                'label'       => 'Grid 4',
                'src'         => '/grid_4.png'
              ),
              array(
                'value'       => 'grid-5',
                'label'       => 'Grid 5',
                'src'         => '/grid_5.png'
              ),
              array(
                'value'       => 'grid-6',
                'label'       => 'Grid 6',
                'src'         => '/grid_6.png'
              ),
              array(
                'value'       => 'full-slider',
                'label'       => 'Slider',
                'src'         => '/module_slider_hp.png'
              ),
              array(
                'value'       => 's-2',
                'label'       => 'Small Slider',
                'src'         => '/module_slider_2_hp.png'
              ),
              array(
                'value'       => 's-1',
                'label'       => 'Slider of 4',
                'src'         => '/module_slider_a_fw.png'
              )
        ),
      ),
      array(
        'id'          => 'cb_hp_offset',
        'label'       => 'Posts Offset',
        'desc'        => 'This option means the grid will show posts #1 -> 5 (if grid of 5), and the posts list below will start showing from post #6 -> onwards. This is to avoid duplicates, but only works if your grid shows the latest posts (not when you feature posts to override the grid).',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_hp_gridslider:not(cb_full_off)',
      ),
      array(
        'id'          => 'cb_gridslider_category',
        'label'       => 'Grid/Slider Category Filter',
        'desc'        => 'Optional category filter for featured posts Grid/Slider (if no categories are checked, featured will show all categories)',
        'std'         => '',
        'type'        => 'category-checkbox',
        'section'     => 'cb_homepage',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_hp_gridslider:not(cb_full_off)',
      ),
      array(
        'id'          => 'cb_hp_ad',
        'label'       => 'Advertising Block Above Posts',
        'desc'        => 'Add an advertising block above the list of posts (appears under grid/slider if enabled)',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'cb_homepage',
        'rows'        => '6',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
      ),
      array(
        'id'          => 'cb_sm_position',
        'label'       => 'Secondary Menu Location',
        'desc'        => '',
        'std'         => 'cb-standard',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
           array(
            'value'       => 'cb-standard',
            'label'       => 'Under Main Navigation Menu',
            'src'         => ''
          ),

           array(
            'value'       => 'cb-top',
            'label'       => 'Above Header Area',
            'src'         => ''
          ),
         
          
        ),
      ),
      array(
        'id'          => 'cb_mm_skin',
        'label'       => 'Mobile Menu Skin',
        'desc'        => '',
        'std'         => 'cb-mobm-light',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
           array(
            'value'       => 'cb-mobm-light',
            'label'       => 'Light',
            'src'         => ''
          ),

           array(
            'value'       => 'cb-mobm-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
         
          
        ),
      ),
      array(
        'id'          => 'cb_sticky_m_nav',
        'label'       => 'Sticky Menu on Mobile',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_m_logo_mobile',
        'label'       => 'Show Logo in Menu on Small Screen devices',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_sticky_m_nav:is(on)',
      ),
       array(
        'id'          => 'cb_logo_nav_m_url',
        'label'       => 'Logo to show in Mobile Menu',
        'desc'        => 'Upload your logo (Recommended size: 110px width by 25px height).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_m_logo_mobile:is(on),cb_sticky_m_nav:is(on)',
      ),
       array(
        'id'          => 'cb_logo_nav_m_retina_url',
        'label'       => 'Logo to show in Mobile Menu (Retina Version)',
        'desc'        => 'Upload your logo (Retina version) for the mobile menu - Size must be exactly double the size of the original logo set above.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_m_logo_mobile:is(on),cb_sticky_m_nav:is(on)',
      ),
      array(
        'id'          => 'cb_logo_in_nav',
        'label'       => 'Logo in Navigation Menu',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'std'         => 'off',
      ),
      array(
        'id'          => 'cb_logo_in_nav_when',
        'label'       => 'When to show logo in navigation menu',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => 'cb_logo_in_nav:is(on)',
        'class'       => 'cb-sub',
        'choices'     => array(
          array(
            'value'       => 'always',
            'label'       => 'Always',
            'src'         => ''
          ),
          array(
            'value'       => 'sticky',
            'label'       => 'Only after scroll down',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_logo_nav_url',
        'label'       => 'Navigation Menu Logo',
        'desc'        => 'Upload your logo (Recommended size: 100px width by 18px height).',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_logo_nav_url_retina',
        'label'       => 'Navigation Menu Retina Logo ',
        'desc'        => 'Upload your retina logo (must be double the size of normal logo.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_logo_nav_left',
        'label'       => 'Adjust menu items position',
        'desc'        => 'Depending on the size of logo in the navigation, menus with few items can be slightly off-center, this option helps to correct it. The slider represents number of pixels to move the menu items left or right.',
        'std'         => '0',
        'type'        => 'numeric-slider',
        'min_max_step'=> '-100,100,1',
        'section'     => 'cb_menus',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_logo_in_nav:is(on)',
      ),
      array(
        'id'          => 'cb_main_nav_icons',
        'label'       => 'Show Search And/Or Login Icons In Main Menu',
        'desc'        => '<strong>Note:</strong> Login option requires "Login With Ajax" plugin to be installed and active',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'both',
            'label'       => 'Show Search + Login',
            'src'         => ''
          ),
          array(
            'value'       => 'search',
            'label'       => 'Only Show Search',
            'src'         => ''
          ),
          array(
            'value'       => 'login',
            'label'       => 'Only Show Login',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_menu_style',
        'label'       => 'Main Navigation Style',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
           array(
            'value'       => 'cb_light',
            'label'       => 'Light',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_ajax_mm',
        'label'       => 'Ajax Megamenu Sub-Menu items',
        'desc'        => 'Enable ajax sub-menus - When user hover over sub-menu in post megamenu, the "Recent posts" section will update to show the latest posts of that megamenu.',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_sticky_nav',
        'label'       => 'Sticky Main Navigation Bar',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_nav_when_sticky',
        'label'       => 'When to show sticky menu',
        'desc'        => '',
        'std'         => 'cb-sticky-menu',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => 'cb_sticky_nav:is(on)',
        'class'       => 'cb-sub',
        'choices'     => array(
          array(
            'value'       => 'cb-sticky-menu',
            'label'       => 'Always (if scrolled past menu)',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-sticky-menu-up',
            'label'       => 'Only when scrolling upwards',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_breaking_news',
        'label'       => 'Breaking News Under Navigation Menu',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_breaking_news_title',
        'label'       => 'Breaking News Title',
        'desc'        => 'Change the "Breaking" word to anything, such as "Trending".',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'cb_menus',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_breaking_news:is(on)',
      ),
      array(
        'id'          => 'cb_breaking_source',
        'label'       => 'What posts to show',
        'desc'        => 'NOTE: The Trending options require JetPack plugin to be installed + activate JetPack\'s Stats module.',
        'std'         => 'cb_breaking_source_latest',
        'type'        => 'select',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_breaking_news:is(on)',
        'choices'     => array(
          array(
            'value'       => 'cb_breaking_source_latest',
            'label'       => 'Latest',
          ),
          array(
            'value'       => 'cb_breaking_source_trend_24',
            'label'       => 'Trending Last 24 Hours',
          ),
           array(
            'value'       => 'cb_breaking_source_trend_week',
            'label'       => 'Trending Last Week',
          ),
           
        ),
      ),
       array(
        'id'          => 'cb_breaking_news_filter',
        'label'       => 'Breaking News Filter',
        'desc'        => 'Optional category filter for breaking news (if no categories are checked - all categories will be shown)',
        'std'         => '',
        'type'        => 'category-checkbox',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => 'cb_breaking_news:is(on),cb_breaking_source:is(cb_breaking_source_latest)',
        'class'       => 'cb-sub-sub',
      ),
       array(
            'id'          => 'cb_breaking_count',
            'label'       => 'Number Of Posts To Show',
            'desc'        => '',
            'std'         => '4',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'section'     => 'cb_menus',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '1,12,1',
            'condition'   => 'cb_breaking_news:is(on)',
            'class'       => 'cb-sub'
      ),
       array(
        'id'          => 'cb_breaking_news_color',
        'label'       => 'Breaking News Post Font Color',
        'desc'        => 'Change the color of the post titles in the breaking news block.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'cb_menus',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_breaking_news:is(on)',
      ),

       array(
        'id'          => 'cb_post_style_override_onoff',
        'label'       => 'Global Featured Image Style Override',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',

      ),
      array(
            'id'          => 'cb_post_style_override',
            'label'       => 'Global Featured Image Style',
            'desc'        => '',
            'std'         => 'standard',
            'type'        => 'radio-image',
            'section'     => 'cb_post_settings',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_post_style_override_onoff:is(on)',
            'choices'     => array(
             array(
                'value'       => 'standard',
                'label'       => 'Standard',
                'src'         => '/img_st.png'
              ),
             array(
          'value'       => 'standard-uncrop',
          'label'       => 'Standard Uncropped',
          'src'         => '/img_stun.png'
          ),
              array(
                'value'       => 'full-width',
                'label'       => 'Full-Width',
                'src'         => '/img_fw.png'
              ),
              array(
                'value'       => 'full-background',
                'label'       => 'Full-Background',
                'src'         => '/img_fb.png'
              ),
              array(
                'value'       => 'parallax',
                'label'       => 'Parallax',
                'src'         => '/img_pa.png'
              ),
              array(
                'value'       => 'off',
                'label'       => 'Do not show featured image',
                'src'         => '/off.png'
              ),
            ),
      ),
      array(
        'id'          => 'cb_social_sharing',
        'label'       => 'Social Sharing',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'on',
            'label'       => 'On - Normal',
            'src'         => ''
          ),
          array(
            'value'       => 'on_big',
            'label'       => 'On - Big',
            'src'         => ''
          ),
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_social_fb',
        'label'       => 'Facebook Like button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
      ),
      array(
        'id'          => 'cb_social_fb_share',
        'label'       => 'Facebook Share button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'off',
      ),
      array(
        'id'          => 'cb_social_st',
        'label'       => 'StumbleUpon button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
      ),
      array(
        'id'          => 'cb_social_tw',
        'label'       => 'Twitter button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
      ),
      array(
        'id'          => 'cb_social_go',
        'label'       => 'Google+ button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
      ),
      array(
        'id'          => 'cb_social_pi',
        'label'       => 'Pinterest button',
        'desc'        => '',
        'type'        => 'on-off',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'std'         => 'on',
      ),
      array(
        'id'          => 'cb_post_footer_ad',
        'label'       => 'Post End Of Content Banner Code',
        'desc'        => 'Enter your ad code. This ad will appear at the end of the post content.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'cb_post_settings',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_comments_onoff',
        'label'       => 'Comments',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_comments_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_comments_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_author_box_onoff',
        'label'       => 'Show author box in articles',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_author_box_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_author_box_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_previous_next_onoff',
        'label'       => 'Show Next/Previous in articles',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_previous_next_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_previous_next_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_related_onoff',
        'label'       => 'Show related posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_related_on',
            'label'       => 'On',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_related_off',
            'label'       => 'Off',
            'src'         => ''
          )
        ),
      ),
      array(
            'id'          => 'cb_related_posts_amount',
            'label'       => 'Number Of Related Posts To Show',
            'desc'        => '',
            'std'         => '2',
            'type'        => 'numeric-slider',
            'rows'        => '',
            'section'     => 'cb_post_settings',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '2,12,2',
            'condition'   => 'cb_related_onoff:not(cb_related_off)',
            'class'       => 'cb-sub'
      ),
      array(
        'id'          => 'cb_related_posts_show',
        'label'       => 'Where to look for related posts',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(cb_related_off)',
        'choices'     => array(
          array(
            'value'       => 'both',
            'label'       => 'Related by tags and if no posts found, show related by category',
            'src'         => ''
          ),
          array(
            'value'       => 'tags',
            'label'       => 'Only related by tags',
            'src'         => ''
          ),
          array(
            'value'       => 'cats',
            'label'       => 'Only related by category',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_related_posts_order',
        'label'       => 'Related Posts Order',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'cb_post_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_related_onoff:not(cb_related_off)',
        'choices'     => array(
          array(
            'value'       => 'rand',
            'label'       => 'Random',
            'src'         => ''
          ),
          array(
            'value'       => 'date',
            'label'       => 'Date (Latest Published)',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_base_color',
        'label'       => 'Global Color',
        'desc'        => 'Color to show on menu, hovers, borders, etc if a page, post, category, etc doesn\'t have their own specific color set',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_header_bg_image',
        'label'       => 'Header Background Color/Image',
        'desc'        => 'Set a background color or image for the header block (behind logo + optional ad)',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_body_text_color',
        'label'       => 'Body Text Color',
        'desc'        => 'Change the body text color',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_link_color',
        'label'       => 'Hyperlink text Color',
        'desc'        => 'Overrides the default color for text links within posts/page body text',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_background_image',
        'label'       => 'Global Background Image',
        'desc'        => 'Upload a background image. Can be overriden by category/post/page background settings',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_module_underlines',
        'label'       => 'Post Title Underlines (Grids/Sliders)',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      
      ),
      array(
        'id'          => 'cb_module_zoom',
        'label'       => 'Zoom CSS hover effect (Grids/Sliders)',
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
       array(
        'id'          => 'cb_modal_style',
        'label'       => 'Modals Skin',
        'desc'        => 'Color of the search and login/logged in modals.',
        'std'         => 'cb-modal-dark',
        'type'        => 'select',
        'section'     => 'ot_styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb-modal-dark',
            'label'       => 'Dark',
            'src'         => ''
          ),
          array(
            'value'       => 'cb-modal-light',
            'label'       => 'Light',
            'src'         => ''
          ),
        ),
      ),
      array(
        'id'          => 'cb_header_font',
        'label'       => 'Recommended Header Fonts',
        'desc'        => 'Select the font of the Headers and important titles.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
        array(
            'value'       => "'Oswald', sans-serif;",
            'label'       => 'Oswald (Recommended)',
            'src'         => ''
          ),
          array(
            'value'       => "'Arvo', serif;",
            'label'       => 'Arvo',
            'src'         => ''
          ),
          array(
            'value'       => "'Gudea', sans-serif;",
            'label'       => 'Gudea',
            'src'         => ''
          ),

          array(
            'value'       => "'Open Sans', sans-serif;",
            'label'       => 'Open Sans',
            'src'         => ''
          ),

          array(
            'value'       => "'PT Sans', sans-serif;",
            'label'       => 'PT Sans',
            'src'         => ''
          ),

          array(
            'value'       => "'Titillium Web', sans-serif;",
            'label'       => 'Titillium Web',
            'src'         => ''
          ),
           array(
            'value'       => "'Ubuntu', sans-serif;",
            'label'       => 'Ubuntu',
            'src'         => ''
          ),
           array(
            'value'       => 'other',
            'label'       => 'Other Google Font',
            'src'         => ''
          ),
           array(
            'value'       => 'none',
            'label'       => 'Use your own font',
            'src'         => ''
          ),

        ),
      ),
      array(
        'id'          => 'cb_user_header_font',
        'label'       => 'Other Header Font',
        'desc'        => 'Use another font. Google Fonts enter the code given at http://www.google.com/fonts. Example: \'Playfair Display SC\', serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_header_font:is(other),cb_header_font:is(none)',
        'operator'    => 'or'
      ),
      array(
        'id'          => 'cb_body_font',
        'label'       => 'Recommended Body Font',
        'desc'        => 'Select the font of the body text.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
         array(
            'value'       => "'Open Sans', sans-serif;",
            'label'       => 'Open Sans (Recommended)',
            'src'         => ''
          ),
          array(
            'value'       => "'Arimo', sans-serif;",
            'label'       => 'Arimo',
            'src'         => ''
          ),
          array(
            'value'       => "'Droid Sans', sans-serif;",
            'label'       => 'Droid Sans',
            'src'         => ''
          ),
          array(
            'value'       => "'Istok Web', sans-serif;",
            'label'       => 'Istok Web',
            'src'         => ''
          ),
          array(
            'value'       => "'PT Sans', sans-serif;",
            'label'       => 'PT Sans',
            'src'         => ''
          ),
           array(
            'value'       => "'Quattrocento Sans', sans-serif;",
            'label'       => 'Quattrocento',
            'src'         => ''
          ),
          array(
            'value'       => "'Raleway', sans-serif;",
            'label'       => 'Raleway',
            'src'         => ''
          ),
          array(
            'value'       => 'other',
            'label'       => 'Other Google Font',
            'src'         => ''
          ),
          array(
            'value'       => 'none',
            'label'       => 'Use your own font',
            'src'         => ''
          ),
        ),
      ),
      array(
        'id'          => 'cb_user_body_font',
        'label'       => 'Other Body Font',
        'desc'        => 'Use another font. For Google Fonts enter the code given at http://www.google.com/fonts. Example: \'Noto Sans\', sans-serif;',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_body_font:is(other),cb_body_font:is(none)',
        'operator'    => 'or'
      ),
      array(
        'id'          => 'cb_font_ext_lat',
        'label'       => 'Use Latin Extended Charset (Needed in some languages)',
        'desc'        => 'Some languages use special characters that require extra marking. Enable this to also load the Latin Extended character font set.',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'std'         => 'off',

      ),
      array(
        'id'          => 'cb_font_cyr',
        'label'       => 'Use Cyrillic Extended Charset (Needed in some languages)',
        'desc'        => 'Some languages use special characters that require extra marking. Enable this to also load the Cyrillic Extended character font set.',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',        
        'std'         => 'off',

      ),
      array(
        'id'          => 'cb_font_greek',
        'label'       => 'Use Greek Charset',
        'desc'        => 'Some languages use special characters that require extra marking. Enable this to also load the Greek Extended character font set.',
        'type'        => 'on-off',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',        
        'std'         => 'on',

      ),
      array(
        'id'          => 'cb_body_font_size_mobile',
        'label'       => 'Body Font Size (Mobile)',
        'desc'        => 'Set the font size for mobile devices. Default = 14px',
        'type'        => 'measurement',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',        
        'std'         => '',
      ),
      array(
        'id'          => 'cb_body_font_size_desktop',
        'label'       => 'Body Font Size (Desktop)',
        'desc'        => 'Set the font size for desktops sized screens (laptops, desktop computers, etc). Default = 14px',
        'type'        => 'measurement',
        'section'     => 'ot_typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',        
        'std'         => '',
      ),
      array(
        'id'          => 'cb_footer_copyright',
        'label'       => 'Footer Copyright',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_footer',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_footer_layout',
        'label'       => 'Footer Layout',
        'desc'        => '',
        'std'         => 'cb-footer-a',
        'type'        => 'radio-image',
        'section'     => 'ot_footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb-footer-a',
            'label'       => 'Layout A',
            'src'         => '/footer_style_a.png'
          ),
          array(
            'value'       => 'cb-footer-b',
            'label'       => 'Layout B',
            'src'         => '/footer_style_b.png'
          ),
          array(
            'value'       => 'cb-footer-c',
            'label'       => 'Layout C',
            'src'         => '/footer_style_c.png'
          ),
          array(
            'value'       => 'cb-footer-d',
            'label'       => 'Layout D',
            'src'         => '/footer_style_d.png'
          ),
          array(
            'value'       => 'cb-footer-e',
            'label'       => 'Layout E',
            'src'         => '/footer_style_e.png'
          ),
          array(
            'value'       => 'cb-footer-f',
            'label'       => 'Layout F',
            'src'         => '/footer_style_f.png'
          ),
        ),
      ),
      array(
        'id'          => 'cb_gridslider_design',
        'label'       => 'Grid & Slider Post Design',
        'desc'        => '',
        'std'         => 'cb-gs-style-a',
        'type'        => 'radio-image',
        'section'     => 'ot_gridsliders',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb-gs-style-a',
            'label'       => 'Design A',
            'src'         => '/gs_style_a.png'
          ),
          array(
            'value'       => 'cb-gs-style-b',
            'label'       => 'Deisng B',
            'src'         => '/gs_style_b.png'
          ),
          array(
            'value'       => 'cb-gs-style-c',
            'label'       => 'Design C',
            'src'         => '/gs_style_c.png'
          ),
          array(
            'value'       => 'cb-gs-style-d',
            'label'       => 'Design D',
            'src'         => '/gs_style_d.png'
          ),
          array(
            'value'       => 'cb-gs-style-e',
            'label'       => 'Design E',
            'src'         => '/gs_style_e.png'
          ),
        ),
      ),
      array(
        'id'          => 'cb_l_5',
        'label'       => 'Global Slider Controls',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_gridsliders',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'   => 'cb-big-title',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'cb_sliders_animation_speed',
        'label'       => 'Speed of Animation Effect',
        'desc'        => 'Set the speed of the animation effect. Default: 600ms (0.6 seconds)',
        'std'         => '600',
        'type'        => 'numeric-slider',
        'min_max_step'=> '0,5000,100',
        'section'     => 'ot_gridsliders',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'cb-sub',
      ),
       array(
        'id'          => 'cb_sliders_autoplay',
        'label'       => 'Automatic Sliding',
        'desc'        => 'Make sliders automatically start sliding or make them static and only slide if visitor clicks/taps on slider arrows',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_gridsliders',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'cb-sub',
        'condition'   => '',
      ),
       array(
        'id'          => 'cb_sliders_speed',
        'label'       => 'Seconds between Automatic Sliding',
        'desc'        => 'Set the speed of sliders to automatically slide Default: 7000ms (7 seconds)',
        'std'         => '7000',
        'type'        => 'numeric-slider',
        'min_max_step'=> '0,15000,100',
        'section'     => 'ot_gridsliders',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_sliders_autoplay:is(on)',
      ),
array(
        'id'          => 'cb_bs_show_read_more',
        'label'       => 'Show "Read More" link after excerpts',
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_blogstyles',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
    array(
        'id'          => 'cb_bs_show_read_more_text',
        'label'       => 'Text for read more button',
        'desc'        => '',
        'std'         => 'Read More...',
        'type'        => 'text',
        'section'     => 'ot_blogstyles',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bs_show_read_more:is(on)',
      ),
      array(
        'id'          => 'cb_misc_search_pl',
        'label'       => 'Search Results Pages Post Layout',
        'desc'        => '',
        'std'         => 'style-a',
        'type'        => 'radio-image',
        'section'     => 'ot_blogstyles',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'style-a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'style-b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'style-c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'style-d',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
           array(
        'value'       => 'style-e',
        'label'       => 'Style E',
        'src'         => '/blog_style_e.png'
      ),
      array(
        'value'       => 'style-f',
        'label'       => 'Style F (A+D)',
        'src'         => '/blog_style_f.png'
      ),
      array(
            'value'       => 'style-g',
            'label'       => 'Style G (B+D)',
            'src'         => '/blog_style_g.png'
          ),

        )
      ),
      array(
        'id'          => 'cb_misc_archives_pl',
        'label'       => 'Archives Post Layout',
        'desc'        => '',
        'std'         => 'style-a',
        'type'        => 'radio-image',
        'section'     => 'ot_blogstyles',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'style-a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'style-b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'style-c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'style-d',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
           array(
        'value'       => 'style-e',
        'label'       => 'Style E',
        'src'         => '/blog_style_e.png'
      ),
      array(
        'value'       => 'style-f',
        'label'       => 'Style F (A+D)',
        'src'         => '/blog_style_f.png'
      ),
      array(
            'value'       => 'style-g',
            'label'       => 'Style G (B+D)',
            'src'         => '/blog_style_g.png'
          ),
        )
      ), array(
        'id'          => 'cb_misc_tags_pl',
        'label'       => 'Tags Post Layout Default',
        'desc'        => '',
        'std'         => 'style-a',
        'type'        => 'radio-image',
        'section'     => 'ot_blogstyles',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'style-a',
            'label'       => 'Style A',
            'src'         => '/blog_style_a.png'
          ),
          array(
            'value'       => 'style-b',
            'label'       => 'Style B',
            'src'         => '/blog_style_b.png'
          ),
          array(
            'value'       => 'style-c',
            'label'       => 'Style C',
            'src'         => '/blog_style_c.png'
          ),
          array(
            'value'       => 'style-d',
            'label'       => 'Style D',
            'src'         => '/blog_style_d.png'
          ),
           array(
        'value'       => 'style-e',
        'label'       => 'Style E',
        'src'         => '/blog_style_e.png'
      ),
      array(
        'value'       => 'style-f',
        'label'       => 'Style F (A+D)',
        'src'         => '/blog_style_f.png'
      ),
      array(
            'value'       => 'style-g',
            'label'       => 'Style G (B+D)',
            'src'         => '/blog_style_g.png'
          ),
        )
      ),
      array(
        'id'          => 'cb_banner_selection',
        'label'       => 'Header Banner Selection',
        'desc'        => 'Type of ad to appear in the site\'s header (Next to the logo)',
        'std'         => 'cb_banner_off',
        'type'        => 'radio-image',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_banner_off',
            'label'       => 'Off',
            'src'         => '/off.png'
          ),
          array(
            'value'       => 'cb_banner_468',
            'label'       => 'Banner 468x60',
            'src'         => '/ada.png'
          ),
          array(
            'value'       => 'cb_banner_728',
            'label'       => 'Banner 728x90',
            'src'         => '/adb.png'
          )
        ),
      ),
      array(
        'id'          => 'cb_banner_code',
        'label'       => 'Banner Code',
        'desc'        => 'Enter your ad code.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_advertising',
        'rows'        => '4',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => 'cb_banner_selection:not(cb_banner_off)'
      ),
      array(
        'id'          => 'cb_bg_to',
        'label'       => 'Clickable Background Advertising Takeover',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'global',
            'label'       => 'Global',
            'src'         => ''
          ),
          array(
            'value'       => 'only-hp',
            'label'       => 'Only Homepage',
            'src'         => ''
          ),
        ),
      ),
      array(
        'id'          => 'cb_bg_to_img',
        'label'       => 'Background Takeover Ad Image',
        'desc'        => 'Uploade/Select the background ad image.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bg_to:not(off)'
      ),
      array(
        'id'          => 'cb_bg_to_url',
        'label'       => 'Background Takeover Ad Link',
        'desc'        => 'Enter the URL that clicking the background ad image should open.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_advertising',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bg_to:not(off)'
      ),
      array(
        'id'          => 'cb_bg_to_margin_top',
        'label'       => 'Top Margin Of Content',
        'desc'        => 'If your background ad needs to be visible at the top, enter a number and select the appropiate measurement and the content of your site will move down. It is recommended to use pixels (px)',
        'std'         => '',
        'type'        => 'measurement',
        'section'     => 'ot_advertising',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub',
        'condition'   => 'cb_bg_to:not(off)'
      ),
      array(
        'id'          => 'cb_custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'No need to hard-edit style.css anymore. All your CSS modifications can be done here so you do not lose them in future theme updates. (It is still recommended to save a backup of this custom CSS to a separate .txt file)',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'ot_custom_code',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_custom_head',
        'label'       => 'Code For &lt;head&gt; section',
        'desc'        => 'No need to hard-edit files anymore to add custom Javascript/code to your head. Code in this box will appear before the closing head tag.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_custom_footer',
        'label'       => 'Code to put just before closing Body tag (end of site)',
        'desc'        => 'No need to hard-edit files anymore to add custom Javascript/code. Code in this box will appear right before the closing body tag.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_disqus_shortname',
        'label'       => 'Disqus Forum Shortname',
        'desc'        => 'If you are using Disqus commenting system, you must enter the forum shortname here to be able to show the comment number everywhere.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_cpt',
        'label'       => 'Custom Post Type Names',
        'desc'        => 'If you want your custom post types to have meta boxes and appear in the pagebuilder, enter the names of them here (Separated by comma, example: books, movies)',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ot_custom_code',
        'rows'        => '1',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_bbpress_global_color',
        'label'       => 'bbPress Global Color',
        'desc'        => 'Set a color to be used in menu hovers, sidebar bottom borders, etc.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'cb_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_bbp_sticky_background_color',
        'label'       => 'bbPress Sticky Posts Background Color',
        'desc'        => 'Set a color to be used on the backgrounds of sticky posts (Light tones are recommended).',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'cb_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(

            'id'          => 'cb_bbpress_sidebar',
            'label'       => 'bbPress Style',
            'desc'        => '',
            'std'         => 'sidebar',
            'type'        => 'radio-image',
            'section'     => 'cb_bbpress',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'choices'     => array(
              array(
                'value'       => 'sidebar',
                'label'       => 'With Sidebar',
                'src'         => '/post_sidebar.png'
              ),
              array(
                'value'       => 'sidebar_left',
                'label'       => 'With Left Sidebar',
                'src'         => '/post_sidebar_left.png'
              ),
              array(
                'value'       => 'nosidebar',
                'label'       => 'No Sidebar',
                'src'         => '/post_nosidebar.png'
              ),
            ),
      ),
      array(
        'id'          => 'cb_bbpress_background_image',
        'label'       => 'bbPress Background Image',
        'desc'        => 'Upload/Select a background image.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'cb_bbpress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_buddypress_global_color',
        'label'       => 'BuddyPress Global Color',
        'desc'        => 'Set a color to be used in menu hovers, sidebar bottom borders, etc.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'cb_buddypress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_buddypress_sidebar',
        'label'       => 'BuddyPress Style',
        'desc'        => '',
        'std'         => 'sidebar',
        'type'        => 'radio-image',
        'section'     => 'cb_buddypress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'sidebar',
            'label'       => 'With Sidebar',
            'src'         => '/post_sidebar.png'
          ),
          array(
            'value'       => 'sidebar_left',
            'label'       => 'With Left Sidebar',
            'src'         => '/post_sidebar_left.png'
          ),
          array(
            'value'       => 'nosidebar',
            'label'       => 'No Sidebar',
            'src'         => '/post_nosidebar.png'
          ),
        ),
      ),
      array(
        'id'          => 'cb_buddypress_background_image',
        'label'       => 'BuddyPress Background Image',
        'desc'        => 'Upload/Select a background image.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'cb_buddypress',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_woocommerce_global_color',
        'label'       => 'WooCommerce Global Color',
        'desc'        => 'Set a color to be used in menu hovers, sidebar bottom borders, etc.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'cb_woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_woocommerce_sidebar',
        'label'       => 'WooCommerce Style',
        'desc'        => '',
        'std'         => 'sidebar',
        'type'        => 'radio-image',
        'section'     => 'cb_woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'sidebar',
            'label'       => 'With Sidebar',
            'src'         => '/post_sidebar.png'
          ),
          array(
            'value'       => 'sidebar_left',
            'label'       => 'With Left Sidebar',
            'src'         => '/post_sidebar_left.png'
          ),
          array(
            'value'       => 'nosidebar',
            'label'       => 'No Sidebar',
            'src'         => '/post_nosidebar.png'
          ),
        ),
      ),
      array(
        'id'          => 'cb_woocommerce_sidebar_override',
        'label'       => 'WooCommerce Sidebar Override',
        'desc'        => '',
        'std'         => 'cb_off',
        'type'        => 'select',
        'section'     => 'cb_woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb_off',
            'label'       => 'Off',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_no_posts',
            'label'       => 'No sidebar on product pages',
            'src'         => ''
          ),
          array(
            'value'       => 'cb_no_shop',
            'label'       => 'No sidebar on Shop page',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'cb_woocommerce_background_image',
        'label'       => 'WooCommerce Background Image',
        'desc'        => 'Upload/Select a background image.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'cb_woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'cb_embeds_sb_narrow',
        'label'       => 'Make Embeds Full-Width in Narrow Sidebar Layout option',
        'desc'        => 'If you select the Narrow Sidebar post layout option for a post, enable this option to make any embedded images set to "align: none" and "full-size" size will be the site width',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_ss',
        'label'       => 'Smooth Scroll',
        'desc'        => 'Enable Smooth Scrolling (does not load on OS X, as it already has smooth scrolling).',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_minify_js_onoff',
        'label'       => 'Minify JS',
        'desc'        => 'Use minified JS code (Recommended).',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_sticky_sb',
        'label'       => 'Sticky Sidebars',
        'desc'        => 'Important and useful info: Some ad providers do not allow their ads to be on sticky sidebars. If you plan on having ads on a sticky sidebar, check the Terms of use of before setting it up that way. For example AdSense policy seems to not allow this. For relevant official policy, read this: https://support.google.com/adsense/answer/1346295?hl=en#Unnatural_attention_to_ads and https://support.google.com/adsense/answer/3394713?hl=en&ref_topic=1250104#2 It is important to always comply with the terms of use/policies of your Ad providers, as if you break them, you could end up with a banned account.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),array(
        'id'          => 'cb_show_pages_search',
        'label'       => 'Show Pages In Search Results',
        'desc'        => 'Pages do not appear in search results by default. If you want them to appear, enable this option.',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_misc_stats_source',
        'label'       => 'View count stats source',
        'desc'        => 'Where to get the view counts from? Theme counter or from Jetpacks -> Stats module? Jetpack stats is the recommended solution for accurate view counts.',
        'std'         => 'theme',
        'type'        => 'select',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'theme',
            'label'       => 'Theme Stats (basic)',
            'src'         => ''
          ),
          array(
            'value'       => 'jetpack',
            'label'       => 'Jetpack -> Stats Module (recommended)',
            'src'         => ''
          ),
        ),
      ),
      array(
        'id'          => 'cb_youtube_api',
        'label'       => 'Video Post Types: Load YouTube API (for video autostart on play click)',
        'desc'        => 'Make YouTube embeds in your Video Post Types automatically start playing when a visitor clicks the first play button.',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_extras',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_title',
        'label'       => 'Image Thumbnails',
        'desc'        => 'These options are for users who know exactly what thumbnail sizes they want to use. If you are unsure, it is recommended to leave them all enabled.',
        'std'         => '',
        'type'        => 'textblock-titled',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'cb_fi_80x60',
        'label'       => 'Thumbnail Size: 80x60',
        'desc'        => 'Used for all small thumbnails (modules, megamenus, widgets, etc)',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_300x250',
        'label'       => 'Thumbnail Size: 300x250',
        'desc'        => 'Used on grids and some sliders',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_360x240',
        'label'       => 'Thumbnail Size: 360x240',
        'desc'        => 'Used on Blog Style A/B/C, Module B/C/E and big style images',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_480x240',
        'label'       => 'Thumbnail Size: 480x240',
        'desc'        => 'Used on Random/Featured megamenu block',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_400x250',
        'label'       => 'Thumbnail Size: 400x250',
        'desc'        => 'Used on sliders with multiple slides, review/slider widget and Grid of 5',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_600x250',
        'label'       => 'Thumbnail Size: 600x250',
        'desc'        => 'Used on Grids',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_600x400',
        'label'       => 'Thumbnail Size: 600x400',
        'desc'        => 'Used on Grids',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_750x400',
        'label'       => 'Thumbnail Size: 750x400',
        'desc'        => 'Used on standard featured image style and big sliders with sidebar',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),
      array(
        'id'          => 'cb_fi_1200x520',
        'label'       => 'Thumbnail Size: 1200x520',
        'desc'        => 'Used on full-width featured image style and biggest slider',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'ot_fi',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
      ),   
      array(
        'id'          => 'cb_how_to_get_support',
        'label'       => 'Having trouble with Valenti?',
        'desc'        => '',
        'std'         => '',
        'type'        => 'radio-image',
        'section'     => 'cb_theme_help',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'cb-doc',
            'label'       => 'Documentation',
            'src'         => '/help_doc.png'
          ),
          array(
            'value'       => 'cb_help_forum',
            'label'       => 'Support Forum',
            'src'         => '/help_forum.png'
          )
        ),
      )
    )
  );

  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );

  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings );
  }

}