<?php
/**
 * Template part for displaying site branding
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<div class="site-branding">
	<?php the_custom_logo(); ?>
	
	<div class="site-title-wrapper">
		<?php
		if ( is_front_page() && is_home() ) :
			?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
		else :
			?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
		endif;
		$versatile_description = get_bloginfo( 'description', 'display' );
		if ( $versatile_description || is_customize_preview() ) :
			?>
			<p class="site-description"><?php echo $versatile_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
	</div><!-- .site-title-wrapper -->
</div><!-- .site-branding -->
