<?php
/**
 * Search results template.
 *
 * @package Clear
 */

get_header();
?>
<header class="page-header">
	<h1>
		<?php
		/* translators: %s: search query text. */
		printf( esc_html__( 'Search results for: %s', 'clear-theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
		?>
	</h1>
</header>
<?php if ( have_posts() ) : ?>
	<section class="post-list" aria-label="<?php esc_attr_e( 'Search results', 'clear-theme' ); ?>">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'list' ); ?>
		<?php endwhile; ?>
	</section>
	<?php get_template_part( 'template-parts/pagination' ); ?>
<?php else : ?>
	<section class="empty-state">
		<h2><?php esc_html_e( 'No results found', 'clear-theme' ); ?></h2>
		<p><?php esc_html_e( 'We could not find posts matching your search. Try a different phrase or browse recent stories below.', 'clear-theme' ); ?></p>
		<?php get_search_form(); ?>
	</section>
<?php endif; ?>
<?php get_footer(); ?>
