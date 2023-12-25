<?php
/**
 * WordPress Custom Customize Control classes
 *
 * @package Idolcrop
 * @since Idolcrop 1.0
 */

/**
 * Custom Customize Control class.
 *
 * @since Idolcrop 1.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom layout control
 */
class Layout_Picker_Themeidol_Control extends WP_Customize_Control
{
      /**
       * Render the content on the theme customizer page
       */

        public function render_content() {

            if ( empty( $this->choices ) )
                return;

            $name = '_customize-radio-' . $this->id;

            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <ul class="controls" id ="themeidol-img-container">
            <?php
                foreach ( $this->choices as $value => $label ) :
                    $class = ($this->value() == $value)?'themeidol-radio-img-selected themeidol-radio-img-img':'themeidol-radio-img-img';
                    ?>
                    <li style="display: inline;">
                    <label>
                        <input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
                        <img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
                    </label>
                    </li>
                    <?php
                endforeach;
            ?>
            </ul>
            <?php
        }
    }
    /**
 * Class to create a custom Column control
 */
class Column_Picker_Themeidol_Control extends WP_Customize_Control
{
      /**
       * Render the content on the theme customizer page
       */

        public function render_content() {

            if ( empty( $this->choices ) )
                return;

            $name = '_customize-radio-' . $this->id;

            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <ul class="controls" id ="themeidol-img-container">
            <?php
                foreach ( $this->choices as $value => $label ) :
                    $class = ($this->value() == $value)?'themeidol-radio-img-selected themeidol-radio-img-img':'themeidol-radio-img-img';
                    ?>
                    <li style="display: inline;">
                    <label>
                        <input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
                        <img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
                    </label>
                    </li>
                    <?php
                endforeach;
            ?>
            </ul>
            <?php
        }
    }

/**
 * A class to create a dropdown for all categories in your WordPress site
 */
 class Category_Dropdown_Themeidol_Control extends WP_Customize_Control
 {
    private $cats = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->cats = get_categories($options);

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content()
       {
            if(!empty($this->cats))
            {
                ?>
                    <label>
                      <span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>
                      <select <?php $this->link(); ?>>
                           <?php
                                foreach ( $this->cats as $cat )
                                {
                                    printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
                                }
                           ?>
                      </select>
                    </label>
                <?php
            }
       }
 }

 
    /**
     * Class to create a custom post control
     */
    class Themeidol_Post_Dropdown_Custom_Control extends WP_Customize_Control {
        private $posts = false;
        public function __construct($manager, $id, $args = array(), $options = array())
        {
            $postargs = wp_parse_args($options, array('numberposts' => '-1'));
            $this->posts = get_posts($postargs);
            parent::__construct( $manager, $id, $args );
        }
        /**
        * Render the content on the theme customizer page
        */
        public function render_content()
        {
            if(!empty($this->posts))
            {
                ?>
                    <label>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                        <select data-customize-setting-link="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
                            <option value="" <?php if ( get_theme_mod($this->id) == '' ) echo 'selected="selected"'; ?>><?php _e( '--Select Post--', 'idolcorp' ); ?></option>
                        <?php
                            foreach ( $this->posts as $post )
                            {
                                printf('<option value="%s" %s>%s</option>', $post->ID, selected($this->value(), $post->ID, false), $post->post_title);
                            }
                        ?>
                        </select>
                    </label>
                <?php
            }
        }
    }

    
    /**
     * Class to create dropdown menu for select page
     */
    class Themeidol_Customize_Page_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 1.0
         */
        public function render_content() {
            $dropdown = wp_dropdown_pages(
                array(
                    'name'              => '_customize-dropdown-pages-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select Pages &mdash;', 'idolcorp' ),
                    'option_none_value' => '',
                    'selected'          => $this->value(),
                )
            );
 
            // Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span><span class="description customize-control-description">%s</span> %s </label>',
                $this->label,
                $this->description,
                $dropdown
            );
        }
}

    /**
     * Theme info 
     */
     class themidol_custom_info_section extends WP_Customize_Control {
        public $type = 'themidol_custom_info_section';
        public $label = '';
        public function render_content() {
        ?>
            <label class="customize-control-select">
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
            </label>
        <?php
        }
    }

    /**
     * Cutomize control for switch option
     */
    
    class Themeidol_Customize_Switch_Control extends WP_Customize_Control {
        public $type = 'switch';   
    /**
    * Enqueue the styles and scripts
    */
    public function enqueue()
        {
            $themeidol_theme = wp_get_theme();
            $version = $themeidol_theme->get( 'Version' );
           
            /**
            * Add custom css for admin section
            */
            
            wp_enqueue_script( 'themeidol_customizer-custom-admin', get_template_directory_uri() . '/themeidol-customizer/js/admin-custom-scripts.js', array( 'jquery' ), $version, true );
            wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/themeidol-customizer/css/admin-style.css', false, $version );
            wp_enqueue_style( 'custom_wp_admin_css' ); 
        }
        public function render_content() {
          $choises_options = $this->choices;
          $s_count = 0;
        ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <div class="switch_options">
                    <?php foreach( $choises_options as $key=>$value ) { $s_count++; ?>
                      <span id="switch_<?php echo esc_attr( $s_count ); ?>" class="switch_<?php echo esc_attr( $key ); ?>"> <?php echo esc_attr ( $value ); ?> </span>
                    <?php } ?>
                  <input type="hidden" id="enable_switch_option" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
                </div>
            </label>
        <?php
        }
    }
/**
 * Customize for textarea, extend the WP customizer
 *
 */
class Textarea_Custom_Control extends WP_Customize_Control
{
    /**
     * Render the control's content.
     *
     * Allows the content to be overriden without having to rewrite the wrapper.
     *
     * @since   10/16/2012
     * @return  void
     */
    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
                <?php echo esc_textarea( $this->value() ); ?>
            </textarea>
        </label>
        <?php
    }

}

/**
 * In order to allow the upload of favicons in the customizer, is it safe/correct to extend WP_Customize_Image_Control
 *
 */

class Themeidol_Custom_Favicon_Control extends WP_Customize_Image_Control {
    public $extensions = array( 'gif', 'ico', 'png' );
}

/**
 * Class to create a custom menu control
 */
class Themeidol_Menu_Dropdown_Custom_Control extends WP_Customize_Control
{
    private $menus = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->menus = wp_get_nav_menus($options);

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content on the theme customizer page
    */
    public function render_content()
    {
        if(!empty($this->menus))
        {
            ?>
                <label>
                    <span class="customize-menu-dropdown"><?php echo esc_html( $this->label ); ?></span>
                    <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
                    <?php
                        foreach ( $this->menus as $menu )
                        {
                            printf('<option value="%s" %s>%s</option>', $menu->term_id, selected($this->value(), $menu->term_id, false), $menu->name);
                        }
                    ?>
                    </select>
                </label>
            <?php
        }
    }
}