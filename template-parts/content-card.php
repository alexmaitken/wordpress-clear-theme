<?php
/**
 * Post card.
 *
 * @package Clear
 */

$context = (string) get_query_var( 'clrthm_card_context', '' );
$slot_qv = get_query_var( 'clrthm_card_slot', null );
$slot    = null !== $slot_qv ? (int) $slot_qv : null;

$layout_class = 'post-card--compact';

if ( 'featured' === $context && null !== $slot && $slot >= 0 ) {
	if ( 0 === $slot ) {
		$layout_class = 'post-card--feature-hero';
	} else {
		$layout_class = 'post-card--feature-tile';
	}
} elseif ( 'entry-list' === $context ) {
	$layout_class = 'post-card--entry-row';
}
?>
<article <?php post_class( 'post-card ' . $layout_class ); ?> id="post-<?php the_ID(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'clrthm-card' ); ?>
		</a>
	<?php else : ?>
		<div class="post-card__media post-card__media--placeholder" aria-hidden="true"></div>
	<?php endif; ?>
	<div class="post-card__content">
		<?php
		$cats = clrthm_get_public_terms_html( get_the_ID(), 'category' );
		if ( 'post-card--feature-tile' !== $layout_class && $cats ) :
			?>
			<p class="post-card__tax">
				<?php echo wp_kses_post( $cats ); ?>
			</p>
			<?php
		endif;
		if ( 'post-card--feature-hero' === $layout_class || 'post-card--entry-row' === $layout_class ) :
			?>
			<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="post-card__excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 30, '' ) ); ?></div>
		<?php else : ?>
			<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php endif; ?>
		<div class="post-card__author">
			<?php if ( get_theme_mod( 'clrthm_link_author_pages', 0 ) ) : ?>
				<a class="post-card__avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" aria-label="<?php echo esc_attr( get_the_author() ); ?>">
					<?php echo wp_kses_post( clrthm_get_author_avatar( get_the_author_meta( 'ID' ) ) ); ?>
				</a>
			<?php else : ?>
				<span class="post-card__avatar"><?php echo wp_kses_post( clrthm_get_author_avatar( get_the_author_meta( 'ID' ) ) ); ?></span>
			<?php endif; ?>
			<p class="post-card__meta"><?php echo wp_kses_post( clrthm_get_post_byline() ); ?></p>
		</div>
	</div>
</article>
