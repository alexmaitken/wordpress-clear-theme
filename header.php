<?php
/**
 * Header template.
 *
 * @package Clear
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'clear-theme' ); ?></a>
<header class="site-header">
	<div class="site-branding">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>
		<?php $description = get_bloginfo( 'description', 'display' ); ?>
		<?php if ( $description ) : ?>
			<p class="site-description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
	</div>
	<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'clear-theme' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
</header>
<main id="content" class="site-main">
