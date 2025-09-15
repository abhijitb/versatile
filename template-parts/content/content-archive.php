<?php
/**
 * Template part for displaying archive content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Versatile
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-post-item' ); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid' ) ); ?>
			</a>
		</div>
	<?php endif; ?>
	
	<div class="post-content">
		<div class="post-meta">
			<span class="post-date">
				<i class="fas fa-calendar-alt"></i>
				<?php echo get_the_date(); ?>
			</span>
			<span class="post-author">
				<i class="fas fa-user"></i>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php the_author(); ?>
				</a>
			</span>
			<?php if ( has_category() ) : ?>
				<span class="post-categories">
					<i class="fas fa-folder"></i>
					<?php the_category( ', ' ); ?>
				</span>
			<?php endif; ?>
		</div>
		
		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		
		<div class="post-excerpt">
			<?php
			if ( has_excerpt() ) {
				the_excerpt();
			} else {
				echo wp_trim_words( get_the_content(), 30, '...' );
			}
			?>
		</div>
		
		<div class="post-footer">
			<a href="<?php the_permalink(); ?>" class="read-more-btn">
				<?php esc_html_e( 'Read More', 'versatile' ); ?>
				<i class="fas fa-arrow-right"></i>
			</a>
			
			<?php if ( has_tag() ) : ?>
				<div class="post-tags">
					<?php the_tags( '', '', '' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	
</article><!-- #post-<?php the_ID(); ?> -->
