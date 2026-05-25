<?php
/**
 * Single content.
 *
 * @package Clear
 */

$entry_id       = get_the_ID();
$layout_class  = clrthm_get_single_layout_class( $entry_id );
$category_list = clrthm_get_public_terms_html( $entry_id, 'category' );
$tag_list      = clrthm_get_public_terms_html( $entry_id, 'post_tag' );
$hero_image    = clrthm_get_featured_image_html( $entry_id );
?>
<article <?php post_class( 'single-entry ' . $layout_class ); ?> id="post-<?php the_ID(); ?>">
	<header class="single-hero">
		<div class="single-hero__content">
			<?php if ( $category_list || $tag_list ) : ?>
				<p class="single-hero__tax">
					<?php echo wp_kses_post( $category_list ); ?>
					<?php if ( $category_list && $tag_list ) : ?>
						<span aria-hidden="true"> · </span>
					<?php endif; ?>
					<?php echo wp_kses_post( $tag_list ); ?>
				</p>
			<?php endif; ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<div class="single-hero__excerpt"><?php the_excerpt(); ?></div>
			<?php endif; ?>
			<p class="single-hero__meta"><?php echo wp_kses_post( clrthm_get_post_byline() ); ?></p>
		</div>
		<?php if ( $hero_image ) : ?>
			<figure class="single-hero__media"><?php echo $hero_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
		<?php endif; ?>
	</header>

	<div class="single-entry__inner">
		<nav class="single-share" aria-label="<?php esc_attr_e( 'Share this post', 'clear-theme' ); ?>">
			<ul>
				<li><a href="https://x.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>"><?php esc_html_e( 'Share on X', 'clear-theme' ); ?></a></li>
				<li><a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>"><?php esc_html_e( 'Share on LinkedIn', 'clear-theme' ); ?></a></li>
				<li><a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=<?php echo rawurlencode( get_permalink() ); ?>"><?php esc_html_e( 'Share via Email', 'clear-theme' ); ?></a></li>
			</ul>
		</nav>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
	</div>
</article>
