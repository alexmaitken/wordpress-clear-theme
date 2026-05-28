<?php
/**
 * Archive template.
 *
 * @package Clear
 */

get_header();
?>
<header class="page-header">
	<h1><?php the_archive_title(); ?></h1>
	<?php the_archive_description( '<div>', '</div>' ); ?>
</header>
<?php if ( have_posts() ) : ?>
	<section class="post-list" aria-label="<?php esc_attr_e( 'Archive stories', 'clear-theme' ); ?>">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'list' ); ?>
		<?php endwhile; ?>
	</section>
	<?php get_template_part( 'template-parts/pagination' ); ?>
<?php else : ?>
	<section class="empty-state">
		<h2><?php esc_html_e( 'No posts in this archive yet', 'clear-theme' ); ?></h2>
		<p><?php esc_html_e( 'Try another archive section, or check back soon for new writing.', 'clear-theme' ); ?></p>
	</section>
<?php endif; ?>
<?php get_footer(); ?>
