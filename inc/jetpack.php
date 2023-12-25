<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 *
 * @package Idolcorp
 */
function idolcorp_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'articlemain',
		'render'    => 'idolcorp_infinite_scroll_render',
		'footer'    => 'fpage',
		'wrapper'        => true,
        'posts_per_page' => false
	) );
} // end function idolcorp_jetpack_setup
add_action( 'after_setup_theme', 'idolcorp_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 *
 * @package Idolcorp
 */
function idolcorp_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'page-templates/content', get_post_format() );
	}
} // end function idolcorp_infinite_scroll_render