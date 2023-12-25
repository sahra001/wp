<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

get_header(); ?>
<div id="main" class="site-main">         
  <div class="container">
    <div class="row content-wrap"> 
      <div id="content" class="site-content"> 
        <div class="error-content-wrap">           
          <header class="entry-header"><h1><?php _e( 'This Page Does Not Exist', 'idolcorp' ); ?></h1></header>
          <div class="entry-content no-border-bottom">
           <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'idolcorp' ); ?></p>
           <?php get_search_form(); ?>
          </div>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="read-more-button" title="go home"><?php _e( 'Go Home', 'idolcorp' ); ?></a>
          <a href="javascript:return(-1);" class="read-more-button" title="Return"><?php _e( 'Return', 'idolcorp' ); ?></a>
        </div> 
      </div><!-- #content -->
    </div>
  </div><!-- .container -->
</div><!-- #main -->
<?php
get_footer();