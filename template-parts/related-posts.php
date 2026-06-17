<?php
/**
 * Related posts section.
 *
 * @package Clear
 */

$current_post_id = get_the_ID();
$category_ids    = wp_get_post_categories( $current_post_id, array( 'fields' => 'ids' ) );
$tag_ids         = wp_get_post_tags( $current_post_id, array( 'fields' => 'ids' ) );
$tax_query       = array();

if ( ! empty( $category_ids ) ) {
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field'    => 'term_id',
		'terms'    => $category_ids,
	);
}

if ( ! empty( $tag_ids ) ) {
	$tax_query[] = array(
		'taxonomy' => 'post_tag',
		'field'    => 'term_id',
		'terms'    => $tag_ids,
	);
}

if ( count( $tax_query ) > 1 ) {
	$tax_query['relation'] = 'OR';
}

$related_args = array(
	'posts_per_page'      => 2,
	'post__not_in'        => array( $current_post_id ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( ! empty( $tax_query ) ) {
	$related_args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
}

$clrthm_related = get_posts( $related_args );

if ( empty( $clrthm_related ) ) {
	return;
}
?>
<section class="related-posts" aria-labelledby="related-posts-title">
	<h2 id="related-posts-title"><?php esc_html_e( 'Related stories', 'clear-theme' ); ?></h2>
	<div class="related-posts__grid">
		<?php foreach ( $clrthm_related as $related_post ) : ?>
			<?php
			$related_id    = $related_post->ID;
			$related_title = get_the_title( $related_id );
			?>
			<article class="related-posts__item">
				<a class="related-posts__media" href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" aria-hidden="true" tabindex="-1">
					<?php if ( has_post_thumbnail( $related_id ) ) : ?>
						<?php echo get_the_post_thumbnail( $related_id, 'clrthm-card' ); ?>
					<?php else : ?>
						<span class="related-posts__placeholder" aria-hidden="true"></span>
					<?php endif; ?>
				</a>
				<h3 class="related-posts__title"><a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>"><?php echo esc_html( $related_title ); ?></a></h3>
			</article>
		<?php endforeach; ?>
	</div>
</section>
