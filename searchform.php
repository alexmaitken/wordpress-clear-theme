<?php
/**
 * Search form template.
 *
 * @package Clear
 */

$search_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $search_id ); ?>"><?php esc_html_e( 'Search for:', 'clear-theme' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $search_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'clear-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><?php esc_html_e( 'Search', 'clear-theme' ); ?></button>
</form>
