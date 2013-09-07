<?php
/**
 * Content Page
 *
 * Loop content in page template (page.php)
 *
 * @package WordPress
 * @subpackage llungen_2013
 * @since Llungen Lures 2013
 */
?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header>
		<h2><?php the_title(); ?></h2>
	</header>

	<?php if ( has_post_thumbnail()) : ?>
		<a href="<?php the_permalink(); ?>" class="th" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail(); ?></a>
	<?php endif; ?>
	
	<?php the_content(); ?>

</article>