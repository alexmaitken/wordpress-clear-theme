<?php
/**
 * Blog home template.
 *
 * @package Clear
 */

get_header();
?>
<section class="editorial-intro">
	<h1><?php single_post_title(); ?></h1>
</section>
<?php clrthm_render_home_author_strip(); ?>
<?php if ( have_posts() ) : ?>
	<section class="entry-list">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'card' );
		endwhile;
		?>
	</section>
	<?php
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => esc_html__( 'Previous page', 'clear-theme' ),
			'next_text' => esc_html__( 'Next page', 'clear-theme' ),
			'screen_reader_text' => esc_html__( 'Posts navigation', 'clear-theme' ),
		)
	);
	?>
<?php else : ?>
	<section class="empty-state"><p><?php esc_html_e( 'No posts yet.', 'clear-theme' ); ?></p></section>
<?php endif; ?>
<?php get_footer(); ?>
