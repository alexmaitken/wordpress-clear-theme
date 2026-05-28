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
		<h2 class="comments-title">
			<?php
			/* translators: %s: number of comments. */
			echo esc_html( sprintf( _n( '%s comment', '%s comments', get_comments_number(), 'clear-theme' ), number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>
			<nav class="comments-navigation comments-navigation--top" aria-label="<?php esc_attr_e( 'Comments navigation', 'clear-theme' ); ?>">
				<?php the_comments_navigation(); ?>
			</nav>
			<ol class="comment-list">
				<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'short_ping' => true,
					)
				);
				?>
			</ol>
		<nav class="comments-navigation comments-navigation--bottom" aria-label="<?php esc_attr_e( 'Comments navigation', 'clear-theme' ); ?>">
			<?php the_comments_navigation(); ?>
		</nav>
	<?php endif; ?>
	<div class="comment-form-wrap">
		<h3 class="comment-reply-title"><?php esc_html_e( 'Leave a comment', 'clear-theme' ); ?></h3>
		<?php comment_form( array( 'title_reply' => '' ) ); ?>
	</div>
</section>
