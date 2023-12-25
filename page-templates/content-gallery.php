<?php
/**
 * he template for displaying posts in the Gallery post format
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
    <div class="entry-meta clearfix">
      <?php idolcorp_header_entry_meta(); ?>
      <?php
      if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
      echo '<div class="fa-comments-o comments-link">';
      comments_popup_link( __( 'Leave a comment', 'idolcorp' ), __( '1 Comment', 'idolcorp' ), __( '% Comments', 'idolcorp' ) );
      echo '</div>';
      endif; 
      edit_post_link( __( 'Edit', 'idolcorp' ), '<div class="fa-pencil-square-o edit-link">', '</div>' );
      ?>
    </div> 
  </header>
  <?php idolcorp_blog_content_without_search();?>
  <?php  idolcorp_entry_meta_tags();?>
</article>