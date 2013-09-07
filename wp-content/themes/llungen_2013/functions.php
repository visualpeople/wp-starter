<?php

/**
 * Functions
 *
 * Core functionality and initial theme setup
 *
 * @package WordPress
 * @subpackage llungen_2013
 * @since Llungen Lures 2013
 */

/**
 * Initiate Foundation, for WordPress
 */

if ( ! function_exists( 'foundation_setup' ) ) :

function foundation_setup() {

	// Content Width
	if ( ! isset( $content_width ) ) $content_width = 900;

	// Language Translations
	load_theme_textdomain( 'foundation', get_template_directory() . '/languages' );

	// Custom Editor Style Support
	add_editor_style();

	// Support for Featured Images
	add_theme_support( 'post-thumbnails' ); 

	// Automatic Feed Links & Post Formats
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// Custom Background
	add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
	) );

	// Custom Header
	add_theme_support( 'custom-header', array(
		'default-text-color' => '#000',
		'header-text'   => true,
		'height'		=> '200',
		'uploads'       => true,
	) );

}

add_action( 'after_setup_theme', 'foundation_setup' );

endif;

// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
   function all_settings_link() {
    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
   }
   add_action('admin_menu', 'all_settings_link');
   
// REPLACE LOGIN LOGO WITH SITE LOGO

function namespace_login_style() {
    if( function_exists('get_custom_header') ){
        $width = get_custom_header()->width;
        $height = get_custom_header()->height;
    } else {
        $width = HEADER_IMAGE_WIDTH;
        $height = HEADER_IMAGE_HEIGHT;
    }
    echo '<style>'.PHP_EOL;
    echo '.login h1 a {'.PHP_EOL; 
    echo '  background-image: url( '; header_image(); echo ' ) !important; '.PHP_EOL;
    echo '  width: '.$width.'px !important;'.PHP_EOL;
    echo '  height: '.$height.'px !important;'.PHP_EOL;
    echo '  background-size: '.$width.'px '.$height.'px !important;'.PHP_EOL;
    echo '}'.PHP_EOL;
    echo '</style>'.PHP_EOL;
}

// REMOVE THE WORDPRESS UPDATE NOTIFICATION FOR ALL USERS EXCEPT SYSADMIN
       global $user_login;
       get_currentuserinfo();
       if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins 
        add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
        add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
       }

// remove version info from head and feeds
function complete_version_removal() {
    return '';
}
add_filter('the_generator', 'complete_version_removal');

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// spam & delete links for all versions of wordpress
function delete_comment_link($id) {
    if (current_user_can('edit_post')) {
        echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&c='.$id.'">del</a> ';
        echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&dt=spam&c='.$id.'">spam</a>';
    }
}

// Set the post revisions unless the constant was set in wp-config.php

if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 10);


// REMOVE META BOXES FROM DEFAULT POSTS SCREEN
   function remove_default_post_screen_metaboxes() {
 remove_meta_box( 'postcustom','post','normal' ); // Custom Fields Metabox
 remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
 remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Metabox
 remove_meta_box( 'trackbacksdiv','post','normal' ); // Talkback Metabox
// remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
 remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
 }
   add_action('admin_menu','remove_default_post_screen_metaboxes');


// REMOVE META BOXES FROM DEFAULT PAGES SCREEN
   function remove_default_page_screen_metaboxes() {
 remove_meta_box( 'postcustom','page','normal' ); // Custom Fields Metabox
 remove_meta_box( 'postexcerpt','page','normal' ); // Excerpt Metabox
 remove_meta_box( 'commentstatusdiv','page','normal' ); // Comments Metabox
 remove_meta_box( 'trackbacksdiv','page','normal' ); // Talkback Metabox
// remove_meta_box( 'slugdiv','page','normal' ); // Slug Metabox
 remove_meta_box( 'authordiv','page','normal' ); // Author Metabox
 }
   add_action('admin_menu','remove_default_page_screen_metaboxes');
   
// Customize the Dashboard

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
   global $wp_meta_boxes;
   // Disables these:
 //Right Now - Comments, Posts, Pages at a glance
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//Recent Comments
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
//Incoming Links
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
//Plugins - Popular, New and Recently updated Wordpress Plugins
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);

//Wordpress Development Blog Feed
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
//Other Wordpress News Feed
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
//Quick Press Form
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
//Recent Drafts List
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
   // Add Help and Support
   wp_add_dashboard_widget('custom_help_widget', 'Help and Support', 'custom_dashboard_help');
}
function custom_dashboard_help() {
    echo '<p>For Help and Support, contact <a href="mailto:info@visualpeople.com">Visual People Design</a>.<br/>
    Phone: 541-752-9922<br/>
    Evenings or Weekend emergencies, call or text:541-231-2829</p>';
}

//Favicons

// add a favicon to the site
function blog_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico" />';
}
add_action('wp_head', 'blog_favicon');

// add a favicon for your admin
function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.png" />';
}
add_action('admin_head', 'admin_favicon');

//Change the Admin Footer
function remove_footer_admin () {
echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="http://www.visualpeople.com" target="_blank">Visual People</a></p>';
}

add_filter('admin_footer_text', 'remove_footer_admin');

/**
 * Enqueue Scripts and Styles for Front-End
 */

if ( ! function_exists( 'foundation_assets' ) ) :

function foundation_assets() {

	if (!is_admin()) {

		/** 
		 * Deregister jQuery in favour of ZeptoJS
		 * jQuery will be used as a fallback if ZeptoJS is not compatible
		 * @see foundation_compatibility & http://foundation.zurb.com/docs/javascript.html
		 */
		wp_deregister_script('jquery');

		// Load JavaScripts
		wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/foundation.min.js', null, '4.0', true );
		wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/vendor/custom.modernizr.js', null, '2.1.0');
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );

		// Load Stylesheets
		wp_enqueue_style( 'foundation', get_template_directory_uri().'/css/foundation.min.css' );
		wp_enqueue_style( 'app', get_stylesheet_uri(), array('foundation') );

		// Load Google Fonts API
		wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,Roboto' );
	
	}

}

add_action( 'wp_enqueue_scripts', 'foundation_assets' );

endif;

/**
 * Initialise Foundation JS
 * @see: http://foundation.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'foundation_js_init' ) ) :

function foundation_js_init () {
    echo '<script>$(document).foundation();</script>';
}

add_action('wp_footer', 'foundation_js_init', 50);

endif;

/**
 * ZeptoJS and jQuery Fallback
 * @see: http://foundation.zurb.com/docs/javascript.html
 */

if ( ! function_exists( 'foundation_comptability' ) ) :

function foundation_comptability () {

echo "<script>";
echo "document.write('<script src=' +";
echo "('__proto__' in {} ? '" . get_template_directory_uri() . "/js/vendor/zepto" . "' : '" . get_template_directory_uri() . "/js/vendor/jquery" . "') +";
echo "'.js><\/script>')";
echo "</script>";

}

add_action('wp_footer', 'foundation_comptability', 10);

endif;

/**
 * Register Navigation Menus
 */

if ( ! function_exists( 'foundation_menus' ) ) :

// Register wp_nav_menus
function foundation_menus() {

	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', 'foundation' )
		)
	);
	
}

add_action( 'init', 'foundation_menus' );

endif;

if ( ! function_exists( 'foundation_page_menu' ) ) :

function foundation_page_menu() {

	$args = array(
	'sort_column' => 'menu_order, post_title',
	'menu_class'  => 'large-12 columns',
	'include'     => '',
	'exclude'     => '',
	'echo'        => true,
	'show_home'   => false,
	'link_before' => '',
	'link_after'  => ''
	);

	wp_page_menu($args);

}

endif;

/**
 * Navigation Menu Adjustments
 */

// Add class to navigation sub-menu
class foundation_navigation extends Walker_Nav_Menu {

function start_lvl(&$output, $depth) {
	$indent = str_repeat("\t", $depth);
	$output .= "\n$indent<ul class=\"dropdown\">\n";
}

function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
	$id_field = $this->db_fields['id'];
	if ( !empty( $children_elements[ $element->$id_field ] ) ) {
		$element->classes[] = 'has-dropdown';
	}
		Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

/**
 * Create pagination
 */

if ( ! function_exists( 'foundation_pagination' ) ) :

function foundation_pagination() {

global $wp_query;

$big = 999999999;

$links = paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'prev_next' => true,
	'prev_text' => '&laquo;',
	'next_text' => '&raquo;',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
	'type' => 'list'
)
);

$pagination = str_replace('page-numbers','pagination',$links);

echo $pagination;

}

endif;

/**
 * Register Sidebars
 */

if ( ! function_exists( 'foundation_widgets' ) ) :

function foundation_widgets() {

	// Sidebar Right
	register_sidebar( array(
			'id' => 'foundation_sidebar_right',
			'name' => __( 'Sidebar Right', 'llungen_2013' ),
			'description' => __( 'This sidebar is located on the right-hand side of each page.', 'foundation' ),
			'before_widget' => '<div>',
			'after_widget' => '</div>',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	// Sidebar Footer Column One
	register_sidebar( array(
			'id' => 'foundation_sidebar_footer_one',
			'name' => __( 'Sidebar Footer One', 'llungen_2013' ),
			'description' => __( 'This sidebar is located in column 1 of your theme footer.', 'foundation' ),
			'before_widget' => '<div class="large-3 columns">',
			'after_widget' => '</div> <!--/col-1-->',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	// Sidebar Footer Column Two
	register_sidebar( array(
			'id' => 'foundation_sidebar_footer_two',
			'name' => __( 'Sidebar Footer Two', 'llungen_2013' ),
			'description' => __( 'This sidebar is located in column 2 of your theme footer.', 'foundation' ),
			'before_widget' => '<div class="large-3 columns">',
			'after_widget' => '</div> <!--/col-2-->',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	// Sidebar Footer Column Three
	register_sidebar( array(
			'id' => 'foundation_sidebar_footer_three',
			'name' => __( 'Sidebar Footer Three', 'llungen_2013' ),
			'description' => __( 'This sidebar is located in column 3 of your theme footer.', 'foundation' ),
			'before_widget' => '<div class="large-3 columns">',
			'after_widget' => '</div> <!--/col-3-->',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	// Sidebar Footer Column Four
	register_sidebar( array(
			'id' => 'foundation_sidebar_footer_four',
			'name' => __( 'Sidebar Footer Four', 'llungen_2013' ),
			'description' => __( 'This sidebar is located in column 4 of your theme footer.', 'foundation' ),
			'before_widget' => '<div class="large-3 columns">',
			'after_widget' => '</div> <!--/col-4-->',
			'before_title' => '<h5>',
			'after_title' => '</h5>',
		) );

	}

add_action( 'widgets_init', 'foundation_widgets' );

endif;

/**
 * Custom Avatar Classes
 */

if ( ! function_exists( 'foundation_avatar_css' ) ) :

function foundation_avatar_css($class) {
	$class = str_replace("class='avatar", "class='author_gravatar left ", $class) ;
	return $class;
}

add_filter('get_avatar','foundation_avatar_css');

endif;

/**
 * Custom Post Excerpt
 */

if ( ! function_exists( 'foundation_excerpt' ) ) :

function foundation_excerpt($text) {
        global $post;
        if ( '' == $text ) {
                $text = get_the_content('');
                $text = apply_filters('the_content', $text);
                $text = str_replace('\]\]\>', ']]&gt;', $text);
                $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
                $text = strip_tags($text, '<p>');
                $excerpt_length = 80;
                $words = explode(' ', $text, $excerpt_length + 1);
                if (count($words)> $excerpt_length) {
                        array_pop($words);
                        array_push($words, '<br><br><a href="'.get_permalink($post->ID) .'" class="button secondary small">' . __('Continue Reading', 'foundation') . '</a>');
                        $text = implode(' ', $words);
                }
        }
        return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'foundation_excerpt');

endif;

/** 
 * Comments Template
 */

if ( ! function_exists( 'foundation_comment' ) ) :

function foundation_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'foundation' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'foundation' ), '<span>', '</span>' ); ?></p>
	<?php
		break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header>
				<?php
					echo "<span class='th alignleft' style='margin-right:1rem;'>";
					echo get_avatar( $comment, 44 );
					echo "</span>";
					printf( '%2$s %1$s',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span class="label">' . __( 'Post Author', 'foundation' ) . '</span>' : ''
					);
					printf( '<br><a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( '%1$s at %2$s', 'foundation' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p><?php _e( 'Your comment is awaiting moderation.', 'foundation' ); ?></p>
			<?php endif; ?>

			<section>
				<?php comment_text(); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'foundation' ), 'after' => ' &darr; <br><br>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

			</div>
		</article>
	<?php
		break;
	endswitch;
}
endif;

/**
 * Remove Class from Sticky Post
 */

if ( ! function_exists( 'foundation_remove_sticky' ) ) :

function foundation_remove_sticky($classes) {
  $classes = array_diff($classes, array("sticky"));
  return $classes;
}

add_filter('post_class','foundation_remove_sticky');

endif;

/**
 * Custom Foundation Title Tag
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 */

function foundation_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'foundation' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'foundation_title', 10, 2 );

/**
 * Retrieve Shortcodes
 * @see: http://fwp.drewsymo.com/shortcodes/
 */

$foundation_shortcodes = trailingslashit( get_template_directory() ) . 'inc/shortcodes.php';

if (file_exists($foundation_shortcodes)) {
	require( $foundation_shortcodes );
}

?>