<?php
/**
 * The template for displaying posts in the Audio post format
 * @package WordPress
 * @subpackage Idolcorp
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
  <div class="entry-content">
    <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'idolcorp' ) ); ?>
    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'idolcorp' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
  </div><!-- .entry-content -->
  <?php  idolcorp_entry_meta_tags();?> 
</article>