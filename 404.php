<?php
/**
 * 404 template.
 *
 * @package Clear
 */

get_header();
?>
<section class="entry-content empty-state" aria-labelledby="not-found-title">
	<h1 id="not-found-title"><?php esc_html_e( 'Page not found', 'clear-theme' ); ?></h1>
	<p><?php esc_html_e( 'The page you are looking for does not exist. Try a search:', 'clear-theme' ); ?></p>
	<?php get_search_form(); ?>
</section>
<?php get_footer(); ?>
