<?php
/**
 * Template Name: Versatile Front Page
 *
 * Modern editorial homepage — dark teal header, split hero, services,
 * work grid, stats bar, journal posts, CTA banner, full footer.
 *
 * @package Versatile
 */

get_header(); ?>

<main class="vs-page">

	<?php // ─── HERO ─────────────────────────────────────────────────────── ?>
	<section class="vs-hero">
		<div class="vs-container">
			<div class="vs-hero__grid">
				<div class="vs-hero__text">
					<span class="vs-eyebrow">
						<?php echo esc_html( get_theme_mod( 'vs_hero_eyebrow', 'Brand & product design studio' ) ); ?>
					</span>
					<h1 class="vs-hero__title">
						<?php echo esc_html( get_theme_mod( 'vs_hero_title', 'We help considered brands find their tideline.' ) ); ?>
					</h1>
					<p class="vs-hero__body">
						<?php echo esc_html( get_theme_mod( 'vs_hero_body', 'A small studio working where strategy, identity, and digital product meet — for teams who care about the details most people never notice, but everyone feels.' ) ); ?>
					</p>
					<div class="vs-hero__ctas">
						<a href="<?php echo esc_url( get_theme_mod( 'vs_hero_cta_url', '#work' ) ); ?>" class="vs-btn vs-btn--primary">
							<?php echo esc_html( get_theme_mod( 'vs_hero_cta_text', 'View our work' ) ); ?>
						</a>
						<a href="<?php echo esc_url( get_theme_mod( 'vs_hero_cta2_url', '#contact' ) ); ?>" class="vs-text-link">
							<?php echo esc_html( get_theme_mod( 'vs_hero_cta2_text', 'Start a project' ) ); ?> &rarr;
						</a>
					</div>
				</div>
				<div class="vs-hero__visual">
					<div class="vs-hero__placeholder">
						<?php if ( get_theme_mod( 'vs_hero_image' ) ) : ?>
							<img src="<?php echo esc_url( get_theme_mod( 'vs_hero_image' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<?php else : ?>
							<span>studio / hero image</span>
						<?php endif; ?>
					</div>
					<div class="vs-hero__stat-card">
						<strong><?php echo esc_html( get_theme_mod( 'vs_hero_stat_number', '80+' ) ); ?></strong>
						<span><?php echo esc_html( get_theme_mod( 'vs_hero_stat_label', 'brands shaped since 2013' ) ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php // ─── TRUSTED BY ───────────────────────────────────────────────── ?>
	<section class="vs-trust">
		<div class="vs-container vs-trust__inner">
			<span class="vs-trust__label"><?php esc_html_e( 'TRUSTED BY TEAMS AT', 'versatile' ); ?></span>
			<div class="vs-trust__logos">
				<?php
				$trusted = get_theme_mod( 'vs_trusted_brands', 'Harbor,Cedar & Co,Lumen,Northwind,Field Notes' );
				foreach ( explode( ',', $trusted ) as $brand ) :
					$brand = trim( $brand );
					if ( $brand ) :
						?>
						<span class="vs-trust__brand"><?php echo esc_html( $brand ); ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── SERVICES ─────────────────────────────────────────────────── ?>
	<section class="vs-services">
		<div class="vs-container">
			<span class="vs-eyebrow"><?php echo esc_html( get_theme_mod( 'vs_services_eyebrow', 'What we do' ) ); ?></span>
			<h2 class="vs-section-title">
				<?php echo esc_html( get_theme_mod( 'vs_services_title', 'Three disciplines, one coherent whole.' ) ); ?>
			</h2>
			<div class="vs-services__grid">
				<?php
				$services = get_theme_mod(
					'vs_services',
					array(
						array(
							'number' => '01',
							'title'  => 'Brand Strategy',
							'desc'   => 'Positioning, narrative, and naming that give your brand a clear reason to exist — and a voice people remember.',
						),
						array(
							'number' => '02',
							'title'  => 'Identity & Systems',
							'desc'   => 'Logo, type, color, and the flexible design systems that keep every touchpoint coherent as you grow.',
						),
						array(
							'number' => '03',
							'title'  => 'Digital Product',
							'desc'   => 'Websites and product interfaces, designed and built to feel inevitable — fast, accessible, and quietly precise.',
						),
					)
				);
				foreach ( $services as $service ) :
					?>
					<div class="vs-service-card">
						<span class="vs-service-card__num"><?php echo esc_html( $service['number'] ); ?></span>
						<h3 class="vs-service-card__title"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="vs-service-card__desc"><?php echo esc_html( $service['desc'] ); ?></p>
						<a href="#" class="vs-text-link"><?php esc_html_e( 'Learn more', 'versatile' ); ?> &rarr;</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php // ─── SELECTED WORK ────────────────────────────────────────────── ?>
	<section class="vs-work" id="work">
		<div class="vs-container">
			<div class="vs-work__header">
				<div>
					<span class="vs-eyebrow"><?php echo esc_html( get_theme_mod( 'vs_work_eyebrow', 'Selected work' ) ); ?></span>
					<h2 class="vs-section-title">
						<?php echo esc_html( get_theme_mod( 'vs_work_title', 'A few brands we\u2019ve had the privilege to shape.' ) ); ?>
					</h2>
				</div>
				<a href="<?php echo esc_url( get_theme_mod( 'vs_work_all_url', '#' ) ); ?>" class="vs-btn vs-btn--ghost">
					<?php esc_html_e( 'All projects', 'versatile' ); ?> &rarr;
				</a>
			</div>
			<div class="vs-work__grid">
				<?php
				$work_posts = new WP_Query(
					array(
						'post_type'      => array( 'post', 'portfolio' ),
						'posts_per_page' => 4,
						'post_status'    => 'publish',
					)
				);
				if ( $work_posts->have_posts() ) :
					while ( $work_posts->have_posts() ) :
						$work_posts->the_post();
						$cats = get_the_category();
						$cat_label = '';
						if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
							$names = wp_list_pluck( $cats, 'name' );
							$cat_label = implode( ' &middot; ', array_map( 'strtoupper', $names ) );
						}
						?>
						<article class="vs-project-card">
							<div class="vs-project-card__cover">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large' ); ?>
								<?php else : ?>
									<span>project cover</span>
								<?php endif; ?>
							</div>
							<div class="vs-project-card__body">
								<?php if ( $cat_label ) : ?>
									<span class="vs-project-card__cat"><?php echo wp_kses_post( $cat_label ); ?></span>
								<?php endif; ?>
								<h3 class="vs-project-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<p class="vs-project-card__desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					// Fallback static cards when no posts.
					$fallback = array(
						array( 'cat' => 'REBRAND &middot; FINANCE', 'title' => 'Harbor Financial', 'desc' => 'A 40-year-old bank, made to feel human again — identity, voice, and a full digital system.' ),
						array( 'cat' => 'E-COMMERCE &middot; RETAIL', 'title' => 'Cedar & Co', 'desc' => 'A heritage homeware brand brought online with a calm, tactile storefront.' ),
						array( 'cat' => 'PRODUCT UI &middot; HEALTH', 'title' => 'Lumen Health', 'desc' => 'A patient app that turns anxious moments into clear, reassuring steps.' ),
						array( 'cat' => 'IDENTITY &middot; STUDIO', 'title' => 'Northwind', 'desc' => 'Naming and identity for an architecture practice working with the landscape.' ),
					);
					foreach ( $fallback as $item ) :
						?>
						<article class="vs-project-card">
							<div class="vs-project-card__cover"><span>project cover</span></div>
							<div class="vs-project-card__body">
								<span class="vs-project-card__cat"><?php echo wp_kses_post( $item['cat'] ); ?></span>
								<h3 class="vs-project-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
								<p class="vs-project-card__desc"><?php echo esc_html( $item['desc'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php // ─── STATS BAR ────────────────────────────────────────────────── ?>
	<section class="vs-stats">
		<div class="vs-container vs-stats__grid">
			<?php
			$stats = get_theme_mod(
				'vs_stats',
				array(
					array( 'number' => '13', 'label' => 'years in practice' ),
					array( 'number' => '80+', 'label' => 'brands shaped' ),
					array( 'number' => '6', 'label' => 'design awards' ),
					array( 'number' => '94%', 'label' => 'work from referrals' ),
				)
			);
			foreach ( $stats as $stat ) :
				?>
				<div class="vs-stat">
					<span class="vs-stat__number"><?php echo esc_html( $stat['number'] ); ?></span>
					<span class="vs-stat__label"><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<?php // ─── JOURNAL ──────────────────────────────────────────────────── ?>
	<section class="vs-journal">
		<div class="vs-container">
			<div class="vs-journal__header">
				<div>
					<span class="vs-eyebrow"><?php echo esc_html( get_theme_mod( 'vs_journal_eyebrow', 'From the journal' ) ); ?></span>
					<h2 class="vs-section-title">
						<?php echo esc_html( get_theme_mod( 'vs_journal_title', 'Notes on craft, strategy & the work.' ) ); ?>
					</h2>
				</div>
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="vs-btn vs-btn--ghost">
					<?php esc_html_e( 'Read the journal', 'versatile' ); ?> &rarr;
				</a>
			</div>
			<div class="vs-journal__grid">
				<?php
				$journal_posts = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'post_status'    => 'publish',
					)
				);
				if ( $journal_posts->have_posts() ) :
					while ( $journal_posts->have_posts() ) :
						$journal_posts->the_post();
						$cat_name = '';
						$cats     = get_the_category();
						if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
							$cat_name = strtoupper( $cats[0]->name );
						}
						?>
						<article class="vs-journal-card">
							<div class="vs-journal-card__cover">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large' ); ?>
								<?php else : ?>
									<span>article image</span>
								<?php endif; ?>
							</div>
							<?php if ( $cat_name ) : ?>
								<span class="vs-journal-card__cat"><?php echo esc_html( $cat_name ); ?></span>
							<?php endif; ?>
							<h3 class="vs-journal-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<span class="vs-journal-card__meta">
								<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
							</span>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
	</section>

	<?php // ─── CTA BANNER ───────────────────────────────────────────────── ?>
	<section class="vs-cta" id="contact">
		<div class="vs-container">
			<div class="vs-cta__card">
				<span class="vs-cta__eyebrow">
					<?php echo esc_html( get_theme_mod( 'vs_cta_eyebrow', 'Have a project in mind?' ) ); ?>
				</span>
				<h2 class="vs-cta__title">
					<?php echo esc_html( get_theme_mod( 'vs_cta_title', 'We take on a handful of partners each quarter.' ) ); ?>
				</h2>
				<p class="vs-cta__body">
					<?php echo esc_html( get_theme_mod( 'vs_cta_body', 'Tell us what you\u2019re building. We\u2019ll tell you honestly whether we\u2019re the right studio for it.' ) ); ?>
				</p>
				<a href="<?php echo esc_url( get_theme_mod( 'vs_cta_url', '/contact' ) ); ?>" class="vs-btn vs-btn--accent">
					<?php echo esc_html( get_theme_mod( 'vs_cta_btn_text', 'Start a conversation' ) ); ?>
				</a>
			</div>
		</div>
	</section>

	<?php // ─── FOOTER ───────────────────────────────────────────────────── ?>
	<footer class="vs-footer">
		<div class="vs-container vs-footer__grid">
			<div class="vs-footer__brand">
				<span class="vs-footer__logo"><?php bloginfo( 'name' ); ?></span>
				<p class="vs-footer__tagline">
					<?php echo esc_html( get_theme_mod( 'vs_footer_tagline', 'A brand & product design studio for considered teams. Working remotely, from the coast.' ) ); ?>
				</p>
			</div>
			<div class="vs-footer__col">
				<h4 class="vs-footer__heading"><?php esc_html_e( 'STUDIO', 'versatile' ); ?></h4>
				<ul class="vs-footer__links">
					<li><a href="#"><?php esc_html_e( 'Work', 'versatile' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'Services', 'versatile' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'About', 'versatile' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Journal', 'versatile' ); ?></a></li>
				</ul>
			</div>
			<div class="vs-footer__col">
				<h4 class="vs-footer__heading"><?php esc_html_e( 'CONNECT', 'versatile' ); ?></h4>
				<ul class="vs-footer__links">
					<li><a href="#">Instagram</a></li>
					<li><a href="#">LinkedIn</a></li>
					<li><a href="#">Dribbble</a></li>
					<li><a href="mailto:<?php echo esc_attr( get_theme_mod( 'vs_footer_email', 'hello@example.co' ) ); ?>">
						<?php echo esc_html( get_theme_mod( 'vs_footer_email', 'hello@example.co' ) ); ?>
					</a></li>
				</ul>
			</div>
			<div class="vs-footer__col vs-footer__dispatch">
				<h4 class="vs-footer__heading"><?php esc_html_e( 'THE DISPATCH', 'versatile' ); ?></h4>
				<p class="vs-footer__dispatch-desc"><?php esc_html_e( 'A short letter on craft and brand, once a month.', 'versatile' ); ?></p>
				<form class="vs-footer__subscribe" action="#" method="post">
					<input type="email" placeholder="you@email.com" aria-label="<?php esc_attr_e( 'Email address', 'versatile' ); ?>">
					<button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'versatile' ); ?>">&rarr;</button>
				</form>
			</div>
		</div>
		<div class="vs-container vs-footer__bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Built on the Versatile theme.', 'versatile' ); ?></span>
			<span class="vs-footer__legal-links">
				<a href="#"><?php esc_html_e( 'Privacy', 'versatile' ); ?></a>
				<a href="#"><?php esc_html_e( 'Terms', 'versatile' ); ?></a>
			</span>
		</div>
	</footer>

</main>

<?php get_footer(); ?>
<?php
/**
 * Template Name: Versatile Front Page
 * Front page template styled with the Versatile design direction
 * Dark teal hero, serif headings, minimal layout
 *
 * @package Versatile
 */

get_header(); ?>

<main class="main-content versatile-front-page">

	<!-- Hero Section -->
	<section class="vs-hero">
		<div class="vs-hero__inner">

			<?php if ( get_theme_mod( 'hero_image' ) ) : ?>
				<div class="vs-hero__avatar">
					<img src="<?php echo esc_url( get_theme_mod( 'hero_image' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</div>
			<?php endif; ?>

			<h1 class="vs-hero__title">
				<?php echo esc_html( get_theme_mod( 'hero_title', 'Hello, I\'m ' . get_bloginfo( 'name' ) ) ); ?>
			</h1>

			<p class="vs-hero__subtitle">
				<?php echo esc_html( get_theme_mod( 'hero_subtitle', get_bloginfo( 'description' ) ) ); ?>
			</p>

			<?php if ( get_theme_mod( 'hero_cta_text' ) && get_theme_mod( 'hero_cta_url' ) ) : ?>
				<a href="<?php echo esc_url( get_theme_mod( 'hero_cta_url' ) ); ?>" class="vs-btn vs-btn--accent">
					<?php echo esc_html( get_theme_mod( 'hero_cta_text' ) ); ?>
				</a>
			<?php endif; ?>

		</div>
	</section>

	<!-- About Section -->
	<?php if ( get_theme_mod( 'about_content' ) ) : ?>
		<section class="vs-section vs-about">
			<div class="vs-container">
				<h2 class="vs-section__title"><?php esc_html_e( 'About', 'versatile' ); ?></h2>
				<div class="vs-about__content">
					<?php echo wp_kses_post( get_theme_mod( 'about_content' ) ); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- Latest Posts -->
	<section class="vs-section vs-posts">
		<div class="vs-container">
			<h2 class="vs-section__title"><?php esc_html_e( 'Latest Posts', 'versatile' ); ?></h2>

			<div class="vs-posts__grid">
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
						<article class="vs-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="vs-card__image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'versatile-featured', array( 'class' => 'img-fluid' ) ); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="vs-card__body">
								<h3 class="vs-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<time class="vs-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
								<div class="vs-card__excerpt">
									<?php the_excerpt(); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="vs-card__link"><?php esc_html_e( 'Read More', 'versatile' ); ?></a>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>

			<div class="vs-posts__more">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="vs-btn vs-btn--outline">
					<?php esc_html_e( 'View All Posts', 'versatile' ); ?>
				</a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
