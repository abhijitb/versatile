<?php
/**
 * Template part for displaying site navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<nav id="site-navigation" class="main-navigation">
	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
		<span class="menu-toggle-text"><?php esc_html_e( 'Menu', 'versatile' ); ?></span>
		<span class="menu-toggle-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</button>
	
	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'menu-1',
			'menu_id'         => 'primary-menu',
			'menu_class'      => 'nav-menu',
			'container'       => 'div',
			'container_class' => 'nav-menu-container',
			'fallback_cb'     => 'versatile_fallback_menu',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		)
	);
	?>
</nav><!-- #site-navigation -->
