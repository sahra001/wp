/**
 * Idolcorp Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
 $=jQuery;
( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {

			$( '.site-description' ).html( to );
		} );
	} );
	//disclaimer title
	
	wp.customize( 'idolcorp_disclaimer_section_title', function( value ) {
		value.bind( function( to ) {
			$( '.disclaimer-site-title a' ).html( to );
		} );
	} );
	//header_search_option
	wp.customize( 'header_search_option', function( value ) {
		value.bind( function( to ) {
			if(to){
			if($('.search-toggle').length){
			$('.search-toggle').show();
			} else {
			$('.search-container').append('<div class="fa-search search-toggle"></div>');
			 }
			 } else{
			 	//remove fa search icon div.
			$('.search-toggle').hide();
			}
		    
			
	} );
		} );

	
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
    
    // Service Section Title
	wp.customize( 'service_section_title', function( value ) {
		value.bind( function( to ) {
			$( '#service_section_title > h2.widget-title' ).html( to );
		} );
		} );
	// Testimonial Section Title
	
	wp.customize( 'testimonials_section_title', function( value ) {
		value.bind( function( to ) {
			$( '#testimonials_section_title > h2.widget-title' ).html( to );
		} );
		} );


		// Call To Action Section Title
	wp.customize( 'call_to_section_title', function( value ) {
		value.bind( function( to ) {
			$( '#protitle_1' ).html( to );
		} );
		} );
			// Call To Action Section Text
	wp.customize( 'call_to_action_text', function( value ) {
		value.bind( function( to ) {
			$( '#promotional_text' ).text( to );
		} );
		} );

		wp.customize( 'call_to_2_section_title', function( value ) {
		value.bind( function( to ) {
			$( '#protitle_2' ).html( to );
		} );
		} );
			// Call To Action Section Text
	wp.customize( 'call_to_action_2_text', function( value ) {
		value.bind( function( to ) {
			$( '#promotional_text_2' ).text( to );
		} );
		} );
		wp.customize( 'call_to_section_url', function( value ) {
		value.bind( function( to ) {
			$( '#promotional_link' ).attr('href', to );
		} );
		} );

		//Features section title
	wp.customize( 'latest_blog_title', function( value ) {
		value.bind( function( to ) {
			$( '#features_title' ).html( to );
		} );
		} );

	//Phone Number Section
	wp.customize( 'top_header_phone', function( value ) {
		value.bind( function( to ) {
			$( '.caller a' ).html( to );
		} );
		} );

} )( jQuery );


