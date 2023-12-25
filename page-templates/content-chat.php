<?php
/**
 * The template for displaying posts in the Chat post format
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
wp_reset_postdata();
?>                
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">
    <?php if ( is_single() ) :
    the_title( '<h2 class="entry-title">', '</h2>' );
    else :
    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    endif;
    ?>
  </header>
                                                                 
  <div class="entry-content">
    <?php the_content(); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'idolcorp' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
    <?php edit_post_link( __( 'Edit', 'idolcorp' ), '<div class="fa-pencil-square-o edit-link">', '</div>' );?>
  </div><!-- .entry-content -->
</article>