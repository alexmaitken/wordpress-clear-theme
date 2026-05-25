<?php
/**
 * Theme setup and utilities.
 *
 * @package Clear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'clrthm_setup' ) ) {
	/**
	 * Registers theme support and menus.
	 */
	function clrthm_setup() {
		load_theme_textdomain( 'clear-theme', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 320, 'flex-height' => true, 'flex-width' => true ) );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'clear-theme' ),
				'footer'  => esc_html__( 'Footer Menu', 'clear-theme' ),
			)
		);

		add_editor_style( 'assets/css/editor-style.css' );

		set_post_thumbnail_size( 1600, 900, true );
		add_image_size( 'clrthm-card', 960, 640, true );
	}
}
add_action( 'after_setup_theme', 'clrthm_setup' );

/**
 * Enqueue front-end assets.
 */
function clrthm_scripts() {
	wp_enqueue_style( 'clrthm-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'clrthm_scripts' );

/**
 * Add class to posts based on index for alternating layouts.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function clrthm_post_class_layout( $classes ) {
	if ( is_home() || is_archive() || is_search() ) {
		global $wp_query;
		$index = absint( $wp_query->current_post );
		if ( 0 === $index % 3 ) {
			$classes[] = 'post-card--full';
		} elseif ( 0 === $index % 2 ) {
			$classes[] = 'post-card--left';
		} else {
			$classes[] = 'post-card--right';
		}
	}
	return $classes;
}
add_filter( 'post_class', 'clrthm_post_class_layout' );
