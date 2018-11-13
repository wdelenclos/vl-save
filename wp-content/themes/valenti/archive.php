<?php
            get_header();
            $cb_global_color = ot_get_option('cb_base_color', '#eb9812');
            $cb_theme_style = ot_get_option('cb_theme_style', 'cb_boxed');
            $cb_blog_style = cb_get_blog_style();
?>

<div class="cb-cat-header<?php if ($cb_theme_style == 'cb_boxed') echo ' wrap'; ?>" style="border-bottom-color:<?php echo $cb_global_color; ?>;">
     <?php if (is_day()) { ?>
            <h1 id="cb-cat-title">
                <span><?php _e("Daily Archives", "cubell"); ?> <i class="fa fa-long-arrow-right"></i></span> <?php the_time(get_option('date_format')); ?>
            </h1>

        <?php } elseif (is_month()) { ?>
            <h1 id="cb-cat-title">
                <span><?php _e("Monthly Archives", "cubell"); ?> <i class="fa fa-long-arrow-right"></i></span> <?php the_time(get_option('date_format')); ?>
            </h1>

        <?php } elseif (is_year()) { ?>
            <h1 id="cb-cat-title">
                <span><?php _e("Yearly Archives", "cubell"); ?> <i class="fa fa-long-arrow-right"></i></span> <?php the_time(get_option('date_format')); ?>
            </h1>

        <?php } elseif (is_tax()) { ?>
        <?php $cb_tax =  get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );  ?>
            <h1 id="cb-cat-title">
                <?php echo $cb_tax->name; ?>
            </h1>
            <?php echo tag_description( $cb_tax->term_id ); ?>
        <?php } ?>

</div>

<div id="cb-content" class="wrap clearfix">

    <div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">

        <?php if ( have_posts() ) {
            get_template_part('cat', $cb_blog_style);
        } ?>

	</div> <!-- end #main -->

	<?php if ( $cb_blog_style != 'style-c' ) { get_sidebar(); } ?>

</div> <!-- end #cb-content -->

<?php get_footer(); ?>