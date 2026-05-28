<?php
/**
 * Text-first post list item.
 *
 * @package Clear
 */

?>
<article <?php post_class( has_post_thumbnail() ? 'post-list__item' : 'post-list__item post-list__item--no-thumb' ); ?> id="post-<?php the_ID(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<?php /* translators: %s: post title. */ ?>
		<a class="post-list__thumb" href="<?php the_permalink(); ?>" aria-label="<?php printf( esc_attr__( 'Read: %s', 'clear-theme' ), esc_attr( get_the_title() ) ); ?>">
			<?php the_post_thumbnail( 'medium' ); ?>
		</a>
	<?php endif; ?>

	<div class="post-list__content">
		<h2 class="post-list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="post-list__author">
			<?php if ( get_theme_mod( 'clrthm_link_author_pages', 0 ) ) : ?>
				<a class="post-list__avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" aria-label="<?php echo esc_attr( get_the_author() ); ?>">
					<?php echo wp_kses_post( clrthm_get_author_avatar( get_the_author_meta( 'ID' ), 36 ) ); ?>
				</a>
			<?php else : ?>
				<span class="post-list__avatar"><?php echo wp_kses_post( clrthm_get_author_avatar( get_the_author_meta( 'ID' ), 36 ) ); ?></span>
			<?php endif; ?>
			<div class="post-list__meta"><?php echo wp_kses_post( clrthm_get_post_byline() ); ?></div>
		</div>

		<?php
		$cats = clrthm_get_public_terms_html( get_the_ID(), 'category' );
		if ( $cats ) :
			?>
			<p class="post-list__tax"><?php echo wp_kses_post( $cats ); ?></p>
		<?php endif; ?>

		<div class="post-list__excerpt"><?php the_excerpt(); ?></div>
	</div>
</article>
