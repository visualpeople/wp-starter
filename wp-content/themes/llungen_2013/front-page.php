<?php
/**
 * Front Page
 *
 * Loop container for front page content
 *
 * @package WordPress
 * @subpackage llungen_2013
 * @since Llungen Lures 2013
 */

get_header(); ?>
<div class="slideshow-container">
	<div class="row">
	    <!-- Main Content -->
	    <div class="large-12 columns" role="main">
			<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Homepage Main') ) ?>
	    </div><!--/main-->
	</div><!--/row-->
</div><!--/slideshow-container-->
<div class="content-container">
	<div class="row">
	    <div class="large-12 columns carousel">
	    	Carousel images
	    </div><!--/carousel-->
	    <div class="large-10 columns large-centered feature">
	    	<img src="" class="right"/>
	    	<h3>Meet Our Pro Staff:</h3>
	    	<h5>Pro Name</h5>
	    	<p>Proin g ravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra.</p>
	    	<p class="more">See Our Other Pro Staff</p>
	    </div><!--/feature-->
	</div><!-/row -->
</div><!--/content-container-->
<?php get_footer(); ?>