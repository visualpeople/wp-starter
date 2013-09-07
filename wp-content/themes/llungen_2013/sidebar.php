<?php
/**
 * Sidebar
 *
 * Content for our sidebar, provides prompt for logged in users to create widgets
 *
 * @package WordPress
 * @subpackage llungen_2013
 * @since Llungen Lures 2013
 */
?>

<!-- Sidebar -->
<aside class="large-3 columns sidebar">

<?php if ( dynamic_sidebar('Sidebar Right') ) : elseif( current_user_can( 'edit_theme_options' ) ) : ?>

	<h5><?php _e( 'No widgets found.', 'foundaton' ); ?></h5>
	<p><?php printf( __( 'It seems you don\'t have any widgets in your sidebar! Would you like to %s now?', 'foundation' ), '<a href=" '. get_admin_url( '', 'widgets.php' ) .' ">populate your sidebar</a>' ); ?></p>

<?php endif; ?>

</aside>
<!-- End Sidebar -->