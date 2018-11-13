<?php /* Category/Blog Style C */

    $i = 0;
    $cb_count = 1;
    $cb_qry = cb_get_qry();

    if ( $cb_qry->have_posts() ) : while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

        global $post;
        $cb_post_id = $post->ID;
        if ( $cb_count == 4 ) { $cb_count = 1; }
        $cb_category_color = cb_get_cat_color( $cb_post_id );  

?>

<article id="post-<?php the_ID(); ?>"  <?php post_class("cb-blog-style-c cb-blog-style cb-color-hover cb-article-row-3 cb-article-row cb-separated clearfix cb-no-$cb_count" ); ?> role="article">

    <div class="cb-mask" style="background-color:<?php echo $cb_category_color;?>;">
        <?php
        cb_thumbnail('360', '240');
        echo cb_review_ext_box($cb_post_id, $cb_category_color);
        ?>
    </div>

    <div class="cb-meta">
        <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php echo cb_byline(); ?>
        <div class="cb-excerpt"><?php echo cb_clean_excerpt(150, false); ?></div>
    </div>

</article>

<?php
    $cb_count++;
    endwhile;
    cb_page_navi( $cb_qry );
    endif;
    wp_reset_postdata();
?>