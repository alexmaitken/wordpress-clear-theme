<?php
/**
 * Footer template.
 *
 * @package Clear
 */
?>
</main>
<footer class="site-footer">
	<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 'clear-theme' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
	<p><?php echo esc_html( sprintf( __( '© %1$s %2$s. Powered by WordPress.', 'clear-theme' ), gmdate( 'Y' ), get_bloginfo( 'name' ) ) ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
