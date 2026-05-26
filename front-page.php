<?php
/**
 * Front page template for latest posts.
 *
 * @package Clear
 */

get_header();
?>
<section class="editorial-intro">
	<h1><?php bloginfo( 'name' ); ?></h1>
	<?php if ( get_bloginfo( 'description' ) ) : ?>
		<p><?php bloginfo( 'description' ); ?></p>
	<?php endif; ?>
</section>
<?php clrthm_render_home_author_strip(); ?>

<?php if ( have_posts() ) : ?>
	<section class="featured-grid" aria-label="<?php esc_attr_e( 'Featured stories', 'clear-theme' ); ?>">
		<?php
		$count = 0;
		while ( have_posts() && $count < 4 ) :
			the_post();
			$count++;
			get_template_part( 'template-parts/content', 'card' );
		endwhile;
		?>
	</section>

	<?php if ( have_posts() ) : ?>
		<section class="entry-list" aria-label="<?php esc_attr_e( 'Latest stories', 'clear-theme' ); ?>">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;
			?>
		</section>
	<?php endif; ?>

	<section class="archive-read-more" aria-label="<?php esc_attr_e( 'Read more', 'clear-theme' ); ?>">
		<h2><?php esc_html_e( 'Read more', 'clear-theme' ); ?></h2>
		<?php
		the_posts_pagination(
			array(
				'mid_size'           => 1,
				'prev_text'          => esc_html__( 'Previous page', 'clear-theme' ),
				'next_text'          => esc_html__( 'Next page', 'clear-theme' ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'clear-theme' ),
			)
		);
		?>
	</section>
<?php else : ?>
	<section class="empty-state">
		<p><?php esc_html_e( 'Publish your first story to get started.', 'clear-theme' ); ?></p>
	</section>
<?php endif; ?>

<?php
get_footer();
