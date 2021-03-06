<?php
/**
 * tenf functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tenf
 */

/**
 * For cache-busting. Always starts at 1.0.0 for a new project.
 */
define( 'TENF_VERSION', '1.0.0' );

function tenf_version() {
  if ( WP_DEBUG )
    return time();

  return TENF_VERSION;
}

if ( ! function_exists( 'tenf_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tenf_setup() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'tenf' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'tenf_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

    add_image_size( 'extra-large', 1200, 1200 );
    add_image_size( 'hero', 1920, 1920 );
	}
endif;
add_action( 'after_setup_theme', 'tenf_setup' );

/**
 * Pretty-print function for objects.
 */
function tenf_r( $data ) {
	echo '<pre>';
	var_dump( $data );
	echo '</pre>';
}

/**
 * Enqueue scripts and styles.
 */
function tenf_scripts() {
	wp_enqueue_style( 'bootstrap-grid', get_stylesheet_directory_uri() . '/bootstrap-grid.css', array(), tenf_version() );
	wp_enqueue_style( 'tenf-style', get_stylesheet_uri(), array(), tenf_version() );
	wp_enqueue_style( 'tenf-style-mobile', get_stylesheet_directory_uri() . '/style-mobile.css', array(), tenf_version() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tenf_scripts' );

function tenf_get_image_url( $image_id, $size=false ) {
    $image_src = wp_get_attachment_image_src( $image_id, $size );
    return $image_src ? $image_src[0] : '';
}

function tenf_image($image_id, $size='medium', $sizes=false) {
	$srcset = wp_get_attachment_image_srcset($image_id, $size);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
	$image_src = wp_get_attachment_image_src($image_id, $size)[0];

	$image_tag = "";
	$image_tag .= "<img";
		
	if ($sizes):
		$image_tag .= " srcset='$srcset'";
	endif;
		
	if ($sizes):
		$image_tag .= " sizes='$sizes'";
	endif;

	$image_tag .=	" src='$image_src' alt='$alt'>";

	return $image_tag;
}

