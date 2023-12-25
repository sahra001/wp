<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="page">
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	  <link rel="profile" href="http://gmpg.org/xfn/11">
	  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	  <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <div id="idolcorp_menu"><span></span><span></span><span></span></div>
      <div id="fpage">
      <div id="page" class="hfeed site">
      <header id="masthead" class="site-header">
        <div class="hgroup-wrap">
          <div class="container">
            <section class="site-branding">
            	<?php 
                  
              if (has_custom_logo() ) { ?>
        			<?php idolcorp_the_custom_logo(); ?>
              <?php } else { ?>
        			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_attr(bloginfo( 'name' )); ?></a></h1>
        			<span class="site-description"><?php esc_attr(bloginfo( 'description' )); ?></span>	        
                <?php } ?>
             </section> 
           <?php idolcorp_top_header();?>
          </div>
        </div>
        <div id="navbar" class="navbar">
          <div class="container">
            <nav id="site-navigation" class="navigation main-navigation row">
              <div class="menu-top-menu-container clearfix">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
              </div>
               
              <div class="search-container">
                <?php if( get_theme_mod( 'header_search_option', 1 ) == 1 ) { ?>
                  <div class="fa-search search-toggle"></div>
                <?php } ?>
                    <div class="search-box">
                    	<?php get_search_form(); ?>
                    </div>
                
              </div> 
              
            </nav>
          </div>
        </div>
          <?php echo do_action('idolcorp_header_title');?>
      </header>
