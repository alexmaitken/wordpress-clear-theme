<?php
/**
 * Single content.
 */
?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<p class="entry-meta"><?php printf( esc_html__( '%1$s · %2$s', 'clear-theme' ), esc_html( get_the_date() ), esc_html( get_the_author() ) ); ?></p>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry-thumbnail"><?php the_post_thumbnail( 'full' ); ?></figure>
	<?php endif; ?>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
	</div>
</article>
