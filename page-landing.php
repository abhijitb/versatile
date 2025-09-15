<?php
/**
 * Template Name: Landing Page
 * Template for creating conversion-focused landing pages
 * Versatile WordPress Theme
 */

get_header( 'landing' ); // Custom header for landing pages ?>

<main class="site-main landing-main">
	
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		
		<!-- Hero Section -->
		<section class="landing-hero" id="hero">
			<div class="hero-background">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="hero-image">
						<?php the_post_thumbnail( 'full' ); ?>
					</div>
				<?php endif; ?>
				<div class="hero-overlay"></div>
			</div>
			
			<div class="container">
				<div class="row align-items-center min-vh-100">
					<div class="col-lg-6">
						<div class="hero-content">
							<div class="hero-badge">
								<?php
								$hero_badge = get_post_meta( get_the_ID(), '_landing_hero_badge', true );
								echo $hero_badge ?: esc_html__( '🚀 New Launch', 'versatile' );
								?>
							</div>
							
							<h1 class="hero-title">
								<?php
								$hero_title = get_post_meta( get_the_ID(), '_landing_hero_title', true );
								echo $hero_title ?: get_the_title();
								?>
							</h1>
							
							<p class="hero-subtitle">
								<?php
								$hero_subtitle = get_post_meta( get_the_ID(), '_landing_hero_subtitle', true );
								echo $hero_subtitle ?: get_the_excerpt();
								?>
							</p>
							
							<div class="hero-features">
								<?php
								$hero_features = get_post_meta( get_the_ID(), '_landing_hero_features', true );
								$features      = $hero_features ? explode( "\n", $hero_features ) : array(
									'Easy to use interface',
									'Mobile-first design',
									'24/7 customer support',
								);

								foreach ( $features as $feature ) {
									if ( trim( $feature ) ) {
										echo '<div class="feature-item"><i class="fas fa-check"></i> ' . esc_html( trim( $feature ) ) . '</div>';
									}
								}
								?>
							</div>
							
							<div class="hero-cta">
								<?php
								$cta_text           = get_post_meta( get_the_ID(), '_landing_cta_text', true ) ?: esc_html__( 'Get Started Now', 'versatile' );
								$cta_url            = get_post_meta( get_the_ID(), '_landing_cta_url', true ) ?: '#signup';
								$cta_secondary_text = get_post_meta( get_the_ID(), '_landing_cta_secondary_text', true ) ?: esc_html__( 'Learn More', 'versatile' );
								$cta_secondary_url  = get_post_meta( get_the_ID(), '_landing_cta_secondary_url', true ) ?: '#features';
								?>
								<a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary btn-lg cta-primary">
									<i class="fas fa-rocket"></i>
									<?php echo esc_html( $cta_text ); ?>
								</a>
								<a href="<?php echo esc_url( $cta_secondary_url ); ?>" class="btn btn-outline-light btn-lg cta-secondary">
									<i class="fas fa-play"></i>
									<?php echo esc_html( $cta_secondary_text ); ?>
								</a>
							</div>
							
							<div class="hero-social-proof">
								<div class="social-proof-item">
									<i class="fas fa-users"></i>
									<span><?php echo get_post_meta( get_the_ID(), '_landing_users_count', true ) ?: '10,000+'; ?></span>
									<small><?php esc_html_e( 'Happy Users', 'versatile' ); ?></small>
								</div>
								<div class="social-proof-item">
									<i class="fas fa-star"></i>
									<span><?php echo get_post_meta( get_the_ID(), '_landing_rating', true ) ?: '4.9'; ?></span>
									<small><?php esc_html_e( 'Star Rating', 'versatile' ); ?></small>
								</div>
								<div class="social-proof-item">
									<i class="fas fa-award"></i>
									<span><?php echo get_post_meta( get_the_ID(), '_landing_awards', true ) ?: '15+'; ?></span>
									<small><?php esc_html_e( 'Awards Won', 'versatile' ); ?></small>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-6">
						<div class="hero-visual">
							<?php
							$hero_video = get_post_meta( get_the_ID(), '_landing_hero_video', true );
							if ( $hero_video ) :
								?>
								<div class="hero-video">
									<video autoplay muted loop>
										<source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
									</video>
									<div class="video-overlay">
										<button class="play-btn" onclick="toggleVideoPlay()">
											<i class="fas fa-play"></i>
										</button>
									</div>
								</div>
							<?php else : ?>
								<div class="hero-mockup">
									<div class="mockup-device">
										<div class="mockup-screen">
											<div class="mockup-content">
												<div class="mockup-header"></div>
												<div class="mockup-body">
													<div class="mockup-element"></div>
													<div class="mockup-element"></div>
													<div class="mockup-element"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Scroll Indicator -->
			<div class="scroll-indicator">
				<a href="#features" class="scroll-down">
					<i class="fas fa-chevron-down"></i>
				</a>
			</div>
		</section>

		<!-- Features Section -->
		<section class="landing-features" id="features">
			<div class="container">
				<div class="section-header text-center">
					<h2 class="section-title">
						<?php
						$features_title = get_post_meta( get_the_ID(), '_landing_features_title', true );
						echo $features_title ?: esc_html__( 'Why Choose Us?', 'versatile' );
						?>
					</h2>
					<p class="section-subtitle">
						<?php
						$features_subtitle = get_post_meta( get_the_ID(), '_landing_features_subtitle', true );
						echo $features_subtitle ?: esc_html__( 'Discover the features that make us different', 'versatile' );
						?>
					</p>
				</div>
				
				<div class="features-grid">
					<?php
					// Get features from custom fields or use defaults
					$features = get_post_meta( get_the_ID(), '_landing_features', true );

					if ( ! $features ) {
						$features = array(
							array(
								'icon'        => 'fas fa-bolt',
								'title'       => 'Lightning Fast',
								'description' => 'Optimized for speed and performance with cutting-edge technology.',
							),
							array(
								'icon'        => 'fas fa-shield-alt',
								'title'       => 'Secure & Reliable',
								'description' => 'Bank-level security with 99.9% uptime guarantee.',
							),
							array(
								'icon'        => 'fas fa-mobile-alt',
								'title'       => 'Mobile Ready',
								'description' => 'Perfect experience across all devices and screen sizes.',
							),
							array(
								'icon'        => 'fas fa-headset',
								'title'       => '24/7 Support',
								'description' => 'Round-the-clock assistance from our expert team.',
							),
							array(
								'icon'        => 'fas fa-sync-alt',
								'title'       => 'Auto Updates',
								'description' => 'Always stay current with automatic updates and new features.',
							),
							array(
								'icon'        => 'fas fa-chart-line',
								'title'       => 'Analytics',
								'description' => 'Detailed insights and reporting to track your progress.',
							),
						);
					}

					foreach ( $features as $feature ) :
						?>
						<div class="feature-item" data-aos="zoom-in">
							<div class="feature-icon">
								<i class="<?php echo esc_attr( $feature['icon'] ); ?>"></i>
							</div>
							<h4 class="feature-title"><?php echo esc_html( $feature['title'] ); ?></h4>
							<p class="feature-description"><?php echo esc_html( $feature['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- Stats/Numbers Section -->
		<section class="landing-stats">
			<div class="container">
				<div class="stats-grid">
					<?php
					$stats = get_post_meta( get_the_ID(), '_landing_stats', true );

					if ( ! $stats ) {
						$stats = array(
							array(
								'number' => '50K+',
								'label'  => 'Active Users',
							),
							array(
								'number' => '99.9%',
								'label'  => 'Uptime',
							),
							array(
								'number' => '24/7',
								'label'  => 'Support',
							),
							array(
								'number' => '100+',
								'label'  => 'Countries',
							),
						);
					}

					foreach ( $stats as $stat ) :
						?>
						<div class="stat-item" data-aos="fade-up">
							<div class="stat-number" data-count="<?php echo esc_attr( $stat['number'] ); ?>">
								<?php echo esc_html( $stat['number'] ); ?>
							</div>
							<div class="stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- Testimonials Section -->
		<section class="landing-testimonials" id="testimonials">
			<div class="container">
				<div class="section-header text-center">
					<h2 class="section-title"><?php esc_html_e( 'What Our Customers Say', 'versatile' ); ?></h2>
					<p class="section-subtitle"><?php esc_html_e( 'Don\'t just take our word for it', 'versatile' ); ?></p>
				</div>
				
				<div class="testimonials-slider">
					<?php
					$testimonials = get_post_meta( get_the_ID(), '_landing_testimonials', true );

					if ( ! $testimonials ) {
						$testimonials = array(
							array(
								'text'     => 'This product has completely transformed how we work. The interface is intuitive and the results are amazing.',
								'author'   => 'Sarah Johnson',
								'position' => 'CEO, TechStart Inc.',
								'avatar'   => '',
							),
							array(
								'text'     => 'Outstanding support and incredible features. I recommend this to anyone looking for a professional solution.',
								'author'   => 'Mike Chen',
								'position' => 'Marketing Director',
								'avatar'   => '',
							),
							array(
								'text'     => 'The best investment we\'ve made for our business. ROI was visible within the first month.',
								'author'   => 'Emily Rodriguez',
								'position' => 'Business Owner',
								'avatar'   => '',
							),
						);
					}

					foreach ( $testimonials as $index => $testimonial ) :
						?>
						<div class="testimonial-item <?php echo $index === 0 ? 'active' : ''; ?>" data-aos="fade-up">
							<div class="testimonial-content">
								<div class="testimonial-stars">
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
								</div>
								<blockquote class="testimonial-text">
									"<?php echo esc_html( $testimonial['text'] ); ?>"
								</blockquote>
								<div class="testimonial-author">
									<?php if ( ! empty( $testimonial['avatar'] ) ) : ?>
										<img src="<?php echo esc_url( $testimonial['avatar'] ); ?>" alt="<?php echo esc_attr( $testimonial['author'] ); ?>" class="author-avatar">
									<?php else : ?>
										<div class="author-avatar-placeholder">
											<i class="fas fa-user"></i>
										</div>
									<?php endif; ?>
									<div class="author-info">
										<strong class="author-name"><?php echo esc_html( $testimonial['author'] ); ?></strong>
										<span class="author-position"><?php echo esc_html( $testimonial['position'] ); ?></span>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				
				<div class="testimonials-navigation">
					<button class="testimonial-nav-btn prev-btn" onclick="changeTestimonial(-1)">
						<i class="fas fa-chevron-left"></i>
					</button>
					<div class="testimonial-dots">
						<?php for ( $i = 0; $i < count( $testimonials ); $i++ ) : ?>
							<button class="dot <?php echo $i === 0 ? 'active' : ''; ?>" onclick="showTestimonial(<?php echo $i; ?>)"></button>
						<?php endfor; ?>
					</div>
					<button class="testimonial-nav-btn next-btn" onclick="changeTestimonial(1)">
						<i class="fas fa-chevron-right"></i>
					</button>
				</div>
			</div>
		</section>

		<!-- Pricing Section -->
		<section class="landing-pricing" id="pricing">
			<div class="container">
				<div class="section-header text-center">
					<h2 class="section-title"><?php esc_html_e( 'Choose Your Plan', 'versatile' ); ?></h2>
					<p class="section-subtitle"><?php esc_html_e( 'Flexible pricing for every need', 'versatile' ); ?></p>
				</div>
				
				<div class="pricing-toggle">
					<span class="toggle-label"><?php esc_html_e( 'Monthly', 'versatile' ); ?></span>
					<label class="toggle-switch">
						<input type="checkbox" id="pricing-toggle">
						<span class="toggle-slider"></span>
					</label>
					<span class="toggle-label"><?php esc_html_e( 'Yearly', 'versatile' ); ?> <span class="discount-badge"><?php esc_html_e( 'Save 20%', 'versatile' ); ?></span></span>
				</div>
				
				<div class="pricing-grid">
					<?php
					$pricing_plans = get_post_meta( get_the_ID(), '_landing_pricing', true );

					if ( ! $pricing_plans ) {
						$pricing_plans = array(
							array(
								'name'          => 'Starter',
								'monthly_price' => '$19',
								'yearly_price'  => '$15',
								'description'   => 'Perfect for individuals and small projects',
								'features'      => array( '5 Projects', '10GB Storage', 'Basic Support', 'Mobile App' ),
								'popular'       => false,
								'cta_text'      => 'Start Free Trial',
								'cta_url'       => '#signup',
							),
							array(
								'name'          => 'Professional',
								'monthly_price' => '$49',
								'yearly_price'  => '$39',
								'description'   => 'Ideal for growing businesses',
								'features'      => array( '25 Projects', '100GB Storage', 'Priority Support', 'Advanced Analytics', 'API Access', 'Custom Integrations' ),
								'popular'       => true,
								'cta_text'      => 'Start Free Trial',
								'cta_url'       => '#signup',
							),
							array(
								'name'          => 'Enterprise',
								'monthly_price' => '$99',
								'yearly_price'  => '$79',
								'description'   => 'For large teams and organizations',
								'features'      => array( 'Unlimited Projects', '1TB Storage', 'Dedicated Support', 'Custom Solutions', 'SLA Guarantee', 'White-label Options' ),
								'popular'       => false,
								'cta_text'      => 'Contact Sales',
								'cta_url'       => '#contact',
							),
						);
					}

					foreach ( $pricing_plans as $plan ) :
						?>
						<div class="pricing-card <?php echo $plan['popular'] ? 'popular' : ''; ?>" data-aos="zoom-in">
							<?php if ( $plan['popular'] ) : ?>
								<div class="popular-badge">
									<i class="fas fa-crown"></i>
									<?php esc_html_e( 'Most Popular', 'versatile' ); ?>
								</div>
							<?php endif; ?>
							
							<div class="pricing-header">
								<h3 class="plan-name"><?php echo esc_html( $plan['name'] ); ?></h3>
								<div class="plan-price">
									<span class="price monthly-price"><?php echo esc_html( $plan['monthly_price'] ); ?></span>
									<span class="price yearly-price" style="display: none;"><?php echo esc_html( $plan['yearly_price'] ); ?></span>
									<span class="price-period">
										<span class="monthly-period"><?php esc_html_e( '/month', 'versatile' ); ?></span>
										<span class="yearly-period" style="display: none;"><?php esc_html_e( '/month, billed yearly', 'versatile' ); ?></span>
									</span>
								</div>
								<p class="plan-description"><?php echo esc_html( $plan['description'] ); ?></p>
							</div>
							
							<div class="pricing-features">
								<ul class="features-list">
									<?php foreach ( $plan['features'] as $feature ) : ?>
										<li class="feature-item">
											<i class="fas fa-check"></i>
											<?php echo esc_html( $feature ); ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
							
							<div class="pricing-footer">
								<a href="<?php echo esc_url( $plan['cta_url'] ); ?>" class="btn <?php echo $plan['popular'] ? 'btn-primary' : 'btn-outline-primary'; ?> btn-lg btn-block">
									<?php echo esc_html( $plan['cta_text'] ); ?>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- FAQ Section -->
		<section class="landing-faq" id="faq">
			<div class="container">
				<div class="section-header text-center">
					<h2 class="section-title"><?php esc_html_e( 'Frequently Asked Questions', 'versatile' ); ?></h2>
					<p class="section-subtitle"><?php esc_html_e( 'Everything you need to know', 'versatile' ); ?></p>
				</div>
				
				<div class="faq-accordion">
					<?php
					$faqs = get_post_meta( get_the_ID(), '_landing_faqs', true );

					if ( ! $faqs ) {
						$faqs = array(
							array(
								'question' => 'How do I get started?',
								'answer'   => 'Simply sign up for a free trial and follow our step-by-step onboarding process. You\'ll be up and running in minutes.',
							),
							array(
								'question' => 'Is there a free trial?',
								'answer'   => 'Yes! We offer a 14-day free trial with full access to all features. No credit card required.',
							),
							array(
								'question' => 'Can I change my plan later?',
								'answer'   => 'Absolutely. You can upgrade or downgrade your plan at any time. Changes take effect immediately.',
							),
							array(
								'question' => 'What kind of support do you offer?',
								'answer'   => 'We provide 24/7 email support for all plans, with priority support and phone access for Professional and Enterprise plans.',
							),
							array(
								'question' => 'Is my data secure?',
								'answer'   => 'Yes, we use bank-level encryption and security measures. Your data is stored securely and backed up regularly.',
							),
						);
					}

					foreach ( $faqs as $index => $faq ) :
						?>
						<div class="faq-item" data-aos="fade-up">
							<button class="faq-question" onclick="toggleFAQ(<?php echo $index; ?>)">
								<span><?php echo esc_html( $faq['question'] ); ?></span>
								<i class="fas fa-chevron-down"></i>
							</button>
							<div class="faq-answer" id="faq-<?php echo $index; ?>">
								<p><?php echo esc_html( $faq['answer'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- CTA Section -->
		<section class="landing-cta" id="signup">
			<div class="container">
				<div class="cta-content text-center">
					<h2 class="cta-title">
						<?php
						$cta_title = get_post_meta( get_the_ID(), '_landing_final_cta_title', true );
						echo $cta_title ?: esc_html__( 'Ready to Get Started?', 'versatile' );
						?>
					</h2>
					<p class="cta-subtitle">
						<?php
						$cta_subtitle = get_post_meta( get_the_ID(), '_landing_final_cta_subtitle', true );
						echo $cta_subtitle ?: esc_html__( 'Join thousands of satisfied customers today', 'versatile' );
						?>
					</p>
					
					<!-- Email Signup Form -->
					<div class="cta-form">
						<form class="signup-form" method="post" action="#" onsubmit="handleSignup(event)">
							<div class="form-group-inline">
								<input type="email" 
										class="form-control" 
										placeholder="<?php esc_attr_e( 'Enter your email address', 'versatile' ); ?>" 
										name="email" 
										required>
								<button type="submit" class="btn btn-primary btn-lg">
									<i class="fas fa-rocket"></i>
									<?php esc_html_e( 'Start Free Trial', 'versatile' ); ?>
								</button>
							</div>
							<p class="form-note">
								<?php esc_html_e( 'No credit card required. Cancel anytime.', 'versatile' ); ?>
							</p>
						</form>
					</div>
					
					<!-- Trust Badges -->
					<div class="trust-badges">
						<div class="badge-item">
							<i class="fas fa-lock"></i>
							<span><?php esc_html_e( 'SSL Secured', 'versatile' ); ?></span>
						</div>
						<div class="badge-item">
							<i class="fas fa-shield-alt"></i>
							<span><?php esc_html_e( 'Privacy Protected', 'versatile' ); ?></span>
						</div>
						<div class="badge-item">
							<i class="fas fa-award"></i>
							<span><?php esc_html_e( 'Award Winning', 'versatile' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</section>
		
	<?php endwhile; ?>
</main>

<style>
/* Landing Page Specific Styles */
.landing-main {
	overflow-x: hidden;
}

/* Hero Section */
.landing-hero {
	position: relative;
	min-height: 100vh;
	display: flex;
	align-items: center;
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white;
	overflow: hidden;
}

.landing-hero::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.05"><circle cx="30" cy="30" r="1"/></g></svg>') repeat;
	z-index: 1;
}

.hero-background {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 1;
}

.hero-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.hero-overlay {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(102, 126, 234, 0.8);
}

.hero-content {
	position: relative;
	z-index: 2;
	animation: fadeInUp 1s ease-out;
}

@keyframes fadeInUp {
	from {
		opacity: 0;
		transform: translateY(40px);
	}
	to {
		opacity: 1;
		transform: translateY(0);
	}
}

.hero-badge {
	display: inline-block;
	background: rgba(255, 255, 255, 0.2);
	padding: 8px 20px;
	border-radius: 25px;
	font-size: 14px;
	margin-bottom: 20px;
	backdrop-filter: blur(10px);
}

.hero-title {
	font-size: clamp(2.5rem, 5vw, 4rem);
	font-weight: 700;
	margin-bottom: 20px;
	line-height: 1.2;
	text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	letter-spacing: -0.02em;
}

.hero-subtitle {
	font-size: 1.4rem;
	margin-bottom: 30px;
	opacity: 0.9;
	line-height: 1.6;
}

.hero-features {
	margin-bottom: 40px;
}

.hero-features .feature-item {
	margin-bottom: 10px;
	font-size: 1.1rem;
}

.hero-features .feature-item i {
	color: #4ade80;
	margin-right: 10px;
}

.hero-cta {
	display: flex;
	gap: 20px;
	margin-bottom: 50px;
	flex-wrap: wrap;
	animation: fadeInUp 1s ease-out 0.3s both;
}

.hero-cta .btn {
	padding: 15px 30px;
	font-size: 1.1rem;
	font-weight: 600;
	border-radius: 50px;
	min-width: 200px;
	text-align: center;
	transition: all 0.3s ease;
}

.cta-primary {
	background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
	border-color: #ff6b6b;
	box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
	position: relative;
	overflow: hidden;
}

.cta-primary::before {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
	transition: left 0.5s;
}

.cta-primary:hover::before {
	left: 100%;
}

.cta-primary:hover {
	background: linear-gradient(45deg, #ff5252, #ff7575);
	transform: translateY(-3px);
	box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
}

.cta-secondary {
	backdrop-filter: blur(10px);
	border: 2px solid rgba(255, 255, 255, 0.3);
}

.cta-secondary:hover {
	background: rgba(255, 255, 255, 0.2);
	transform: translateY(-2px);
}

.hero-social-proof {
	display: flex;
	gap: 30px;
	justify-content: center;
	flex-wrap: wrap;
}

.social-proof-item {
	text-align: center;
}

.social-proof-item i {
	font-size: 1.5rem;
	color: #ffd700;
	margin-bottom: 5px;
}

.social-proof-item span {
	display: block;
	font-size: 1.2rem;
	font-weight: 700;
}

.social-proof-item small {
	font-size: 0.9rem;
	opacity: 0.8;
}

.hero-visual {
	position: relative;
	z-index: 2;
}

/* Mockup Device */
.mockup-device {
	background: #2d3748;
	border-radius: 20px;
	padding: 20px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
	transform: perspective(1000px) rotateY(-15deg) rotateX(10deg);
	animation: float 6s ease-in-out infinite;
}

@keyframes float {
	0%, 100% { transform: perspective(1000px) rotateY(-15deg) rotateX(10deg) translateY(0px); }
	50% { transform: perspective(1000px) rotateY(-15deg) rotateX(10deg) translateY(-20px); }
}

.mockup-screen {
	background: #f7fafc;
	border-radius: 10px;
	padding: 20px;
	min-height: 300px;
}

.mockup-header {
	height: 60px;
	background: linear-gradient(135deg, #667eea, #764ba2);
	border-radius: 8px;
	margin-bottom: 20px;
}

.mockup-element {
	height: 40px;
	background: #e2e8f0;
	border-radius: 6px;
	margin-bottom: 15px;
	animation: pulse 2s infinite;
}

.mockup-element:nth-child(2) {
	width: 80%;
	animation-delay: 0.5s;
}

.mockup-element:nth-child(3) {
	width: 60%;
	animation-delay: 1s;
}

@keyframes pulse {
	0%, 100% { opacity: 1; }
	50% { opacity: 0.7; }
}

.scroll-indicator {
	position: absolute;
	bottom: 30px;
	left: 50%;
	transform: translateX(-50%);
	z-index: 2;
}

.scroll-down {
	display: block;
	color: white;
	font-size: 1.5rem;
	animation: bounce 2s infinite;
	text-decoration: none;
}

.scroll-down:hover {
	color: white;
	text-decoration: none;
}

/* Features Section */
.landing-features {
	padding: 100px 0;
	background: white;
}

.section-header {
	margin-bottom: 60px;
}

.section-title {
	font-size: 2.5rem;
	font-weight: 700;
	margin-bottom: 20px;
	color: #2d3748;
}

.section-subtitle {
	font-size: 1.2rem;
	color: #718096;
	max-width: 600px;
	margin: 0 auto;
}

.features-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
	gap: 40px;
	margin-top: 20px;
}

.features-grid .feature-item {
	text-align: center;
	padding: 50px 40px;
	background: linear-gradient(145deg, #ffffff, #f8fafc);
	border-radius: 20px;
	transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
	border: 1px solid #e2e8f0;
	position: relative;
	overflow: hidden;
}

.features-grid .feature-item::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: linear-gradient(145deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
	opacity: 0;
	transition: opacity 0.4s ease;
}

.features-grid .feature-item:hover::before {
	opacity: 1;
}

.features-grid .feature-item:hover {
	transform: translateY(-15px) scale(1.02);
	box-shadow: 0 25px 50px rgba(102, 126, 234, 0.15);
	border-color: rgba(102, 126, 234, 0.3);
}

.feature-icon {
	width: 90px;
	height: 90px;
	background: linear-gradient(135deg, #667eea, #764ba2);
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	margin: 0 auto 25px;
	color: white;
	font-size: 2.2rem;
	position: relative;
	z-index: 1;
	transition: all 0.4s ease;
	box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.feature-icon::before {
	content: '';
	position: absolute;
	top: -5px;
	left: -5px;
	right: -5px;
	bottom: -5px;
	background: linear-gradient(135deg, #667eea, #764ba2);
	border-radius: 50%;
	z-index: -1;
	opacity: 0;
	transition: opacity 0.4s ease;
}

.features-grid .feature-item:hover .feature-icon::before {
	opacity: 0.3;
}

.features-grid .feature-item:hover .feature-icon {
	transform: scale(1.1) rotateY(15deg);
	box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.feature-title {
	font-size: 1.3rem;
	font-weight: 600;
	margin-bottom: 15px;
	color: #2d3748;
}

.feature-description {
	color: #718096;
	line-height: 1.6;
}

/* Stats Section */
.landing-stats {
	padding: 80px 0;
	background: linear-gradient(135deg, #667eea, #764ba2);
	color: white;
}

.stats-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
	gap: 40px;
	text-align: center;
}

.stat-number {
	font-size: 3rem;
	font-weight: 700;
	margin-bottom: 10px;
}

.stat-label {
	font-size: 1.1rem;
	opacity: 0.9;
}

/* Testimonials */
.landing-testimonials {
	padding: 100px 0;
	background: #f7fafc;
}

.testimonials-slider {
	max-width: 800px;
	margin: 0 auto;
	position: relative;
}

.testimonial-item {
	display: none;
	text-align: center;
	padding: 50px 40px;
	background: linear-gradient(145deg, #ffffff, #f8fafc);
	border-radius: 20px;
	box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
	transition: all 0.5s ease;
	opacity: 0;
	transform: translateY(30px);
}

.testimonial-item.active {
	display: block;
	opacity: 1;
	transform: translateY(0);
	animation: slideInUp 0.6s ease-out;
}

@keyframes slideInUp {
	from {
		opacity: 0;
		transform: translateY(50px);
	}
	to {
		opacity: 1;
		transform: translateY(0);
	}
}

.testimonial-stars {
	color: #ffd700;
	font-size: 1.2rem;
	margin-bottom: 20px;
}

.testimonial-text {
	font-size: 1.3rem;
	font-style: italic;
	color: #2d3748;
	margin-bottom: 30px;
	line-height: 1.6;
}

.testimonial-author {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 15px;
}

.author-avatar,
.author-avatar-placeholder {
	width: 60px;
	height: 60px;
	border-radius: 50%;
	overflow: hidden;
}

.author-avatar-placeholder {
	background: #e2e8f0;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #718096;
}

.author-info {
	text-align: left;
}

.author-name {
	display: block;
	font-weight: 600;
	color: #2d3748;
}

.author-position {
	color: #718096;
	font-size: 0.9rem;
}

.testimonials-navigation {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 20px;
	margin-top: 40px;
}

.testimonial-nav-btn {
	background: #667eea;
	color: white;
	border: none;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	cursor: pointer;
	transition: all 0.3s ease;
}

.testimonial-nav-btn:hover {
	background: #5a67d8;
	transform: scale(1.1);
}

.testimonial-dots {
	display: flex;
	gap: 10px;
}

.dot {
	width: 12px;
	height: 12px;
	border-radius: 50%;
	background: #cbd5e0;
	border: none;
	cursor: pointer;
	transition: all 0.3s ease;
}

.dot.active {
	background: #667eea;
}

/* Pricing Section */
.landing-pricing {
	padding: 100px 0;
	background: white;
}

.pricing-toggle {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 20px;
	margin-bottom: 60px;
}

.toggle-label {
	font-weight: 600;
	color: #2d3748;
}

.discount-badge {
	background: #48bb78;
	color: white;
	padding: 2px 8px;
	border-radius: 12px;
	font-size: 12px;
	margin-left: 5px;
}

.toggle-switch {
	position: relative;
	display: inline-block;
	width: 60px;
	height: 30px;
}

.toggle-switch input {
	opacity: 0;
	width: 0;
	height: 0;
}

.toggle-slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #cbd5e0;
	transition: 0.3s;
	border-radius: 30px;
}

.toggle-slider:before {
	position: absolute;
	content: "";
	height: 22px;
	width: 22px;
	left: 4px;
	bottom: 4px;
	background-color: white;
	transition: 0.3s;
	border-radius: 50%;
}

input:checked + .toggle-slider {
	background-color: #667eea;
}

input:checked + .toggle-slider:before {
	transform: translateX(30px);
}

.pricing-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
	gap: 30px;
	max-width: 1000px;
	margin: 0 auto;
}

.pricing-card {
	background: linear-gradient(145deg, #ffffff, #f8fafc);
	border-radius: 25px;
	padding: 50px 40px;
	text-align: center;
	border: 2px solid #e2e8f0;
	transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
	position: relative;
	overflow: hidden;
	backdrop-filter: blur(10px);
}

.pricing-card::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: linear-gradient(145deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
	opacity: 0;
	transition: opacity 0.4s ease;
}

.pricing-card:hover::before {
	opacity: 1;
}

.pricing-card:hover {
	transform: translateY(-15px) scale(1.02);
	box-shadow: 0 30px 60px rgba(102, 126, 234, 0.15);
	border-color: rgba(102, 126, 234, 0.3);
}

.pricing-card.popular {
	border-color: #667eea;
	transform: scale(1.08);
	background: linear-gradient(145deg, #667eea, #764ba2);
	color: white;
	box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
}

.pricing-card.popular::before {
	background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
}

.pricing-card.popular:hover {
	transform: scale(1.08) translateY(-20px);
	box-shadow: 0 35px 70px rgba(102, 126, 234, 0.4);
}

.pricing-card.popular .plan-name,
.pricing-card.popular .price,
.pricing-card.popular .plan-description {
	color: white;
}

.pricing-card.popular .features-list .feature-item {
	color: rgba(255, 255, 255, 0.9);
	border-bottom-color: rgba(255, 255, 255, 0.2);
}

.popular-badge {
	position: absolute;
	top: -1px;
	left: 50%;
	transform: translateX(-50%);
	background: linear-gradient(135deg, #667eea, #764ba2);
	color: white;
	padding: 8px 25px;
	border-radius: 0 0 15px 15px;
	font-size: 14px;
	font-weight: 600;
}

.plan-name {
	font-size: 1.5rem;
	font-weight: 700;
	margin-bottom: 10px;
	color: #2d3748;
}

.plan-price {
	margin-bottom: 15px;
}

.price {
	font-size: 3rem;
	font-weight: 700;
	color: #667eea;
}

.price-period {
	color: #718096;
	font-size: 1rem;
}

.plan-description {
	color: #718096;
	margin-bottom: 30px;
}

.features-list {
	list-style: none;
	padding: 0;
	margin-bottom: 40px;
	text-align: left;
}

.features-list .feature-item {
	padding: 10px 0;
	border-bottom: 1px solid #f7fafc;
}

.features-list .feature-item:last-child {
	border-bottom: none;
}

.features-list .feature-item i {
	color: #48bb78;
	margin-right: 10px;
}

/* FAQ Section */
.landing-faq {
	padding: 100px 0;
	background: #f7fafc;
}

.faq-accordion {
	max-width: 800px;
	margin: 0 auto;
}

.faq-item {
	background: white;
	border-radius: 10px;
	margin-bottom: 20px;
	overflow: hidden;
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.faq-question {
	width: 100%;
	background: none;
	border: none;
	padding: 25px 30px;
	text-align: left;
	display: flex;
	justify-content: space-between;
	align-items: center;
	font-size: 1.1rem;
	font-weight: 600;
	color: #2d3748;
	cursor: pointer;
	transition: all 0.3s ease;
}

.faq-question:hover {
	background: #f7fafc;
}

.faq-question.active i {
	transform: rotate(180deg);
}

.faq-answer {
	padding: 0 30px;
	max-height: 0;
	overflow: hidden;
	transition: all 0.3s ease;
}

.faq-answer.active {
	padding: 0 30px 25px;
	max-height: 200px;
}

.faq-answer p {
	color: #718096;
	line-height: 1.6;
	margin: 0;
}

/* CTA Section */
.landing-cta {
	padding: 100px 0;
	background: linear-gradient(135deg, #667eea, #764ba2);
	color: white;
}

.cta-title {
	font-size: 2.5rem;
	font-weight: 700;
	margin-bottom: 20px;
}

.cta-subtitle {
	font-size: 1.2rem;
	margin-bottom: 40px;
	opacity: 0.9;
}

.cta-form {
	max-width: 600px;
	margin: 0 auto;
}

.form-group-inline {
	display: flex;
	gap: 15px;
	margin-bottom: 15px;
	align-items: stretch;
}

.form-group-inline .form-control {
	flex: 1;
	padding: 15px 20px;
	border: none;
	border-radius: 50px;
	font-size: 16px;
}

.form-group-inline .btn {
	padding: 15px 30px;
	border-radius: 50px;
	font-weight: 600;
	white-space: nowrap;
}

.form-note {
	font-size: 14px;
	opacity: 0.8;
	margin-bottom: 40px;
}

.trust-badges {
	display: flex;
	justify-content: center;
	gap: 40px;
	flex-wrap: wrap;
}

.badge-item {
	display: flex;
	align-items: center;
	gap: 10px;
	font-size: 14px;
	opacity: 0.9;
}

.badge-item i {
	font-size: 1.2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
	.landing-hero {
		min-height: 90vh;
		padding: 60px 0;
	}
	
	.hero-title {
		font-size: clamp(2rem, 6vw, 2.5rem);
		margin-bottom: 15px;
	}
	
	.hero-subtitle {
		font-size: 1.1rem;
		margin-bottom: 25px;
	}
	
	.hero-cta {
		flex-direction: column;
		align-items: center;
		gap: 15px;
		margin-bottom: 40px;
	}
	
	.hero-cta .btn {
		width: 100%;
		max-width: 280px;
	}
	
	.hero-social-proof {
		flex-direction: column;
		gap: 20px;
	}
	
	.mockup-device {
		transform: none;
		animation: none;
		margin-top: 40px;
	}
	
	.section-title {
		font-size: 2rem;
		margin-bottom: 20px;
	}
	
	.section-subtitle {
		font-size: 1.1rem;
	}
	
	.features-grid {
		grid-template-columns: 1fr;
		gap: 30px;
		margin-top: 30px;
	}
	
	.features-grid .feature-item {
		padding: 40px 30px;
	}
	
	.feature-icon {
		width: 75px;
		height: 75px;
		font-size: 2rem;
	}
	
	.stats-grid {
		grid-template-columns: repeat(2, 1fr);
		gap: 25px;
	}
	
	.pricing-grid {
		grid-template-columns: 1fr;
		gap: 25px;
	}
	
	.pricing-card {
		padding: 40px 30px;
	}
	
	.pricing-card.popular {
		transform: none;
		margin: 20px 0;
	}
	
	.pricing-card.popular:hover {
		transform: translateY(-10px);
	}
	
	.testimonial-item {
		padding: 40px 30px;
	}
	
	.form-group-inline {
		flex-direction: column;
		gap: 12px;
	}
	
	.trust-badges {
		gap: 20px;
		flex-direction: column;
	}
	
	.cta-title {
		font-size: 2rem;
	}
	
	.faq-question {
		padding: 20px 25px;
		font-size: 1rem;
	}
	
	.faq-answer {
		padding: 0 25px;
	}
	
	.faq-answer.active {
		padding: 0 25px 20px;
	}
}

/* Animation on Scroll */
[data-aos] {
	opacity: 0;
	transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

[data-aos].aos-animate {
	opacity: 1;
}

[data-aos="fade-up"] {
	transform: translateY(60px);
}

[data-aos="fade-up"].aos-animate {
	transform: translateY(0);
}

[data-aos="fade-in"] {
	opacity: 0;
}

[data-aos="fade-in"].aos-animate {
	opacity: 1;
}

[data-aos="zoom-in"] {
	transform: scale(0.8);
	opacity: 0;
}

[data-aos="zoom-in"].aos-animate {
	transform: scale(1);
	opacity: 1;
}

/* Enhanced bounce animation */
@keyframes bounce {
	0%, 20%, 53%, 80%, 100% {
		transform: translate3d(-50%, 0, 0);
	}
	40%, 43% {
		transform: translate3d(-50%, -8px, 0);
	}
	70% {
		transform: translate3d(-50%, -4px, 0);
	}
	90% {
		transform: translate3d(-50%, -2px, 0);
	}
}

/* Smooth section transitions */
section {
	transform: translateZ(0);
	backface-visibility: hidden;
}
</style>

<script>
// Landing Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
	
	// Smooth scrolling for anchor links
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			e.preventDefault();
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				target.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
			}
		});
	});
	
	// Pricing toggle
	const pricingToggle = document.getElementById('pricing-toggle');
	if (pricingToggle) {
		pricingToggle.addEventListener('change', function() {
			const monthlyPrices = document.querySelectorAll('.monthly-price, .monthly-period');
			const yearlyPrices = document.querySelectorAll('.yearly-price, .yearly-period');
			
			if (this.checked) {
				monthlyPrices.forEach(el => el.style.display = 'none');
				yearlyPrices.forEach(el => el.style.display = 'inline');
			} else {
				monthlyPrices.forEach(el => el.style.display = 'inline');
				yearlyPrices.forEach(el => el.style.display = 'none');
			}
		});
	}
	
	// Enhanced AOS (Animate on Scroll) implementation
	const observerOptions = {
		threshold: 0.15,
		rootMargin: '0px 0px -80px 0px'
	};
	
	const observer = new IntersectionObserver(function(entries) {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				entry.target.classList.add('aos-animate');
				// Add staggered animation delay for grid items
				if (entry.target.parentElement && entry.target.parentElement.classList.contains('features-grid')) {
					const index = Array.from(entry.target.parentElement.children).indexOf(entry.target);
					entry.target.style.transitionDelay = `${index * 0.1}s`;
				}
			}
		});
	}, observerOptions);
	
	document.querySelectorAll('[data-aos]').forEach(el => {
		observer.observe(el);
	});
	
	// Counter animation for stats
	const animateCounters = () => {
		document.querySelectorAll('.stat-number[data-count]').forEach(counter => {
			const target = parseInt(counter.getAttribute('data-count').replace(/\D/g, ''));
			const suffix = counter.getAttribute('data-count').replace(/[\d.]/g, '');
			const increment = target / 100;
			let current = 0;
			
			const updateCounter = () => {
				current += increment;
				if (current < target) {
					counter.textContent = Math.floor(current) + suffix;
					requestAnimationFrame(updateCounter);
				} else {
					counter.textContent = counter.getAttribute('data-count');
				}
			};
			
			updateCounter();
		});
	};
	
	// Trigger counter animation when stats section is visible
	const statsSection = document.querySelector('.landing-stats');
	if (statsSection) {
		const statsObserver = new IntersectionObserver((entries) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					animateCounters();
					statsObserver.unobserve(entry.target);
				}
			});
		});
		statsObserver.observe(statsSection);
	}
});

// Testimonials functionality
let currentTestimonial = 0;
const testimonials = document.querySelectorAll('.testimonial-item');
const totalTestimonials = testimonials.length;

function showTestimonial(index) {
	testimonials.forEach(testimonial => testimonial.classList.remove('active'));
	document.querySelectorAll('.dot').forEach(dot => dot.classList.remove('active'));
	
	if (testimonials[index]) {
		testimonials[index].classList.add('active');
		document.querySelectorAll('.dot')[index]?.classList.add('active');
		currentTestimonial = index;
	}
}

function changeTestimonial(direction) {
	currentTestimonial += direction;
	
	if (currentTestimonial >= totalTestimonials) {
		currentTestimonial = 0;
	} else if (currentTestimonial < 0) {
		currentTestimonial = totalTestimonials - 1;
	}
	
	showTestimonial(currentTestimonial);
}

// Auto-rotate testimonials
if (totalTestimonials > 1) {
	setInterval(() => {
		changeTestimonial(1);
	}, 5000);
}

// FAQ functionality
function toggleFAQ(index) {
	const question = document.querySelectorAll('.faq-question')[index];
	const answer = document.getElementById(`faq-${index}`);
	
	question.classList.toggle('active');
	answer.classList.toggle('active');
}

// Video functionality
function toggleVideoPlay() {
	const video = document.querySelector('.hero-video video');
	const playBtn = document.querySelector('.play-btn');
	
	if (video.paused) {
		video.play();
		playBtn.innerHTML = '<i class="fas fa-pause"></i>';
	} else {
		video.pause();
		playBtn.innerHTML = '<i class="fas fa-play"></i>';
	}
}

// Signup form handling
function handleSignup(event) {
	event.preventDefault();
	const email = event.target.email.value;
	
	// Here you would typically send the email to your backend
	console.log('Signup email:', email);
	
	// Show success message
	alert('Thank you for signing up! Check your email for next steps.');
	
	// Reset form
	event.target.reset();
}
</script>

<?php get_footer( 'landing' ); // Custom footer for landing pages ?>