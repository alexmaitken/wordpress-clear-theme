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
				'util'    => esc_html__( 'Utility Menu', 'clear-theme' ),
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
 * Estimated reading time in minutes.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function clrthm_get_reading_time( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes = max( 1, (int) ceil( $words / 220 ) );

	/* translators: %s: number of minutes. */
	return sprintf( _n( '%s min read', '%s mins read', $minutes, 'clear-theme' ), number_format_i18n( $minutes ) );
}

/**
 * Post byline HTML.
 *
 * @return string
 */
function clrthm_get_post_byline() {
	$author = sprintf(
		'<a href="%1$s" rel="author">%2$s</a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
	$date = sprintf(
		'<time datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
	$read = esc_html( clrthm_get_reading_time() );

	/* translators: 1: author link, 2: date, 3: reading time. */
	return sprintf( __( 'By %1$s · %2$s · %3$s', 'clear-theme' ), $author, $date, $read );
}
