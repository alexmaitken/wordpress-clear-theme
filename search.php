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
<div class="entry-list">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'card' ); ?>
		<?php endwhile; ?>
		<?php
		the_posts_pagination(
			array(
				'prev_text'          => esc_html__( 'Previous page', 'clear-theme' ),
				'next_text'          => esc_html__( 'Next page', 'clear-theme' ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'clear-theme' ),
			)
		);
		?>
	<?php else : ?>
		<section class="empty-state">
			<p><?php esc_html_e( 'No matching stories were found. Try another search term or browse recent posts.', 'clear-theme' ); ?></p>
			<?php get_search_form(); ?>
		</section>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
