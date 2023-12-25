<?php
/**
 * The sidebar containing the secondary widget area in the left side
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */

?>
<?php
        if( is_page_template( 'page-templates/contact-page.php' ) ) {
			$sidebar = 'contact_page_sidebar';
			$layout='contact';
		} else {
			$sidebar = 'idolcorp_left_sidebar';
			$layout='secondary';
		}
if ( is_active_sidebar( $sidebar ) ) : ?>
 <?php echo idolcorp_custom_layout_class_and_structure($layout);?>
		<?php dynamic_sidebar( $sidebar ); ?>
	</div><!-- #primary-sidebar -->
<?php endif;?>