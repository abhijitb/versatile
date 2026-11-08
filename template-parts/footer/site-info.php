<?php
/**
 * Template part for displaying site info in footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

$contact_phone   = get_theme_mod( 'versatile_contact_phone', '' );
$contact_email   = get_theme_mod( 'versatile_contact_email', '' );
$contact_address = get_theme_mod( 'versatile_contact_address', '' );
$copyright_text  = get_theme_mod( 'versatile_copyright_text', '' );
?>

<div class="footer-info">
	<div class="container">
		<?php if ( $contact_phone || $contact_email || $contact_address ) : ?>
			<div class="footer-contact">
				<?php if ( $contact_phone ) : ?>
					<p class="footer-contact-phone">
						<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a>
					</p>
				<?php endif; ?>

				<?php if ( $contact_email ) : ?>
					<p class="footer-contact-email">
						<a href="<?php echo esc_url( 'mailto:' . antispambot( $contact_email ) ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a>
					</p>
				<?php endif; ?>

				<?php if ( $contact_address ) : ?>
					<address class="footer-contact-address"><?php echo wp_kses_post( nl2br( $contact_address ) ); ?></address>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="footer-info-content">
			<div class="footer-copyright">
				<?php if ( $copyright_text ) : ?>
					<?php echo wp_kses_post( $copyright_text ); ?>
				<?php else : ?>
					<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
						<?php esc_html_e( 'All rights reserved.', 'versatile' ); ?>
					</p>
				<?php endif; ?>
			</div>

			<?php if ( get_theme_mod( 'versatile_show_theme_credit', true ) ) : ?>
				<p class="theme-credit">
					<?php
					printf(
						/* translators: %s is the theme name. */
						esc_html__( 'Theme: %s', 'versatile' ),
						esc_html__( 'Versatile', 'versatile' )
					);
					?>
				</p>
			<?php endif; ?>
			
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
