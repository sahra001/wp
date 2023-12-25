<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
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