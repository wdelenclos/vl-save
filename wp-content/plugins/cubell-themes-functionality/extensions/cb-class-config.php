<?php
if ( is_admin() ){
  $prefix = 'cb_';

  $config = array(
    'id' => 'cb_cat_meta',          // meta box id, unique per meta box
    'title' => 'Category Extra Meta',          // meta box title
    'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );

  $cb_cat_meta =  new Tax_Meta_Class($config);
  $cb_cat_meta->addSelect($prefix.'cat_style_field_id',array('style-a'=>'Blog Style A','style-b'=>'Blog Style B','style-c'=>'Blog Style C','style-d'=>'Blog Style D','style-e'=>'Blog Style E','style-f'=>'Blog Style F (A+D)','style-g'=>'Blog Style G (B+D)'),array('name'=> __('Blog Style ','tax-meta'), 'std'=> array('style-a')));
  $cb_cat_meta->addSelect($prefix.'cat_style_color',array('cb-light-blog'=>'Light','cb-dark-blog'=>'Dark'),array('name'=> __('Blog Style Posts Skin ','tax-meta'), 'std'=> array('cb-light-blog')));
  $cb_cat_meta->addSelect($prefix.'cat_infinite',array('cb-off'=>'Off','infinite-scroll'=>'Infinite Scroll','infinite-load'=>'Infinite Scroll With Load More Button'),array('name'=> __('Infinite Scroll','tax-meta'), 'std'=> array('cb-light-blog')));
  $cb_cat_meta->addColor($prefix.'color_field_id',array('name'=> __('Category Global Color','tax-meta'), 'desc'=> 'This color is used on category hovers, main navigation megamenu, widget underlines, review boxes, etc.'));
  $cb_cat_meta->addImage( $prefix . 'cat_header_bg',array('name'=> __('Category Title Background Image ','tax-meta')));
  $cb_cat_meta->addSelect($prefix.'cat_header_title',array('cb-cat-t-dark'=>'Dark Text', 'cb-cat-t-light'=>'Light Text'),array('name'=> __('Category Header Text Colors','tax-meta'), 'desc' => 'If your Title Background image is dark, choose the light text option to make the category title and description light.', 'std'=> array('cb-cat-t-dark')));

  $cb_cat_meta->addSelect($prefix.'cat_featured_op',array('Off' => 'Off', 'full-slider'=>'Full-width Slider', 'slider'=>'Slider', 's-1'=>'Slider of 4 posts', 'grid-4'=>'Grid - 4', 'grid-5'=>'Grid - 5','grid-6'=>'Grid - 6'),array('name'=> __('Show grid/slider ','tax-meta'), 'std'=> array('Off'), 'desc'=> 'Show a grid or slider of posts above the blog style posts list on the category page.'));
  $cb_cat_meta->addSelect($prefix.'cat_offset',array('on'=>'On', 'off'=>'Off'),array('name'=> __('Offset Posts ','tax-meta'), 'std'=> array('on'),  'desc'=> 'This option means the grid will show posts #1 -> 5 (if grid of 5), and the posts list below will start showing from post #6 -> onwards. This is to avoid duplicates, but only works if your grid shows the latest posts (not when you feature posts to override the grid).'));
  $cb_cat_meta->addSelect($prefix.'cat_sidebar',array('off'=>'Off','on'=>'On'),array('name'=> __('Custom Sidebar ','tax-meta'), 'std'=> array('off'), 'desc'=> 'This option allows you to use a unique sidebar for this category, when enabled, you will find a new sidebar area with the category name in Appearance -> Widgets.' ));
  $cb_cat_meta->addImage($prefix.'bg_image_field_id',array('name'=> __('Category Background Image ','tax-meta')));
  $cb_cat_meta->addSelect($prefix.'bg_image_setting_op',array('1' => 'Full-Width Stretch', '2'=>'Repeat', '3'=>'No-Repeat'),array('name'=> __('Background Image Settings','tax-meta'), 'std'=> array('1')));
  $cb_cat_meta->addColor($prefix.'bg_color_field_id',array('name'=> __('Category Background Color','tax-meta')));
  $cb_cat_meta->addWysiwyg($prefix.'cat_ad',array('name'=> __('Category Ad','tax-meta')));
  $cb_cat_meta->Finish();

  $config = array(
    'id' => 'cb_tag_meta',          // meta box id, unique per meta box
    'title' => 'Tags Extra Meta',          // meta box title
    'pages' => array('post_tag'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );

   $cb_tag_meta =  new Tax_Meta_Class($config);
  $cb_tag_meta->addSelect($prefix.'cat_style_field_id',array('style-a'=>'Blog Style A','style-b'=>'Blog Style B','style-c'=>'Blog Style C','style-d'=>'Blog Style D','style-e'=>'Blog Style E','style-f'=>'Blog Style F (A+D)','style-g'=>'Blog Style G (B+D)'),array('name'=> __('Blog Style ','tax-meta'), 'std'=> array('style-a')));
  $cb_tag_meta->addSelect($prefix.'cat_style_color',array('cb-light-blog'=>'Light','cb-dark-blog'=>'Dark'),array('name'=> __('Blog Style Colors ','tax-meta'), 'std'=> array('cb-light-blog')));
  $cb_tag_meta->addSelect($prefix.'cat_infinite',array('cb-off'=>'Off','infinite-scroll'=>'Infinite Scroll','infinite-load'=>'Infinite Scroll With Load More Button'),array('name'=> __('Infinite Scroll','tax-meta'), 'std'=> array('cb-light-blog')));
  //$cb_tag_meta->addColor($prefix.'color_field_id',array('name'=> __('Tag Global Color','tax-meta'), 'desc'=> 'This color is used on tag hovers, main navigation megamenu, widget underlines, review boxes, etc.'));
  $cb_tag_meta->addSelect($prefix.'cat_featured_op',array('Off' => 'Off', 'full-slider'=>'Full-width Slider', 'slider'=>'Slider', 's-1'=>'Slider of 4 posts', 'grid-4'=>'Grid - 4', 'grid-5'=>'Grid - 5','grid-6'=>'Grid - 6'),array('name'=> __('Show grid/slider ','tax-meta'), 'std'=> array('Off'), 'desc'=> 'Show a grid or slider of posts above the blog style posts list on the tag page.'));
  $cb_tag_meta->addSelect($prefix.'cat_offset',array('on'=>'On', 'off'=>'Off'),array('name'=> __('Offset Posts ','tax-meta'), 'std'=> array('on'),  'desc'=> 'This option means the grid will show posts #1 -> 5 (if grid of 5), and the posts list below will start showing from post #6 -> onwards. This is to avoid duplicates, but only works if your grid shows the latest posts (not when you feature posts to override the grid).'));
  $cb_tag_meta->addImage($prefix.'bg_image_field_id',array('name'=> __('Tag Background Image ','tax-meta')));
  $cb_tag_meta->addSelect($prefix.'bg_image_setting_op',array('1' => 'Full-Width Stretch', '2'=>'Repeat', '3'=>'No-Repeat'),array('name'=> __('Background Image Settings','tax-meta'), 'std'=> array('1')));
  $cb_tag_meta->addColor($prefix.'bg_color_field_id',array('name'=> __('Tag Background Color','tax-meta')));
  $cb_tag_meta->addWysiwyg($prefix.'cat_ad',array('name'=> __('Tag Ad','tax-meta')));
  $cb_tag_meta->Finish();

}