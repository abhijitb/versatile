<?php
/**
 * The header template file
 * This template part displays the HTML head and opening body tag
 * Versatile WordPress Theme
 *
 * @package Versatile
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'versatile' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-wrapper">
			<div class="container">
				<div class="header-content">
					<?php get_template_part( 'template-parts/header/site-branding' ); ?>
					<?php get_template_part( 'template-parts/header/site-navigation' ); ?>

					<div class="header-actions">
						<button type="button" class="search-toggle" aria-controls="site-search-overlay" aria-expanded="false">
							<i class="fas fa-search" aria-hidden="true"></i>
							<span class="screen-reader-text"><?php esc_html_e( 'Search', 'versatile' ); ?></span>
						</button>

						<?php if ( class_exists( 'WooCommerce' ) && WC()->cart ) : ?>
							<div class="header-cart">
								<?php versatile_woocommerce_cart_link(); ?>

								<div class="mini-cart-wrapper">
									<?php if ( ! WC()->cart->is_empty() ) : ?>
										<div class="widget_shopping_cart_content">
											<?php woocommerce_mini_cart(); ?>
										</div>
									<?php else : ?>
										<p class="empty-cart"><?php esc_html_e( 'Your cart is empty', 'versatile' ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( get_theme_mod( 'versatile_social_links_header', false ) ) : ?>
							<div class="header-social">
								<?php versatile_social_links(); ?>
							</div>
						<?php endif; ?>

						<?php
						$cta_text = get_theme_mod( 'versatile_header_cta_text', '' );
						$cta_url  = get_theme_mod( 'versatile_header_cta_url', '' );
						if ( $cta_text && $cta_url ) :
							?>
							<div class="header-cta">
								<a href="<?php echo esc_url( $cta_url ); ?>" class="cta-button">
									<?php echo esc_html( $cta_text ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div id="site-search-overlay" class="search-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site search', 'versatile' ); ?>" aria-hidden="true">
			<div class="search-overlay-content">
				<button type="button" class="search-close">
					<i class="fas fa-times" aria-hidden="true"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Close search', 'versatile' ); ?></span>
				</button>
				<div class="search-form-wrapper">
					<h2><?php esc_html_e( 'Search the site', 'versatile' ); ?></h2>
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>

		<div id="mobile-navigation-overlay" class="mobile-menu-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Mobile navigation', 'versatile' ); ?>" aria-hidden="true">
			<div class="mobile-menu-content">
				<div class="mobile-menu-header">
					<div class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					</div>
					<button type="button" class="mobile-menu-close">
						<i class="fas fa-times" aria-hidden="true"></i>
						<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'versatile' ); ?></span>
					</button>
				</div>

				<nav class="mobile-navigation" aria-label="<?php esc_attr_e( 'Mobile menu', 'versatile' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'mobile-menu',
							'menu_class'     => 'mobile-menu',
							'container'      => false,
							'fallback_cb'    => 'versatile_fallback_menu',
						)
					);
					?>
				</nav>

				<div class="mobile-search">
					<?php get_search_form(); ?>
				</div>

				<?php if ( get_theme_mod( 'versatile_social_links_mobile', true ) ) : ?>
					<div class="mobile-social">
						<?php versatile_social_links(); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<div id="content" class="site-content">
