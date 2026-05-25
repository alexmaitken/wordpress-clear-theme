<?php
/**
 * Post card.
 */
?>
<article <?php post_class( 'post-card' ); ?> id="post-<?php the_ID(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php the_post_thumbnail( 'clrthm-card' ); ?></a>
	<?php endif; ?>
	<div class="post-card__content">
		<p class="post-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
		<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php the_excerpt(); ?>
	</div>
</article>
