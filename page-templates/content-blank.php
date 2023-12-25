<?php
/**
 * The template used for displaying page content on the blank template - ideal for use with page builders
 * 
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
wp_reset_postdata();
?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'idolcorp' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					<?php edit_post_link( __( 'Edit', 'idolcorp' ), '<div class="fa-pencil-square-o edit-link">', '</div>' );?>
					</div><!-- .entry-content -->
				</article>

