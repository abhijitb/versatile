<?php
/**
 * Template part for displaying site info in footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<div class="footer-info">
	<div class="container">
		<div class="footer-info-content">
			<div class="footer-copyright">
				<p>&copy; <?php echo esc_html( get_the_date( 'Y' ) ); ?> 
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>. 
					<?php esc_html_e( 'All rights reserved.', 'versatile' ); ?>
				</p>
			</div>
			
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<div class="footer-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_id'        => 'footer-menu',
							'menu_class'     => 'footer-nav-menu',
							'container'      => false,
							'depth'          => 1,
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						)
					);
					?>
				</div>
			<?php endif; ?>
			
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<div class="footer-social">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'social',
							'menu_id'        => 'social-menu',
							'menu_class'     => 'social-nav-menu',
							'container'      => false,
							'depth'          => 1,
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						)
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
