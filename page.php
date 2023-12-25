<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
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
	        <div id="content" class="page site-content"> 
	        <section id="articlemain" class="post" role="main">
	            <?php
	            // Start the Loop.
				while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'page-templates/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				endwhile;
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