<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'template-parts/content', 'single' ); ?>
	<?php get_template_part( 'template-parts/author', 'box' ); ?>
	<?php get_template_part( 'template-parts/related', 'posts' ); ?>
	<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
	<?php the_post_navigation(); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
