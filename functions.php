<?php
/**
 * Idolcorp functions and definitions
 *
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 *
 *
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 *
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */



if ( ! function_exists( 'idolcorp_setup' ) ) :
/**
 * Idolcorp setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Idolcorp 1.0
 */
function idolcorp_setup() {
   
	/*
	 * Make  Idolcorp for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Idolcorp, use a find and
	 * replace to change 'idolcorp' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'idolcorp', get_template_directory() . '/languages' );
	
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'jetpack-responsive-videos' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 760, 354, true );
	add_image_size( 'idolcorp-full-width', 1350, 434, true );
	add_image_size( 'idolcorp-ourfeatures-thumb', 263, 165, true );
	add_image_size( 'idolcorp-mediumblog-thumb', 288, 244, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'idolcorp' ),
		'discalimer' => __( 'Disclaimer Menu', 'idolcorp' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	/**
     * Filter the arguments used when adding 'custom-background' support in Twenty Sixteen.
     *
     * @since Idolcorp 1.0
     *
     * @param array $args {
     *     An array of custom-background support arguments.
     *
     *     @type string $default-color Default color of the background.
     * }
     */
    add_theme_support( 'custom-background', array('default-color' =>'#ffffff' ) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	
	add_editor_style( array( 'editor-style.css', idolcorp_fonts_url() ) );

	/*
	* Theme Logo is a theme feature, first introduced in Version 4.5. This feature allows themes to add custom logos.
	*
	*/

	/*
	 * Enable support for custom logo.
	 *
	 *  @Idolcorp 1.1
	 */

	add_theme_support( 'custom-logo', array(
   'height'      => 175,
   'width'       => 400,
   'flex-width' => true,
	 ));

}
endif; // idolcorp_setup
add_action( 'after_setup_theme', 'idolcorp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Idolcorp 1.0
 *
 * @return void
 */

function idolcorp_content_width() {

	$GLOBALS['content_width'] = apply_filters( 'idolcorp_content_width', 750 );

}
add_action( 'after_setup_theme', 'idolcorp_content_width', 0 );


// Load idolcorp custom function file.
require get_template_directory() . '/inc/idolcorp-functions.php';

// Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Load idolcorp custom contact info widget.
require get_template_directory() .'/inc/widget/idolcorp_contactinfo_widgets.php'; // Call to Action widget

// Load idolcorp custom widget area and related functions.
require get_template_directory() . '/inc/idolcorp-widget-area.php';

// Add Custom WordPress Customizer classes
require_once get_template_directory() . '/themeidol-customizer/class-wp-custom-customize-control.php';

// Add Custom WordPress Sanitize functionality
require_once get_template_directory() . '/themeidol-customizer/themidol-sanitize.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/themeidol-customizer/themeidol-customizer.php';

 // Load Jetpack compatibility file.
require get_template_directory() . '/inc/jetpack.php';

