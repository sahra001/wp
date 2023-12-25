<?php
/**
 * Template Name: Home Page
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
    <div id="primary" class="content-area">
        <div id="content" class="site-content">
		
            <!-- Homepage Slider -->
            <?php echo do_action('idolcorp_slider'); ?>
        
            <!-- Homepage services -->        
    		<?php 
    			if( get_theme_mod( 'service_section_control', 'enable' ) == 'enable' ) {
    				echo do_action('idolcorp_services');
    			}
    		?>  
		    <!-- Homepage Call a action -->   
            <?php echo do_action('call_to_action');?>
        

        
            <!--Homepage Latest Blog-->  
            <?php
            if( get_theme_mod( 'blog_section_control', 'enable' ) == 'enable' ) {
				echo do_action('idolcorp_blog');
			}
            ?>
            <!-- Home page Call a action below -->
            <?php echo do_action('call_to_action_below');?>
            <!--Homepage Testimonials slider -->        
            <?php
            if( get_theme_mod( 'testi_section_control', 'enable' ) == 'enable' ) {
                echo do_action('idolcorp_testimonials');
            }
            ?>
        </div>
    </div>
</div>
</div><!-- Main div close-->
<?php get_footer(); ?>