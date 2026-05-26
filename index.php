<?php
/**
 * Main template fallback.
 *
 * @package Clear
 */

get_header();
?>
<main id="main" class="site-main">
	<?php if ( have_posts() ) : ?>
		<div class="post-feed">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;
			?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'clear-theme' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
