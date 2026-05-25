<?php get_header(); ?>
<div class="post-grid entry-list">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'card' ); ?>
	<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts yet.', 'clear-theme' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
