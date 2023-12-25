<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
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
					// Start the Loop.
					while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'page-templates/content', get_post_format() );

					endwhile;
					// Previous/next page navigation.
					idolcorp_paging_nav();

					else :
					// If no content, include the "No posts found" template.
					get_template_part( 'page-templates/content', 'none' );

					endif;
					?>
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