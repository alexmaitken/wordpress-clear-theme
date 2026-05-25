<?php get_header(); ?>
<header class="page-header">
	<h1><?php bloginfo( 'name' ); ?></h1>
	<p><?php bloginfo( 'description' ); ?></p>
</header>
<div class="post-grid entry-list">
	<?php
	$clrthm_query = new WP_Query( array( 'posts_per_page' => 10 ) );
	if ( $clrthm_query->have_posts() ) :
		while ( $clrthm_query->have_posts() ) :
			$clrthm_query->the_post();
			get_template_part( 'template-parts/content', 'card' );
		endwhile;
		wp_reset_postdata();
	else :
		?>
		<p><?php esc_html_e( 'Publish your first story to get started.', 'clear-theme' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
