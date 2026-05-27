<?php
/**
 * Blog home template.
 *
 * @package Clear
 */

get_header();

get_template_part(
	'template-parts/home-layout',
	null,
	array(
		'show_intro' => true,
		'empty_text' => __( 'No posts yet.', 'clear-theme' ),
	)
);

get_footer();
