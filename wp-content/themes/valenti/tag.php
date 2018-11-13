<?php
    get_header();
    $cb_cats = get_the_category();
    $cb_tag_id = get_query_var('tag_id');
    $cb_cat_id = $cb_tag_id;
    $cb_blog_style = cb_get_blog_style();
    $cb_tax_id = $cb_taxonomy = $cb_tax_qry = NULL; 

    if ( function_exists('get_tax_meta') ) {

        $cb_category_color_style = get_tax_meta($cb_tag_id, 'cb_cat_style_color');
        $cb_featured_option = get_tax_meta($cb_tag_id, 'cb_cat_featured_op');
        $cb_category_ad = get_tax_meta_strip($cb_tag_id, 'cb_cat_ad');
        $cb_category_color = get_tax_meta($cb_tag_id, 'cb_color_field_id');

    } else {
        $cb_category_color = $cb_category_ad = NULL;
        $cb_featured_option = 'Off';
    }

    $cb_cat_desc = category_description( $cb_tag_id );
    $cb_global_color = ot_get_option('cb_base_color', '#eb9812');

    if (($cb_category_color == NULL) || ($cb_category_color == '#')) {
         $cb_category_color = $cb_global_color;
    }
?>

<div id="cb-content" class="wrap clearfix">

    <div class="cb-cat-header cb-tag-header" style="border-bottom-color:<?php echo $cb_category_color;?>;">
           <h1 id="cb-search-title"><?php _e('Tagged', 'cubell'); ?> <span style="color:<?php echo $cb_category_color; ?>"><?php single_tag_title(); ?></span></h1>
           <?php echo tag_description( $cb_tag_id ); ?>
    </div>

    <?php 

        if ( ( $cb_featured_option != 'Off' ) && ( $cb_featured_option != NULL ) && ( $cb_featured_option != 'slider' )  && ( $cb_featured_option != 's-1' ) ) {

            $cb_flipped = NULL;
            $j = 0;
            $cb_section = 'a';
            include( locate_template( 'library/modules/cb-'.$cb_featured_option.'.php' ) );

        }  

        echo cb_breadcrumbs();

        if ( ( $cb_featured_option != 'Off' ) && ( $cb_featured_option != NULL ) && ( $cb_featured_option == 's-1' ) ) {

            $cb_flipped = NULL;
            $j = 0;
            $cb_section = 'a';
            include( locate_template( 'library/modules/cb-'.$cb_featured_option.'.php' ) );

        }  
    ?>
    
    <div class="clearfix">

        <div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">

            <?php

                if ( $cb_category_ad != NULL ) {
                    echo '<div class="cb-category-top">' . do_shortcode( $cb_category_ad ) . '</div>';
                }

                if ( $cb_featured_option == 'slider' ) {
                    $cb_section = $cb_title = $cb_module_style = $j = NULL;
                    include( locate_template( 'library/modules/cb-s-2.php' ) );
                }

                include( locate_template( 'cat-' . $cb_blog_style . '.php') );

            ?>

        </div> <!-- /main -->

        <?php if ( $cb_blog_style != 'style-c' ) { get_sidebar(); } ?>
    </div> 

</div> <!-- end /#cb-content -->

<?php get_footer(); ?>