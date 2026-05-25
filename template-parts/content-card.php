<?php
/**
 * Post card.
 *
 * @package Clear
 */

global $wp_query;
$index        = (int) $wp_query->current_post;
$layout_class = 'post-card--compact';

if ( 0 === $index ) {
	$layout_class = 'post-card--feature';
} elseif ( 0 === $index % 4 ) {
	$layout_class = 'post-card--compact';
} elseif ( 0 === $index % 2 ) {
	$layout_class = 'post-card--left';
} else {
	$layout_class = 'post-card--right';
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
		<div class="post-card__excerpt"><?php the_excerpt(); ?></div>
		<p class="post-card__meta"><?php echo wp_kses_post( clrthm_get_post_byline() ); ?></p>
	</div>
</article>
