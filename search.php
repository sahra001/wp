<?php
/**
 * The template for displaying Search Results pages
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

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'idolcorp' ), get_search_query() ); ?></h1>
				</header>

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
