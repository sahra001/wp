<?php
/**
 * Idolcorp Theme Customizer
 *
 * @package Idolcorp
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
class themeidol_customizer
{
    public function __construct()
    {
        global $finalImageDirectory;
        add_action( 'customize_preview_init', array(&$this, 'themeidol_customize_preview_js' ),9);

        add_action( 'customize_register', array(&$this, 'themeidol_customize_manager' ));

        $imageDirectory = '/themeidol-customizer/images/';
            $imageDirectoryInc = '/inc/themeidol-customizer/images/';

            $finalImageDirectory = '';

            if(is_dir(get_stylesheet_directory().$imageDirectory))
            {
                $finalImageDirectory = get_stylesheet_directory_uri().$imageDirectory;
            }

            if(is_dir(get_stylesheet_directory().$imageDirectoryInc))
            {
                $finalImageDirectory = get_stylesheet_directory_uri().$imageDirectoryInc;
            }
    }

    /**
 * This outputs the javascript needed to automate the live settings preview.
 * Also keep in mind that this function isn't necessary unless your settings 
 * are using 'transport'=>'postMessage' instead of the default 'transport'
 * => 'refresh'
 * 
 * Used by hook: 'customize_preview_init'
 */

   
/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Idolcorp 1.0
 */
    public static function themeidol_customize_preview_js() {
        $themeidol_theme = wp_get_theme();
        $version = $themeidol_theme->get( 'Version' );

        wp_enqueue_script( 'idolcorp-customizer', get_stylesheet_directory_uri() . '/themeidol-customizer/js/theme-customizer.js', array( 'jquery','customize-preview' ), $version, true );
        
    }



    /**
     * Idolcorp Customizer manager 
     * @param  WP_Customizer_Manager $wp_manager
     * @return void
     */
    public function themeidol_customize_manager( $wp_manager )
    {
        

        $this->themeidol_theme_description_section( $wp_manager );
        $this->themidol_design_customizer( $wp_manager );
        $this->themeidol_general_settings_register( $wp_manager );
        $this->themeidol_header_settings_register( $wp_manager );
        $this->themeidol_homepage_settings_register( $wp_manager );
        $this->themeidol_footer_settings_register( $wp_manager );
       
        
    }

    private function themeidol_theme_description_section($wp_manager)
    {

    global $finalImageDirectory;

    // Theme specific notes
    $wp_manager->add_section( 'idolcorp_theme_notes' , array(
        'title'      =>'Idolcorp Theme Notes',
        'description' => sprintf( __( 'Welcome & thank you for choosing idolcorp a theme by themeidol as your site theme. In this section you\'ll find some helpful hints and tips to help you configure your site quickly and easily.
        <b><br/><a href="%1$s" target="_blank" >View Theme Demo</a> | <a href="%2$s" target="_blank" >Get Theme Support</a> ', 'idolcorp' ),  esc_url('http://idolcorp.themeidol.com/'), esc_url('http://themeidol.com/submit-ticket/') ),
        'priority'       => 36,
    ) );

    // Theme Notes section
    $wp_manager->add_setting( 'idolcorp_theme_notice', array(
        'sanitize_callback' => 'idolcorp_sanitize_text' //Note: Since WordPress 4.0, input type 'hidden' is supported implicitly as variations of the 'text' input type hence the sanitization callback used! 
    ));

  $wp_manager->add_control(
    'idolcorp_theme_notice',
    array(
        'section' => 'idolcorp_theme_notes',
        'type' => 'hidden',
    ));

    }

    /**
     * A section to show how you use the Design customizer controls in WordPress
     *
     * @param  Obj $wp_customize - WP Customizer
     *
     * @return Void
     */
    private function themidol_design_customizer($wp_customize)
    {
        global $finalImageDirectory;
    $wp_customize->add_panel( 
        'idolcorp_design_panel', 
        array(
            'priority'       => 37,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Design Settings', 'idolcorp'),
            ) 
    );


    $wp_customize->get_section( 'colors' )->panel = 'idolcorp_design_panel';
    $wp_customize->get_section( 'colors' )->priority = '3';

  /**
   * Archive Page sidebar
   */
   $wp_customize->add_section(
        'idolcorp_archive_sidebar_section',
        array(
            'title'         => __('Archive Sidebar', 'idolcorp'),
            'priority'      => 3,
            'panel'         => 'idolcorp_design_panel'
        )
    );
   
   // Archive Default layout
    $wp_customize->add_setting(
        'idolcorp_archive_sidebar', 
        array(
            'default' => 'right_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'idolcorp_layout_sanitize'
           )
    );

    $wp_customize->add_control( new Layout_Picker_Themeidol_Control(
        $wp_customize, 
        'idolcorp_archive_sidebar', 
        array(
            'type' => 'radio',
            'label' => __( 'Available layouts', 'idolcorp' ),
            'description' => __( 'Select layout for whole site archives, categories, search page etc.', 'idolcorp' ),
            'section' => 'idolcorp_archive_sidebar_section',
            'priority'       => 3,
            'choices' => array(
                    'right_sidebar' => $finalImageDirectory . '2cr.png',
                    'left_sidebar' => $finalImageDirectory . '2cl.png',
                    'no_sidebar_full_width' => $finalImageDirectory . '1col.png',
                )
           )
        )
    );


    
    
/*--------------------------------------------------------------------------------------------------------*/
  /**
   * Page sidebar
   */
   $wp_customize->add_section(
        'idolcorp_page_sidebar_section',
        array(
            'title'         => __('Page Sidebar', 'idolcorp'),
            'priority'      => 4,
            'panel'         => 'idolcorp_design_panel'
        )
    );
   
   // Archive Default layout
    $wp_customize->add_setting(
        'idolcorp_default_page_sidebar', 
        array(
            'default' => 'right_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'idolcorp_layout_sanitize'
           )
    );

    $wp_customize->add_control( new Layout_Picker_Themeidol_Control(
        $wp_customize, 
        'idolcorp_default_page_sidebar', 
        array(
            'type' => 'radio',
            'label' => __( 'Available layouts', 'idolcorp' ),
            'description' => __( 'Select layout for all pages unless unique layout is set for specific page.', 'idolcorp' ),
            'section' => 'idolcorp_page_sidebar_section',
            'priority'       => 3,
            'choices' => array(
                    'right_sidebar' => $finalImageDirectory . '2cr.png',
                    'left_sidebar' => $finalImageDirectory . '2cl.png',
                    'no_sidebar_full_width' => $finalImageDirectory . '1col.png',
                )
           )
        )
    );
/*--------------------------------------------------------------------------------------------------------*/
  /**
   * Post sidebar
   */
   $wp_customize->add_section(
        'idolcorp_post_sidebar_section',
        array(
            'title'         => __('Post Sidebar', 'idolcorp'),
            'priority'      => 5,
            'panel'         => 'idolcorp_design_panel'
        )
    );
   
   // Archive Default layout
    $wp_customize->add_setting(
        'idolcorp_default_single_posts_sidebar', 
        array(
            'default' => 'right_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'idolcorp_layout_sanitize'
           )
    );

    $wp_customize->add_control( new Layout_Picker_Themeidol_Control(
        $wp_customize, 
        'idolcorp_default_single_posts_sidebar', 
        array(
            'type' => 'radio',
            'label' => __( 'Available layouts', 'idolcorp' ),
            'description' => __( 'Select layout for all posts unless unique layout is set for specific page.', 'idolcorp' ),
            'section' => 'idolcorp_post_sidebar_section',
            'priority'       => 3,
            'choices' => array(
                    'right_sidebar' => $finalImageDirectory . '2cr.png',
                    'left_sidebar' => $finalImageDirectory . '2cl.png',
                    'no_sidebar_full_width' => $finalImageDirectory . '1col.png',
                )
           )
        )
    );
/*--------------------------------------------------------------------------------------------------------*/
  /**
   * Breadcrumbs 
   */
   $wp_customize->add_section(
        'idolcorp_bredcrumbs_settings',
        array(
            'title'         => __( 'Breadcrumbs', 'idolcorp' ),
            'priority'      => 6,
            'panel'         => 'idolcorp_design_panel'
        )
    );
     
    // Breadcrumbes option
    $wp_customize->add_setting(
        'breadcrumb_option',
        array(
            'default' =>'show',
            'sanitize_callback' => 'idolcorp_sanitize_show_hide',
        )
    );
    $wp_customize->add_control(
        'breadcrumb_option',
        array(
            'type' => 'radio',
            'priority'    => 3,
            'label' => __( 'Breadcrumbs Option', 'idolcorp' ),
            'description' => __( 'Choose option to show/hide breadcrumbs in inner pages/posts', 'idolcorp' ),
            'section' => 'idolcorp_bredcrumbs_settings',
            'choices' => array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' )
            )
        )
    );
    /*--------------------------------------------------------------------------------------------------------*/
 /**
  * Customm design
  */
 
 $wp_customize->add_section(
        'idolcorp_blog_design',
        array(
            'title'         => __( 'Blog Setting', 'idolcorp' ),
            'description'   => __('Select option for blog listing wide layout and boxed layout', 'idolcorp'),
            'priority'      => 7,
            'panel'         => 'idolcorp_design_panel'
        )
    );

     $wp_customize->add_setting(
        'blog_layout_option',
        array(
            'default'           => 'boxed_layout',
            'sanitize_callback' => 'idolcorp_sanitize_site_layout',
        )       
    );
    $wp_customize->add_control(
        'blog_layout_option',
        array(
            'type' => 'radio',
            'priority'    => 7,
            'label' => __( 'Site Layout', 'idolcorp' ),
            'section' => 'idolcorp_blog_design',
            'choices' => array(
                'wide_layout' => __( 'Wide Layout', 'idolcorp' ),
                'boxed_layout' => __( 'Boxed Layout', 'idolcorp' )
            ),
        )
    );
/*--------------------------------------------------------------------------------------------------------*/
 /**
  * Customm design
  */
 
 $wp_customize->add_section(
        'idolcorp_custom_design',
        array(
            'title'         => __( 'Custom Design', 'idolcorp' ),
            'priority'      => 8,
            'panel'         => 'idolcorp_design_panel'
        )
    );
     
    // Custom CSS option
    $wp_customize->add_setting(
        'idolcorp_custom_css',
        array(
            'default' =>'',
            'sanitize_callback' => 'idolcorp_sanitize_text',
        )
    );
    $wp_customize->add_control( new Textarea_Custom_Control(
        $wp_customize,
        'idolcorp_custom_css',
            array(
                'label' => __( 'Custom css', 'idolcorp' ),
                'priority' => 5,
                'section' => 'idolcorp_custom_design'
                )
        )
    ); 

    /**
     * Top Header Section
     */
    $wp_customize->add_section(
        'idolcorp_nicescroll_bar',
        array(
            'title'         => __('Scroll Bar Setting', 'idolcorp'),
            'priority'      => 9,
            'panel'         => 'idolcorp_design_panel'
        )
    );

    // Nice Scroll Bar Settings
    $wp_customize->add_setting(
        'idolcorp_nicescroll_bar_option',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'idolcorp_nicescroll_bar_option', 
            array(
                'type' => 'switch',
                'priority'  => 6,
                'label' => __( 'Nice Scroll Bar', 'idolcorp' ),
                'description' => __( 'Enable/Disable option for Nice scroll bar.', 'idolcorp' ),
                'section' => 'idolcorp_nicescroll_bar',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );

     // Scroll Bar Cursor Color
       $wp_customize->add_setting(
        'idolcorp_nicescroll_cursorcolor',
        array(
            'default'           => '#4d4d4d',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'idolcorp_nicescroll_cursorcolor',
            array(
                'label'         => __('Cursor color', 'idolcorp'),
                'section'       => 'idolcorp_nicescroll_bar',
                'settings'      => 'idolcorp_nicescroll_cursorcolor',
                'priority'      => 7
            )
        )
    );


     // Scroll Bar Cursor Border Width

    $wp_customize->add_setting( 
        'idolcorp_nicescroll_cursorborder', 
         array(
            'default' => 0,
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => '',
            'sanitize_callback' => 'intval',
                ) 
         );

$wp_customize->add_control( 
    'idolcorp_nicescroll_cursorborder',
             array(
            'type' => 'range',
            'priority' => 7,
            'section' => 'idolcorp_nicescroll_bar',
            'label' => __( 'Cursor Border', 'idolcorp' ),
            'description' => '',
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'class' => 'example-class',
                'style' => 'color: #0a0',
            ),
        ) );
//Scroll Bar Cursor width 
    $wp_customize->add_setting( 
        'idolcorp_nicescroll_cursorwidth', 
         array(
            'default' => 7,
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => '',
            'sanitize_callback' => 'intval',
                ) 
         );

$wp_customize->add_control( 
    'idolcorp_nicescroll_cursorwidth',
             array(
            'type' => 'range',
            'priority' => 8,
            'section' => 'idolcorp_nicescroll_bar',
            'label' => __( 'Cursor Width', 'idolcorp' ),
            'description' => '',
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'class' => 'example-class',
                'style' => 'color: #0a0',
            ),
        ) );



           if ( $wp_customize->is_preview() && !is_admin() ) {
            add_action( 'wp_footer', array(&$this,'preview'), 21 );
        }
    
    }

    // Adds a snippet that will add faster previews via ajax
function preview() { ?>
    <script>
        ( function ( $ ) {
            var $Idolcorpcss = $('header').find('#Generatedcss');
            
                        if ( !$Idolcorpcss.length ) {
                $('head').append( '<style id="Generatedcss"></style>' );
                $Idolcorpcss = $('head').find('#Generatedcss');
            }
            wp.customize( 'idolcorp_custom_css', function ( setval ) {
                       setval.bind( function ( opt ) {
                    //Use default CSS value if option is empty
                    $Idolcorpcss.text( opt );
                });
            });
            
        } ) ( jQuery );
    </script>
    <?php 
}

     /**
     * A section to show how you use the General customizer controls in WordPress
     *
     * @param  Obj $wp_customize - WP Customizer
     *
     * @return Void
     */
    private function themeidol_general_settings_register( $wp_customize ) {
    
    $wp_customize->get_section( 'title_tagline' )->panel = 'idolcorp_general_settings_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = '3';
    $wp_customize->get_section( 'background_image' )->panel = 'idolcorp_general_settings_panel';
    $wp_customize->get_section( 'background_image' )->priority = '4';
    $wp_customize->get_section( 'static_front_page' )->panel = 'idolcorp_general_settings_panel';
    $wp_customize->get_section( 'static_front_page' )->priority = '5';
    
    /**
     * Add General Settings Panel 
     */
    $wp_customize->add_panel( 
        'idolcorp_general_settings_panel', 
        array(
            'priority'       => 38,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('General Settings', 'idolcorp'),
            ) 
        );
/*======================================================================================================================*/
    /**
     * Website layout
     */
    
    $wp_customize->add_section(
        'idolcorp_site_layout',
        array(
            'title'         => __('Website Layout', 'idolcorp'),
            'description'   => __('Choose site layout which shows your website more effective.', 'idolcorp'),
            'priority'      => 5,
            'panel'         => 'idolcorp_general_settings_panel',
        )
    );
    
    $wp_customize->add_setting(
        'site_layout_option',
        array(
            'default'           => 'boxed_layout',
            'sanitize_callback' => 'idolcorp_sanitize_site_layout',
        )       
    );
    $wp_customize->add_control(
        'site_layout_option',
        array(
            'type' => 'radio',
            'priority'    => 7,
            'label' => __( 'Site Layout', 'idolcorp' ),
            'section' => 'idolcorp_site_layout',
            'choices' => array(
                'wide_layout' => __( 'Wide Layout', 'idolcorp' ),
                'boxed_layout' => __( 'Boxed Layout', 'idolcorp' )
            ),
        )
    );

    /**
     * Website layout
     */
    
    $wp_customize->add_section(
        'idolcorp_excerpt_Settings',
        array(
            'title'         => __('Excerpt Settings', 'idolcorp'),
            'description'   => __('Provide the Excerpt lenght for Blog Page.', 'idolcorp'),
            'priority'      => 6,
            'panel'         => 'idolcorp_general_settings_panel',
        )
    );

     // Feed Excerpt Length
    $wp_customize->add_setting(
        'idolcorp_feed_excerpt_length', 
        array(
              'default' => '85',
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'idolcorp_sanitize_text',
            )
    );
   $wp_customize->add_control(
        'idolcorp_feed_excerpt_length', 
        array(
              'type' => 'text',
              'label' => __('Feed/Blog Excerpt Length', 'idolcorp'),
              'section' => 'idolcorp_excerpt_Settings',
              'priority'      => 1
            )
   );
 }
     /**
     * A section to show how you use the Header customizer controls in WordPress
     *
     * @param  Obj $wp_customize - WP Customizer
     *
     * @return Void
     */

 private function themeidol_header_settings_register( $wp_customize ) {
    
    $wp_customize->get_section( 'header_image' )->panel = 'idolcorp_header_panel';
    $wp_customize->get_section( 'header_image' )->priority = '13';
    $wp_customize->get_section( 'header_image' )->title =  __('Header Section', 'idolcorp');
   
    $wp_customize->add_panel( 
        'idolcorp_header_panel', 
        array(
            'priority'       => 13,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Homepage Settings', 'idolcorp'),
            ) 
    );
    $wp_customize->add_panel( 
        'idolcorp_header_panel', 
        array(
            'priority'       => 39,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Header Settings', 'idolcorp'),
            ) 
    );

        
    /*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Top Header Section
     */
    $wp_customize->add_section(
        'idolcorp_top_header',
        array(
            'title'         => __('Top Header Section', 'idolcorp'),
            'priority'      => 3,
            'panel'         => 'idolcorp_header_panel'
        )
    );

        // Top Header Switch Option
    $wp_customize->add_setting(
        'top_header_option',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'top_header_option', 
            array(
                'type' => 'switch',
                'priority'  => 2,
                'label' => __( 'Top Header', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display top header section.', 'idolcorp' ),
                'section' => 'idolcorp_top_header',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );
         
   //Top Header info
   $wp_customize->add_setting(
        'top_header_section_info', 
        array(
              'capability' => 'edit_theme_options',
              'sanitize_callback' => 'sanitize_text_field'
            )
    );
    $wp_customize->add_control( 
        new themidol_custom_info_section( 
        $wp_customize,
        'top_header_section_info', 
        array(
            'type' => 'section_info',
            'label' => __( 'Top Header Elements', 'idolcorp' ),
            'description' => __( 'Add your contact number to display at top header section as contact info.', 'idolcorp' ),
            'section' => 'idolcorp_top_header',
            'priority' => 2
            )
        )
    );
     
   // Contact number field
    $wp_customize->add_setting(
        'top_header_phone', 
        array(
              'default' => __( '167-157-5987', 'idolcorp' ),
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'idolcorp_sanitize_text',
            )
    );
   $wp_customize->add_control(
        'top_header_phone', 
        array(
              'type' => 'text',
              'label' => __('Top Header Contact', 'idolcorp'),
              'section' => 'idolcorp_top_header',
              'priority'      => 3
            )
   );
   
   //Top Header info right side
   $wp_customize->add_setting(
        'top_header_section_info_social', 
        array(
              'capability' => 'edit_theme_options',
              'sanitize_callback' => 'sanitize_text_field'
            )
    );
    $wp_customize->add_control( 
        new themidol_custom_info_section( 
        $wp_customize,
        'top_header_section_info_social', 
        array(
            'type' => 'section_info',
            'label' => __( 'Top Header Social Links', 'idolcorp' ),
            'description' => __( 'Add your social link to display at top header section as social icons.', 'idolcorp' ),
            'section' => 'idolcorp_top_header',
            'priority' => 4
            )
        )
    );
    
    //Add Facebook Link
    $wp_customize->add_setting(
        'social_fb_link',
        array(
            'default' => __( 'https://facebook.com/', 'idolcorp' ),
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
            )
    );
    $wp_customize->add_control(
        'social_fb_link',
        array(
            'type' => 'text',
            'priority' => 5,
            'label' => __( 'Facebook', 'idolcorp' ),
            'section' => 'idolcorp_top_header'
            )
    );
    
    //Add twitter Link
    $wp_customize->add_setting(
        'social_tw_link',
        array(
            'default' => __( 'https://twitter.com/', 'idolcorp' ),
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
            )
    );
    $wp_customize->add_control(
        'social_tw_link',
        array(
            'type' => 'text',
            'priority' => 6,
            'label' => __( 'Twitter', 'idolcorp' ),
            'section' => 'idolcorp_top_header'
            )
    );
    
    //Add google plus Link
    $wp_customize->add_setting(
        'social_gp_link',
        array(
            'default' => __( 'https://plus.google.com/', 'idolcorp' ),
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
            )
    );
    $wp_customize->add_control(
        'social_gp_link',
        array(
            'type' => 'text',
            'priority' => 7,
            'label' => __( 'Google Plus', 'idolcorp' ),
            'section' => 'idolcorp_top_header'
            )
    );
    
    //Add LinkedIn Link
    $wp_customize->add_setting(
        'social_lnk_link',
        array(
            'default' => __( 'https://linkedin.com/', 'idolcorp' ),
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
            )
    );
    $wp_customize->add_control(
        'social_lnk_link',
        array(
            'type' => 'text',
            'priority' => 8,
            'label' => __( 'LinkedIn', 'idolcorp' ),
            'section' => 'idolcorp_top_header'
            )
    );
    
    //Add youtube Link
    $wp_customize->add_setting(
        'social_yt_link',
        array(
            'default' => __( 'https://youtube.com/', 'idolcorp' ),
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
            )
    );
    $wp_customize->add_control(
        'social_yt_link',
        array(
            'type' => 'text',
            'priority' => 9,
            'label' => __( 'YouTube', 'idolcorp' ),
            'section' => 'idolcorp_top_header'
            )
    );
    
    //Add vimeo Link
    $wp_customize->add_setting(
        'social_vm_link',
        array(
            'default' => __( 'https://vimeo.com/', 'idolcorp' ),
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
            )
    );
    $wp_customize->add_control(
        'social_vm_link',
        array(
            'type' => 'text',
            'priority' => 10,
            'label' => __( 'Vimeo', 'idolcorp' ),
            'section' => 'idolcorp_top_header'
            )
    );
/*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Header Style
     */

    
    // Search icon Option
    $wp_customize->add_setting(
        'header_search_option', 
        array(
              'default' =>1,
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'idolcorp_sanitize_checkbox'
            )
    );
   $wp_customize->add_control(
        'header_search_option', 
        array(
              'type' => 'checkbox',
              'label' => __( 'Search Icon Option', 'idolcorp' ),
              'description' => __( 'Checked to show/add search icon at primary menu section.', 'idolcorp' ),
              'section' => 'header_image',
              'priority'      => 3
            )
   );
   
    
}
    /**
     * A section to show how you use the Home Page customizer controls in WordPress
     *
     * @param  Obj $wp_customize - WP Customize
     *
     * @return Void
     */
    private function themeidol_homepage_settings_register( $wp_customize ) {
    global $finalImageDirectory;
    $wp_customize->add_panel( 
        'idolcorp_homepage_panel', 
        array(
            'priority'       => 39,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Homepage Settings', 'idolcorp'),
            ) 
    );
    
/*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Homepage Slider Section
     */
    $wp_customize->add_section(
        'idolcorp_slider_section',
        array(
            'title'         => __('Slider Settings', 'idolcorp'),
            'priority'      => 3,
            'panel'         => 'idolcorp_homepage_panel'
        )
    );
    
    // Slider category
    $wp_customize->add_setting(
        'slider_category',
        array(
            'default' => '0',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'false_value'
        )
    );
    $wp_customize->add_control( 
        new Category_Dropdown_Themeidol_Control( 
        $wp_customize,
        'slider_category', 
        array(
            'label' => __( "Slider's Category", 'idolcorp' ),
            'description' => __( "Select cateogry for Homepage slider", "idolcorp" ),
            'section' => 'idolcorp_slider_section',
            'priority' => 3
            )
        )
    );
    
    // Slider control
    $wp_customize->add_setting(
        'slider_control_option',
        array(
            'default' =>'hide',
            'sanitize_callback' => 'idolcorp_sanitize_show_hide',
        )
    );
    $wp_customize->add_control(
        'slider_control_option',
        array(
            'type' => 'radio',
            'priority'    => 4,
            'label' => __( 'Slider Control', 'idolcorp' ),
            'description' => __( 'Choose option to show/hide slider control at homepage.', 'idolcorp' ),
            'section' => 'idolcorp_slider_section',
            'choices' => array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            ),
        )
    );
    
    // Slider Pager
    $wp_customize->add_setting(
        'slider_pager_option',
        array(
            'default' =>'show',
            'sanitize_callback' => 'idolcorp_sanitize_slider_pager',
        )
    );
    $wp_customize->add_control(
        'slider_pager_option',
        array(
            'type' => 'radio',
            'priority'    => 5,
            'label' => __( 'Slider Pager', 'idolcorp' ),
            'description' => __( 'Choose option to show/hide slider pager at homepage.', 'idolcorp' ),
            'section' => 'idolcorp_slider_section',
            'choices' => array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            ),
        )
    );
    
    // Slider Transaction
    $wp_customize->add_setting(
        'slider_transaction_option',
        array(
            'default' =>'auto',
            'sanitize_callback' => 'idolcorp_sanitize_slider_transaction',
        )
    );
    $wp_customize->add_control(
        'slider_transaction_option',
        array(
            'type' => 'radio',
            'priority'    => 6,
            'label' => __( 'Slider Transaction', 'idolcorp' ),
            'description' => __( "Choose option about slide's auto/manual transaction at homepage.", 'idolcorp' ),
            'section' => 'idolcorp_slider_section',
            'choices' => array(
                'auto'     => __( 'Auto', 'idolcorp' ),
                'manual'   => __( 'Manual', 'idolcorp' ),
            ),
        )
    );

     // Slider control for mobile to show hide caption
    $wp_customize->add_setting(
        'slider_caption_option',
        array(
            'default' =>'hide',
            'sanitize_callback' => 'idolcorp_sanitize_show_hide',
        )
    );
    $wp_customize->add_control(
        'slider_caption_option',
        array(
            'type' => 'radio',
            'priority'    => 7,
            'label' => __( 'Slider Caption Control', 'idolcorp' ),
            'description' => __( 'Choose option to show/hide slider Caption at homepage in mobile.', 'idolcorp' ),
            'section' => 'idolcorp_slider_section',
            'choices' => array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            ),
        )
    );


    // Slider control
    $wp_customize->add_setting(
        'slider_readmore_option',
        array(
            'default' =>'hide',
            'sanitize_callback' => 'idolcorp_sanitize_show_hide',
        )
    );
    $wp_customize->add_control(
        'slider_readmore_option',
        array(
            'type' => 'radio',
            'priority'    => 8,
            'label' => __( 'Slider Read More Option', 'idolcorp' ),
            'description' => __( 'Choose option to show/hide Read More Botton at homepage.', 'idolcorp' ),
            'section' => 'idolcorp_slider_section',
            'choices' => array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            ),
        )
    );
    // Range control
    $wp_customize->add_setting(
        'slider_speed_option',
        array(
            'default' =>'hide',
            'sanitize_callback' => 'idolcorp_sanitize_text',
        )
    );

    $wp_customize->add_control( 'slider_speed_option', array(
    'type'        => 'range',
    'priority'    => 9,
    'section'     => 'idolcorp_slider_section',
    'label'       => __( 'Slider Speed Option', 'idolcorp' ),
    'description' => __( 'Slider Speed control Option Min 500 and Max 1500', 'idolcorp' ),
    'input_attrs' => array(
        'min'   => 500,
        'max'   => 1500,
        'step'  => 100,
        'class' => 'test-class test',
        'style' => 'color: #0a0',
    ),
    ) );        
   
/*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Homepage service Section
     */
    $wp_customize->add_section(
        'idolcorp_service_section',
        array(
            'title'         => __('Service Settings', 'idolcorp'),
            'priority'      => 4,
            'panel'         => 'idolcorp_homepage_panel'
        )
    );
    
    //Switch section
    $wp_customize->add_setting(
        'service_section_control',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'service_section_control', 
            array(
                'type' => 'switch',
                'priority'  => 2,
                'label' => __( 'Section Conrol', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display Our Service section at home page.', 'idolcorp' ),
                'section' => 'idolcorp_service_section',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );

    //Service section title
    $wp_customize->add_setting(
        'service_section_title', 
            array(
                'default' => __( 'Our Services', 'idolcorp' ),
                'sanitize_callback' => 'idolcorp_sanitize_text',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'service_section_title',
            array(
            'type' => 'text',
            'label' => __( 'Service Section Title', 'idolcorp' ),
            'descrption' => __( 'Add title for Service section.', 'idolcorp' ),
            'section' => 'idolcorp_service_section',
            'priority' => 3
            )
    );
    
    // Service category
    $wp_customize->add_setting(
        'service_category',
        array(
            'default' => '0',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'false_value'
        )
    );
    $wp_customize->add_control( 
        new Category_Dropdown_Themeidol_Control( 
        $wp_customize,
        'service_category', 
        array(
            'label' => __( "Service Category", 'idolcorp' ),
            'description' => __( "Select cateogry for Homepage's Service section", "idolcorp" ),
            'section' => 'idolcorp_service_section',
            'priority' => 4
            )
        )
    );

    // Default Column
    $wp_customize->add_setting(
        'idolcorp_services_column', 
        array(
            'default' => 'three_column',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'idolcorp_column_sanitize'
           )
    );

    $wp_customize->add_control( new Column_Picker_Themeidol_Control(
        $wp_customize, 
        'idolcorp_services_column', 
        array(
            'type' => 'radio',
            'label' => __( 'Available layouts', 'idolcorp' ),
            'description' => __( 'Select Column for Service Section', 'idolcorp' ),
            'section' => 'idolcorp_service_section',
            'priority'       => 5,
            'choices' => array(
                    'three_column' => $finalImageDirectory . '3column.png',
                    'four_column' => $finalImageDirectory . '4column.png'
                )
           )
        )
    );

  
/*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Homepage Call to action Section
     */
    $wp_customize->add_section(
        'idolcorp_call_to_action_section',
        array(
            'title'         => __('Call to Action', 'idolcorp'),
            'priority'      => 5,
            'panel'         => 'idolcorp_homepage_panel'
        )
    );
    // Section display option
    //Switch section
    $wp_customize->add_setting(
        'call_to_action_option',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'call_to_action_option', 
            array(
                'type' => 'switch',
                'priority'  => 2,
                'label' => __( 'Section Conrol', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display Call to action section at home page.', 'idolcorp' ),
                'section' => 'idolcorp_call_to_action_section',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );

      // WP_Customize_Image_Control
     $default_call_background=get_template_directory_uri().'/images/call_to_action-1.jpg';
        $wp_customize->add_setting( 'call_action_background_image', array(
            'default'        => $default_call_background,
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'call_action_background_image', array(
            'label'   => __( 'Background Image Setting','idolcorp'),
            'section' => 'idolcorp_call_to_action_section',
            'settings'   => 'call_action_background_image',
            'priority' => 4
        ) ) );

    //Call in action section title
    $wp_customize->add_setting(
        'call_to_section_title', 
            array(
                'default' => __( 'Introducing Best Simple Theme', 'idolcorp' ),
                'sanitize_callback' => 'idolcorp_sanitize_text',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'call_to_section_title',
            array(
            'type' => 'text',
            'label' => __( 'Section Title', 'idolcorp' ),
            'descrption' => __( 'Add title for Call To Action section.', 'idolcorp' ),
            'section' => 'idolcorp_call_to_action_section',
            'priority' => 5
    ));

    // Add a textarea control
        $wp_customize->add_setting( 'call_to_action_text', array(
            'default'        => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text',
            'sanitize_callback' => 'idolcorp_sanitize_text',
        ) );
        $wp_customize->add_control( new Textarea_Custom_Control( $wp_customize, 'call_to_action_text', array(
            'label'   => __('Call To Action Description','idolcorp'),
            'section' => 'idolcorp_call_to_action_section',
            'settings'   => 'call_to_action_text',
            'priority' => 6
        ) ) );

        // Call in action for custom url

         $wp_customize->add_setting(
        'call_to_section_url', 
            array(
                'default' => 'http://idolcorp.themeidol.com/',
                'sanitize_callback' => 'idolcorp_sanitize_url',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'call_to_section_url',
            array(
            'type' => 'text',
            'label' => __( 'Call in action URI', 'idolcorp' ),
            'descrption' => __( 'Add URI for Call To Action section.', 'idolcorp' ),
            'section' => 'idolcorp_call_to_action_section',
            'priority' => 5
    ));
    // Section display option
    //Switch section
    $wp_customize->add_setting(
        'call_to_action_learnmore',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'call_to_action_learnmore', 
            array(
                'type' => 'switch',
                'priority'  => 6,
                'label' => __( 'Section Conrol', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display Call to action section Read More Botton', 'idolcorp' ),
                'section' => 'idolcorp_call_to_action_section',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );


/*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Latest blog section
     */
    $wp_customize->add_section(
        'idolcorp_latest_blog_section',
        array(
            'title'         => __('Our Features', 'idolcorp'),
            'priority'      => 6,
            'panel'         => 'idolcorp_homepage_panel'
        )
    );
    
    //Switch section
    $wp_customize->add_setting(
        'blog_section_control',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'blog_section_control', 
            array(
                'type' => 'switch',
                'priority'  => 3,
                'label' => __( 'Section Conrol', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display latest blog section at home page.', 'idolcorp' ),
                'section' => 'idolcorp_latest_blog_section',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );
    
    //Latest Blog section title
    $wp_customize->add_setting(
        'latest_blog_title', 
            array(
                'default' => __( 'Our Features', 'idolcorp' ),
                'sanitize_callback' => 'idolcorp_sanitize_text',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'latest_blog_title',
            array(
            'type' => 'text',
            'label' => __( 'Section Title', 'idolcorp' ),
            'descrption' => __( 'Add title for latest blog section.', 'idolcorp' ),
            'section' => 'idolcorp_latest_blog_section',
            'priority' => 4
            )
    );
    
    // Latest Blog category
    $wp_customize->add_setting(
        'latest_blog_category',
        array(
            'default' => '0',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'false_value'
        )
    );
    $wp_customize->add_control( 
        new Category_Dropdown_Themeidol_Control( 
        $wp_customize,
        'latest_blog_category', 
        array(
            'label' => __( 'Our Features', 'idolcorp' ),
            'description' => __( "Select cateogry for Our Features posts.", "idolcorp" ),
            'section' => 'idolcorp_latest_blog_section',
            'priority' => 5
            )
        )
    );
    // Archive Default Column
    $wp_customize->add_setting(
        'idolcorp_blog_column', 
        array(
            'default' => 'four_column',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'idolcorp_column_sanitize'
           )
    );

    $wp_customize->add_control( new Column_Picker_Themeidol_Control(
        $wp_customize, 
        'idolcorp_blog_column', 
        array(
            'type' => 'radio',
            'label' => __( 'Available layouts', 'idolcorp' ),
            'description' => __( 'Select Column for Service Section', 'idolcorp' ),
            'section' => 'idolcorp_latest_blog_section',
            'priority'       => 6,
            'choices' => array(
                    'three_column' => $finalImageDirectory . '3column.png',
                    'four_column' => $finalImageDirectory . '4column.png'
                )
           )
        )
    );


  
/*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Homepage Call to action Section
     */
    $wp_customize->add_section(
        'idolcorp_call_to_action_2_section',
        array(
            'title'         => __('Call to Action', 'idolcorp'),
            'priority'      => 7,
            'panel'         => 'idolcorp_homepage_panel'
        )
    );
    // Section display option
    //Switch section
    $wp_customize->add_setting(
        'call_to_action_2_option',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'call_to_action_2_option', 
            array(
                'type' => 'switch',
                'priority'  => 2,
                'label' => __( 'Section Conrol', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display Call to action section at home page.', 'idolcorp' ),
                'section' => 'idolcorp_call_to_action_2_section',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );

      // WP_Customize_Image_Control
     $default_call_background=get_template_directory_uri().'/images/call_to_action-2.jpg';
        $wp_customize->add_setting( 'call_action_2_background_image', array(
            'default'        => $default_call_background,
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'call_action_2_background_image', array(
            'label'   => __( 'Background Image Setting','idolcorp'),
            'section' => 'idolcorp_call_to_action_2_section',
            'settings'   => 'call_action_2_background_image',
            'priority' => 4
        ) ) );

    //Call in action section title
    $wp_customize->add_setting(
        'call_to_2_section_title', 
            array(
                'default' => __( 'Theme Idol\'s First WordPress Theme', 'idolcorp' ),
                'sanitize_callback' => 'idolcorp_sanitize_text',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'call_to_2_section_title',
            array(
            'type' => 'text',
            'label' => __( 'Section Title', 'idolcorp' ),
            'descrption' => __( 'Add title for Call To Action section.', 'idolcorp' ),
            'section' => 'idolcorp_call_to_action_2_section',
            'priority' => 5
    ));

    // Add a textarea control
        $wp_customize->add_setting( 'call_to_2_action_text', array(
            'default'        => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text',
            'sanitize_callback' => 'idolcorp_sanitize_text',
        ) );
        $wp_customize->add_control( new Textarea_Custom_Control( $wp_customize, 'call_to_action_2_text', array(
            'label'   => __('Call To Action Description','idolcorp'),
            'section' => 'idolcorp_call_to_action_2_section',
            'settings'   => 'call_to_2_action_text',
            'priority' => 6
        ) ) );

 
    /*----------------------------------------------------------------------------------------------------------------------*/
    /**
     * Homepage About and Testimonials section
     */
    $wp_customize->add_section(
        'idolcorp_testi_section',
        array(
            'title'         => __('Testimonals', 'idolcorp'),
            'priority'      => 8,
            'panel'         => 'idolcorp_homepage_panel'
        )
    );

       //Top Header info
   $wp_customize->add_setting(
        'testimonials_section_info', 
        array(
              'capability' => 'edit_theme_options',
              'sanitize_callback' => 'sanitize_text_field'
            )
    );
    $wp_customize->add_control( 
        new themidol_custom_info_section( 
        $wp_customize,
        'testimonials_section_info', 
        array(
            'type' => 'section_info',
            'label' => __( 'Testimonials Section', 'idolcorp' ),
            'description' => __( 'Set the testimoinals section.', 'idolcorp' ),
            'section' => 'idolcorp_testi_section',
            'priority' => 1
            )
        )
    );
    
    //Switch section
    $wp_customize->add_setting(
        'testi_section_control',
        array(
            'default' => 'enable',
            'sanitize_callback' => 'idolcorp_sanitize_enable_disable'
            )
    );
     $wp_customize->add_control( new Themeidol_Customize_Switch_Control(
        $wp_customize, 
            'testi_section_control', 
            array(
                'type' => 'switch',
                'priority'  => 2,
                'label' => __( 'Section Conrol', 'idolcorp' ),
                'description' => __( 'Enable/Disable option to display Testimonilas section at home page.', 'idolcorp' ),
                'section' => 'idolcorp_testi_section',
                'choices'   => array(
                    'enable' => __( 'Enable', 'idolcorp' ),
                    'disable' => __( 'Disable', 'idolcorp' ),
                    ),
                )
        )
    );
    
 
    
    //Testimonilas section title
    $wp_customize->add_setting(
        'testimonials_section_title', 
            array(
                'default' => __( 'Happy Clients', 'idolcorp' ),
                'sanitize_callback' => 'idolcorp_sanitize_text',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'testimonials_section_title',
            array(
            'type' => 'text',
            'label' => __( 'Section Title', 'idolcorp' ),
            'descrption' => __( 'Add title for tesimonials section.', 'idolcorp' ),
            'section' => 'idolcorp_testi_section',
            'priority' => 3
            )
    );
    
    // Testimonials category
    $wp_customize->add_setting(
        'testimonials_category',
        array(
            'default' => '0',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'false_value'
        )
    );
    $wp_customize->add_control( 
        new Category_Dropdown_Themeidol_Control( 
        $wp_customize,
        'testimonials_category', 
        array(
            'label' => __( "Testimonials Category", 'idolcorp' ),
            'description' => __( "Select cateogry for testimonials posts.", "idolcorp" ),
            'section' => 'idolcorp_testi_section',
            'priority' => 4
            )
        )
    );
   

        
    
  
}

    /**
     * A section to show how you use the Footer customizer controls in WordPress
     *
     * @param  Obj $wp_customize - WP Customize
     *
     * @return Void
     */
private function themeidol_footer_settings_register( $wp_customize )
{
    global $finalImageDirectory;
     $wp_customize->add_panel( 
        'idolcorp_footer_panel', 
        array(
            'priority'       => 41,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Footer Settings', 'idolcorp'),
            ) 
    ); 

     /**
     * Disclaimer Section
     */
    $wp_customize->add_section(
        'idolcorp_disclaimer_section',
        array(
            'title'         => __('Disclaimer Settings', 'idolcorp'),
            'description' => __( 'Disclaimer Details on footer', 'idolcorp' ),
            'priority'      => 1,
            'panel'         => 'idolcorp_footer_panel'
        )
    );

     //Disclaimer section title
    $wp_customize->add_setting(
        'idolcorp_disclaimer_section_title', 
            array(
                'default' => __( 'Idol Corporate', 'idolcorp' ),
                'sanitize_callback' => 'idolcorp_sanitize_text',
                'transport' => 'postMessage'
           )
    );    
    $wp_customize->add_control(
        'idolcorp_disclaimer_section_title',
            array(
            'type' => 'text',
            'label' => __( 'Disclaimers title', 'idolcorp' ),
            'descrption' => __( 'Add title for Disclaimers.', 'idolcorp' ),
            'section' => 'idolcorp_disclaimer_section',
            'priority' => 1
            )
    );



    /**
     * Copyright Section
     */
    $wp_customize->add_section(
        'idolcorp_copyright_section',
        array(
            'title'         => __('Copyright Settings', 'idolcorp'),
            'description' => __( 'Copyright Settings goes here. Here the legends are as follows @@DATE@@=Current Year and @@BLOG@@=Blog Title. Dynamically blog title and date are generated', 'idolcorp' ),
            'priority'      => 2,
            'panel'         => 'idolcorp_footer_panel'
        )
    );

         //Copyright section Details
    $wp_customize->add_setting(
        'idolcorp_copyright_section_title',
        array(
            'default' =>'@@DATE@@ @@BLOG@@ , All rights reserved',
            'sanitize_callback' => 'idolcorp_sanitize_text',
            'transport' => 'postMessage'
        )
    );
    $wp_customize->add_control( new Textarea_Custom_Control(
        $wp_customize,
        'idolcorp_copyright_section_title',
            array(
                'label' => __( 'Copyright Text', 'idolcorp' ),
                'priority' => 1,
                'section' => 'idolcorp_copyright_section'
                )
        )
    );
    /**
     * Footer Column Section
     */
    $wp_customize->add_section(
        'idolcorp_footercolumn_section',
        array(
            'title'         => __('Column Settings', 'idolcorp'),
            'description' => __( 'Footer Column Settings goes here. Here the legends are as follows @@DATE@@=Current Year and @@BLOG@@=Blog Title. Dynamically blog title and date are generated', 'idolcorp' ),
            'priority'      => 3,
            'panel'         => 'idolcorp_footer_panel'
        )
    );
    // Default Column
    $wp_customize->add_setting(
        'idolcorp_footer_column', 
        array(
            'default' => 'four_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'idolcorp_column_sanitize'
           )
    );



    $wp_customize->add_control( new Column_Picker_Themeidol_Control(
        $wp_customize, 
        'idolcorp_footer_column', 
        array(
            'type' => 'radio',
            'label' => __( 'Available layouts', 'idolcorp' ),
            'description' => __( 'Select Column for Service Section', 'idolcorp' ),
            'section' => 'idolcorp_footercolumn_section',
            'priority'       => 1,
            'choices' => array(
                    'three_column' => $finalImageDirectory . '3column.png',
                    'four_column' => $finalImageDirectory . '4column.png'
                )
           )
        )
    );



}
}

new themeidol_customizer();