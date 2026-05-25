<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>>
	<header class="entry-header"><h1 class="entry-title"><?php the_title(); ?></h1></header>
	<div class="entry-content"><?php the_content(); ?></div>
</article>
<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
