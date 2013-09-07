<?php
/**
 * Footer
 *
 * Displays content shown in the footer section
 *
 * @package WordPress
 * @subpackage llungen_2013
 * @since Llungen Lures 2013
 */
?>

<!-- Footer -->
<div class="footer-container">
	<footer class="row">
<?php if ( !dynamic_sidebar('Sidebar Footer One') || !dynamic_sidebar('Sidebar Footer Two') || !dynamic_sidebar('Sidebar Footer Three') || !dynamic_sidebar('Sidebar Footer Four')  ) : endif; ?>
	</footer>
</div><!--/footer-container-->

<?php wp_footer(); ?>

</body>
</html>