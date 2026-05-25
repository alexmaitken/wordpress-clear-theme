<?php
/**
 * Related posts section.
 *
 * @package Clear
 */

$category_ids = wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) );
if ( empty( $category_ids ) ) {
	return;
}

$clrthm_related = get_posts(
	array(
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
		'category__in'        => $category_ids,
		'no_found_rows'       => true,
	)
);

if ( empty( $clrthm_related ) ) {
	return;
}
?>
<section class="related-posts">
	<h2><?php esc_html_e( 'Related stories', 'clear-theme' ); ?></h2>
	<ul>
		<?php foreach ( $clrthm_related as $post ) : setup_postdata( $post ); ?>
			<li><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></li>
		<?php endforeach; wp_reset_postdata(); ?>
	</ul>
</section>
