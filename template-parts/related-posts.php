<?php
$clrthm_related = get_posts(
	array(
		'posts_per_page'      => 3,
		'post__not_in'        => array( get_the_ID() ),
		'ignore_sticky_posts' => true,
	)
);
if ( ! empty( $clrthm_related ) ) :
	?>
<section class="related-posts">
	<h2><?php esc_html_e( 'Related stories', 'clear-theme' ); ?></h2>
	<ul>
		<?php foreach ( $clrthm_related as $post ) : setup_postdata( $post ); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endforeach; wp_reset_postdata(); ?>
	</ul>
</section>
<?php endif; ?>
