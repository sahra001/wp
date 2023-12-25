<?php
/**
 * The template for displaying Author archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

get_header(); ?>
<div id="main" class="site-main">         
	<div class="container">
	    <div class="row content-wrap">              
	    <?php echo idolcorp_custom_layout_class_and_structure('primary');?>
	    <div id="content" class="site-content"> 
	    	<section id="articlemain" class="post" role="main">
	              	<?php if ( have_posts() ) : ?>

					<?php
						/*
						 * Queue the first post, that way we know what author
						 * we're dealing with (if that is the case).
						 *
						 * We reset this later so we can run the loop
						 * properly with a call to rewind_posts().
						 */
						the_post();
					?>
					<?php
						/*
						 * Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();
					?>
					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<?php get_template_part( 'author-bio' ); ?>
					<?php endif; ?>

					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'page-templates/content', get_post_format() ); ?>
					<?php endwhile; ?>

					<?php idolcorp_paging_nav(); ?>

					<?php else : ?>
						<?php get_template_part( 'page-templates/content', 'none' ); ?>
					<?php endif; ?>
			</section>
	    </div>
	    </div>
	      <?php idolcorp_sidebar_layout(); ?>                   
		</div>
	</div><!-- .container -->
</div><!-- #main -->
</div><!-- Main div Close-->
<?php
get_footer();