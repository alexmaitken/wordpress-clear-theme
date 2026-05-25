<?php
/**
 * Comments template.
 *
 * @package Clear
 */

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2>
			<?php
			/* translators: %s: number of comments. */
			echo esc_html( sprintf( _n( '%s comment', '%s comments', get_comments_number(), 'clear-theme' ), number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>
		<?php the_comments_navigation(); ?>
		<ol><?php wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) ); ?></ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
