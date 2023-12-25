<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 *
 * @package Idolcorp
 * @since Idolcorp 1.0
 */
 if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
 <?php echo idolcorp_custom_layout_class_and_structure('secondary');?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #primary-sidebar-->
<?php endif;?>
