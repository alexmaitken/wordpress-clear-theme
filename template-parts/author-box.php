<?php if ( get_the_author_meta( 'description' ) ) : ?>
<section class="author-box">
	<h2><?php esc_html_e( 'About the author', 'clear-theme' ); ?></h2>
	<p class="author-box__meta"><?php echo esc_html( get_the_author() ); ?></p>
	<p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
</section>
<?php endif; ?>
