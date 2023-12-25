<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
?>

<footer id="colophon" class="site-footer" >
  <div class="widget-wrap">
    <div class="container">
      <div class="widget-area">
        <div class="row">
          <?php
          $footer_column=get_theme_mod('idolcorp_footer_column','four_column');
          if($footer_column=='four_column'):
          ?>
          <div class="col-sm-3">
            <?php
            if ( is_active_sidebar( 'idolcorp_footer_sidebar_one' ) ) : ?>
            <?php dynamic_sidebar( 'idolcorp_footer_sidebar_one' ); ?>
            <?php endif;?> 
               
          </div>
          <div class="col-sm-3">
            <?php
            if ( is_active_sidebar( 'idolcorp_footer_sidebar_two' ) ) : ?>
            <?php dynamic_sidebar( 'idolcorp_footer_sidebar_two' ); ?>
            <?php endif;?> 
          </div>
          <div class="col-sm-3">
            <?php
            if ( is_active_sidebar( 'idolcorp_footer_sidebar_three' ) ) : ?>
            <?php dynamic_sidebar( 'idolcorp_footer_sidebar_three' ); ?>
            <?php endif;?> 
          </div>
          <div class="col-sm-3">
              <?php
              if ( is_active_sidebar( 'idolcorp_footer_sidebar_four' ) ) : ?>
              <?php dynamic_sidebar( 'idolcorp_footer_sidebar_four' ); ?>
              <?php endif;?> 
          </div>
        <?php else:?>
          <div class="col-sm-4">
            <?php
            if ( is_active_sidebar( 'idolcorp_footer_sidebar_one' ) ) : ?>
            <?php dynamic_sidebar( 'idolcorp_footer_sidebar_one' ); ?>
            <?php endif;?> 
               
          </div>
          <div class="col-sm-4">
            <?php
            if ( is_active_sidebar( 'idolcorp_footer_sidebar_two' ) ) : ?>
            <?php dynamic_sidebar( 'idolcorp_footer_sidebar_two' ); ?>
            <?php endif;?> 
          </div>
          <div class="col-sm-4">
            <?php
            if ( is_active_sidebar( 'idolcorp_footer_sidebar_three' ) ) : ?>
            <?php dynamic_sidebar( 'idolcorp_footer_sidebar_three' ); ?>
            <?php endif;?> 
          </div>

       <?php endif;?>
        </div>
      </div>
      <div class="site-info">
          <h2 class="disclaimer-site-title">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_attr( get_theme_mod( 'idolcorp_disclaimer_section_title', 'Idol Corporate' ) ); ?></a>
          </h2>
          <div class="copy-right">
            <div class="disclaimer-menu">                
          <?php wp_nav_menu( array( 'theme_location' => 'discalimer', 'menu_class' => 'menu' ) );?>
            </div>
          <?php  do_action('idolcorp_copyright'); ?>
          </div>        
      </div>
      <div class="back-to-top">
        <a href="#masthead" title="Go to Top" class="fa-angle-up"></a>       
      </div>
    </div>
  </div>
</footer>
</div>
</div> <!-- End of #fpage-->
<?php wp_footer(); ?>
</body>
</html>