<?php
/**
 * Shared homepage layout.
 *
 * @package Clear
 */

$show_intro    = ! empty( $args['show_intro'] );
$empty_text    = isset( $args['empty_text'] ) ? (string) $args['empty_text'] : '';
$is_paged      = is_paged();
$show_featured = ! $is_paged;

if ( $show_intro ) :
	$tagline = get_bloginfo( 'description' );
	if ( get_theme_mod( 'clrthm_show_site_tagline', 1 ) && $tagline ) :
		?>
		<section class="editorial-intro">
			<p><?php echo esc_html( $tagline ); ?></p>
		</section>
		<?php
	endif;
endif;

clrthm_render_home_author_strip();

if ( have_posts() ) :
	if ( $show_featured ) :
		?>
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
		<?php
	endif;

	if ( have_posts() ) :
		?>
		<section class="post-list" aria-label="<?php esc_attr_e( 'Latest stories', 'clear-theme' ); ?>">
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'list' ); ?>
			<?php endwhile; ?>
		</section>
		<?php
	endif;
	?>
	<section class="archive-read-more" aria-label="<?php esc_attr_e( 'Read more', 'clear-theme' ); ?>">
		<h2><?php esc_html_e( 'Read more', 'clear-theme' ); ?></h2>
		<?php get_template_part( 'template-parts/pagination' ); ?>
	</section>
	<?php
else :
	?>
	<section class="empty-state">
		<p><?php echo esc_html( $empty_text ? $empty_text : __( 'No posts yet.', 'clear-theme' ) ); ?></p>
	</section>
	<?php
endif;
