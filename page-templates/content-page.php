<?php
/**
 * The template used for displaying page content
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
    endif;?>
  </header>
  <?php idolcorp_blog_content_without_search();?>
  
  <footer class="entry-footer">
    <?php edit_post_link( esc_html__( 'Edit', 'idolcorp' ), '<div class="fa-pencil-square-o edit-link">', '</div>' ); ?>
  </footer><!-- .entry-footer -->
</article>