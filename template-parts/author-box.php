<?php
/**
 * Author box.
 *
 * @package Clear
 */

$author_id   = get_the_author_meta( 'ID' );
$author_bio  = get_the_author_meta( 'description' );
$author_name = get_the_author();

if ( ! $author_id && ! $author_bio ) {
	return;
}
?>
<section class="author-box">
	<h2><?php esc_html_e( 'About the author', 'clear-theme' ); ?></h2>
	<div class="author-box__inner">
		<?php echo get_avatar( $author_id, 88, '', $author_name, array( 'class' => 'author-box__avatar' ) ); ?>
		<div>
			<p class="author-box__meta"><?php echo esc_html( $author_name ); ?></p>
			<?php if ( $author_bio ) : ?>
				<p><?php echo esc_html( $author_bio ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
