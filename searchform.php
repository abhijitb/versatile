<?php
/**
 * Search Form Template
 * Versatile WordPress Theme
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-input-wrapper">
		<input type="search" 
				class="search-field" 
				placeholder="<?php esc_attr_e( 'Search...', 'versatile' ); ?>" 
				value="<?php echo get_search_query(); ?>" 
				name="s" 
				title="<?php esc_attr_e( 'Search for:', 'versatile' ); ?>"
				required>
		<button type="submit" class="search-submit" title="<?php esc_attr_e( 'Search', 'versatile' ); ?>">
			<i class="fas fa-search"></i>
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'versatile' ); ?></span>
		</button>
	</div>
</form>
