<?php get_header(); ?>
<header class="page-header">
	<h1><?php the_archive_title(); ?></h1>
	<?php the_archive_description( '<div>', '</div>' ); ?>
</header>
<div class="entry-list">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'card' ); ?>
	<?php
	endwhile;
	the_posts_pagination(
		array(
			'prev_text'          => esc_html__( 'Previous page', 'clear-theme' ),
			'next_text'          => esc_html__( 'Next page', 'clear-theme' ),
			'screen_reader_text' => esc_html__( 'Posts navigation', 'clear-theme' ),
		)
	);
	else :
	?>
		<p><?php esc_html_e( 'Nothing found in this archive.', 'clear-theme' ); ?></p>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
