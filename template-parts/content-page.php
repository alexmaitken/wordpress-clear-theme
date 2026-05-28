<?php
/**
 * Page content template.
 *
 * @package Clear
 */
?>
<article <?php post_class( 'page-entry' ); ?> id="post-<?php the_ID(); ?>">
	<header class="page-entry__header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="page-entry__inner">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
	</div>
</article>
