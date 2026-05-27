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
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 120,
				'width'       => 320,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
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
		add_image_size( 'clrthm-single-hero', 1400, 900, true );
	}
}
add_action( 'after_setup_theme', 'clrthm_setup' );

/**
 * Scripts.
 */
function clrthm_scripts() {
	wp_enqueue_style(
		'clrthm-inter-font',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
		array(),
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_style( 'clrthm-style', get_stylesheet_uri(), array( 'clrthm-inter-font' ), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'clrthm_scripts' );

/**
 * Sanitize checkbox.
 *
 * @param mixed $value Checkbox value.
 * @return int
 */
function clrthm_sanitize_checkbox( $value ) {
	return ( isset( $value ) && true === (bool) $value ) ? 1 : 0;
}

/**
 * Sanitize header layout.
 *
 * @param string $value Header layout slug.
 * @return string
 */
function clrthm_sanitize_header_layout( $value ) {
	$value   = sanitize_key( $value );
	$allowed = array( 'centered', 'left' );

	return in_array( $value, $allowed, true ) ? $value : 'left';
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 * @return void
 */
function clrthm_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'clrthm_presentation',
		array(
			'title'       => esc_html__( 'Theme Presentation', 'clear-theme' ),
			'priority'    => 40,
			'description' => esc_html__( 'Visual-only options for this theme.', 'clear-theme' ),
		)
	);

	$wp_customize->add_setting(
		'clrthm_accent_color',
		array(
			'default'           => '#0a66d1',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'clrthm_accent_color',
			array(
				'label'   => esc_html__( 'Accent color', 'clear-theme' ),
				'section' => 'clrthm_presentation',
			)
		)
	);

	$checkbox_controls = array(
		'clrthm_show_reading_time'  => esc_html__( 'Show reading time', 'clear-theme' ),
		'clrthm_show_author_strip'  => esc_html__( 'Show featured authors strip on homepage', 'clear-theme' ),
		'clrthm_show_related_posts' => esc_html__( 'Show related posts', 'clear-theme' ),
		'clrthm_show_site_tagline'  => esc_html__( 'Show homepage tagline', 'clear-theme' ),
		'clrthm_link_author_pages'  => esc_html__( 'Link author names and avatars to author pages', 'clear-theme' ),
	);
	$checkbox_defaults = array(
		'clrthm_show_reading_time'  => 1,
		'clrthm_show_author_strip'  => 0,
		'clrthm_show_related_posts' => 1,
		'clrthm_show_site_tagline'  => 1,
		'clrthm_link_author_pages'  => 0,
	);

	foreach ( $checkbox_controls as $setting_id => $label ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $checkbox_defaults[ $setting_id ],
				'sanitize_callback' => 'clrthm_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'type'    => 'checkbox',
				'label'   => $label,
				'section' => 'clrthm_presentation',
			)
		);
	}

	$wp_customize->add_setting(
		'clrthm_header_layout',
		array(
			'default'           => 'left',
			'sanitize_callback' => 'clrthm_sanitize_header_layout',
		)
	);
	$wp_customize->add_control(
		'clrthm_header_layout',
		array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Header layout', 'clear-theme' ),
			'section' => 'clrthm_presentation',
			'choices' => array(
				'left'     => esc_html__( 'Left-aligned', 'clear-theme' ),
				'centered' => esc_html__( 'Centered', 'clear-theme' ),
			),
		)
	);

	$wp_customize->add_setting(
		'clrthm_footer_copyright_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'clrthm_footer_copyright_text',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Footer copyright text', 'clear-theme' ),
			'section'     => 'clrthm_presentation',
			'description' => esc_html__( 'Optional. If empty, a default copyright line is shown.', 'clear-theme' ),
		)
	);
}
add_action( 'customize_register', 'clrthm_customize_register' );

/**
 * Get reading time.
 *
 * @param int|null $post_id Post ID, defaults to current post.
 * @return string
 */
function clrthm_get_reading_time( $post_id = null ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes = max( 1, (int) ceil( $words / 220 ) );

	/* translators: %s: estimated reading time in minutes. */
	return sprintf( _n( '%s min read', '%s mins read', $minutes, 'clear-theme' ), number_format_i18n( $minutes ) );
}


/**
 * Get author avatar html for cards.
 *
 * @param int $author_id Author ID.
 * @param int $size Avatar size.
 * @return string
 */
function clrthm_get_author_avatar( $author_id, $size = 40 ) {
	$author_id = absint( $author_id );
	if ( ! $author_id ) {
		return '';
	}

	return get_avatar( $author_id, absint( $size ), '', '', array( 'class' => 'post-card__avatar-image' ) );
}

/**
 * Get post byline.
 */
function clrthm_get_post_byline() {
	$author_name = esc_html( get_the_author() );
	$author      = $author_name;
	if ( get_theme_mod( 'clrthm_link_author_pages', 0 ) ) {
		$author = sprintf(
			'<a href="%1$s" rel="author">%2$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			$author_name
		);
	}
	$date   = sprintf(
		'<time class="byline-date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
	$author = '<span class="byline-author">' . $author . '</span>';
	if ( get_theme_mod( 'clrthm_show_reading_time', 1 ) ) {
		$read = '<span class="byline-read">' . esc_html( clrthm_get_reading_time() ) . '</span>';
		/* translators: 1: post author, 2: post date, 3: reading time. */
		return sprintf( __( 'By %1$s on %2$s · %3$s', 'clear-theme' ), $author, $date, $read );
	}

	/* translators: 1: post author, 2: post date. */
	return sprintf( __( 'By %1$s on %2$s', 'clear-theme' ), $author, $date );
}

/**
 * Get footer copyright text.
 */
function clrthm_get_footer_copyright_text() {
	$custom = trim( (string) get_theme_mod( 'clrthm_footer_copyright_text', '' ) );
	if ( '' !== $custom ) {
		return $custom;
	}

	/* translators: 1: year, 2: site name. */
	return sprintf( __( '© %1$s %2$s. Powered by WordPress.', 'clear-theme' ), gmdate( 'Y' ), get_bloginfo( 'name' ) );
}

/**
 * Print customizer css.
 */
function clrthm_print_customizer_css() {
	$accent = sanitize_hex_color( get_theme_mod( 'clrthm_accent_color', '#0a66d1' ) );
	if ( ! $accent ) {
		$accent = '#0a66d1';
	}
	?>
	<style id="clrthm-customizer-css">:root{--clrthm-focus:<?php echo esc_html( $accent ); ?>;--clrthm-accent:<?php echo esc_html( $accent ); ?>;}</style>
	<?php
}
add_action( 'wp_head', 'clrthm_print_customizer_css' );

/**
 * Render home author strip.
 */
function clrthm_render_home_author_strip() {
	if ( ! get_theme_mod( 'clrthm_show_author_strip', 0 ) ) {
		return;
	}
	global $wp_query;
	$featured_posts = array_slice( (array) $wp_query->posts, 0, 4 );
	if ( empty( $featured_posts ) ) {
		return;
	}

	$authors = array();
	foreach ( $featured_posts as $featured_post ) {
		$author_id = (int) $featured_post->post_author;
		if ( ! $author_id || isset( $authors[ $author_id ] ) ) {
			continue;
		}
		$authors[ $author_id ] = get_the_author_meta( 'display_name', $author_id );
	}
	if ( empty( $authors ) ) {
		return;
	}
	echo '<section class="home-author-strip" aria-label="' . esc_attr__( 'Featured authors', 'clear-theme' ) . '"><p><strong>' . esc_html__( 'Featured authors:', 'clear-theme' ) . '</strong></p><ul class="home-author-strip__list">';
	foreach ( $authors as $author_id => $author_name ) {
		echo '<li class="home-author-strip__item"><a href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . wp_kses_post( clrthm_get_author_avatar( $author_id, 36 ) ) . '<span>' . esc_html( $author_name ) . '</span></a></li>';
	}
	echo '</ul></section>';
}


/**
 * Get layout control tag slugs.
 */
function clrthm_get_layout_control_tag_slugs() {
	return array( 'layout-left-image', 'layout-right-image', 'layout-full-width-image' );
}

/**
 * Get single layout class.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function clrthm_get_single_layout_class( $post_id ) {
	$post_id = absint( $post_id );

	if ( has_tag( 'layout-left-image', $post_id ) ) {
		return 'single-layout--left-image';
	}
	if ( has_tag( 'layout-right-image', $post_id ) ) {
		return 'single-layout--right-image';
	}
	if ( has_tag( 'layout-full-width-image', $post_id ) || has_post_thumbnail( $post_id ) ) {
		return 'single-layout--full-width-image';
	}

	return 'single-layout--text-first';
}

/**
 * Get public terms html.
 *
 * @param int    $post_id  Post ID.
 * @param string $taxonomy Taxonomy slug.
 * @return string
 */
function clrthm_get_public_terms_html( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}

	$items = array();
	foreach ( $terms as $term ) {
		if ( 'post_tag' === $taxonomy && in_array( $term->slug, clrthm_get_layout_control_tag_slugs(), true ) ) {
			continue;
		}
		$items[] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}

	return implode( ', ', $items );
}

/**
 * Get featured image html.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return string
 */
function clrthm_get_featured_image_html( $post_id, $size = 'clrthm-single-hero' ) {
	$thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( ! $thumbnail_id ) {
		return '';
	}
	$alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
	if ( '' === trim( (string) $alt_text ) ) {
		$alt_text = get_the_title( $post_id );
	}

	return wp_get_attachment_image(
		$thumbnail_id,
		$size,
		false,
		array(
			'alt'     => $alt_text,
			'loading' => 'eager',
		)
	);
}
