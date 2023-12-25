<?php
/**
 * Class Idolcorp_Contactinfo_Widget . Custom Widget for contact info
 *
 * @package Idolcorp 
 */
class Idolcorp_Contactinfo_Widget extends WP_Widget {

	/**
	 * Array containing the keys for each value of the contact fields
	 */
	public function widget_keys() {
		$widget_keys = apply_filters( 'ic_widget_keys', array(
			'title',
			'detail',
			'phone',
			'email'
			
			)
		);
		return $widget_keys;
	}

	
    
	/**
	 * Register widget with WordPress.
	 * 
	 * @package Idolcorp
	 */
	public function __construct() {
		parent::__construct(
	 		'idolcorp_contactinfo_widget', // Base ID
			'Idolcorp Contact Widget', // Name
			array( 'description' => __( 'A contact info widget', 'idolcorp' ), ) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		
		$widget_output = '<ul class="vcard" itemscope itemtype="http://schema.org/'. $instance['title'] . '">';
			if ( !empty( $instance['detail'] ) )
				$widget_output .= '<li class="fn ' . $title . '" itemprop="detail"><strong>' . $instance['detail'] . '</strong></li>';
			

			if ( !empty( $instance['phone'] ) ) {
				$widget_output .= '<li class="fa-phone tel" itemprop="telephone">';

				global $wp_version;
				if ( version_compare( $wp_version, '3.4', '>=' ) && wp_is_mobile() ) {
				        $widget_output .= '<a href="tel:' . $instance['phone'] . '">' . $instance['phone'] . '</a>';
				}
				else
				    $widget_output .= $instance['phone'];
				$widget_output .= '</li>';
			}
			if ( !empty( $instance['email'] ) ) {
				$widget_output .= '<li class="fa-envelope email" itemprop="email"><a href="mailto:' . antispambot($instance['email']) . '">' . $instance['email'] . '</a></li>';
			}


		$widget_output .= '</ul>';

		$widget_output = apply_filters( 'ic_widget_output', $widget_output, $instance );
		echo $widget_output;
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		foreach ( $this->widget_keys() as $key=>$value ) {
			if ( $old_instance[ $value ] != $new_instance[ $value ] || !array_key_exists($value, $old_instance) ) {
				$new_instance[ $value ] = strip_tags( $new_instance[$value] );
			}
		}
		        
		return $new_instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		foreach ( $this->widget_keys() as $key=>$value ) {
			if ( !array_key_exists( $value, $instance ) && $value == 'title' ) {
				${$value} = __( 'Contact', 'idolcorp' );
			} elseif ( !array_key_exists( $value, $instance ) ) {
				${$value} = '';
			} else {
				${$value} = $instance[ $value ];
			}
		}

		$widget_form_output = '<p>
		<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title :' , 'idolcorp') . '</label> 
		<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '" />
		</p>';
		
		$widget_form_output .= '<p>
			<label for="' . $this->get_field_id( 'detaik' ) . '">' . __( 'Your Detail :', 'idolcorp' ) . '</label>
			<input class="widefat" id="' . $this->get_field_id( 'detail' ). '" name="' . $this->get_field_name( 'detail' ) . '" type="text" value="' . esc_attr( $detail ) . '" />
		</p>';
		
		$widget_form_output .= '<p>
			<label for="' . $this->get_field_id( 'phone' ) . '">' . __( 'Phone number :', 'idolcorp' ) . '</label>
			<input class="widefat" id="' . $this->get_field_id( 'phone' ) . '" name="' . $this->get_field_name( 'phone' ) . '" type="text" value="' . esc_attr( $phone ) . '" />
		</p>';
		$widget_form_output .= '<p>
			<label for="' . $this->get_field_id( 'email' ) . '">' . __( 'Email address :', 'idolcorp' ) . '</label>
			<input class="widefat" id="' . $this->get_field_id( 'email' ) . '" name="' . $this->get_field_name( 'email' ) . '" type="text" value="' . esc_attr( $email ) . '" />
		</p>';
		
		
		$widget_form_output = apply_filters( 'ic_widget_form_output', $widget_form_output, $instance );
		echo $widget_form_output;
	}

} // class Idolcorp_Contactinfo_Widget