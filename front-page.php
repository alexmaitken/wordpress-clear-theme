<?php
/**
 * Front page template for latest posts.
 *
 * @package Clear
 */

get_header();

get_template_part(
	'template-parts/home-layout',
	null,
	array(
		'show_intro' => true,
		'empty_text' => __( 'Publish your first story to get started.', 'clear-theme' ),
	)
);

get_footer();
