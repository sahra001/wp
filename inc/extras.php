<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Idolcorp 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
 
if ( ! function_exists( '_wp_render_title_tag' ) ) {
function idolcorp_render_title() { ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
<?php }
add_action( 'wp_head', 'idolcorp_render_title' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 * 
 * @package Idolcorp
 */
function idolcorp_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'idolcorp' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'idolcorp_wp_title', 10, 2 );
}

	/**
	* Idolcorp Custom Excerpt to return the_excerpt()
	*
	*@package Idolcorp
	*/
function idolcorp_trim_excerpt($idolcorp_excerpt) {
  $raw_excerpt = $idolcorp_excerpt;
  if ( '' == $idolcorp_excerpt ) {
    $idolcorp_excerpt = get_the_content(''); // Original Content
    $idolcorp_excerpt = strip_shortcodes($idolcorp_excerpt); // Minus Shortcodes
    $idolcorp_excerpt = apply_filters('the_content', $idolcorp_excerpt); // Filters
    $idolcorp_excerpt = str_replace(']]>', ']]&gt;', $idolcorp_excerpt); // Replace
    
    if (get_theme_mod( 'idolcorp_feed_excerpt_length' )) :
		$idolcorp_feedlimit = get_theme_mod( 'idolcorp_feed_excerpt_length' ,'85');
	else :
		$idolcorp_feedlimit = '85';
	endif;
    $excerpt_length = apply_filters('excerpt_length', $idolcorp_feedlimit); // Length
    $idolcorp_excerpt = wp_trim_words( $idolcorp_excerpt, $excerpt_length );    
  }
  return apply_filters('idolcorp_trim_excerpt', $idolcorp_excerpt, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'idolcorp_trim_excerpt');
apply_filters('the_excerpt', 'idolcorp_trim_excerpt');



/**
* Lets do a separate excerpt length for the alternative our features and our services in home template
*
* @package Idolcorp
*/
function idolcorp_featured_excerpt () {
	$theContent = trim(strip_tags(get_the_content()));
		$output = str_replace( '"', '', $theContent);
		$output = str_replace( '\r\n', ' ', $output);
		$output = str_replace( '\n', ' ', $output);
			$limit = '25';
			$content = explode(' ', $output, $limit);
			array_pop($content);
		$content = implode(" ",$content)."  ";
	return strip_tags($content, ' ');
}


/**
 * This fucntion is responsible for rendering metaboxes in single post area
 * 
 * @package Idolcorp
 */

add_action( 'add_meta_boxes', 'idolcorp_sidebar_layout_metabox' );
/**
 * Add Meta Boxes.
 */
function idolcorp_sidebar_layout_metabox() {
	// Adding layout meta box for page
	add_meta_box( 
                'page-sidebar', // $id
                __( 'Select Layout', 'idolcorp' ), // $title 
                'idolcorp_page_sidebar', // $callback 
                'page', // $page
                'normal', // $context
                'high' ); // $priority
                 
	// Adding layout meta box for
	add_meta_box( 
                'page-sidebar', //$id
                __( 'Select Layout', 'idolcorp' ), //$title
                'idolcorp_page_sidebar', //$callback 
                'post', //$page
                'normal', //$context
                'high' ); // $priority
}

/****************************************************************************************/

global $sidebars;
$sidebars = array(
					'default-sidebar' 	=> array(
												'id'			=> 'idolcorp_page_sidebar',
												'value' 		=> 'default_sidebar',
												'label' 		=> __( 'Default Layout', 'idolcorp' )
												),
					'right-sidebar' 	=> array(
												'id'			=> 'idolcorp_page_sidebar',
												'value' 		=> 'right_sidebar',
												'label' 		=> __( 'Right Sidebar', 'idolcorp' )
												),
					'left-sidebar' 	=> array(
												'id'			=> 'idolcorp_page_sidebar',
												'value' 		=> 'left_sidebar',
												'label' 		=> __( 'Left Sidebar', 'idolcorp' )
												),
					'no-sidebar-full-width' => array(
													'id'			=> 'idolcorp_page_sidebar',
													'value' 		=> 'no_sidebar_full_width',
													'label' 		=> __( 'No Sidebar Full Width', 'idolcorp' )
													)
				);

/****************************************************************************************/

/**
 * Displays metabox to for select layout option
 *
 * @package Idolcorp
 */
function idolcorp_page_sidebar() {
	global $sidebars, $post;

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'idolcorp_page_sidebar_nonce' );

	foreach ($sidebars as $field) {
		$sidebar_meta = get_post_meta( $post->ID, $field['id'], true );
		if( empty( $sidebar_meta ) ) { $sidebar_meta = 'default_sidebar'; }
		?>
			<input class="post-format" type="radio" name="<?php echo esc_attr($field['id']); ?>" value="<?php echo esc_attr($field['value']); ?>" <?php checked( $field['value'], $sidebar_meta ); ?>/>
			<label class="post-format-icon"><?php echo esc_attr($field['label']); ?></label><br/>
		<?php
	}
}

/****************************************************************************************/

add_action('pre_post_update', 'idolcorp_save_page_sidebar_meta');
/**
 * save the custom metabox data
 * @hooked to pre_post_update hook
 *
 * @package Idolcorp
 */
function idolcorp_save_page_sidebar_meta( $post_id ) {
	global $sidebars, $post;

	// Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'idolcorp_page_sidebar_nonce' ] ) || !wp_verify_nonce( $_POST[ 'idolcorp_page_sidebar_nonce' ], basename( __FILE__ ) ) )
      return;

	// Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
      return;

	if ('page' == $_POST['post_type']) {
      if (!current_user_can( 'edit_page', $post_id ) )
         return $post_id;
   }
   elseif (!current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
   }

	foreach ( $sidebars as $field ) {
		//idolcorp this saving function
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = $_POST[$field['id']];
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // end foreach
}

/**
* Only add the code below to your functions or plugin.
* Adds gallery shortcode defaults of size="medium" and columns="2"  
*
* @package Idolcorp
*/

function idolcorp_gallery_atts( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
      'columns' => '3',
      'size' => 'medium',
    ), $atts );
 
    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];
 
    return $out;
 
}
add_filter( 'shortcode_atts_gallery', 'idolcorp_gallery_atts', 10, 3 );


/**
* Function to add parse @@DATE@@ and @@BLOG@@ with its respective Cuurrent Date and Blog Title for footer copyright section
*
* @package Idolcorp
*/

if( !function_exists( 'idolcorp_parse_blog_details_and_date' ) ):

function idolcorp_parse_blog_details_and_date()
{
	$phrase=(String)get_theme_mod('idolcorp_copyright_section_title','@@DATE@@ @@BLOG@@ , All rights reserved');
	$current_year=date('Y');
	$blog_title=get_bloginfo();
	$old=array('/@@DATE@@/','/@@BLOG@@/');
	$new=array('<span class="copyright-text">&copy; '.$current_year.'</span>','<span class="idolcorp-sitename"> '.$blog_title);
 	$newphrase = preg_replace($old, $new, $phrase);
 	echo $newphrase.'</span>';

}
add_action('idolcorp_copyright','idolcorp_parse_blog_details_and_date');
endif;
