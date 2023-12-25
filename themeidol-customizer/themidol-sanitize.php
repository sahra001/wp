<?php
/**
 * Sanitization and definitions 
 * 
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
 
    /**
    * Text Sanitization
    */
    function idolcorp_sanitize_text( $input ) {
        return wp_kses_post( force_balance_tags( $input ) );
    }
    
    /**
    * Email Sanitization
    */
    function idolcorp_sanitize_email( $input ) {
        return sanitize_email( $input );
    }
    
    /**
    * Checkboxes
    */
    function idolcorp_sanitize_checkbox( $input ) {
        if ( $input == 1 ) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
    * Sanitize URL
    */
    function idolcorp_sanitize_url( $input )
    {
        return esc_url_raw( $input );
    }

    
    /**
    * site layout
    */
    function idolcorp_sanitize_site_layout($input) {
        $valid_keys = array(
            'wide_layout' => __( 'Wide Layout', 'idolcorp' ),
            'boxed_layout' => __( 'Boxed Layout', 'idolcorp' )
            );
        if ( array_key_exists( $input, $valid_keys ) ) {
            return $input;
        } else {
            return '';
        }
   }
   
   /**
   * Show/Hide  control
   */
    function idolcorp_sanitize_show_hide($input) {
        $valid_keys = array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            );
        if ( array_key_exists( $input, $valid_keys ) ) {
            return $input;
        } else {
            return '';
        }
   }

   /**
   * Enable/Disable  control
   */
    function idolcorp_sanitize_enable_disable($input) {
        $valid_keys = array(
                'enable'     => __( 'Enable', 'idolcorp' ),
                'disable'   => __( 'Disable', 'idolcorp' ),
            );
        if ( array_key_exists( $input, $valid_keys ) ) {
            return $input;
        } else {
            return '';
        }
   }
   
   /**
   * Slider  pager Show /hide sanitization
   */

    function idolcorp_sanitize_slider_pager($input) {
        $valid_keys = array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            );
        if ( array_key_exists( $input, $valid_keys ) ) {
            return $input;
        } else {
            return '';
        }
   }
   
   /**
   * Slider  transaction Sanitization
   */
    function idolcorp_sanitize_slider_transaction($input) {
        $valid_keys = array(
                'auto'     => __( 'Auto', 'idolcorp' ),
                'manual'   => __( 'Manual', 'idolcorp' ),
            );
        if ( array_key_exists( $input, $valid_keys ) ) {
            return $input;
        } else {
            return '';
        }
   }
   
   /**
   * Slider  description Sanitization
   */
    function idolcorp_sanitize_slider_description($input) {
        $valid_keys = array(
                'show'     => __( 'Show', 'idolcorp' ),
                'hide'   => __( 'Hide', 'idolcorp' ),
            );
        if ( array_key_exists( $input, $valid_keys ) ) {
            return $input;
        } else {
            return '';
        }
   }
   
     
   /**
   * Design layout for post/page/archvie
   */
    function idolcorp_layout_sanitize($input) {
         global $finalImageDirectory;

   	$valid_keys = array(
         'right_sidebar' => $finalImageDirectory . '2cr.png',
			'left_sidebar' => $finalImageDirectory . '2cl.png',
			'no_sidebar_full_width'	=> $finalImageDirectory . '1col.png'
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }

      /**
   * Design column for blog/service and footer
   */
    function idolcorp_column_sanitize($input) {
         global $finalImageDirectory;

    $valid_keys = array(
      'three_column' => $finalImageDirectory . '3column.png',
      'four_column' => $finalImageDirectory . '4column.png'
      );
      if ( array_key_exists( $input, $valid_keys ) ) {
         return $input;
      } else {
         return '';
      }
   }
  

    /**
    * Sanitize the blank option and false value
    */
    function false_value($value) {
        return $value;
    }    
    add_filter('__return_false', 'false_value');