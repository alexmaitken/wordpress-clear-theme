<?php
/**
 * Page content template.
 *
 * @package Clear
 */

$entry_id     = get_the_ID();
$layout_class = clrthm_get_single_layout_class( $entry_id );
$hero_image   = clrthm_should_render_featured_image( $entry_id ) ? clrthm_get_featured_image_html( $entry_id ) : '';
?>
<article <?php post_class( 'page-entry single-entry ' . $layout_class ); ?> id="post-<?php the_ID(); ?>">
	<header class="page-entry__header single-hero">
		<?php if ( $hero_image ) : ?>
			<figure class="single-hero__media"><?php echo $hero_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
		<?php endif; ?>
		<div class="single-hero__content">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</div>
	</header>
	<div class="page-entry__inner">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
	</div>
</article>
