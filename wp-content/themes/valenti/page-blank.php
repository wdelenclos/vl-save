<?php /* Template Name: Valenti Blank */

get_header(); 
?>

<div id="cb-content" class="wrap clearfix">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div id="main" class="cb-main entry-content clearfix" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
		    
			<section class="entry-content clearfix" itemprop="articleBody">
				<?php the_content(); ?>
	     	</section> <!-- end article section -->

		</article> <!-- end article -->

		<?php endwhile; endif; ?>

	</div> <!-- end #main -->

</div> <!-- end #cb-content -->
