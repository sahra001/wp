<?php
/**
 * The template for displaying a "No posts found" message
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
wp_reset_postdata();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h2 class="page-title"><?php _e( 'Nothing Found', 'idolcorp' ); ?></h2>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'idolcorp' ), admin_url( 'post-new.php' ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'idolcorp' ); ?></p>
		<?php get_search_form(); ?>

		<?php else : ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'idolcorp' ); ?></p>
		<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</article>
					
