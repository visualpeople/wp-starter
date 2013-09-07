<?php
/**
 * Header
 *
 *
 * @package WordPress
 * @subpackage llungen_2013
 * @since Llungen Lures 2013
 */
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />

<title><?php wp_title(); ?></title>

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<header>
		<div class="row top">
			<div class="large-3 columns logo">
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php $header_image = get_header_image(); if ( ! empty( $header_image ) ) : ?> <img src="<?php echo esc_url( $header_image ); ?>"/> <?php endif; ?></a>
			</div> <!--/logo-->
			<div class="large-9 columns top-nav-left">
				<ul class="toplinks">
					<li class="first">FB Logo</li>
					<li><a href="#">My Cart</a></li>
					<li><a href="#">My Account</a></li>
				</ul>
			</div><!--/top-nav-->
			<div class="large-9 columns main-nav">
				<nav class="top-bar">
					<ul class="title-area">
						<li class="name">&nbsp;</li>
						<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
					</ul>
					<section class="top-bar-section">
						<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'menu_class' => 'left', 'container' => '', 'fallback_cb' => 'foundation_page_menu', 'walker' => new foundation_navigation() ) ); ?>
					</section>
				</nav>
			</div><!--/main-nav-->
		</div><!--/row top-->
	</header>
<!-- Begin Page -->