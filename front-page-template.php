<?php
/**
 * Front Page Template - Personal Site
 * Template Name: front-page-personal.php
 *
 * @package Versatile
 */

get_header(); ?>

<main class="main-content site-type-personal">
	<!-- Hero Section -->
	<section class="hero-section">
		<div class="container">
			<div class="hero-content text-center">
				<?php if ( get_theme_mod( 'hero_image' ) ) : ?>
					<div class="hero-avatar">
						<img src="<?php echo esc_url( get_theme_mod( 'hero_image' ) ); ?>" alt="<?php echo esc_html( bloginfo( 'name' ) ); ?>" class="img-fluid">
					</div>
				<?php endif; ?>
				
				<h1 class="hero-title">
					<?php echo esc_html( get_theme_mod( 'hero_title', 'Hello, I\'m ' . esc_html( get_bloginfo( 'name' ) ) ) ); ?>
				</h1>
				
				<p class="hero-subtitle">
					<?php echo esc_html( get_theme_mod( 'hero_subtitle', esc_html( get_bloginfo( 'description' ) ) ) ); ?>
				</p>
				
				<?php if ( get_theme_mod( 'hero_cta_text' ) && get_theme_mod( 'hero_cta_url' ) ) : ?>
					<a href="<?php echo esc_url( get_theme_mod( 'hero_cta_url' ) ); ?>" class="btn btn-primary">
						<?php echo esc_html( get_theme_mod( 'hero_cta_text' ) ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- About Section -->
	<?php if ( get_theme_mod( 'about_content' ) ) : ?>
		<section class="about-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8 mx-auto">
						<h2 class="section-title text-center">About Me</h2>
						<div class="about-content">
							<?php echo wp_kses_post( get_theme_mod( 'about_content' ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Latest Posts -->
	<section class="latest-posts">
		<div class="container">
			<h2 class="section-title text-center">Latest Posts</h2>
			<div class="posts-grid">
				<?php
				$recent_posts = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'post_status'    => 'publish',
					)
				);

				if ( $recent_posts->have_posts() ) :
					while ( $recent_posts->have_posts() ) :
						$recent_posts->the_post();
						?>
						<article class="post-card">
							<div class="post-thumbnail">
								<a href="<?php the_permalink(); ?>">
									<?php echo esc_html( versatile_get_post_image( get_the_ID(), 'versatile-featured', array( 'class' => 'img-fluid' ) ) ); ?>
								</a>
							</div>
							
							<div class="post-content">
								<h3 class="post-title">
									<a href="<?php the_permalink(); ?>"><?php echo esc_html( the_title() ); ?></a>
								</h3>
								<div class="post-meta">
									<span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
								</div>
								<div class="post-excerpt">
									<?php echo esc_html( the_excerpt() ); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			
			<div class="text-center mt-3">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn btn-secondary">
					View All Posts
				</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>

<?php
/**
 * Front Page Template - E-commerce Site
 * Template Name: front-page-ecommerce.php
 *
 * @package Versatile
 */

get_header();
?>

<main class="main-content site-type-ecommerce">
	<!-- Hero Banner -->
	<section class="hero-banner">
		<div class="container">
			<div class="hero-content">
				<div class="row align-items-center">
					<div class="col-md-6">
						<h1 class="hero-title">
							<?php echo esc_html( get_theme_mod( 'shop_hero_title', 'Welcome to Our Store' ) ); ?>
						</h1>
						<p class="hero-subtitle">
							<?php echo esc_html( get_theme_mod( 'shop_hero_subtitle', 'Discover amazing products at great prices' ) ); ?>
						</p>
						<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary">
							Shop Now
						</a>
					</div>
					<div class="col-md-6">
						<?php if ( get_theme_mod( 'shop_hero_image' ) ) : ?>
							<img src="<?php echo esc_url( get_theme_mod( 'shop_hero_image' ) ); ?>" alt="Hero" class="img-fluid">
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Featured Categories -->
	<?php
	if ( class_exists( 'WooCommerce' ) ) :
		$featured_categories = get_theme_mod( 'featured_categories', array() );
		if ( ! empty( $featured_categories ) ) :
			?>
			<section class="featured-categories">
				<div class="container">
					<h2 class="section-title text-center">Shop by Category</h2>
					<div class="categories-grid">
						<?php
						foreach ( $featured_categories as $feature_cat_id ) :
							$category = get_term( $feature_cat_id, 'product_cat' );
							if ( $category && ! is_wp_error( $category ) ) :
								$thumbnail_id = get_term_meta( $feature_cat_id, 'thumbnail_id', true );
								$image        = wp_get_attachment_url( $thumbnail_id );
								?>
								<div class="category-card">
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
										<?php if ( $image ) : ?>
											<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" class="img-fluid">
										<?php endif; ?>
										<h3><?php echo esc_html( $category->name ); ?></h3>
									</a>
								</div>
								<?php
							endif;
						endforeach;
						?>
					</div>
				</div>
			</section>
			<?php
		endif;
	endif;
	?>

	<!-- Featured Products -->
	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<section class="featured-products">
			<div class="container">
				<h2 class="section-title text-center">Featured Products</h2>
				<?php echo do_shortcode( '[featured_products limit="8" columns="4"]' ); ?>
			</div>
		</section>

		<!-- Latest Products -->
		<section class="latest-products">
			<div class="container">
				<h2 class="section-title text-center">New Arrivals</h2>
				<?php echo do_shortcode( '[recent_products limit="8" columns="4"]' ); ?>
			</div>
		</section>

		<!-- Sale Products -->
		<section class="sale-products">
			<div class="container">
				<h2 class="section-title text-center">On Sale</h2>
				<?php echo do_shortcode( '[sale_products limit="4" columns="4"]' ); ?>
			</div>
		</section>
	<?php endif; ?>

	<!-- Newsletter Signup -->
	<section class="newsletter-section">
		<div class="container">
			<div class="newsletter-content text-center">
				<h2>Stay Updated</h2>
				<p>Subscribe to our newsletter for the latest products and exclusive offers</p>
				<form class="newsletter-form">
					<div class="form-group">
						<input type="email" placeholder="Enter your email address" required>
						<button type="submit" class="btn btn-primary">Subscribe</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>

<?php
/**
 * Front Page Template - Business Site
 * Template Name: front-page-business.php
 */

get_header();
?>

<main class="main-content site-type-business">
	<!-- Hero Section -->
	<section class="hero-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="hero-content">
						<h1 class="hero-title">
							<?php echo esc_html( get_theme_mod( 'business_hero_title', 'Your Business Success Starts Here' ) ); ?>
						</h1>
						<p class="hero-subtitle">
							<?php echo esc_html( get_theme_mod( 'business_hero_subtitle', 'We provide professional solutions for your business needs' ) ); ?>
						</p>
						<div class="hero-actions">
							<?php if ( get_theme_mod( 'business_cta_primary_text' ) && get_theme_mod( 'business_cta_primary_url' ) ) : ?>
								<a href="<?php echo esc_url( get_theme_mod( 'business_cta_primary_url' ) ); ?>" class="btn btn-primary">
									<?php echo esc_html( get_theme_mod( 'business_cta_primary_text' ) ); ?>
								</a>
							<?php endif; ?>
							<?php if ( get_theme_mod( 'business_cta_secondary_text' ) && get_theme_mod( 'business_cta_secondary_url' ) ) : ?>
								<a href="<?php echo esc_url( get_theme_mod( 'business_cta_secondary_url' ) ); ?>" class="btn btn-secondary">
									<?php echo esc_html( get_theme_mod( 'business_cta_secondary_text' ) ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<?php if ( get_theme_mod( 'business_hero_image' ) ) : ?>
						<div class="hero-image">
							<img src="<?php echo esc_url( get_theme_mod( 'business_hero_image' ) ); ?>" alt="Hero" class="img-fluid">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- Services Section -->
	<section class="services-section">
		<div class="container">
			<h2 class="section-title text-center">Our Services</h2>
			<div class="services-grid">
				<?php
				// Get services from customizer or use default.
				$services = get_theme_mod( 'business_services', array() );
				if ( empty( $services ) ) {
					$services = array(
						array(
							'title'       => 'Consulting',
							'description' => 'Expert business consulting services',
							'icon'        => 'icon-briefcase',
						),
						array(
							'title'       => 'Development',
							'description' => 'Custom software development',
							'icon'        => 'icon-code',
						),
						array(
							'title'       => 'Support',
							'description' => '24/7 customer support',
							'icon'        => 'icon-support',
						),
					);
				}

				foreach ( $services as $service ) :
					?>
					<div class="service-card">
						<div class="service-icon">
							<i class="<?php echo esc_attr( $service['icon'] ); ?>"></i>
						</div>
						<h3 class="service-title"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="service-description"><?php echo esc_html( $service['description'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- About Section -->
	<section class="about-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<?php if ( get_theme_mod( 'business_about_image' ) ) : ?>
						<img src="<?php echo esc_url( get_theme_mod( 'business_about_image' ) ); ?>" alt="About Us" class="img-fluid">
					<?php endif; ?>
				</div>
				<div class="col-md-6">
					<div class="about-content">
						<h2><?php echo esc_html( get_theme_mod( 'business_about_title', 'About Our Company' ) ); ?></h2>
						<p><?php echo wp_kses_post( get_theme_mod( 'business_about_content', 'We are a professional company dedicated to providing excellent services to our clients.' ) ); ?></p>
						
						<?php if ( get_theme_mod( 'business_about_cta_text' ) && get_theme_mod( 'business_about_cta_url' ) ) : ?>
							<a href="<?php echo esc_url( get_theme_mod( 'business_about_cta_url' ) ); ?>" class="btn btn-primary">
								<?php echo esc_html( get_theme_mod( 'business_about_cta_text' ) ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Stats Section -->
	<section class="stats-section">
		<div class="container">
			<div class="stats-grid">
				<?php
				$stats = get_theme_mod( 'business_stats', array() );
				if ( empty( $stats ) ) {
					$stats = array(
						array(
							'number' => '500+',
							'label'  => 'Happy Clients',
						),
						array(
							'number' => '50+',
							'label'  => 'Projects Completed',
						),
						array(
							'number' => '10+',
							'label'  => 'Years Experience',
						),
						array(
							'number' => '24/7',
							'label'  => 'Support Available',
						),
					);
				}

				foreach ( $stats as $stat ) :
					?>
					<div class="stat-item">
						<div class="stat-number"><?php echo esc_html( $stat['number'] ); ?></div>
						<div class="stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Testimonials Section -->
	<section class="testimonials-section">
		<div class="container">
			<h2 class="section-title text-center">What Our Clients Say</h2>
			<div class="testimonials-grid">
				<?php
				$testimonials = get_theme_mod( 'business_testimonials', array() );
				if ( empty( $testimonials ) ) {
					$testimonials = array(
						array(
							'content' => 'Excellent service and professional team. Highly recommended!',
							'author'  => 'John Doe',
							'company' => 'ABC Corp',
						),
						array(
							'content' => 'They delivered exactly what we needed on time and within budget.',
							'author'  => 'Jane Smith',
							'company' => 'XYZ Ltd',
						),
					);
				}

				foreach ( $testimonials as $testimonial ) :
					?>
					<div class="testimonial-card">
						<div class="testimonial-content">
							<p>"<?php echo esc_html( $testimonial['content'] ); ?>"</p>
						</div>
						<div class="testimonial-author">
							<strong><?php echo esc_html( $testimonial['author'] ); ?></strong>
							<span><?php echo esc_html( $testimonial['company'] ); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Contact CTA Section -->
	<section class="contact-cta-section">
		<div class="container">
			<div class="contact-cta-content text-center">
				<h2><?php echo esc_html( get_theme_mod( 'business_cta_title', 'Ready to Get Started?' ) ); ?></h2>
				<p><?php echo esc_html( get_theme_mod( 'business_cta_subtitle', 'Contact us today to discuss your project requirements.' ) ); ?></p>
				<a href="<?php echo esc_url( get_theme_mod( 'business_contact_url', '/contact' ) ); ?>" class="btn btn-primary">
					Get In Touch
				</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>

<?php
/**
 * Front Page Template - Portfolio Site
 * Template Name: front-page-portfolio.php
 */

get_header();
?>

<main class="main-content site-type-portfolio">
	<!-- Hero Section -->
	<section class="portfolio-hero">
		<div class="container">
			<div class="hero-content text-center">
				<h1 class="hero-title">
					<?php echo esc_html( get_theme_mod( 'portfolio_hero_title', 'Creative Portfolio' ) ); ?>
				</h1>
				<p class="hero-subtitle">
					<?php echo esc_html( get_theme_mod( 'portfolio_hero_subtitle', 'Showcasing my creative work and passion projects' ) ); ?>
				</p>
			</div>
		</div>
	</section>

	<!-- Portfolio Grid -->
	<section class="portfolio-grid-section">
		<div class="container">
			<h2 class="section-title text-center">Featured Work</h2>
			<div class="portfolio-filter">
				<button class="filter-btn active" data-filter="*">All</button>
				<?php
				$portfolio_categories = get_terms(
					array(
						'taxonomy'   => 'portfolio_category',
						'hide_empty' => true,
					)
				);

				if ( $portfolio_categories && ! is_wp_error( $portfolio_categories ) ) :
					foreach ( $portfolio_categories as $category ) :
						?>
						<button class="filter-btn" data-filter=".<?php echo esc_attr( $category->slug ); ?>">
							<?php echo esc_html( $category->name ); ?>
						</button>
						<?php
					endforeach;
				endif;
				?>
			</div>
			
			<div class="portfolio-grid">
				<?php
				$portfolio_query = new WP_Query(
					array(
						'post_type'      => 'portfolio',
						'posts_per_page' => 12,
						'post_status'    => 'publish',
					)
				);

				if ( $portfolio_query->have_posts() ) :
					while ( $portfolio_query->have_posts() ) :
						$portfolio_query->the_post();
						$categories  = get_the_terms( get_the_ID(), 'portfolio_category' );
						$cat_classes = '';
						if ( $categories && ! is_wp_error( $categories ) ) {
							$cat_classes = implode( ' ', wp_list_pluck( $categories, 'slug' ) );
						}
						?>
						
						<div class="portfolio-item <?php echo esc_attr( $cat_classes ); ?>">
							<div class="portfolio-card">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="portfolio-image">
										<?php the_post_thumbnail( 'versatile-portfolio', array( 'class' => 'img-fluid' ) ); ?>
										<div class="portfolio-overlay">
											<div class="portfolio-actions">
												<a href="<?php the_permalink(); ?>" class="btn btn-primary">
													View Project
												</a>
												<?php if ( get_post_meta( get_the_ID(), 'portfolio_live_url', true ) ) : ?>
													<a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'portfolio_live_url', true ) ); ?>" 
														class="btn btn-secondary" target="_blank">
														Live Demo
													</a>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
								
								<div class="portfolio-content">
									<h3 class="portfolio-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
										<div class="portfolio-categories">
											<?php foreach ( $categories as $category ) : ?>
												<span class="portfolio-category"><?php echo esc_html( $category->name ); ?></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
			
			<div class="text-center mt-3">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" class="btn btn-secondary">
					View All Projects
				</a>
			</div>
		</div>
	</section>

	<!-- Skills Section -->
	<section class="skills-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Skills & Expertise</h2>
					<p><?php echo esc_html( get_theme_mod( 'portfolio_skills_intro', 'Here are some of the technologies and skills I work with:' ) ); ?></p>
				</div>
				<div class="col-md-6">
					<div class="skills-list">
						<?php
						$skills = get_theme_mod( 'portfolio_skills', array() );
						if ( empty( $skills ) ) {
							$skills = array(
								array(
									'name'  => 'HTML/CSS',
									'level' => '90',
								),
								array(
									'name'  => 'JavaScript',
									'level' => '85',
								),
								array(
									'name'  => 'PHP',
									'level' => '80',
								),
								array(
									'name'  => 'WordPress',
									'level' => '95',
								),
								array(
									'name'  => 'Photoshop',
									'level' => '75',
								),
							);
						}

						foreach ( $skills as $skill ) :
							?>
							<div class="skill-item">
								<div class="skill-info">
									<span class="skill-name"><?php echo esc_html( $skill['name'] ); ?></span>
									<span class="skill-percentage"><?php echo esc_html( $skill['level'] ); ?>%</span>
								</div>
								<div class="skill-bar">
									<div class="skill-progress" style="width: <?php echo esc_attr( $skill['level'] ); ?>%"></div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Contact Section -->
	<section class="contact-section">
		<div class="container">
			<div class="contact-content text-center">
				<h2><?php echo esc_html( get_theme_mod( 'portfolio_contact_title', 'Let\'s Work Together' ) ); ?></h2>
				<p><?php echo esc_html( get_theme_mod( 'portfolio_contact_subtitle', 'Have a project in mind? I\'d love to hear about it.' ) ); ?></p>
				<a href="<?php echo esc_url( get_theme_mod( 'portfolio_contact_url', '/contact' ) ); ?>" class="btn btn-primary">
					Get In Touch
				</a>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>