<?php
/**
 * 404 template.
 *
 * @package Clear
 */

get_header();
?>
<article class="page-entry not-found" aria-labelledby="not-found-title">
	<header class="page-entry__header not-found__header">
		<p class="not-found__eyebrow"><?php esc_html_e( '404', 'clear-theme' ); ?></p>
		<h1 id="not-found-title" class="entry-title"><?php esc_html_e( 'Page not found', 'clear-theme' ); ?></h1>
	</header>
	<div class="page-entry__inner">
		<div class="entry-content not-found__content">
			<p><?php esc_html_e( 'The page you are looking for does not exist. Try searching for the story, page, or topic you had in mind.', 'clear-theme' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
</article>
<?php get_footer(); ?>
