<?php
/**
 * Blog home template.
 *
 * @package Clear
 */

get_header();
?>
<?php clrthm_render_home_author_strip(); ?>

<?php if ( have_posts() ) : ?>
	<section class="featured-grid" aria-label="<?php esc_attr_e( 'Featured stories', 'clear-theme' ); ?>">
		<?php
		$count = 0;
		set_query_var( 'clrthm_card_context', 'featured' );
		while ( have_posts() && $count < 4 ) :
			the_post();
			set_query_var( 'clrthm_card_slot', $count );
			$count++;
			get_template_part( 'template-parts/content', 'card' );
		endwhile;
		?>
	</section>

	<?php if ( have_posts() ) : ?>
		<section class="entry-list" aria-label="<?php esc_attr_e( 'Latest stories', 'clear-theme' ); ?>">
			<?php
			set_query_var( 'clrthm_card_context', 'entry-list' );
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;
			?>
		</section>
	<?php endif; ?>
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
<?php else : ?>
	<section class="empty-state"><p><?php esc_html_e( 'No posts yet.', 'clear-theme' ); ?></p></section>
<?php endif; ?>
<?php get_footer(); ?>
