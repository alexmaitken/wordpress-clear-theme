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
				'height' => 120,
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
	$theme_version = wp_get_theme()->get( 'Version' );

	if ( clrthm_should_load_google_fonts() ) {
		wp_enqueue_style(
			'clrthm-inter-font',
			clrthm_get_google_fonts_url(),
			array(),
			$theme_version
		);
	}

	$style_dependencies = clrthm_should_load_google_fonts() ? array( 'clrthm-inter-font' ) : array();
	wp_enqueue_style( 'clrthm-style', get_stylesheet_uri(), $style_dependencies, $theme_version );

	wp_enqueue_script(
		'clrthm-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}

add_action( 'wp_enqueue_scripts', 'clrthm_scripts' );

/**
 * Get theme Google Fonts URL.
 *
 * @return string
 */
function clrthm_get_google_fonts_url() {
	$fonts_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap';

	/**
	 * Filters the theme Google Fonts URL.
	 *
	 * @param string $fonts_url Google Fonts URL.
	 */
	return esc_url_raw( apply_filters( 'clrthm_google_fonts_url', $fonts_url ) );
}

/**
 * Determine whether Google Fonts should be loaded.
 *
 * @return bool
 */
function clrthm_should_load_google_fonts() {
	$enabled = (bool) get_theme_mod( 'clrthm_enable_google_fonts', 0 );

	/**
	 * Filters whether the theme should load Google Fonts.
	 *
	 * @param bool $enabled Whether Google Fonts are enabled.
	 */
	return (bool) apply_filters( 'clrthm_load_google_fonts', $enabled );
}


/**
 * Add presentation CSS variables based on Customizer settings.
 *
 * @return void
 */
function clrthm_add_presentation_css_variables() {
	$bg_color = sanitize_hex_color( get_theme_mod( 'clrthm_background_color', '#ffffff' ) );
	$bg_color = $bg_color ? $bg_color : '#ffffff';

	$bg_style = clrthm_sanitize_background_style( get_theme_mod( 'clrthm_background_style', 'solid' ) );
	$bg_alpha = clrthm_sanitize_background_alpha( get_theme_mod( 'clrthm_background_radial_alpha', 0.12 ) );

	if ( 'radial' === $bg_style ) {
		$bg_gradient = sprintf(
			'radial-gradient(85%% 60%% at 50%% 0%%, %1$s 0%%, %2$s 16%%, %3$s 34%%, rgba(255, 255, 255, 1) 100%%)',
			clrthm_hex_to_rgba( $bg_color, $bg_alpha ),
			clrthm_hex_to_rgba( $bg_color, $bg_alpha * 0.35 ),
			clrthm_hex_to_rgba( $bg_color, 0 )
		);
	} else {
		$bg_gradient = 'none';
	}

	$css = sprintf(
		':root{--clrthm-bg:%1$s;--clrthm-bg-gradient:%2$s;}',
		$bg_color,
		$bg_gradient
	);

	wp_add_inline_style( 'clrthm-style', $css );
}
add_action( 'wp_enqueue_scripts', 'clrthm_add_presentation_css_variables', 20 );

/**
 * Enqueue editor fonts.
 *
 * @return void
 */
function clrthm_editor_assets() {
	if ( clrthm_should_load_google_fonts() ) {
		wp_enqueue_style(
			'clrthm-inter-font',
			clrthm_get_google_fonts_url(),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'clrthm_editor_assets' );

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
 * Sanitize background style.
 *
 * @param string $value Background style.
 * @return string
 */
function clrthm_sanitize_background_style( $value ) {
	$value   = sanitize_key( $value );
	$allowed = array( 'solid', 'radial' );

	return in_array( $value, $allowed, true ) ? $value : 'solid';
}


/**
 * Sanitize background radial alpha.
 *
 * @param mixed $value Alpha value.
 * @return float
 */
function clrthm_sanitize_background_alpha( $value ) {
	$value = is_numeric( $value ) ? (float) $value : 0.12;

	if ( $value < 0 ) {
		return 0;
	}

	if ( $value > 1 ) {
		return 1;
	}

	return round( $value, 2 );
}

/**
 * Convert a hex color to rgba().
 *
 * @param string $hex   Hex color.
 * @param float  $alpha Alpha channel between 0 and 1.
 * @return string
 */
function clrthm_hex_to_rgba( $hex, $alpha ) {
	$hex = sanitize_hex_color( $hex );

	if ( ! $hex ) {
		return 'rgba(255, 255, 255, 0)';
	}

	$hex = ltrim( $hex, '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	$red   = hexdec( substr( $hex, 0, 2 ) );
	$green = hexdec( substr( $hex, 2, 2 ) );
	$blue  = hexdec( substr( $hex, 4, 2 ) );

	return sprintf( 'rgba(%d, %d, %d, %.2f)', $red, $green, $blue, $alpha );
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

	$wp_customize->add_setting(
		'clrthm_background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'clrthm_background_color',
			array(
				'label'       => esc_html__( 'Background primary color', 'clear-theme' ),
				'section'     => 'clrthm_presentation',
				'description' => esc_html__( 'Used for both solid and radial background styles.', 'clear-theme' ),
			)
		)
	);

	$wp_customize->add_setting(
		'clrthm_background_style',
		array(
			'default'           => 'solid',
			'sanitize_callback' => 'clrthm_sanitize_background_style',
		)
	);
	$wp_customize->add_control(
		'clrthm_background_style',
		array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Background style', 'clear-theme' ),
			'section' => 'clrthm_presentation',
			'choices' => array(
				'solid'  => esc_html__( 'Solid color', 'clear-theme' ),
				'radial' => esc_html__( 'Minimal radial gradient', 'clear-theme' ),
			),
		)
	);

	$wp_customize->add_setting(
		'clrthm_background_radial_alpha',
		array(
			'default'           => 0.12,
			'sanitize_callback' => 'clrthm_sanitize_background_alpha',
		)
	);
	$wp_customize->add_control(
		'clrthm_background_radial_alpha',
		array(
			'type'        => 'range',
			'label'       => esc_html__( 'Radial gradient intensity', 'clear-theme' ),
			'section'     => 'clrthm_presentation',
			'description' => esc_html__( 'Controls the transparency of the radial color burst.', 'clear-theme' ),
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 1,
				'step' => 0.01,
			),
		)
	);

	$checkbox_controls = array(
		'clrthm_enable_google_fonts' => esc_html__( 'Enable hosted Inter font from Google Fonts (external request)', 'clear-theme' ),
		'clrthm_show_reading_time'   => esc_html__( 'Show reading time', 'clear-theme' ),
		'clrthm_show_author_strip'   => esc_html__( 'Show featured authors strip on homepage', 'clear-theme' ),
		'clrthm_show_related_posts'  => esc_html__( 'Show related posts', 'clear-theme' ),
		'clrthm_show_site_tagline'   => esc_html__( 'Show homepage tagline', 'clear-theme' ),
		'clrthm_link_author_pages'   => esc_html__( 'Link author names and avatars to author pages', 'clear-theme' ),
	);
	$checkbox_defaults = array(
		'clrthm_enable_google_fonts' => 0,
		'clrthm_show_reading_time'   => 1,
		'clrthm_show_author_strip'   => 0,
		'clrthm_show_related_posts'  => 1,
		'clrthm_show_site_tagline'   => 1,
		'clrthm_link_author_pages'   => 0,
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
	$date  = sprintf(
		'<time class="byline-date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);
	$parts = array(
		'<span class="byline-author"><span class="screen-reader-text">' . esc_html__( 'By ', 'clear-theme' ) . '</span>' . $author . '</span>',
		'<span class="byline-published"><span class="screen-reader-text">' . esc_html__( 'Published ', 'clear-theme' ) . '</span>' . $date . '</span>',
	);

	if ( get_theme_mod( 'clrthm_show_reading_time', 1 ) ) {
		$parts[] = '<span class="byline-read">' . esc_html( clrthm_get_reading_time() ) . '</span>';
	}

	$byline = implode( '<span class="byline-separator" aria-hidden="true"> · </span>', $parts );

	return '<p class="post-byline">' . $byline . '</p>';
}

/**
 * Render editorial post navigation.
 */
function clrthm_render_post_navigation() {
	$previous_post = get_previous_post();
	$next_post     = get_next_post();

	if ( ! $previous_post && ! $next_post ) {
		return;
	}
	?>
	<nav class="post-navigation post-navigation--editorial" aria-label="<?php esc_attr_e( 'Post navigation', 'clear-theme' ); ?>">
		<div class="post-navigation__grid">
			<?php if ( $previous_post ) : ?>
				<a class="post-nav-card post-nav-card--prev" href="<?php echo esc_url( get_permalink( $previous_post ) ); ?>" rel="prev">
					<span class="post-nav-card__kicker"><?php esc_html_e( 'Previous story', 'clear-theme' ); ?></span>
					<span class="post-nav-card__title"><?php echo esc_html( get_the_title( $previous_post ) ); ?></span>
				</a>
			<?php endif; ?>
			<?php if ( $next_post ) : ?>
				<a class="post-nav-card post-nav-card--next" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" rel="next">
					<span class="post-nav-card__kicker"><?php esc_html_e( 'Next story', 'clear-theme' ); ?></span>
					<span class="post-nav-card__title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</nav>
	<?php
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
 * Get featured image width choices.
 *
 * @return array<string, string>
 */
function clrthm_get_featured_image_width_choices() {
	return array(
		'content' => esc_html__( 'Content width', 'clear-theme' ),
		'large'   => esc_html__( 'Large', 'clear-theme' ),
		'full'    => esc_html__( 'Full width', 'clear-theme' ),
	);
}

/**
 * Get featured image position choices.
 *
 * @return array<string, string>
 */
function clrthm_get_featured_image_position_choices() {
	return array(
		'hidden' => esc_html__( 'Hide featured image', 'clear-theme' ),
		'above'  => esc_html__( 'Above title', 'clear-theme' ),
		'left'   => esc_html__( 'Left of title', 'clear-theme' ),
		'right'  => esc_html__( 'Right of title', 'clear-theme' ),
	);
}

/**
 * Get featured image width for a post.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function clrthm_get_featured_image_width( $post_id ) {
	$post_id = absint( $post_id );
	$value   = sanitize_key( (string) get_post_meta( $post_id, '_clrthm_featured_image_width', true ) );
	$allowed = array_keys( clrthm_get_featured_image_width_choices() );

	if ( in_array( $value, $allowed, true ) ) {
		return $value;
	}

	if ( has_tag( 'layout-full-width-image', $post_id ) ) {
		return 'full';
	}
	if ( has_tag( 'layout-left-image', $post_id ) || has_tag( 'layout-right-image', $post_id ) ) {
		return 'large';
	}

	return 'large';
}

/**
 * Get featured image position for a post.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function clrthm_get_featured_image_position( $post_id ) {
	$post_id = absint( $post_id );
	$value   = sanitize_key( (string) get_post_meta( $post_id, '_clrthm_featured_image_position', true ) );
	$allowed = array_keys( clrthm_get_featured_image_position_choices() );

	if ( in_array( $value, $allowed, true ) ) {
		return $value;
	}

	if ( has_tag( 'layout-left-image', $post_id ) ) {
		return 'left';
	}
	if ( has_tag( 'layout-right-image', $post_id ) ) {
		return 'right';
	}

	return 'above';
}

/**
 * Register post layout meta box.
 */
function clrthm_register_post_layout_meta_box() {
	add_meta_box( 'clrthm_post_layout', esc_html__( 'Clear layout', 'clear-theme' ), 'clrthm_render_post_layout_meta_box', 'post', 'side', 'default' );
	add_meta_box( 'clrthm_post_layout', esc_html__( 'Clear layout', 'clear-theme' ), 'clrthm_render_post_layout_meta_box', 'page', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'clrthm_register_post_layout_meta_box' );

/**
 * Render post layout meta box.
 *
 * @param WP_Post $post Post object.
 */
function clrthm_render_post_layout_meta_box( $post ) {
	$width_value    = clrthm_get_featured_image_width( $post->ID );
	$position_value = clrthm_get_featured_image_position( $post->ID );

	wp_nonce_field( 'clrthm_save_post_layout', 'clrthm_post_layout_nonce' );
	?>
	<p>
		<label for="clrthm_featured_image_width"><strong><?php esc_html_e( 'Featured image width', 'clear-theme' ); ?></strong></label><br />
		<select id="clrthm_featured_image_width" name="clrthm_featured_image_width" class="widefat">
			<?php foreach ( clrthm_get_featured_image_width_choices() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $width_value, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="clrthm_featured_image_position"><strong><?php esc_html_e( 'Featured image position', 'clear-theme' ); ?></strong></label><br />
		<select id="clrthm_featured_image_position" name="clrthm_featured_image_position" class="widefat">
			<?php foreach ( clrthm_get_featured_image_position_choices() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $position_value, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
}

/**
 * Save post layout meta values.
 *
 * @param int $post_id Post ID.
 */
function clrthm_save_post_layout_meta( $post_id ) {
	if ( ! isset( $_POST['clrthm_post_layout_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['clrthm_post_layout_nonce'] ) ), 'clrthm_save_post_layout' ) ) {
		return;
	}

	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! in_array( get_post_type( $post_id ), array( 'post', 'page' ), true ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$allowed_widths    = array_keys( clrthm_get_featured_image_width_choices() );
	$allowed_positions = array_keys( clrthm_get_featured_image_position_choices() );

	if ( isset( $_POST['clrthm_featured_image_width'] ) ) {
		$width = sanitize_key( wp_unslash( $_POST['clrthm_featured_image_width'] ) );
		if ( in_array( $width, $allowed_widths, true ) ) {
			update_post_meta( $post_id, '_clrthm_featured_image_width', $width );
		}
	}

	if ( isset( $_POST['clrthm_featured_image_position'] ) ) {
		$position = sanitize_key( wp_unslash( $_POST['clrthm_featured_image_position'] ) );
		if ( in_array( $position, $allowed_positions, true ) ) {
			update_post_meta( $post_id, '_clrthm_featured_image_position', $position );
		}
	}
}
add_action( 'save_post', 'clrthm_save_post_layout_meta' );

/**
 * Get single layout class.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function clrthm_get_single_layout_class( $post_id ) {
	$post_id = absint( $post_id );
	$width   = clrthm_get_featured_image_width( $post_id );
	$pos     = clrthm_get_featured_image_position( $post_id );

	if ( ! clrthm_should_render_featured_image( $post_id ) ) {
		return 'single-featured-position--' . sanitize_html_class( $pos );
	}

	return sprintf( 'single-featured-width--%1$s single-featured-position--%2$s', sanitize_html_class( $width ), sanitize_html_class( $pos ) );
}

/**
 * Whether the featured image should render in the hero area.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function clrthm_should_render_featured_image( $post_id ) {
	$post_id = absint( $post_id );
	if ( ! has_post_thumbnail( $post_id ) ) {
		return false;
	}

	return 'hidden' !== clrthm_get_featured_image_position( $post_id );
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
			'<a class="clrthm-term-pill" href="%1$s">%2$s</a>',
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}

	return implode( ' ', $items );
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

/**
 * Output lightweight JSON-LD for theme templates.
 */
function clrthm_output_structured_data() {
	if ( is_singular( 'post' ) ) {
		if ( ! apply_filters( 'clrthm_enable_single_post_schema', true ) ) {
			return;
		}

		$post_id = get_queried_object_id();
		$schema  = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'headline'         => wp_strip_all_tags( get_the_title( $post_id ) ),
			'datePublished'    => get_post_time( DATE_W3C, true, $post_id ),
			'dateModified'     => get_post_modified_time( DATE_W3C, true, $post_id ),
			'mainEntityOfPage' => get_permalink( $post_id ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) ),
			),
			'publisher'        => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
		);

		if ( has_excerpt( $post_id ) ) {
			$schema['description'] = wp_strip_all_tags( get_the_excerpt( $post_id ) );
		}
		if ( has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'full' );
			if ( $image ) {
				$schema['image'] = $image;
			}
		}

		$schema = apply_filters( 'clrthm_single_post_schema_data', $schema, $post_id );
	} elseif ( is_home() || is_front_page() ) {
		if ( ! apply_filters( 'clrthm_enable_home_schema', true ) ) {
			return;
		}
		$schema = apply_filters(
			'clrthm_home_schema_data',
			array(
				'@context' => 'https://schema.org',
				'@type'    => 'WebSite',
				'name'     => get_bloginfo( 'name' ),
				'url'      => home_url( '/' ),
			)
		);
	} else {
		return;
	}

	if ( empty( $schema ) || ! is_array( $schema ) ) {
		return;
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
}
add_action( 'wp_head', 'clrthm_output_structured_data', 30 );
