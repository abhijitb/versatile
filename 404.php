<?php
/**
 * Template for displaying 404 error pages
 * Versatile WordPress Theme
 */

get_header(); ?>

<main class="site-main error-404-main">
	
	<!-- 404 Hero Section -->
	<section class="error-404-hero">
		<div class="container">
			<div class="error-404-content">
				
				<!-- 404 Animation/Graphic -->
				<div class="error-404-graphic">
					<div class="error-number">
						<span class="number-4">4</span>
						<span class="number-0">
							<i class="fas fa-search"></i>
						</span>
						<span class="number-4">4</span>
					</div>
					<div class="error-illustration">
						<i class="fas fa-exclamation-triangle"></i>
					</div>
				</div>
				
				<div class="error-404-text">
					<h1 class="error-title"><?php esc_html_e( 'Oops! Page Not Found', 'versatile' ); ?></h1>
					<p class="error-description">
						<?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'versatile' ); ?>
					</p>
					
					<!-- Search Form -->
					<div class="error-search">
						<h3><?php esc_html_e( 'Try searching for what you need:', 'versatile' ); ?></h3>
						<form role="search" method="get" class="error-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="search-input-group">
								<input type="search" 
										class="search-field" 
										placeholder="<?php esc_attr_e( 'Search...', 'versatile' ); ?>" 
										name="s" 
										title="<?php esc_attr_e( 'Search for:', 'versatile' ); ?>"
										autocomplete="off">
								<button type="submit" class="search-submit">
									<i class="fas fa-search"></i>
								</button>
							</div>
						</form>
					</div>
					
					<!-- Action Buttons -->
					<div class="error-actions">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">
							<i class="fas fa-home"></i>
							<?php esc_html_e( 'Go to Homepage', 'versatile' ); ?>
						</a>
						<button onclick="history.back()" class="btn btn-secondary btn-lg">
							<i class="fas fa-arrow-left"></i>
							<?php esc_html_e( 'Go Back', 'versatile' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Helpful Content Section -->
	<section class="error-404-content-section">
		<div class="container">
			<div class="row">
				
				<!-- Popular Content -->
				<div class="col-lg-4 col-md-6">
					<div class="helpful-widget">
						<h3><?php esc_html_e( 'Popular Posts', 'versatile' ); ?></h3>
						<?php
						$popular_posts = get_posts(
							array(
								'numberposts' => 5,
								'orderby'     => 'comment_count',
								'order'       => 'DESC',
								'post_status' => 'publish',
							)
						);

						if ( $popular_posts ) :
							?>
							<div class="popular-posts-list">
								<?php foreach ( $popular_posts as $post ) : ?>
									<div class="popular-post-item">
										<div class="post-thumb">
											<a href="<?php echo get_permalink( $post->ID ); ?>">
												<?php echo versatile_get_small_post_image( $post->ID, array( 60, 60 ) ); ?>
											</a>
										</div>
										<div class="post-content">
											<h5><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h5>
											<span class="post-date"><?php echo get_the_date( 'M j, Y', $post->ID ); ?></span>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<p><?php esc_html_e( 'No popular posts found.', 'versatile' ); ?></p>
						<?php endif; ?>
					</div>
				</div>
				
				<!-- Categories -->
				<div class="col-lg-4 col-md-6">
					<div class="helpful-widget">
						<h3><?php esc_html_e( 'Browse Categories', 'versatile' ); ?></h3>
						<?php
						$categories = get_categories(
							array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'number'     => 8,
								'hide_empty' => true,
							)
						);

						if ( $categories ) :
							?>
							<div class="categories-grid">
								<?php foreach ( $categories as $category ) : ?>
									<a href="<?php echo get_category_link( $category->term_id ); ?>" class="category-item">
										<div class="category-info">
											<span class="category-name"><?php echo $category->name; ?></span>
											<span class="category-count"><?php echo $category->count; ?> <?php echo _n( 'post', 'posts', $category->count, 'versatile' ); ?></span>
										</div>
										<i class="fas fa-arrow-right"></i>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				
				<!-- Recent Posts -->
				<div class="col-lg-4 col-md-12">
					<div class="helpful-widget">
						<h3><?php esc_html_e( 'Recent Posts', 'versatile' ); ?></h3>
						<?php
						$recent_posts = get_posts(
							array(
								'numberposts' => 5,
								'orderby'     => 'date',
								'order'       => 'DESC',
								'post_status' => 'publish',
							)
						);

						if ( $recent_posts ) :
							?>
							<div class="recent-posts-list">
								<?php foreach ( $recent_posts as $post ) : ?>
									<div class="recent-post-item">
										<div class="post-thumb">
											<a href="<?php echo get_permalink( $post->ID ); ?>">
												<?php echo versatile_get_small_post_image( $post->ID, array( 60, 60 ) ); ?>
											</a>
										</div>
										<div class="post-content">
											<h5><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post->ID ); ?></a></h5>
											<div class="post-meta">
												<span class="post-date"><?php echo get_the_date( 'M j, Y', $post->ID ); ?></span>
												<span class="post-author"><?php echo get_the_author_meta( 'display_name', $post->post_author ); ?></span>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Tags Cloud Section -->
	<section class="error-404-tags-section">
		<div class="container">
			<div class="tags-widget">
				<h3><?php esc_html_e( 'Popular Tags', 'versatile' ); ?></h3>
				<?php
				$tags = get_tags(
					array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'number'     => 20,
						'hide_empty' => true,
					)
				);

				if ( $tags ) :
					?>
					<div class="tags-cloud">
						<?php foreach ( $tags as $tag ) : ?>
							<a href="<?php echo get_tag_link( $tag->term_id ); ?>" 
								class="tag-link" 
								style="font-size: <?php echo min( 20, 12 + ( $tag->count * 2 ) ); ?>px;">
								<?php echo $tag->name; ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Contact/Help Section -->
	<section class="error-404-help-section">
		<div class="container">
			<div class="help-content">
				<div class="row align-items-center">
					<div class="col-lg-6">
						<div class="help-text">
							<h3><?php esc_html_e( 'Still need help?', 'versatile' ); ?></h3>
							<p><?php esc_html_e( 'If you can\'t find what you\'re looking for, don\'t hesitate to get in touch. We\'re here to help!', 'versatile' ); ?></p>
							
							<div class="help-options">
								<?php
								// Get contact page URL
								$contact_page = get_page_by_path( 'contact' );
								if ( ! $contact_page ) {
									$contact_page = get_page_by_path( 'contact-us' );
								}

								if ( $contact_page ) :
									?>
									<a href="<?php echo get_permalink( $contact_page->ID ); ?>" class="btn btn-outline-primary">
										<i class="fas fa-envelope"></i>
										<?php esc_html_e( 'Contact Us', 'versatile' ); ?>
									</a>
								<?php endif; ?>
								
								<?php
								// Check if there's a support or FAQ page
								$faq_page = get_page_by_path( 'faq' );
								if ( ! $faq_page ) {
									$faq_page = get_page_by_path( 'frequently-asked-questions' );
								}

								if ( $faq_page ) :
									?>
									<a href="<?php echo get_permalink( $faq_page->ID ); ?>" class="btn btn-outline-secondary">
										<i class="fas fa-question-circle"></i>
										<?php esc_html_e( 'FAQ', 'versatile' ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6">
						<div class="help-illustration">
							<i class="fas fa-life-ring fa-5x"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<style>
/* 404 Page Specific Styles */
.error-404-main {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white;
}

.error-404-hero {
	padding: 100px 0;
	text-align: center;
}

.error-404-graphic {
	margin-bottom: 40px;
}

.error-number {
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 120px;
	font-weight: bold;
	margin-bottom: 20px;
}

.error-number span {
	margin: 0 10px;
}

.number-0 {
	position: relative;
	color: #ffd700;
}

.number-0 i {
	font-size: 60px;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	animation: bounce 2s infinite;
}

@keyframes bounce {
	0%, 20%, 50%, 80%, 100% {
		transform: translate(-50%, -50%) translateY(0);
	}
	40% {
		transform: translate(-50%, -50%) translateY(-10px);
	}
	60% {
		transform: translate(-50%, -50%) translateY(-5px);
	}
}

.error-illustration i {
	font-size: 80px;
	color: #ff6b6b;
	animation: pulse 2s infinite;
}

@keyframes pulse {
	0% {
		transform: scale(1);
	}
	50% {
		transform: scale(1.1);
	}
	100% {
		transform: scale(1);
	}
}

.error-title {
	font-size: 2.5rem;
	margin-bottom: 20px;
}

.error-description {
	font-size: 1.2rem;
	margin-bottom: 40px;
	opacity: 0.9;
}

.error-search {
	margin-bottom: 40px;
}

.error-search h3 {
	font-size: 1.1rem;
	margin-bottom: 15px;
}

.error-search-form .search-input-group {
	display: flex;
	max-width: 500px;
	margin: 0 auto;
	border-radius: 50px;
	overflow: hidden;
	box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.error-search-form .search-field {
	flex: 1;
	padding: 15px 20px;
	border: none;
	font-size: 16px;
	outline: none;
}

.error-search-form .search-submit {
	padding: 15px 25px;
	border: none;
	background: var(--primary-color);
	color: white;
	cursor: pointer;
	transition: all 0.3s ease;
}

.error-search-form .search-submit:hover {
	background: var(--primary-hover);
}

.error-actions {
	display: flex;
	gap: 15px;
	justify-content: center;
	flex-wrap: wrap;
}

.error-404-content-section {
	padding: 80px 0;
	background: white;
	color: #333;
}

.helpful-widget {
	background: #f8f9fa;
	padding: 30px;
	border-radius: 10px;
	margin-bottom: 30px;
	box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.helpful-widget h3 {
	color: #333;
	margin-bottom: 20px;
	font-size: 1.25rem;
}

.popular-post-item,
.recent-post-item {
	display: flex;
	align-items: center;
	margin-bottom: 15px;
	padding: 10px 0;
	border-bottom: 1px solid #eee;
}

.popular-post-item:last-child,
.recent-post-item:last-child {
	border-bottom: none;
	margin-bottom: 0;
}

.post-thumb {
	flex-shrink: 0;
	margin-right: 15px;
}

.post-thumb img {
	border-radius: 8px;
}

.post-content h5 {
	margin: 0 0 5px 0;
	font-size: 14px;
	line-height: 1.4;
}

.post-content h5 a {
	color: #333;
	text-decoration: none;
}

.post-content h5 a:hover {
	color: #667eea;
}

.post-date,
.post-author {
	font-size: 12px;
	color: #666;
}

.categories-grid {
	display: grid;
	gap: 10px;
}

.category-item {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 12px 15px;
	background: white;
	border-radius: 8px;
	text-decoration: none;
	color: #333;
	transition: all 0.3s ease;
	border: 1px solid #e9ecef;
}

.category-item:hover {
	background: #667eea;
	color: white;
	text-decoration: none;
}

.category-name {
	font-weight: 600;
}

.category-count {
	font-size: 12px;
	opacity: 0.7;
}

.error-404-tags-section {
	padding: 60px 0;
	background: #f8f9fa;
}

.tags-cloud {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.tag-link {
	padding: 8px 15px;
	background: white;
	border-radius: 25px;
	text-decoration: none;
	color: #333;
	border: 1px solid #e9ecef;
	transition: all 0.3s ease;
}

.tag-link:hover {
	background: #667eea;
	color: white;
	text-decoration: none;
}

.error-404-help-section {
	padding: 80px 0;
	background: #667eea;
	color: white;
}

.help-illustration {
	text-align: center;
}

.help-illustration i {
	color: rgba(255,255,255,0.3);
}

.help-options {
	margin-top: 20px;
}

.help-options .btn {
	margin-right: 15px;
	margin-bottom: 10px;
}

@media (max-width: 768px) {
	.error-number {
		font-size: 80px;
	}
	
	.error-title {
		font-size: 2rem;
	}
	
	.error-actions {
		flex-direction: column;
		align-items: center;
	}
	
	.error-actions .btn {
		width: 100%;
		max-width: 300px;
	}
}
</style>

<script>
// Auto-focus search field
document.addEventListener('DOMContentLoaded', function() {
	const searchField = document.querySelector('.error-search-form .search-field');
	if (searchField) {
		searchField.focus();
	}
	
	// Add some interactive effects
	const errorNumber = document.querySelector('.error-number');
	if (errorNumber) {
		errorNumber.addEventListener('mouseenter', function() {
			this.style.transform = 'scale(1.1)';
			this.style.transition = 'transform 0.3s ease';
		});
		
		errorNumber.addEventListener('mouseleave', function() {
			this.style.transform = 'scale(1)';
		});
	}
});
</script>

<?php get_footer(); ?>