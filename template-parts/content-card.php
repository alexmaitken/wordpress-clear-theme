<?php
/**
 * Post card.
 *
 * @package Clear
 */

$context = (string) get_query_var( 'clrthm_card_context', 'featured' );
$slot    = (int) get_query_var( 'clrthm_card_slot', 0 );

$layout_class = 'post-card--compact';

if ( 'featured' === $context ) {
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
		$tags = clrthm_get_public_terms_html( get_the_ID(), 'post_tag' );
		if ( $cats || $tags ) :
			?>
			<p class="post-card__tax">
				<?php echo wp_kses_post( $cats ); ?>
				<?php if ( $cats && $tags ) : ?>
					<span aria-hidden="true">·</span>
				<?php endif; ?>
				<?php echo wp_kses_post( $tags ); ?>
			</p>
		<?php endif; ?>
		<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( 'post-card--feature-hero' === $layout_class || 'post-card--entry-row' === $layout_class ) : ?>
			<div class="post-card__excerpt"><?php the_excerpt(); ?></div>
		<?php endif; ?>
		<div class="post-card__author">
			<a class="post-card__avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" aria-label="<?php echo esc_attr( get_the_author() ); ?>">
				<?php echo wp_kses_post( clrthm_get_author_avatar( get_the_author_meta( 'ID' ) ) ); ?>
			</a>
			<p class="post-card__meta"><?php echo wp_kses_post( clrthm_get_post_byline() ); ?></p>
		</div>
	</div>
</article>
