<?php get_header(); ?>
<header class="page-header">
	<h1><?php printf( esc_html__( 'Search results for: %s', 'clear-theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
</header>
<div class="search-grid entry-list">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'card' ); ?>
	<?php endwhile; the_posts_pagination(); else : ?>
		<p><?php esc_html_e( 'No matching stories were found.', 'clear-theme' ); ?></p>
	<?php get_search_form(); endif; ?>
</div>
<?php get_footer(); ?>
