<?php
/**
 * Register required widget area and function related to widget.
 * 
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
 
 /**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function idolcorp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'idolcorp' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Show widgets at Right sidebar of archive/posts/pages.', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'idolcorp' ),
		'id'            => 'idolcorp_left_sidebar',
		'description'   => esc_html__( 'Show widgets at Left sidebar of archive/posts/pages.', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Contact Sidebar', 'idolcorp' ),
		'id'            => 'contact_page_sidebar',
		'description'   => esc_html__( 'Show widgets at Left sidebar of archive/posts/pages.', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar One', 'idolcorp' ),
		'id'            => 'idolcorp_footer_sidebar_one',
		'description'   => esc_html__( 'Show widgets at footer sidebar one', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Two', 'idolcorp' ),
		'id'            => 'idolcorp_footer_sidebar_two',
		'description'   => esc_html__( 'Show widgets at footer sidebar two', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Three', 'idolcorp' ),
		'id'            => 'idolcorp_footer_sidebar_three',
		'description'   => esc_html__( 'Show widgets at footer sidebar three', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Sidebar Four', 'idolcorp' ),
		'id'            => 'idolcorp_footer_sidebar_four',
		'description'   => esc_html__( 'Show widgets at footer sidebar four', 'idolcorp' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

}
add_action( 'widgets_init', 'idolcorp_widgets_init' );

add_filter('widget_text', 'do_shortcode');



add_action( 'widgets_init', 'idolcorp_register_widget' );

/**
* Function to register Idolcorp custom contact info widgets
*
* @package Idolcorp
*/

function idolcorp_register_widget() {
    register_widget( 'idolcorp_contactinfo_widget' );
}