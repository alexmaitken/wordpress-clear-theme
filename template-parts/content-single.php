<?php
/**
 * Single content.
 *
 * @package Clear
 */

$entry_id      = get_the_ID();
$layout_class  = clrthm_get_single_layout_class( $entry_id );
$category_list = clrthm_get_public_terms_html( $entry_id, 'category' );
$tag_list      = clrthm_get_public_terms_html( $entry_id, 'post_tag' );
$hero_image    = clrthm_get_featured_image_html( $entry_id );
?>
<article <?php post_class( 'single-entry ' . $layout_class ); ?> id="post-<?php the_ID(); ?>">
	<header class="single-hero">
		<?php if ( $hero_image ) : ?>
			<figure class="single-hero__media"><?php echo $hero_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
		<?php endif; ?>
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
			<div class="single-hero__meta">
				<?php echo wp_kses_post( clrthm_get_post_byline() ); ?>
			</div>
			<?php if ( has_excerpt() ) : ?>
				<div class="single-hero__excerpt"><?php the_excerpt(); ?></div>
			<?php endif; ?>
		</div>
	</header>

	<div class="single-entry__inner">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
		<nav class="single-share" aria-label="<?php esc_attr_e( 'Share this post', 'clear-theme' ); ?>">
			<p class="single-share__label"><?php esc_html_e( 'Share', 'clear-theme' ); ?></p>
			<ul>
				<li><a href="<?php echo esc_url( 'https://x.com/intent/tweet?url=' . rawurlencode( get_permalink() ) . '&text=' . rawurlencode( get_the_title() ) ); ?>" aria-label="<?php esc_attr_e( 'Share on X', 'clear-theme' ); ?>"><span aria-hidden="true">𝕏</span></a></li>
				<li><a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'clear-theme' ); ?>"><span aria-hidden="true">in</span></a></li>
				<li><a href="<?php echo esc_url( 'mailto:?subject=' . rawurlencode( get_the_title() ) . '&body=' . rawurlencode( get_permalink() ) ); ?>" aria-label="<?php esc_attr_e( 'Share via Email', 'clear-theme' ); ?>"><span aria-hidden="true">✉</span></a></li>
			</ul>
		</nav>
	</div>
</article>
