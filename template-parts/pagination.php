<?php
/**
 * Shared posts pagination.
 *
 * @package Clear
 */

the_posts_pagination(
	array(
		'mid_size'           => 1,
		'prev_text'          => esc_html__( 'Previous page', 'clear-theme' ),
		'next_text'          => esc_html__( 'Next page', 'clear-theme' ),
		'screen_reader_text' => esc_html__( 'Posts navigation', 'clear-theme' ),
	)
);
