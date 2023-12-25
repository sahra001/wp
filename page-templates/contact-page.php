<?php
/**
 * Template Name: Contact Page
 *
 * This is the template that display sections in home page.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Idolcorp
 */
get_header(); ?>
<div id="main" class="site-main">      
  <div class="container">
    <div id="content" class="content-area">
      <div class="row content-wrap">
        <div id="primary" class="col-sm-6">
          <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'page-templates/content', 'page' );

          endwhile;
          ?>  
        </div>
        <?php get_sidebar('left');?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>