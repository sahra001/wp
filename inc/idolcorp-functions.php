<?php
/**
 * Custom function defines 
 * 
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
 
 /**
 * Enqueue scripts and styles.
 *
 * @package Idolcorp
 */
function idolcorp_scripts() {
    $idolcorp_nicescroll_bar_option=get_theme_mod('idolcorp_nicescroll_bar_option','enable');
           
    wp_enqueue_style( 'idolcorp-bootstrap', get_template_directory_uri() . '/css/bootstrap.css');

    wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.css', array(), '4.5.0' );

    wp_enqueue_style( 'idolcorp-style', get_stylesheet_uri(), array());
    
    wp_enqueue_style( 'idolcorp-google-fonts', idolcorp_fonts_url(), array(), null );

    wp_enqueue_script( 'idolcorp-bootstrap-script', get_template_directory_uri() .  '/js/bootstrap.js', array('jquery'), '20120206', false );

    wp_enqueue_script( 'idolcorp-bxSlider', get_template_directory_uri() . '/js/jquery.bxslider.js', array( 'jquery' ), '4.1.2', false );

    wp_enqueue_script( 'idolcopr-custom-scripts', get_template_directory_uri() .'/js/custom-scripts.js', array( 'jquery' ) );   
    
    wp_enqueue_style( 'idolcorp-generated-style',get_template_directory_uri().'/css/generated.css','','','all');

    // Enable nice scroll bar if its enabled in customizer. By default its enabled
    if($idolcorp_nicescroll_bar_option=='enable'){

    wp_enqueue_script('idoclcorp-nice-scrollbar-main-js', get_template_directory_uri().'/js/jquery.nicescroll.min.js', array('jquery'));

    }
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'idolcorp_scripts' );

/**
 * Enqueue scripts and styles for the front end for conditional Statements.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_script_add_data/
 *
 * @package Idolcorp
 * @since Idolcorp 1.0.6
 *
 * @return void
 */
 
function idolcorp_ie_support_header() {

    wp_enqueue_script( 'wpdemo-respond', get_template_directory_uri().'/js/respond.js' );
    wp_script_add_data( 'wpdemo-respond', 'conditional', 'lt IE 9' );
 
    wp_enqueue_script( 'wpdemo-html5shiv',get_template_directory_uri().'/js/html5shiv.js');
    wp_script_add_data( 'wpdemo-html5shiv', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'idolcorp_ie_support_header', 1 ); 



/**
 * Add filter in wp_hed
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 *
 */

add_filter( 'wp_head', 'idolcorp_wp_head' );
 
if( !function_exists( 'idolcorp_wp_head' ) ):
function idolcorp_wp_head() {
    $homeslider_control = ( get_theme_mod( 'slider_control_option', 'hide' ) == 'show' ) ? 'true' : 'false';
    $homeslider_pager = ( get_theme_mod( 'slider_pager_option', 'show' ) == 'show' ) ? 'true' : 'false';
    $homeslider_transaction = ( get_theme_mod( 'slider_transaction_option', 'auto' ) == 'auto' ) ? 'true' : 'false';
    $slider_speed_option=get_theme_mod( 'slider_speed_option', 500 );

    $idolcorp_nicescroll_bar_option=get_theme_mod('idolcorp_nicescroll_bar_option','enable');
    $idolcorp_nicescroll_cursorcolor=get_theme_mod('idolcorp_nicescroll_cursorcolor','#4d4d4d');
    $idolcorp_nicescroll_cursorborder=get_theme_mod('idolcorp_nicescroll_cursorborder','0');
    $idolcorp_nicescroll_cursorwidth=get_theme_mod('idolcorp_nicescroll_cursorwidth','7');

if($idolcorp_nicescroll_bar_option=='enable'){
    ?>
        <script type="text/javascript">
        /* <![CDATA[ */
        jQuery(function($) {
            jQuery("html").niceScroll({
                cursorcolor:"<?php echo esc_js($idolcorp_nicescroll_cursorcolor);?>",
                cursorborder:"<?php echo esc_js($idolcorp_nicescroll_cursorborder)."px";?>",
                cursorwidth:"<?php echo esc_js($idolcorp_nicescroll_cursorwidth)."px";?>",
            });
            $('#homepage-slider .bx-slider').bxSlider({
                    adaptiveHeight: true,
                    pager: <?php echo esc_js($homeslider_pager) ;?>,
                    controls: <?php echo esc_js($homeslider_control) ;?>,
                    auto: <?php echo esc_js($homeslider_transaction) ;?>,
                    speed:<?php echo esc_js($slider_speed_option);?>
            });
                
            $('.testimonials-slider').bxSlider({
                    adaptiveHeight: true,
                    pager:false,
            });
        });
        /* ]]> */
    </script>
    <?php

} else
{ ?>
    <script type="text/javascript">
    /* <![CDATA[ */
        jQuery(function($) {
                $('#homepage-slider .bx-slider').bxSlider({
                    adaptiveHeight: true,
                    pager: <?php echo esc_js($homeslider_pager) ;?>,
                    controls: <?php echo esc_js($homeslider_control) ;?>,
                    auto: <?php echo esc_js($homeslider_transaction) ;?>,
                    speed:<?php echo esc_js($slider_speed_option);?>
                });
                
                 $('.testimonials-slider').bxSlider({
                        adaptiveHeight: true,
                        pager:false,
                   });
            });
        /* ]]> */
    </script>

<?php
}

}
endif;


/**
 * Added custom class and return its layout for pages with sidebar(Left/right sidebar) and page without sidebar
 * @return Div structure with its respective class eg '<div id="primary" class="col-sm-12">' for full width layout
 *
 * @package Idolcorp
 */

if( !function_exists( 'idolcorp_custom_layout_class_and_structure' ) ):
    
function idolcorp_custom_layout_class_and_structure( $layout='primary' ) {
    global $post;

    if( $post ) { $sidebar_meta = get_post_meta( $post->ID, 'idolcorp_page_sidebar', true ); }
    
    if( is_home() ) {
        $queried_id = get_option( 'page_for_posts' );
        $sidebar_meta = get_post_meta( $queried_id, 'idolcorp_page_sidebar', true );
    }
     if( empty( $sidebar_meta ) || is_archive() || is_search() ) { $sidebar_meta = 'default_sidebar'; }
    $idolcorp_default_sidebar = get_theme_mod( 'idolcorp_archive_sidebar', 'right_sidebar' );

    $idolcorp_default_page_sidebar = get_theme_mod( 'idolcorp_default_page_sidebar', 'right_sidebar' );
    $idolcorp_default_post_sidebar = get_theme_mod( 'idolcorp_default_single_posts_sidebar', 'right_sidebar' );
    


    if( $sidebar_meta === 'default_sidebar' ) {
        if( is_page() ) {
            if( $idolcorp_default_page_sidebar === 'right_sidebar' ) { $sidebar_classes = 'col-sm-4'; $primary_classes='col-sm-8'; }
            elseif( $idolcorp_default_page_sidebar === 'left_sidebar' ) { $sidebar_classes = 'col-sm-4 col-sm-pull-8'; $primary_classes='col-sm-8 col-sm-push-4';}
            elseif( $idolcorp_default_page_sidebar === 'no_sidebar_full_width' ) { $sidebar_classes = ''; $primary_classes='col-sm-12';}
        }
        elseif( is_single() ) {
            if( $idolcorp_default_post_sidebar == 'right_sidebar' ) { $sidebar_classes = 'col-sm-4'; $primary_classes='col-sm-8'; }
            elseif( $idolcorp_default_post_sidebar == 'left_sidebar' ) { $sidebar_classes = 'col-sm-4 col-sm-pull-8'; $primary_classes='col-sm-8 col-sm-push-4'; }
            elseif( $idolcorp_default_post_sidebar == 'no_sidebar_full_width' ) { $sidebar_classes = ''; $primary_classes='col-sm-12'; }
        }
        elseif( $idolcorp_default_sidebar == 'right_sidebar' ) { $sidebar_classes = 'col-sm-4'; $primary_classes='col-sm-8'; }
        elseif( $idolcorp_default_sidebar == 'left_sidebar' ) { $sidebar_classes = 'col-sm-4 col-sm-pull-8'; $primary_classes='col-sm-8 col-sm-push-4'; }
        elseif( $idolcorp_default_sidebar == 'no_sidebar_full_width' ) { $sidebar_classes = ''; $primary_classes='col-sm-12'; }
    }
    elseif( $sidebar_meta == 'right_sidebar' ) { $sidebar_classes = 'col-sm-4'; $primary_classes='col-sm-8'; }
    elseif( $sidebar_meta == 'left_sidebar' ) { $sidebar_classes = 'col-sm-4 col-sm-pull-8'; $primary_classes='col-sm-8 col-sm-push-4';}
    elseif( $sidebar_meta == 'no_sidebar_full_width' ) { $sidebar_classes = ''; $primary_classes='col-sm-12'; }

   
        if($layout=='primary')
        return '<div id="primary" class="'.$primary_classes.'">';
        elseif($layout=='secondary')
        return '<div id="secondary" class="'.$sidebar_classes.'" role="complementary">';
        elseif($layout=='contact')
        return ' <div id="secondary" class="col-sm-6">';
}
endif;

/**
 * Function to select the sidebar
 * @return get_sidebar('left') or get_sidebar()
 *
 * @package Idolcorp
 */ 
if ( ! function_exists( 'idolcorp_sidebar_layout' ) ) :

function idolcorp_sidebar_layout() {
    global $post;

    if( $post ) { $sidebar_meta = get_post_meta( $post->ID, 'idolcorp_page_sidebar', true ); }

    if( is_home() ) {
        $queried_id = get_option( 'page_for_posts' );
        $sidebar_meta = get_post_meta( $queried_id, 'idolcorp_page_sidebar', true );
    }
    if( get_theme_mod( 'site_layout_option', 'boxed_layout' ) == 'boxed_layout' ) {
           
       

    if( empty( $sidebar_meta ) || is_archive() || is_search() ) { $sidebar_meta = 'default_sidebar'; }
    
    $idolcorp_default_sidebar = get_theme_mod( 'idolcorp_archive_sidebar', 'right_sidebar' );
    $idolcorp_default_page_sidebar = get_theme_mod( 'idolcorp_default_page_sidebar', 'right_sidebar' );
    $idolcorp_default_post_sidebar = get_theme_mod( 'idolcorp_default_single_posts_sidebar', 'right_sidebar' );

    if( $sidebar_meta == 'default_sidebar' ) {
        if( is_page() ) {
            if( $idolcorp_default_page_sidebar == 'right_sidebar' ) { get_sidebar(); }
            elseif ( $idolcorp_default_page_sidebar == 'left_sidebar' ) { get_sidebar( 'left' ); }
        }
        if( is_single() ) {
            if( $idolcorp_default_post_sidebar == 'right_sidebar' ) { get_sidebar(); }
            elseif ( $idolcorp_default_post_sidebar == 'left_sidebar' ) { get_sidebar( 'left' ); }
        }
        elseif( $idolcorp_default_sidebar == 'right_sidebar' ) { get_sidebar(); }
        elseif ( $idolcorp_default_sidebar == 'left_sidebar' ) { get_sidebar( 'left' ); }
    }
    elseif( $sidebar_meta == 'right_sidebar' ) { get_sidebar(); }
    elseif( $sidebar_meta == 'left_sidebar' ) { get_sidebar( 'left' ); }
     }
}
endif;


/**
 * Top Header for social links 
 *
 * @package Idolcorp
 */
if( !function_exists( 'idolcorp_top_header' ) ):
function idolcorp_top_header() {
  
  //$content='';  
    if( get_theme_mod( 'top_header_option', 'enable' ) == 'enable' ) {
         // Get any existing copy of our transient data
if ( false === ( $content = get_transient( 'idolcorp_top_header_transient' ) ) ) {
        $top_phone = get_theme_mod( 'top_header_phone', '+977 123456789' );
        $top_fb = get_theme_mod( 'social_fb_link', 'https://facebook.com/' );
        $top_tw = get_theme_mod( 'social_tw_link', 'https://facebook.com/' );
        $top_gp = get_theme_mod( 'social_gp_link', 'https://plus.google.com/' );
        $top_lnk = get_theme_mod( 'social_lnk_link', 'https://linkedin.com/' );
        $top_yt = get_theme_mod( 'social_yt_link', 'https://youtube.com/' );
        $top_vm = get_theme_mod( 'social_vm_link', 'https://vimeo.com/' );
    ob_start();
    ?>

     <section class="hgroup-right">
              <?php if( !empty( $top_phone ) ){ ?><div class="caller"><a class="fa-phone" href="tel:<?php echo preg_replace('/(\W*)/', '', esc_attr( $top_phone )); ?>" title="<?php echo esc_attr__('our number','idolcorp');?>" target="_blank"><?php echo esc_attr( $top_phone ); ?></a>
              </div><?php } ?>
              <div class="inline-social-profiles">
                <ul>
                  <?php if( !empty( $top_fb ) ){ ?><li><a class="fa-facebook-f" href="<?php echo esc_url( $top_fb ); ?>" title="Facebook" target="_blank"></a></li><?php } ?>
                  <?php if( !empty( $top_tw ) ){ ?><li><a class="fa-twitter" href="<?php echo esc_url( $top_tw ); ?>" title="Twitter" target="_blank"></a></li><?php } ?>
                  <?php if( !empty( $top_lnk ) ){ ?><li><a class="fa-linkedin" href="<?php echo esc_url( $top_lnk ); ?>" title="Linkedin" target="_blank"></a></li><?php } ?>
                  <?php if( !empty( $top_gp ) ){ ?><li><a class="fa-google-plus" href="<?php echo esc_url( $top_gp ); ?>" title="Google Plus" target="_blank"></a></li><?php } ?>
                  <?php if( !empty( $top_yt ) ){ ?><li><a class="fa-youtube" href="<?php echo esc_url( $top_yt ); ?>" title="Youtube" target="_blank"></a></li><?php } ?>
                  <?php if( !empty( $top_vm ) ){ ?><li><a class="fa-vimeo-square" href="<?php echo esc_url( $top_vm ); ?>" title="Vimeo" target="_blank"></a></li><?php } ?>

                </ul>
              </div>
            </section>
            <?php
            $content=ob_get_contents();
            set_transient('idolcorp_top_header_transient',$content);
    }
     else
    {
        echo $content;
        
    }
}
    
}
endif;

/**
 * Function for custom BreadCrumb
 *
 * @package Idolcorp
 */
if( !function_exists( 'idolcorp_breadcrumbs' ) ):
function idolcorp_breadcrumbs() {
    global $post;
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show

    $delimiter = ' / ';

    $home = __( 'Home', 'idolcorp' );

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span typeof="v:Breadcrumb"><span property="v:title">'; // tag before the current crumb
    $after = '</span></span>'; // tag after the current crumb
    
    $homeLink = home_url();

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1)
            echo '<div class="breadcrumb"><span typeof="v:Breadcrumb"><a href="' . esc_url($homeLink) . '">' . esc_attr($home) . '</a></span>';
    } else {

        echo '<div class="breadcrumb"><span typeof="v:Breadcrumb"><a href="' . esc_url($homeLink) . '">' . esc_attr($home) . '</a></span> ' . $delimiter . ' ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0)
                echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
            echo $before . __( 'Archive by category', 'idolcorp' ).' "' . single_cat_title('', false) . '"' . $after;
        } elseif (is_search()) {
            echo $before . __( 'Search results for', 'idolcorp' ). '"' . get_search_query() . '"' . $after;
        } elseif (is_day()) {
            echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . esc_url($homeLink . '/' . $slug['slug']) . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1)
                    echo ' ' . $delimiter . ' ' . $before . esc_attr(get_the_title()) . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                if ($showCurrent == 0)
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                echo $cats;
                if ($showCurrent == 1)
                    echo $before . esc_attr(get_the_title()) . $after;
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            if ($showCurrent == 1) echo ' ' . $before . esc_attr(get_the_title()) . $after;
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1)
                echo $before . esc_attr(get_the_title()) . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID) ). '">' . esc_attr(get_the_title($page->ID)) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1)
                    echo ' ' . $delimiter . ' ';
            }
            if ($showCurrent == 1)
                echo ' ' . $delimiter . ' ' . $before . esc_attr(get_the_title()) . $after;
        } elseif (is_tag()) {
            echo $before . __( 'Posts tagged','idolcorp' ).' "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . __( 'Articles posted by ','idolcorp' ). $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before .  __( 'Error 404 ','idolcorp' ) . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo __('Page', 'idolcorp') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ')';
        }

        echo '</div>';
    }
}
endif;

/**
 * Return the primary div with its respective class for Blog Layout 
 * Blog layout are : Full Width, Right Sidebar, Left Sidebar
 *
 * @package Idolcorp
 */
if( !function_exists( 'idolcorp_blog_layout' ) ):
function idolcorp_blog_layout(&$image_wrapper_open,&$image_wrapper_close,&$no_border_class) {
    $blog_layout_option='';
    $image_wrapper_close='';
    $no_border_class='';
    $blog_layout_option = get_theme_mod( 'blog_layout_option', 'boxed_layout' );
        if($blog_layout_option=='boxed_layout'):
            if(!is_single()){
            $image_wrapper_open='<div class="post-content-wrap clearfix">';
            $image_wrapper_close='</div>';
            $no_border_class='no-border-bottom';
            }
        endif;
    }
endif;

/**
 * Action for Blog content without search conditions to display the_content() to be dispalyed
 *
 * @package Idolcorp
 */
if( !function_exists( 'idolcorp_blog_content_without_search' ) ):
    function idolcorp_blog_content_without_search()
    {
        
        idolcorp_blog_layout($image_wrapper_open,$image_wrapper_close,$no_border_class);
        
         echo $image_wrapper_open;
        if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) :
           
            echo '<figure class="post-featured-image">
                        <a href="'.esc_url(get_the_permalink()).'"  title="'.esc_attr(get_the_title()).'">';
                        the_post_thumbnail();

            echo    '</a>
                        <span class="up-arrow"></span>
                      </figure>';
        endif;

                                           
       echo '<div class="entry-content '.$no_border_class.'">';
       the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'idolcorp' ) );
       wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'idolcorp' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                    echo '</div><!-- .entry-content -->';
                    echo $image_wrapper_close;
                    
    }
endif;

/**
 * Action for Blog content with search , archive and category conditions to display the_excerpt() or the_content() to be dispalyed
 *
 * @package Idolcorp
 */
if( !function_exists( 'idolcorp_blog_content' ) ):
    function idolcorp_blog_content()
    {
        
        idolcorp_blog_layout($image_wrapper_open,$image_wrapper_close,$no_border_class);
        echo $image_wrapper_open;
        if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) :
           
            echo '<figure class="post-featured-image">
                        <a href="'.esc_url(get_the_permalink()).'"  title="'.esc_attr(get_the_title()).'">';
                        the_post_thumbnail();

            echo    '</a>
                        <span class="up-arrow"></span>
                      </figure>';
        endif;
            if (is_archive() ||  is_search() ||is_category() ) : // Only display Excerpts for Search 
                        echo '<div class="entry-summary">';
                        the_excerpt();
                        echo '<p><a href="'.esc_url( get_permalink() ).'" class="read">'. __( 'Continue reading &raquo;', 'idolcorp' ).'</a></p>';
                        echo '</div><!-- .entry-summary -->'.
                      $image_wrapper_close;
                    else : 
                                           
                    echo '<div class="entry-content '.$no_border_class.'">';
                    the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'idolcorp' ) );
                    //echo '<p><a href="'.esc_url( get_permalink() ).'" class="read">'. __( 'Continue reading &raquo;', 'idolcorp' ).'</a></p>';
                    wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'idolcorp' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                    echo '</div><!-- .entry-content -->';
                    echo $image_wrapper_close;
                    endif;
                    
    }
    
endif;


/**
 * Manage the header title for all page, post,archive, tag,category 
 *
 * @package Idolcorp
 */
if( !function_exists( 'idolcorp_header_title' ) ):
function idolcorp_header_title()
{
    if(!is_front_page()) {
        if(!is_page_template( 'page-templates/home-page.php' )):
            ob_start();
            if ( get_header_image() ) :
            echo '<div class="page-title-wrap" style="background-image:url('.esc_url( get_header_image() ).');">';
            else:
            echo '<div class="page-title-wrap">';
            endif;
            echo '<div class="container">';
            idolcorp_all_title('<h1 class="page-title">','</h1>');
            idolcorp_archive_description( '<div class="taxonomy-description">', '</div>' );           
            if( get_theme_mod( 'breadcrumb_option', 'show' ) == 'show' && !is_front_page() ) {
                idolcorp_breadcrumbs();
            }
                    
            echo '</div>
            </div>';
        endif;

         } 
         $content=ob_get_contents();
         return $content;
}
add_action('idolcorp_header_title','idolcorp_header_title');
endif;


/**
 * Generate the slider for the home page template from customizer category
 *
 * @package Idolcorp
 */

if( !function_exists( 'idolcorp_homepage_slider' ) ):
function idolcorp_homepage_slider()
{
    $content='';
  // Get any existing copy of our transient data
if ( false === ( $content = get_transient( 'idolcorp_home_slider_transient' ) ) ) {
    ob_start();
    echo '<section class="idolcorp-home-section" id="section-slider"><div class="idolcorp-slider-wrapper" id="homepage-slider">';
        $slider_category = get_theme_mod( 'slider_category', '' );
        if( !empty( $slider_category ) && $slider_category !='0' ) {
            $slider_args = array(
                            'post_type' => 'post',
                            'cat' => $slider_category,
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'order'=>'DESC'   
                            );
            $slider_query = new WP_Query( $slider_args );
            if( $slider_query->have_posts() ) {
                echo '<ul class="bx-slider">';
                while( $slider_query->have_posts() ) {
                    $slider_query->the_post();
                    $image_id = get_post_thumbnail_id();
                    $image_path = wp_get_attachment_image_src( $image_id, 'idolcorp-full-width', true );
                    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    if( has_post_thumbnail() ) {
   
                echo '<li class="slider">
                    <div class="slide-image">
                        <figure><img src="'.esc_url( $image_path[0] ).'" alt="'. esc_attr( $image_alt ).'" /></figure>
                    </div>
                    <div class="mt-container">
                        <div class="slider-container">
                            <div class="entry-container-description">
                                <h3 class="slider-title">
                                <a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'">'.esc_attr(get_the_title()).'</a>
                                </h3>
                                <div class="slider-content">';
                                the_content();
                                echo '</div>
                                 <div class="clearfix"></div>';
                            if(get_theme_mod( 'slider_readmore_option', 'hide' )=='show'):
                             echo '<a class="atag-button homeslider-read-more-button" href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'">';
                             _e( 'Read More', 'idolcorp' );
                             echo '</a>';
                            endif;
                            echo '</div>
                        </div>
                    </div>
                    </li>';
    
                    }
                }
            }
            wp_reset_query();
            echo '</ul>';
        }
    
    echo '</div></section>';
    $content=ob_get_contents();
    set_transient( 'idolcorp_home_slider_transient', $content);
            }
    else {
    echo $content;
    $content=ob_get_contents();
    }
    return $content;
}

add_action('idolcorp_slider','idolcorp_homepage_slider');
endif;

/**
* Generate Call to Action hook for home template
*
* @package Idolcorp
*/
if( !function_exists( 'call_to_action' ) ):
function call_to_action()
{
      // Get any existing copy of our transient data
if ( false === ( $content = get_transient( 'idolcorp_home_call_action_one' ) ) ) {
    ob_start();
    echo '<!-- section call to action -->';
       if( get_theme_mod( 'call_to_action_option', 'enable' ) == 'enable' ) {
        $default_call_background=get_template_directory_uri().'/images/call_to_action-1.jpg';
        $call_action_background_image=esc_url(get_theme_mod('call_action_background_image',$default_call_background));
         echo '<div class="widget widget-promotional-bar">
              <div class="promotional-bar-content" style="background-image:url('.$call_action_background_image.');">
                <div class="container">
                  <h1 class="promotional-bar-title" id="protitle_1">'.esc_attr(get_theme_mod('call_to_section_title','Introducing Best Simple Theme')).'</h1>
                  <hr>
                  <article><p id="promotional_text">'.esc_attr(get_theme_mod('call_to_action_text','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text')).'</p></article>';
                  if(get_theme_mod('call_to_action_learnmore','enable')=='enable'):
                  echo '<a href="'.esc_url(get_theme_mod('call_to_section_url','http://idolcorp.themeidol.com')).'" target="_self" class="read-more-button" id="promotional_link" title="'.esc_attr__( 'Learn More', 'idolcorp' ).'">'.__( 'Learn More', 'idolcorp' ).'</a>';
                  endif;
                echo '</div>
              </div>
            </div>';
         }
    $content=ob_get_contents();
    set_transient( 'idolcorp_home_call_action_one', $content);
    }
    else {
    echo $content;
    $content=ob_get_contents();
    }
    return $content;

}
add_action('call_to_action','call_to_action');
endif;


/**
* Generate second Call to Action  lower section before testimonial hook
*
* @package Idolcorp
*/
if( !function_exists( 'call_to_action_below' ) ):
function call_to_action_below()
{
          // Get any existing copy of our transient data
if ( false === ( $content = get_transient( 'idolcorp_home_call_action_two' ) ) ) {
    ob_start();
    echo '<!-- section call to action -->';
       if( get_theme_mod( 'call_to_action_2_option', 'enable' ) == 'enable' ) {
        $default_call_background=get_template_directory_uri().'/images/call_to_action-2.jpg';
        $call_action_2_background_image=esc_url(get_theme_mod('call_action_2_background_image',$default_call_background));
         echo '<div class="widget widget-promotional-bar">
              <div class="promotional-bar-content" style="background-image:url('.$call_action_2_background_image.');">
                <div class="container">
                  <h1 class="promotional-bar-title" id="protitle_2">'.esc_attr(get_theme_mod('call_to_2_section_title','Theme Idol\'s First WordPress Theme')).'</h1>
                  <hr>
                  <article><p id="promotional_text_2">'.esc_attr(get_theme_mod('call_to_2_action_text','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text')).'</p></article>
                </div>
              </div>
            </div>';
         }
    $content=ob_get_contents();
    set_transient( 'idolcorp_home_call_action_two', $content);
    }
    else {
    echo $content;
    $content=ob_get_contents();
    }
    return $content;

}
add_action('call_to_action_below','call_to_action_below');
endif;


/**
 * Generate the Testimonials slider for the home page template
 *
 * @package Idolcorp
 */

if( !function_exists( 'idolcorp_homepage_testimonials' ) ):
function idolcorp_homepage_testimonials()
{
$content='';
$testi_category = get_theme_mod( 'testimonials_category', '' );
 if( !empty( $testi_category ) && $testi_category != '0' ) {
        // Get any existing copy of our transient data
if ( false === ( $content = get_transient( 'idolcorp_home_testimonials_transient' ) ) ) {
    ob_start();
            echo '<div class="widget widget-testimonial">
              <div class="container">
                <div class="widget-title-wrap" id="testimonials_section_title">
                  <h2 class="widget-title" >'. esc_attr( get_theme_mod( 'testimonials_section_title', 'Happy Clients' ) ).'</h2>
                  <div class="widget-title-border">
                    <span class="fa-star"></span>
                  </div>
               </div>
                <div class="testimonial-content clearfix" id="testimonials-slider">';
                        

                                $testi_args = array(
                                                'post_type' => 'post',
                                                'cat' => $testi_category,
                                                'post_status'=>'publish',
                                                'posts_per_page' => -1,
                                                'order' => 'DESC'
                                                );
                                $testi_query = new WP_Query( $testi_args );
                                if( $testi_query->have_posts() ) {
                                    echo '<ul class="bx-slider">';
                                    while( $testi_query->have_posts() ) {
                                        $testi_query->the_post();
                                        $image_id = get_post_thumbnail_id();
                                        $image_path = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
                                        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        
            echo '<li class="single-testi-wrapper clearfix">
                    <div class="testi-content-wrapper">
                  <div class="testimonial-author">';
                    if( has_post_thumbnail() ) {
                        echo '<figure>
                            <img src="'.esc_url( $image_path[0] ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_attr(get_the_title()).'" />
                        </figure>';
                     }
                     else
                     {
                        $default_avatar=get_template_directory_uri().'/images/noimage-120x150.png';
                        echo '<figure>
                            <img src="'.esc_url( $default_avatar ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_attr(get_the_title()).'" />
                        </figure>';
                     }
                    echo '<div class="slogan author-name">'.esc_attr(get_the_title()).'</div>
                   
                  </div>
                      <div class="testimonial-text-content">
                        <p class="testimonial-icon">
                          <span class="fa fa-quote-left"></span>
                        </p>
                        <article class="testimonial-text">';
                        the_content();
                        echo '</article>
                        
                      </div>
                    </div>
                </li>';
                       
                                    }
                                    echo '</ul>';
                                }
                                wp_reset_query();
                            
                        
              echo '</div>
            </div>';
            $content=ob_get_contents();
            set_transient( 'idolcorp_home_testimonials_transient', $content);
            }
    else {
    echo $content;
    $content=ob_get_contents();
    }
    }
    return $content;
           
}
add_action('idolcorp_testimonials','idolcorp_homepage_testimonials');
endif;

/**
 * Generate the Services section for the home page template
 *
 * @package Idolcorp
 */

if( !function_exists( 'idolcorp_homepage_services' ) ):
function idolcorp_homepage_services()
{
 $content='';
$service_category = get_theme_mod( 'service_category', '0' );
if( !empty( $service_category ) && $service_category != '0' ) {
    // Get any existing copy of our transient data
if ( false === ( $content = get_transient( 'idolcorp_home_services_transient' ) ) ) {
    ob_start();
        echo '<div class="widget widget-service">
              <div class="container">
                <div class="widget-title-wrap" id="service_section_title">
                  <h2 class="widget-title" >'.esc_attr( get_theme_mod( 'service_section_title', 'Our Services' ) ).'</h2>
                  <div class="widget-title-border">
                    <span class="fa-star"></span>
                  </div>
               </div>';
               
                $service_category = get_theme_mod( 'service_category', '0' );
                $service_column = get_theme_mod( 'idolcorp_services_column', 'three_column' );
                $numberof_posts=($service_column=='three_column')?3:4;
                $columnClass=($service_column=='three_column')?'col-sm-4':'col-sm-3';
               
                echo '<div class="row">';
                    
                        $services_args = array(
                                            'post_type' => 'post',
                                            'cat' => $service_category,
                                            'post_status' => 'publish',
                                            'posts_per_page' => $numberof_posts,
                                            'order' => 'DESC'
                                            );
                        $services_query = new WP_Query( $services_args );
                        if( $services_query->have_posts() ) { 
                            while( $services_query->have_posts() ) {
                                $services_query->the_post();
                                $image_id = get_post_thumbnail_id();
                                $image_path = wp_get_attachment_image_src( $image_id, 'thumbnail', true );
                                $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    
                  echo '<div class="'.$columnClass.'">
                    <div class="service-icon">';
                         if( has_post_thumbnail() ){ 
                                echo '<figure><img src="'.esc_url( $image_path[0] ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_attr(get_the_title()).'" /></figure>';
                            } 
                        else
                        {
                            $default_image=get_template_directory_uri().'/images/noimage-120x120.png';
                            echo '<figure><img src="'.esc_url( $default_image ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_attr(get_the_title()).'" />
                            </figure>'; 
                        }
                    echo '</div>
                    <h3 class="service-title">';
                    the_title();
                    echo '</h3>
                   <article>
                      <p>'.idolcorp_featured_excerpt().'</p>
                   </article>
                   <div class="post-readmore"><a href="'.esc_url(get_the_permalink()).'">';
                    _e( 'Read More', 'idolcorp' );
                    echo '</a></div>
                  </div>';
                 
                            }
                        }
                        wp_reset_query();
                    
                echo '</div>';
                 
              echo '</div>
            </div>';
            $content=ob_get_contents();
            set_transient( 'idolcorp_home_services_transient', $content);
        }
    else {
    echo $content;
    $content=ob_get_contents();
    }
    }
    return $content;
    
}
add_action('idolcorp_services','idolcorp_homepage_services');

endif;

/**
 * Generate the Blog section for the home page template
 *
 * @package Idolcorp
 */

if( !function_exists( 'idolcorp_homepage_blog' ) ):
function idolcorp_homepage_blog()
{
    $content='';
    // Get any existing copy of our transient data
     $blog_category = get_theme_mod( 'latest_blog_category', '' );
     if( !empty( $blog_category ) && $blog_category != '0' ) {
if ( false === ( $content = get_transient( 'idolcorp_home_blog_transient' ) ) ) {
    ob_start();
        echo '<div class="widget widget-featured-section">
              <div class="container">
                <div class="widget-title-wrap">
                  <h2 class="widget-title" id="features_title">'.esc_attr( get_theme_mod( 'latest_blog_title', 'Our Features' ) ).'</h2>
                  <div class="widget-title-border">
                    <span class="fa-star"></span>
                  </div>
                </div>
                <div class="row">';
                $blog_column = get_theme_mod( 'idolcorp_blog_column', 'four_column' );
                $numberof_posts=($blog_column=='four_column')?4:3;
                $columnClass=($blog_column=='four_column')?'col-sm-3':'col-sm-4';
                    
                        $blog_args = array(
                                        'post_type' => 'post',
                                        'cat' => $blog_category,
                                        'post_status' => 'publish',
                                        'posts_per_page' => $numberof_posts,
                                        'order' => 'DESC'
                                        );
                        $blog_query = new WP_Query( $blog_args );
                        if( $blog_query->have_posts() ) {
                            while( $blog_query->have_posts() ) {
                                $blog_query->the_post();
                                $image_id = get_post_thumbnail_id();
                                $image_path = wp_get_attachment_image_src( $image_id, 'idolcorp-ourfeatures-thumb', true );
                                $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                                 $post_classes = array('featured-work');
    
                
                  echo '<div class="'.$columnClass.'">';
                    echo '<div id="post-'.get_the_ID().'"'; echo " "; post_class($post_classes);echo '>';
                    echo '<h3 class="featured-title entry-title">
                        <a href="'.esc_url(get_the_permalink()).'">';
                        the_title();
                        echo '</a>
                    </h3>';
                    if( has_post_thumbnail() ){ 
                        echo '<figure class="featured-image-section">
                            <a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'">
                                <img src="'.esc_url( $image_path[0] ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_url(get_the_title()).'" />
                            </a>
                        </figure>';
                    }
                    else
                    {
                        $default_image=get_template_directory_uri().'/images/noimage-263x170.png';
                        echo '<figure class="featured-image-section">
                        <a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'">
                            <img src="'.esc_url( $default_image ).'" alt="'.esc_attr( $image_alt ).'" title="'.esc_attr(get_the_title()).'" />
                        </a>
                        </figure>'; 
                    }
                      echo '<article class="featured-text-content">'.idolcorp_featured_excerpt().'</article>
                    </div>
                  </div>';
                 
                            }
                        }
                        wp_reset_query();
                    
                


                echo '</div>';
                
                if( !empty( $blog_category ) && $blog_category != '0' ) {
                echo '<a href="'.esc_url( get_category_link($blog_category) ).'" target="_self" class="read-more-button features-read-more"  title="'. esc_attr__( 'View All', 'idolcorp' ).'">'.__( 'View All', 'idolcorp' ).'</a>';
               } 
              echo '</div>
            </div>';
    $content=ob_get_contents();
    set_transient( 'idolcorp_home_blog_transient', $content);
    }
    else {
    echo $content;
    $content=ob_get_contents();
    }
}
    return $content;

}
add_action('idolcorp_blog','idolcorp_homepage_blog');

endif;


/**
 * Generate generated.css file with Custom css provided in the customizer by using the theme customizer property of custom css
 * This functions also deletes all the transient related to customizer property
 * delete_transient('idolcorp_home_slider_transient');
 * delete_transient('idolcorp_home_testimonials_transient');
 * delete_transient('idolcorp_home_services_transient');
 * delete_transient('idolcorp_home_blog_transient');
 * delete_transient('idolcorp_home_call_action_one');
 * delete_transient('idolcorp_home_call_action_two');
 * delete_transient('idolcorp_top_header_transient');
 *
 * @package Idolcorp
 */

if( !function_exists( 'idolcorp_generate_options_css' ) ):

function idolcorp_generate_options_css( $wp_customize )
    {
            //Delete Transient for all home page category in change in customizer 
            delete_transient('idolcorp_home_slider_transient');
            delete_transient('idolcorp_home_testimonials_transient');
            delete_transient('idolcorp_home_services_transient');
            delete_transient('idolcorp_home_blog_transient');

            //Delete transient for Call a Action
            delete_transient('idolcorp_home_call_action_one');
            delete_transient('idolcorp_home_call_action_two');
            delete_transient('idolcorp_top_header_transient');

        $css_dir = get_stylesheet_directory() . '/css/';
        $css_php_dir = get_template_directory() . '/css/';
        
        $custom = '';
               
        if (get_theme_mod('idolcorp_custom_css') != "" ) {
        
        $idolcorp_custom_css = get_theme_mod( 'idolcorp_custom_css', '' );
        $custom .= esc_attr($idolcorp_custom_css);
        }

        if(get_theme_mod('slider_caption_option','hide')=='hide' )
        {
            $custom .='@media only screen and (max-width: 479px) {#homepage-slider .entry-container-description{display:none !important}}';

        }
        
        // WP Filsystem to update generated.css in css file with all custom css
        global $wp_filesystem;
        WP_Filesystem();
        if ( ! $wp_filesystem->put_contents( $css_dir . 'generated.css', $custom, 0644 ) ) {
            return true;
        }
        
    }

    // Action to be called after customizer save action is called
    add_action('customize_save_after','idolcorp_generate_options_css');
endif;



/**
* When enqueuing Google fonts, there are five things to consider:
*
* Is the font enqueued instead of included directly in the template files or CSS?
* Is the font enqueued on the correct hook?
* Is the font URL protocol independent?
* Can translators deactivate the font if their language’s character set isn’t supported?
* Can the font be dequeued by child themes?
*
*
* @link https://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
*
* @package Idolcorp
*/

if( !function_exists( 'idolcorp_fonts_url' ) ):
    function idolcorp_fonts_url() {
        $fonts_url = '';
         
        /* Translators: If there are characters in your language that are not
        * supported by Roboto, translate this to 'off'. Do not translate
        * into your own language.
        */
        $Roboto = _x( 'on', 'Roboto font: on or off', 'idolcorp' );
                 
        if ( 'off' !== $Roboto ) {
        $font_families[] = 'Roboto:400,300,500,700,900';
        }
         
        
         
        $query_args = array(
        'family' =>urlencode( implode( '|', $font_families ) )
        );
         
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        
         
        return esc_url_raw( $fonts_url );
    }
endif;