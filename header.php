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
<header class="site-header site-header--<?php echo esc_attr( get_theme_mod( 'clrthm_header_layout', 'left' ) ); ?>">
	<div class="site-branding">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>
	</div>
	<div class="site-header__navs">
		<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'clear-theme' ); ?>">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'fallback_cb'    => false,
				)
			); ?>
		</nav>
		<nav class="util-navigation" aria-label="<?php esc_attr_e( 'Utility menu', 'clear-theme' ); ?>">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'util',
					'fallback_cb'    => false,
				)
			); ?>
		</nav>
	</div>
</header>
<main id="content" class="site-main">
