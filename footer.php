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
	<p><?php echo esc_html( clrthm_get_footer_copyright_text() ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>
