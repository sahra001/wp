<?php
/**
 * Implement Custom Header functionality for Idolcorp
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

/**
 * Set up the WordPress core custom header settings.
 *
 * @since Idolcorp 1.0
 *
 * @uses idolcorp_header_style()
 * @uses idolcorp_admin_header_style()
 * @uses idolcorp_admin_header_image()
 */
function idolcorp_custom_header_setup() {
	/**
	 * Filter Idolcorp custom-header support arguments.
	 *
	 * @since Idolcorp 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type bool   $header_text            Whether to display custom header text. Default false.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 1260.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 240.
	 *     @type bool   $flex_height            Whether to allow flexible-height header images. Default true.
	 *     @type string $admin_head_callback    Callback function used to style the image displayed in
	 *                                          the Appearance > Header screen.
	 *     @type string $admin_preview_callback Callback function used to create the custom header markup in
	 *                                          the Appearance > Header screen.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'idolcorp_custom_header_args', array(
		'default-text-color'     => '000',
		'width'                  => 1350,
		'height'                 => 377,
		'flex-height'            => true,
		'default-image'			 => get_template_directory_uri().'/images/best-theme.png',
		'wp-head-callback'       => 'idolcorp_header_style',
		'admin-head-callback'    => 'idolcorp_admin_header_style',
		'admin-preview-callback' => 'idolcorp_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'idolcorp_custom_header_setup' );

if ( ! function_exists( 'idolcorp_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see idolcorp_custom_header_setup().
 *
 */
function idolcorp_header_style() {
	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="idolcorp-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php
		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', '#212e32' ) ) :
	?>
		.site-title a,
        .site-description {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // idolcorp_header_style


if ( ! function_exists( 'idolcorp_admin_header_style' ) ) :
/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see idolcorp_custom_header_setup()
 *
 * @since Idolcorp 1.0
 */
function idolcorp_admin_header_style() {
?>
	<style type="text/css" id="idolcorp-admin-header-css">
	.appearance_page_custom-header #headimg {
		background-color: #000;
		border: none;
		max-width: 1600px;
		min-height: 48px;
	}
	#headimg h1 {
		font-family: Lato, sans-serif;
		font-size: 18px;
		line-height: 48px;
		margin: 0 0 0 30px;
	}
	#headimg h1 a {
		color: #fff;
		text-decoration: none;
	}
	#headimg img {
		vertical-align: middle;
	}
	</style>
<?php
}
endif; // idolcorp_admin_header_style

if ( ! function_exists( 'idolcorp_admin_header_image' ) ) :
/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see idolcorp_custom_header_setup()
 *
 * @since Idolcorp 1.0
 */
function idolcorp_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
		<h1 class="displaying-header-text"><a id="name"<?php echo sprintf( ' style="color:#%s;"', get_header_textcolor() ); ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php
}
endif; // idolcorp_admin_header_image
