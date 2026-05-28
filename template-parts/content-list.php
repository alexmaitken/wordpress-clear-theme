<?php
/**
 * Text-first post list item.
 *
 * @package Clear
 */

?>
<article <?php post_class( 'post-list__item' ); ?> id="post-<?php the_ID(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-list__thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'medium' ); ?>
		</a>
	<?php endif; ?>

	<div class="post-list__content">
		<h2 class="post-list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<p class="post-list__meta"><?php echo wp_kses_post( clrthm_get_post_byline() ); ?></p>

		<?php
		$cats = clrthm_get_public_terms_html( get_the_ID(), 'category' );
		if ( $cats ) :
			?>
			<p class="post-list__tax"><?php echo wp_kses_post( $cats ); ?></p>
		<?php endif; ?>

		<div class="post-list__excerpt"><?php the_excerpt(); ?></div>
	</div>
</article>
