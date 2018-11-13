<?php

function _cb_meta() {

  $cb_cpt_list = ot_get_option( 'cb_cpt', NULL ); 
  $cb_cpt_output = array('post');
  if ( $cb_cpt_list != NULL ) {
    $cb_cpt = explode(',', str_replace(' ', '', $cb_cpt_list ) );

    foreach ( $cb_cpt as $cb_cpt_single ) {
      $cb_cpt_output[] = $cb_cpt_single;
    }
  }
  
  $cb_taxes = cb_get_taxonomies();
  $cb_tax_list_choices = array();
  foreach ( $cb_taxes as $cb_taxes_single ) {

    $cb_tax_list_choices[] = array(
        'value'       => $cb_taxes_single,
        'label'       => $cb_taxes_single,
        'src'         => ''
        );
  }

  $cb_tax_str_output_1 = $cb_tax_str_output_2 = $cb_tax_str_output_3 = array(
    'label'       => 'Hidden',
    'id'          => 'cb_hide',
    'type'        => 'textarea',
    'desc'        => '',
    'std'         => '',
    'rows'        => '',
    'post_type'   => '',
    'taxonomy'    => '',
    'class'       => '',
    'condition'   => 'cb_a_module_style_hide:is(hidden)',
  );

  $cb_count = 1;
  if ( $cb_taxes != NULL ) {
    $cb_tax_str = $cb_taxes;

    if ( count($cb_tax_str) == 0 ) {
      $cb_tax_str[] = 'dummy';
      $cb_tax_str[] = 'dummy';
      $cb_tax_str[] = 'dummy';
    }
     if ( count($cb_tax_str) == 1 ) {
      $cb_tax_str[] = 'dummy';
      $cb_tax_str[] = 'dummy';
    }
    if ( count($cb_tax_str) == 2 ) {
      $cb_tax_str[] = 'dummy';
    }

    foreach ( $cb_tax_str as $cb_tax_str_single ) {
      if ( $cb_tax_str_single == 'dummy' ) {
        $cb_tax_str_single = NULL;
      }

      ${"cb_tax_str_output_". $cb_count } = array(
      'label'       => 'Taxonomy Terms From: ' . $cb_tax_str_single,
      'id'          => 'ctax_cb',
      'type'        => 'taxonomy-checkbox',
      'desc'        => '',
      'std'         => '',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => $cb_tax_str_single,
      'class'       => '',
      'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a),cb_filter:is(cb_filter_ctax),cb_tax_list:is(' . $cb_tax_str_single . ')',
      );
    $cb_count++;
    }
  } 

  $cb_go = array(
    'id'          => 'cb_go',
    'title'       => 'Valenti Post Options',
    'desc'        => '',
    'pages'       => $cb_cpt_output,
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      
      array(
      'label'       =>  'Featured Image Options',
      'id'          => 'cb_tab_fi',
      'type'        => 'tab'
  ),
      array(
        'id'          => 'cb_featured_image_style_override',
        'label'       => 'Ignore Global Featured Image Style',
        'desc'        => 'Enable this to Ignore whatever you have set in "Theme Options -> Posts -> Global Featured Image Style Override" option.',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => '-',
            'src'         => ''
            ),
          array(
            'value'       => 'on',
            'label'       => 'Ignore Global Override',
            'src'         => ''
            )
          ),
        ),
      array(
        'id'          => 'cb_featured_image_style',
        'label'       => 'Featured Image Style',
        'desc'        => '',
        'std'         => 'standard',
        'type'        => 'radio-image',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
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
        'id'          => 'cb_featured_image_title_style',
        'label'       => 'Title Location',
        'desc'        => 'Title style for Full-Width, Background and Parallax Featured Image Styles',
        'std'         => 'cb-fis-tl-default',
        'type'        => 'radio-image',
        'rows'        => '',
        'post_type'   => '',
        'condition'   => 'cb_featured_image_style:not(standard),cb_featured_image_style:not(standard-uncrop),cb_featured_image_style:not(off)',
        'taxonomy'    => '',
        'class'       => 'cb-sub',
        'choices'     => array(
         array(
          'value'       => 'cb-fis-tl-default',
          'label'       => 'Standard',
          'src'         => '/img_ts_def.png'
          ),
         array(
          'value'       => 'cb-fis-tl-overlay',
          'label'       => 'Overlay',
          'src'         => '/img_ts_ov.png'
          ),
         ),
        ),

array(
        'id'          => 'cb_featured_image_st_title_style',
        'label'       => 'Title Location',
        'desc'        => 'Title style for standard Featured Image Style',
        'std'         => 'cb-fis-tl-st-default',
        'type'        => 'radio-image',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'condition'   => 'cb_featured_image_style:is(standard),cb_featured_image_style:is(standard-uncrop)',
        'operator'    => 'or',
        'class'       => 'cb-sub',
        'choices'     => array(
         array(
          'value'       => 'cb-fis-tl-st-default',
          'label'       => 'Standard',
          'src'         => '/img_ts_st.png'
          ),
         array(
          'value'       => 'cb-fis-tl-st-above',
          'label'       => 'Above',
          'src'         => '/img_ts_ab.png'
          ),
         ),
        ),
array(
            'id'          => 'cb_post_fis_header',
            'label'       => 'Show site Header (Logo + Header Ad area)',
            'desc'        => 'To maximise the screen for this featured image style, you can disable the header for this post (Post doesn\'t load logo/header ad area). If you have a logo in the menu, this will be visible.',
            'std'         => 'on',
            'type'        => 'on-off',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_featured_image_style:is(parallax),cb_featured_image_style:is(background-slideshow),cb_featured_image_style:is(full-background),cb_featured_image_style:is(full-width)',
            'operator'    => 'or'
        ),
array(
  'label'       => 'Featured Image Credit Line',
  'id'          => 'cb_image_credit',
  'type'        => 'text',
  'desc'        => 'Optional Photograph credit line',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => ''
  ),
array(
          'label'       =>  'Featured Post',
          'id'          => 'cb_tab_bg',
          'type'        => 'tab'
      ),
      array(
        'id'          => 'cb_featured_post_menu',
        'label'       => 'Valenti Dropdown Menu Featured',
        'desc'        => 'Featured on category dropdown "Valenti Megamenu: Featured/Random + Recent Posts"',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
            ),
          array(
            'value'       => 'featured',
            'label'       => 'Featured On Category Menu',
            'src'         => ''
            )
          ),
        ),
      array(
            'id'          => 'cb_featured_post',
            'label'       => 'Valenti Blog Style Homepage Grid Feature',
            'desc'        => 'Featured on grid of a blogstyle homepage',
            'std'         => '',
            'type'        => 'select',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => '',
            'choices'     => array(
              array(
                'value'       => 'off',
                'label'       => 'Off',
                'src'         => ''
              ),
              array(
                'value'       => 'featured',
                'label'       => 'Featured On Grid',
                'src'         => ''
              )
            ),
      ),
      array(
        'id'          => 'cb_featured_cat_post',
        'label'       => 'Valenti Category Feature',
        'desc'        => 'Featured on category page (If Grid/slider enabled)',
        'std'         => '',
        'type'        => 'select',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array(
          array(
            'value'       => 'off',
            'label'       => 'Off',
            'src'         => ''
            ),
          array(
            'value'       => 'featured',
            'label'       => 'Featured On Feature Grid/slider',
            'src'         => ''
            )
          ),
        ),
array(
      'label'       =>  'Layout Options',
      'id'          => 'cb_tab_si',
      'type'        => 'tab'
  ),
array(
    'id'          => '_cb_dropcap',
    'label'       => 'Dropcap',
    'desc'        => 'Make first letter of the article be a dropcap.',
    'std'         => 'off',
    'type'        => 'on-off',
    'rows'        => '',
    'post_type'   => '',
    'class'       => '',
    'condition'   => '',
),
array(
    'id'          => '_cb_first_dropcap',
    'label'       => 'Dropcap Size',
    'desc'        => 'Choose between normal and large dropcap sizes. Standard dropcap = 3 times bigger than the text. Large dropcap = 6 times bigger than the text.',
    'std'         => 'off',
    'type'        => 'select',
    'rows'        => '',
    'post_type'   => '',
    'class'       => 'cb-sub',
    'condition'   => '_cb_dropcap:is(on)',
    'choices'     => array(
    array(
      'value'       => 'cb_dropcap_s',
      'label'       => 'Standard Dropcap',
      ),
    array(
      'value'       => 'cb_dropcap_l',
      'label'       => 'Large Dropcap',
      ),
    ),
),
array(

  'id'          => 'cb_full_width_post',
  'label'       => 'Post Style',
  'desc'        => '',
  'std'         => 'sidebar',
  'type'        => 'radio-image',
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
    array(
      'value'       => 'nosidebar-narrow',
      'label'       => 'No Sidebar Narrow',
      'src'         => '/post_nosidebar_narrow.png'
      ),
    ),
  ),
array(
            'id'          => 'cb_post_sidebar',
            'label'       => 'Use default Sidebar',
            'desc'        => 'If the post\'s category has a custom sidebar, this post will use that, if not it will use the global sidebar. Set to Off to select specific sidebar.',
            'std'         => 'on',
            'type'        => 'on-off',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub',
            'condition'   => 'cb_full_width_post:not(nosidebar),cb_full_width_post:not(nosidebar-narrow)',
            'operator'    => 'and'
        ),
        array(
            'id'          => 'cb_post_custom_sidebar_type',
            'label'       => 'What Sidebar To Use',
            'desc'        => 'Choose what Sidebar To Use: New or existing.',
            'std'         => '',
            'type'        => 'select',
            'section'     => 'option_types',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => 'cb-sub-sub',
            'condition'   => 'cb_full_width_post:not(nosidebar),cb_post_sidebar:is(off),cb_full_width_post:not(nosidebar-narrow)',
            'operator'    => 'and',
            'choices'     => array(
              array(
                'value'       => 'cb_unique_sidebar',
                'label'       => 'New sidebar in Appearance -> Widgets',
                'src'         => ''
                ),
              array(
                'value'       => 'cb_existing',
                'label'       => 'Use existing sidebar',
                'src'         => ''
                ),
              ),
        ),
      array(
        'id'          => 'cb_sidebar_select',
        'label'       => __( 'Sidebar Select', 'cubell_admin' ),
        'desc'        => 'Use a sidebar that already exists.',
        'std'         => '',
        'type'        => 'sidebar-select',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'cb-sub-sub',
        'condition'   => 'cb_full_width_post:not(nosidebar),cb_post_sidebar:is(off),cb_full_width_post:not(nosidebar-narrow),cb_post_custom_sidebar_type:is(cb_existing)',
        'operator'    => 'and'
      ),

)
);

if ( function_exists( 'ot_register_meta_box' ) ) {
  ot_register_meta_box( $cb_go );
}

$cb_hpb = array(
  'id'          => 'cb_hpb',
  'title'       => 'Valenti Drag & Drop Builder',
  'desc'        => '',
  'pages'       => array( 'page' ),
  'context'     => 'normal',
  'priority'    => 'high',
  'fields'      => array(
    array(
      'id'          => 'cb_section_a',
      'label'       => 'Section A (Full-Width)',
      'desc'        => '',
      'std'         => '',
      'type'        => 'list-item',
      'section'     => 'cb_homepage',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => '',
      'settings'    => array(
        array(
          'id'          => 'cb_a_module_style',
          'label'       => 'Module Block',
          'desc'        => '',
          'std'         => 'm-aa',
          'type'        => 'radio-image',
          'rows'        => '',
          'post_type'   => '',
          'taxonomy'    => '',
          'class'       => '',
          'choices'     => array(
            array(
              'value'       => 'm-aa',
              'label'       => 'Module A',
              'src'         => '/module_a_fw.png'
              ),
            array(
              'value'       => 'grid-4a',
              'label'       => 'Grid 4',
              'src'         => '/grid_4.png'
              ),
            array(
              'value'       => 'grid-5a',
              'label'       => 'Grid 5',
              'src'         => '/grid_5.png'
              ),
            array(
              'value'       => 'grid-5-fa',
              'label'       => 'Grid 5',
              'src'         => '/grid_5_f.png'
              ),
            array(
              'value'       => 'grid-6a',
              'label'       => 'Grid 6',
              'src'         => '/grid_6.png'
              ),
            array(
              'value'       => 's-1a',
              'label'       => 'Slider A',
              'src'         => '/module_slider_a_fw.png'
              ),
            array(
              'value'       => 's-2a',
              'label'       => 'Slider B',
              'src'         => '/module_slider_b_fw.png'
              ),
            array(
              'value'       => 'ad-970a',
              'label'       => 'Ad: 970x90',
              'src'         => '/adc.png'
              ),
            array(
              'value'       => 'customa',
              'label'       => 'Custom Code',
              'src'         => '/custom.png'
              )
            ),
),
array(
  'id'          => 'cb_subtitle_a',
  'label'       => 'Optional Subtitle',
  'desc'        => '',
  'std'         => '',
  'type'        => 'text',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(ad-970a)',
  ),
array(
  'id'          => 'cb_filter',
  'label'       => 'Post selection',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  'choices'     => array(
    array(
      'value'       => 'cb_filter_category',
      'label'       => 'By Category',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_tags',
      'label'       => 'By Tags',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_postid',
      'label'       => 'By Post Names',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_ctax',
      'label'       => 'By Custom Taxonomy',
      'src'         => ''
      ),
    ),
  ),
array(
  'label'       => 'Category Filter',
  'id'          => 'cb_a_latest_posts',
  'type'        => 'category-checkbox',
  'desc'        => '',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_filter:is(cb_filter_category),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  'class'       => '',
  ),
array(
  'label'       => 'Tag Filter',
  'id'          => 'tags_cb',
  'type'        => 'text',
  'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_filter:is(cb_filter_tags),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  ),
array(
  'label'       => 'Posts Filter',
  'id'          => 'ids_posts_cb',
  'type'        => 'text',
  'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => 'cb-aj-input',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_filter:is(cb_filter_postid),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  ),
array(
  'id'          => 'cb_tax_list',
  'label'       => 'Custom Taxonomies',
  'desc'        => 'Select the desired custom taxonomy and then choose the custom taxonomy term/s in the option below to show posts from',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a),cb_filter:is(cb_filter_ctax)',
  'choices'     => $cb_tax_list_choices,
  ),
  $cb_tax_str_output_1, $cb_tax_str_output_2, $cb_tax_str_output_3,
array(
  'id'          => 'cb_order',
  'label'       => 'Post Order',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  'class'       => '',
  'choices'     => array(
    array(
      'value'       => 'cb_latest',
      'label'       => 'Latest Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_random',
      'label'       => 'Random Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_oldest',
      'label'       => 'Oldest Posts',
      'src'         => ''
      ),
    ),
  ),
array(
  'id'          => 'cb_style_a',
  'label'       => 'Style',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  'choices'     => array(
    array(
      'value'       => 'cb_light_a',
      'label'       => 'Light',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_dark_a',
      'label'       => 'Dark',
      'src'         => ''
      )
    ),
  ),
array(
  'id'          => 'cb_ad_code_a',
  'label'       => 'Ad Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'condition'   => 'cb_a_module_style:is(ad-970a)',
  'taxonomy'    => '',
  'class'       => ''
  ),
array(
  'id'          => 'cb_slider_a',
  'label'       => 'Number Of Posts To Show',
  'desc'        => '',
  'std'         => '3',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '3,12,3',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(grid-4a),cb_a_module_style:not(grid-5a),cb_a_module_style:not(grid-6a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  ),
array(
  'id'          => 'cb_offset',
  'label'       => 'Posts Offset (optional)',
  'desc'        => '',
  'std'         => '0',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '0,50,1',
  'class'       => '',
  'condition'   => 'cb_a_module_style:not(customa),cb_a_module_style:not(ad-970a),cb_a_module_style:not(cl-1a),cb_a_module_style:not(cl-3a),cb_a_module_style:not(cl-2a)',
  ),
array(
  'id'          => 'cb_custom_a',
  'label'       => 'Custom Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_a_module_style:is(customa)',
  ),
)
),
array(
  'id'          => 'cb_section_b',
  'label'       => 'Section B + "Section B Sidebar (In Appearance -> Widgets)"',
  'desc'        => '',
  'std'         => '',
  'type'        => 'list-item',
  'section'     => 'cb_homepage',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'settings'    => array(
    array(
      'id'          => 'cb_b_module_style',
      'label'       => 'Module Block',
      'desc'        => '',
      'std'         => 'm-ab',
      'type'        => 'radio-image',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => '',
      'choices'     => array(
        array(
          'value'       => 'm-ab',
          'label'       => 'Module A',
          'src'         => '/module_a.png'
          ),
        array(
          'value'       => 'm-bb',
          'label'       => 'Module B',
          'src'         => '/module_b.png'
          ),
        array(
          'value'       => 'm-cb',
          'label'       => 'Module C',
          'src'         => '/module_c.png'
          ),
        array(
          'value'       => 'm-db',
          'label'       => 'Module D',
          'src'         => '/module_d.png'
          ),
        array(
          'value'       => 'm-eb',
          'label'       => 'Module E',
          'src'         => '/module_e.png'
          ),
        array(
          'value'       => 'm-fb',
          'label'       => 'Module F',
          'src'         => '/module_f.png'
          ),
        array(
          'value'       => 'm-gb',
          'label'       => 'Module G',
          'src'         => '/module_g.png'
          ),
        array(
          'value'       => 'grid-3b',
          'label'       => 'Grid 3',
          'src'         => '/grid_3.png'
          ),
        array(
          'value'       => 'ad-728b',
          'label'       => 'Ad: 728x90',
          'src'         => '/adb.png'
          ),
        array(
          'value'       => 'ad-336b',
          'label'       => 'Ad: 336x280',
          'src'         => '/add.png'
          ),
        array(
          'value'       => 's-1b',
          'label'       => 'Slider A',
          'src'         => '/module_slider_a.png'
          ),
        array(
          'value'       => 's-2b',
          'label'       => 'Slider B',
          'src'         => '/module_slider_b.png'
          ),
        array(
          'value'       => 'customb',
          'label'       => 'Custom Code',
          'src'         => '/custom.png'
          ),
        array(
          'value'       => 'h-customb',
          'label'       => 'Custom Code 50% Width',
          'src'         => '/custom_half.png'
          )
        ),
),
array(
  'id'          => 'cb_subtitle_b',
  'label'       => 'Optional Subtitle',
  'desc'        => '',
  'std'         => '',
  'type'        => 'text',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(ad-728b),cb_b_module_style:not(ad-336b)',
  ),
array(
  'id'          => 'cb_filter',
  'label'       => 'Post selection',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(h-customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  'choices'     => array(
    array(
      'value'       => 'cb_filter_category',
      'label'       => 'By Category',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_tags',
      'label'       => 'By Tags',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_postid',
      'label'       => 'By Post Names',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_ctax',
      'label'       => 'By Custom Taxonomy',
      'src'         => ''
      ),
    ),
  ),
array(
  'label'       => 'Category Filter',
  'id'          => 'cb_b_latest_posts',
  'type'        => 'category-checkbox',
  'desc'        => '',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(h-customb),cb_b_module_style:not(customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_filter:is(cb_filter_category)',
  ),
array(
  'label'       => 'Tag Filter',
  'id'          => 'tags_cb',
  'type'        => 'text',
  'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(h-customb),cb_b_module_style:not(customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_filter:is(cb_filter_tags)',
  ),
array(
  'label'       => 'Posts Filter',
  'id'          => 'ids_posts_cb',
  'type'        => 'text',
  'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => 'cb-aj-input',
  'condition'   => 'cb_b_module_style:not(h-customb),cb_b_module_style:not(customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_filter:is(cb_filter_postid)',
  ),
array(
  'id'          => 'cb_tax_list',
  'label'       => 'Custom Taxonomies',
  'desc'        => 'Select the desired custom taxonomy and then choose the custom taxonomy term/s in the option below to show posts from',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(h-customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b),cb_b_module_style:not(cl-1b),cb_b_module_style:not(cl-3b),cb_b_module_style:not(cl-2b),cb_filter:is(cb_filter_ctax)',
  'choices'     => $cb_tax_list_choices,
  ),
  $cb_tax_str_output_1, $cb_tax_str_output_2, $cb_tax_str_output_3,
array(
  'id'          => 'cb_order',
  'label'       => 'Post Order',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(h-customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  'choices'     => array(
    array(
      'value'       => 'cb_latest',
      'label'       => 'Latest Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_random',
      'label'       => 'Random Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_oldest',
      'label'       => 'Oldest Posts',
      'src'         => ''
      ),
    ),
  ),
array(
  'id'          => 'cb_style_b',
  'label'       => 'Style',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(h-customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  'class'       => '',
  'choices'     => array(
    array(
      'value'       => 'cb_light_b',
      'label'       => 'Light',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_dark_b',
      'label'       => 'Dark',
      'src'         => ''
      )
    ),
  ),

array(
  'id'          => 'cb_ad_code_b',
  'label'       => 'Ad Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'operator'    => 'OR',
  'condition'   => 'cb_b_module_style:is(ad-336b),cb_b_module_style:is(ad-728b)',
  ),
array(
  'id'          => 'cb_slider_b',
  'label'       => 'Number Of Posts To Show',
  'desc'        => '',
  'std'         => '2',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '2,12,1',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(grid-3b),cb_b_module_style:not(h-customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  ),
array(
  'id'          => 'cb_offset',
  'label'       => 'Posts Offset (optional)',
  'desc'        => '',
  'std'         => '0',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '0,50,1',
  'class'       => '',
  'condition'   => 'cb_b_module_style:not(customb),cb_b_module_style:not(h-customb),cb_b_module_style:not(ad-336b),cb_b_module_style:not(ad-728b)',
  ),
array(
  'id'          => 'cb_custom_b',
  'label'       => 'Custom Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'operator'    => 'OR',
  'condition'   => 'cb_b_module_style:is(customb),cb_b_module_style:is(h-customb)',
  ),
)
),
array(
  'id'          => 'cb_section_c',
  'label'       => 'Section C (Full-Width)',
  'desc'        => '',
  'std'         => '',
  'type'        => 'list-item',
  'section'     => 'cb_homepage',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'settings'    => array(
    array(
      'id'          => 'cb_c_module_style',
      'label'       => 'Module Block',
      'desc'        => '',
      'std'         => 'm-ac',
      'type'        => 'radio-image',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => '',
      'choices'     => array(
        array(
          'value'       => 'm-ac',
          'label'       => 'Module A',
          'src'         => '/module_a_fw.png'
          ),
        array(
          'value'       => 'grid-4c',
          'label'       => 'Grid 4',
          'src'         => '/grid_4.png'
          ),
        array(
          'value'       => 'grid-5c',
          'label'       => 'Grid 5',
          'src'         => '/grid_5.png'
          ),
        array(
          'value'       => 'grid-5-fc',
          'label'       => 'Grid 5',
          'src'         => '/grid_5_f.png'
          ),
        array(
          'value'       => 'grid-6c',
          'label'       => 'Grid 6',
          'src'         => '/grid_6.png'
          ),
        array(
          'value'       => 's-1c',
          'label'       => 'Slider A',
          'src'         => '/module_slider_a_fw.png'
          ),
        array(
          'value'       => 's-2c',
          'label'       => 'Slider B',
          'src'         => '/module_slider_b_fw.png'
          ),
        array(
          'value'       => 'ad-970c',
          'label'       => 'Ad: 970x90',
          'src'         => '/adc.png'
          ),
        array(
          'value'       => 'customc',
          'label'       => 'Custom Code',
          'src'         => '/custom.png'
          )
        ),
),
array(
  'id'          => 'cb_subtitle_c',
  'label'       => 'Optional Subtitle',
  'desc'        => '',
  'std'         => '',
  'type'        => 'text',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(ad-970c)',
  ),
array(
  'id'          => 'cb_filter',
  'label'       => 'Post selection',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  'choices'     => array(
    array(
      'value'       => 'cb_filter_category',
      'label'       => 'By Category',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_tags',
      'label'       => 'By Tags',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_postid',
      'label'       => 'By Post Names',
      'src'         => ''
      ),
     array(
      'value'       => 'cb_filter_ctax',
      'label'       => 'By Custom Taxonomy',
      'src'         => ''
      ),
    ),
  ),
array(
  'label'       => 'Category Filter',
  'id'          => 'cb_c_latest_posts',
  'type'        => 'category-checkbox',
  'desc'        => '',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_filter:is(cb_filter_category),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  ),
array(
  'label'       => 'Tag Filter',
  'id'          => 'tags_cb',
  'type'        => 'text',
  'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_filter:is(cb_filter_tags),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  ),
array(
  'label'       => 'Posts Filter',
  'id'          => 'ids_posts_cb',
  'type'        => 'text',
  'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => 'cb-aj-input',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_filter:is(cb_filter_postid),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  ),
array(
  'id'          => 'cb_tax_list',
  'label'       => 'Custom Taxonomies',
  'desc'        => 'Select the desired custom taxonomy and then choose the custom taxonomy term/s in the option below to show posts from',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-3c),cb_c_module_style:not(cl-2c),cb_filter:is(cb_filter_ctax)',
  'choices'     => $cb_tax_list_choices,
  ),
  $cb_tax_str_output_1, $cb_tax_str_output_2, $cb_tax_str_output_3,
array(
  'id'          => 'cb_order',
  'label'       => 'Post Order',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  'choices'     => array(
    array(
      'value'       => 'cb_latest',
      'label'       => 'Latest Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_random',
      'label'       => 'Random Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_oldest',
      'label'       => 'Oldest Posts',
      'src'         => ''
      ),
    ),
  ),
array(
  'id'          => 'cb_style_c',
  'label'       => 'Style',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  'choices'     => array(
    array(
      'value'       => 'cb_light_c',
      'label'       => 'Light',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_dark_c',
      'label'       => 'Dark',
      'src'         => ''
      )
    ),
  ),
array(
  'id'          => 'cb_ad_code_c',
  'label'       => 'Ad Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:is(ad-970c)',
  ),
array(
  'id'          => 'cb_slider_c',
  'label'       => 'Number Of Posts To Show',
  'desc'        => '',
  'std'         => '3',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '3,12,3',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(grid-4c),cb_c_module_style:not(grid-5c),cb_c_module_style:not(grid-6c),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  ),
array(
  'id'          => 'cb_offset',
  'label'       => 'Posts Offset (optional)',
  'desc'        => '',
  'std'         => '0',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '0,50,1',
  'class'       => '',
  'condition'   => 'cb_c_module_style:not(customc),cb_c_module_style:not(ad-970c),cb_c_module_style:not(cl-1c),cb_c_module_style:not(cl-2c),cb_c_module_style:not(cl-3c)',
  ),
array(
  'id'          => 'cb_custom_c',
  'label'       => 'Custom Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_c_module_style:is(customc)',
  ),
)
),
array(
  'id'          => 'cb_section_d',
  'label'       => 'Section D + "Section D Sidebar (In Appearance -> Widgets)"',
  'desc'        => '',
  'std'         => '',
  'type'        => 'list-item',
  'section'     => 'cb_homepage',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'settings'    => array(
    array(
      'id'          => 'cb_d_module_style',
      'label'       => 'Module Block',
      'desc'        => '',
      'std'         => 'm-ad',
      'type'        => 'radio-image',
      'rows'        => '',
      'post_type'   => '',
      'taxonomy'    => '',
      'class'       => '',
      'choices'     => array(
        array(
          'value'       => 'm-ad',
          'label'       => 'Module A',
          'src'         => '/module_a.png'
          ),
        array(
          'value'       => 'm-bd',
          'label'       => 'Module B',
          'src'         => '/module_b.png'
          ),
        array(
          'value'       => 'm-cd',
          'label'       => 'Module C',
          'src'         => '/module_c.png'
          ),
        array(
          'value'       => 'm-dd',
          'label'       => 'Module D',
          'src'         => '/module_d.png'
          ),
        array(
          'value'       => 'm-ed',
          'label'       => 'Module E',
          'src'         => '/module_e.png'
          ),
        array(
          'value'       => 'm-fd',
          'label'       => 'Module F',
          'src'         => '/module_f.png'
          ),
        array(
          'value'       => 'm-gd',
          'label'       => 'Module G',
          'src'         => '/module_g.png'
          ),
        array(
          'value'       => 'grid-3d',
          'label'       => 'Grid 3',
          'src'         => '/grid_3.png'
          ),
        array(
          'value'       => 'ad-728d',
          'label'       => 'Ad: 728x90',
          'src'         => '/adb.png'
          ),
        array(
          'value'       => 'ad-336d',
          'label'       => 'Ad: 336x280',
          'src'         => '/add.png'
          ),
        array(
          'value'       => 's-1d',
          'label'       => 'Slider A',
          'src'         => '/module_slider_a.png'
          ),
        array(
          'value'       => 's-2d',
          'label'       => 'Slider B',
          'src'         => '/module_slider_b.png'
          ),
        array(
          'value'       => 'customd',
          'label'       => 'Custom Code',
          'src'         => '/custom.png'
          ),
        array(
          'value'       => 'h-customd',
          'label'       => 'Custom Code 50% Width',
          'src'         => '/custom_half.png'
          )
        ),
),
array(
  'id'          => 'cb_subtitle_d',
  'label'       => 'Optional Subtitle',
  'desc'        => '',
  'std'         => '',
  'type'        => 'text',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(ad-728d),cb_d_module_style:not(ad-336d)',
  ),
array(
  'id'          => 'cb_filter',
  'label'       => 'Post selection',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(customd),cb_d_module_style:not(h-customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d)',
  'choices'     => array(
    array(
      'value'       => 'cb_filter_category',
      'label'       => 'By Category',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_tags',
      'label'       => 'By Tags',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_filter_postid',
      'label'       => 'By Post Names',
      'src'         => ''
      ),
     array(
      'value'       => 'cb_filter_ctax',
      'label'       => 'By Custom Taxonomy',
      'src'         => ''
      ),
    ),
  ),
array(
  'label'       => 'Category Filter',
  'id'          => 'cb_d_latest_posts',
  'type'        => 'category-checkbox',
  'desc'        => '',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(h-customd),cb_d_module_style:not(customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d),cb_filter:is(cb_filter_category)',
  ),
array(
  'label'       => 'Tag Filter',
  'id'          => 'tags_cb',
  'type'        => 'text',
  'desc'        => 'Type the name of the tag to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
   'condition'   => 'cb_d_module_style:not(h-customd),cb_d_module_style:not(customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d),cb_filter:is(cb_filter_tags)',
  ),
array(
  'label'       => 'Posts Filter',
  'id'          => 'ids_posts_cb',
  'type'        => 'text',
  'desc'        => 'Type a word of the post title to search for it and then click it in the list to add it to the module.',
  'std'         => '',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => 'cb-aj-input',
  'condition'   => 'cb_d_module_style:not(h-customd),cb_d_module_style:not(customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d),cb_filter:is(cb_filter_postid)',
  ),
array(
  'id'          => 'cb_tax_list',
  'label'       => 'Custom Taxonomies',
  'desc'        => 'Select the desired custom taxonomy and then choose the custom taxonomy term/s in the option below to show posts from',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(customb),cb_d_module_style:not(h-customb),cb_d_module_style:not(ad-336b),cb_d_module_style:not(ad-728b),cb_d_module_style:not(cl-1b),cb_d_module_style:not(cl-3b),cb_d_module_style:not(cl-2b),cb_filter:is(cb_filter_ctax)',
  'choices'     => $cb_tax_list_choices,
  ),
  $cb_tax_str_output_1, $cb_tax_str_output_2, $cb_tax_str_output_3,
array(
  'id'          => 'cb_order',
  'label'       => 'Post Order',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(customd),cb_d_module_style:not(h-customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d)',
  'choices'     => array(
    array(
      'value'       => 'cb_latest',
      'label'       => 'Latest Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_random',
      'label'       => 'Random Posts',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_oldest',
      'label'       => 'Oldest Posts',
      'src'         => ''
      ),
    ),
  ),
array(
  'id'          => 'cb_style_d',
  'label'       => 'Style',
  'desc'        => '',
  'std'         => '',
  'type'        => 'select',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(customd),cb_d_module_style:not(h-customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d)',
  'choices'     => array(
    array(
      'value'       => 'cb_light_d',
      'label'       => 'Light',
      'src'         => ''
      ),
    array(
      'value'       => 'cb_dark_d',
      'label'       => 'Dark',
      'src'         => ''
      )
    ),
  ),
array(
  'id'          => 'cb_ad_code_d',
  'label'       => 'Ad Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'operator'    => 'OR',
  'condition'   => 'cb_d_module_style:is(ad-336d),cb_d_module_style:is(ad-728d)',
  ),
array(
  'id'          => 'cb_slider_d',
  'label'       => 'Number Of Posts To Show',
  'desc'        => '',
  'std'         => '2',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '2,12,1',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(customd),cb_d_module_style:not(grid-3d),cb_d_module_style:not(h-customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d)',
  ),
array(
  'id'          => 'cb_offset',
  'label'       => 'Posts Offset (optional)',
  'desc'        => '',
  'std'         => '0',
  'type'        => 'numeric-slider',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'min_max_step'=> '0,50,1',
  'class'       => '',
  'condition'   => 'cb_d_module_style:not(customd),cb_d_module_style:not(h-customd),cb_d_module_style:not(ad-336d),cb_d_module_style:not(ad-728d)',
  ),
array(
  'id'          => 'cb_custom_d',
  'label'       => 'Custom Code',
  'desc'        => '',
  'std'         => '',
  'type'        => 'textarea',
  'rows'        => '',
  'post_type'   => '',
  'taxonomy'    => '',
  'class'       => '',
  'operator'    => 'OR',
  'condition'   => 'cb_d_module_style:is(customd),cb_d_module_style:is(h-customd)',
  ),
)
),
array(
    'id'          => 'cb_pb_onoff',
    'label'       => 'Section With Latest Global Posts + Pagination',
    'desc'        => '',
    'std'         => 'off',
    'type'        => 'on-off',
    'rows'        => '',
    'post_type'   => '',
    'taxonomy'    => '',
    'min_max_step'=> '',
    'class'       => '',
),
array(
    'id'          => 'cb_pb_append',
    'label'       => 'Where to add paginatined block',
    'desc'        => '',
    'std'         => '',
    'type'        => 'select',
    'rows'        => '',
    'post_type'   => '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub',
    'choices'     => array(
          array(
            'value'       => 'style-a',
            'label'       => 'End of Section A',
            'src'         => ''
            ),
          array(
            'value'       => 'style-b',
            'label'       => 'End of Section B',
            'src'         => ''
            ),
          array(
            'value'       => 'style-c',
            'label'       => 'End of Section C',
            'src'         => ''
            ),
          array(
            'value'       => 'style-d',
            'label'       => 'End of Section D',
            'src'         => ''
            ),
          ),
    ),
array(
    'id'          => 'cb_pb_bs',
    'label'       => 'Blog Style',
    'desc'        => '',
    'std'         => 'style-a',
    'type'        => 'radio-image',
    'section'     => 'ot_homepage',
    'rows'        => '',
    'post_type'   => '',
    'taxonomy'    => '',
    'min_max_step'=> '',
    'condition'   => 'cb_pb_onoff:is(on),cb_pb_append:not(style-a),cb_pb_append:not(style-c)',
    'operator'    => 'and',
    'class'       => 'cb-sub-sub',
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
    'id'          => 'cb_pb_title',
    'label'       => 'Optional Title',
    'desc'        => '',
    'std'         => '',
    'type'        => 'text',
    'rows'        => '',
    'post_type'   => '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub'
    ),
    array(
    'id'          => 'cb_pb_subtitle',
    'label'       => 'Optional Subtitle',
    'desc'        => '',
    'std'         => '',
    'type'        => 'text',
    'rows'        => '',
    'post_type'   => '',
    'condition'   => 'cb_pb_onoff:is(on)',
    'class'       => 'cb-sub'
    ),


)
);
if ( function_exists( 'ot_register_meta_box' ) ) {
  ot_register_meta_box( $cb_hpb );
}

}
add_action( 'admin_init', '_cb_meta' );