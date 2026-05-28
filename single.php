<?php
/**
 * Single post template.
 *
 * @package Clear
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content', 'single' );
		get_template_part( 'template-parts/author', 'box' );

		if ( get_theme_mod( 'clrthm_show_related_posts', 1 ) ) :
			get_template_part( 'template-parts/related', 'posts' );
		endif;

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

		clrthm_render_post_navigation();
	endwhile;
endif;

get_footer();
