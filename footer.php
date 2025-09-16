<?php
/**
 * The footer template file
 * Contains the closing of the #content div and all content after
 * Versatile WordPress Theme
 *
 * @package Versatile
 */

?>

	</div><!-- #content -->

	<!-- Footer -->
	<footer id="colophon" class="site-footer">
		
		<!-- Footer Widgets -->
		<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>
		
		<!-- Footer Info -->
		<?php get_template_part( 'template-parts/footer/site-info' ); ?>
		
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>