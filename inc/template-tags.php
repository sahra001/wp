<?php
/**
 * Custom template tags for Idolcorp
 *
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

if ( ! function_exists( 'idolcorp_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Idolcorp 1.0
 *
 * @return void
 */
function idolcorp_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&laquo;', 'idolcorp' ),
		'next_text' => __( '&raquo;', 'idolcorp' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'idolcorp' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'idolcorp_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Idolcorp 1.0
 *
 * @return void
 */
function idolcorp_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'idolcorp' ); ?></h1>
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'idolcorp' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav">Previous</span>%title', 'idolcorp' ) );
				next_post_link( '%link', __( '%title <span class="meta-nav">Next</span>', 'idolcorp' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'idolcorp_all_title' ) ) :
/**
 * Shim for `idolcorp_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function idolcorp_all_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'idolcorp' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'idolcorp' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'idolcorp' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'idolcorp' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'idolcorp' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'idolcorp' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'idolcorp' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'idolcorp' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'idolcorp' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'idolcorp' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'idolcorp' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'idolcorp' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'idolcorp' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		if(is_single())
		$title=get_the_title();
	    elseif(is_page())
	   	$title=get_the_title();
		else
		if(is_404())
		$title = esc_html_x( 'Error 404 - Page Not Found ', 'Page Not Found', 'idolcorp' );	
		if(is_search())
		$title = sprintf( esc_html__( 'Search Results for: %s', 'idolcorp' ), '<span>' . get_search_query() . '</span>' );
		elseif(is_single())
		$title=get_the_title();
	    elseif(is_page())
	   	$title=get_the_title();
	    elseif(is_404())
		$title = esc_html_x( 'Error 404 - Page Not Found ', 'Page Not Found', 'idolcorp' );	
		else	
		$title = esc_html__( 'Archives', 'idolcorp' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'idolcorp_archive_description' ) ) :
/**
 * Shim for `idolcorp_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function idolcorp_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;


/**
 * Flush out the transients used in idolcorp_categorized_blog.
 *
 * @since Idolcorp 1.0
 *
 * @return void
 */
function idolcorp_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'idolcorp_category_count' );
	delete_transient('idolcorp_home_slider_transient');
	delete_transient('idolcorp_home_testimonials_transient');
	delete_transient('idolcorp_home_services_transient');
	delete_transient('idolcorp_home_blog_transient');

}
add_action( 'edit_category', 'idolcorp_category_transient_flusher' );
add_action( 'save_post',     'idolcorp_category_transient_flusher' );


/**
 * Modify Post thumbnail html 
 */
if( !function_exists( 'idolcorp_modify_post_thumbnail_html' ) ):
function idolcorp_modify_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
    $id = get_post_thumbnail_id(); // gets the id of the current post_thumbnail (in the loop)
    $blog_layout_option = get_theme_mod( 'blog_layout_option', 'boxed_layout' );
    if($blog_layout_option=='boxed_layout')
    $size='idolcorp-mediumblog-thumb';
    if($blog_layout_option=='wide_layout')
    $size='idolcorp-full-width';   
    else
    $size='thumbnail';
    if(is_single())
    $size='idolcorp-full-width';
    $src = wp_get_attachment_image_src($id, $size); // gets the image url specific to the passed in size (aka. custom image size)
    $alt = get_the_title($id); // gets the post thumbnail title
   

    
    $html = '<img src="' . esc_url($src[0]) . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($size) . '" />';
   

    return $html;
}
add_filter('post_thumbnail_html', 'idolcorp_modify_post_thumbnail_html', 99, 5);
endif;


if ( ! function_exists( 'idolcorp_header_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, permalink, author, and date.
 *
 * Create your own idolcorp_entry_meta() to override in a child theme.
 *
 * @since Idolcorp 1.0
 */
function idolcorp_header_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'idolcorp' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		

	// Translators: used between list items, there is a space after the comma.
	$categories_list='';
	$categories_list = get_the_category_list( __( ', ', 'idolcorp' ) );
	if ( $categories_list ) {
		echo '<div class="entry-meta">';
		echo '<span class="cat-links">' . $categories_list . '</span>';
		echo '</div>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		
		printf( '<div class="fa-user"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></div>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'idolcorp' ), get_the_author() ) ),
			get_the_author()
		);
	}
	idolcorp_entry_date();
	
	
}
endif;
if ( ! function_exists( 'idolcorp_entry_meta_tags' ) ) :
/**
 * Print HTML with meta information for current post: tags only .
 *
 * Create your own idolcorp_entry_meta_tags() to override in a child theme.
 *
 * @since Idolcorp 1.0
 */
function idolcorp_entry_meta_tags()
{
		/* translators: used between list items, there is a space after the comma */
		echo '<footer class="entry-footer entry-meta-bar"><div class="entry-meta">';
		$tags_list = get_the_tag_list( '', '' );
		if ( $tags_list ) {
			printf( '<span class="tag-links  clearfix"><h4>'.esc_html__( 'Tags', 'idolcorp' ).'</h4>' . esc_html__( '%1$s', 'idolcorp' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
		echo '</div></footer>';
	
	
}
//add_action('idolcorp_blog_tags','idolcorp_entry_meta_tags');
endif;

if ( ! function_exists( 'idolcorp_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own idolcorp_entry_date() to override in a child theme.
 *
 * @since Idolcorp 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function idolcorp_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'idolcorp' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<div class="fa-clock-o"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></div>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'idolcorp' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'idolcorp_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since TIdolcorp 1.0
 */
function idolcorp_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Twenty thirteen 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'idolcorp_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'idolcorp_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @package Idolcorp
 * @since Idolcorp 1.0.6
 */
function idolcorp_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Filter to change the class name of custom logo image.
 *
 * Does nothing if the custom logo class is not present.
 *
 * @package Idolcorp
 * @since Idolcorp 1.0.6
 */

add_filter('get_custom_logo', 'idolcorp_custom_logo_output', 10);

if ( ! function_exists( 'idolcorp_custom_logo_output' ) ) :

function  idolcorp_custom_logo_output( $html ){
	$html = str_replace( 'custom-logo', 'custom-logo site-logo', $html );
	return $html;
}

endif;