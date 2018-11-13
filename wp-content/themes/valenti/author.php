<?php
		get_header();
        if ( $post == NULL ) {
            $cb_author_id = $author;
        } else {
            $cb_author_id = get_the_author_meta( 'ID' );
        }

        $cb_author_name = get_the_author_meta( 'display_name', $cb_author_id );
        $cb_theme_style = ot_get_option( 'cb_theme_style', 'cb_boxed' );
?>
<div class="cb-cat-header<?php if ( $cb_theme_style == 'cb_boxed' ) echo ' wrap'; ?>">
    <h1 id="cb-cat-title"><span><?php echo __( 'Author', 'cubell' ) . ' <i class="fa fa-long-arrow-right"></i></span> ' . $cb_author_name; ?></h1>
</div>

<div id="cb-content" class="cb-author-page wrap clearfix">
    <?php if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) { echo '<div class="cb-sticky-sidebar"><div class="cb-sidebar">'; } ?>
    <?php echo cb_author_details( $cb_author_id ); ?>
    <?php if ( ot_get_option('cb_sticky_sb', 'off') == 'on' ) { echo '</div></div>'; } ?>
    <div id="main" class="cb-main clearfix cb-module-block cb-blog-style-roll" role="main">

        <?php get_template_part( 'cat', 'style-a' ); ?>

	</div> <!-- end #main -->

</div> <!-- end #cb-content -->

<?php get_footer(); ?>