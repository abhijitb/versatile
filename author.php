<?php
/**
 * Template for displaying author archive pages
 * Versatile WordPress Theme
 *
 * @package Versatile
 */

// Enqueue author-specific styles and scripts.
wp_enqueue_style( 'versatile-author', get_template_directory_uri() . '/assets/css/src/author.css', array(), _S_VERSION );
wp_enqueue_script( 'versatile-author-filter', get_template_directory_uri() . '/assets/js/src/author-filter.js', array(), filemtime( get_template_directory() . '/assets/js/src/author-filter.js' ), true );

get_header(); ?>

<main class="site-main author-main">
	
	<!-- Author Header -->
	<section class="author-header">
		<div class="container">
			<div class="author-info">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
				</div>
				
				<div class="author-details">
					<h1 class="author-name">
						<i class="fas fa-user"></i>
						<?php echo esc_html( get_the_author() ); ?>
					</h1>
					
					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="author-bio">
							<?php echo esc_html( get_the_author_meta( 'description' ) ); ?>
						</div>
					<?php endif; ?>
					
					<div class="author-meta">
						<div class="author-stats">
							<span class="post-count">
								<i class="fas fa-file-alt"></i>
								<?php
								$post_count = count_user_posts( get_the_author_meta( 'ID' ) );
								// translators: %s is the number of posts.
								printf( esc_html( _n( '%s Post', '%s Posts', $post_count, 'versatile' ) ), esc_html( number_format_i18n( $post_count ) ) );
								?>
							</span>
							<span class="member-since">
								<i class="fas fa-calendar-plus"></i>
								<?php
								echo esc_html__( 'Member since', 'versatile' ) . ' ' . esc_html( gmdate( 'F Y', strtotime( get_the_author_meta( 'user_registered' ) ) ) );
								?>
							</span>
						</div>
						
						<!-- Author Social Links -->
						<div class="author-social">
							<?php
							$social_fields = array(
								'url'       => array(
									'icon'  => 'fas fa-globe',
									'label' => 'Website',
								),
								'twitter'   => array(
									'icon'  => 'fab fa-twitter',
									'label' => 'Twitter',
								),
								'facebook'  => array(
									'icon'  => 'fab fa-facebook',
									'label' => 'Facebook',
								),
								'instagram' => array(
									'icon'  => 'fab fa-instagram',
									'label' => 'Instagram',
								),
								'linkedin'  => array(
									'icon'  => 'fab fa-linkedin',
									'label' => 'LinkedIn',
								),
								'youtube'   => array(
									'icon'  => 'fab fa-youtube',
									'label' => 'YouTube',
								),
							);

							foreach ( $social_fields as $field => $data ) {
								$value = get_the_author_meta( $field );
								if ( $value ) {
									// Add protocol if missing for website.
									if ( 'url' === $field && ! preg_match( '/^https?:\/\//', $value ) ) {
										$value = 'http://' . $value;
									}
									echo '<a href="' . esc_url( $value ) . '" target="_blank" rel="noopener" title="' . esc_attr( $data['label'] ) . '">';
									echo '<i class="' . esc_attr( $data['icon'] ) . '"></i>';
									echo '</a>';
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Author Posts -->
	<section class="author-posts-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					
					<div class="section-header">
<h2>
							<?php
							// translators: %s is the author name.
							printf( esc_html__( 'Posts by %s', 'versatile' ), esc_html( get_the_author() ) );
							?>
						</h2>
						
						<!-- Post Filters -->
						<div class="author-post-filters">
							<div class="filter-group">
								<label for="author-post-filter"><?php esc_html_e( 'Filter by Category:', 'versatile' ); ?></label>
								<select id="author-post-filter" onchange="filterAuthorPosts(this.value)">
									<option value="all"><?php esc_html_e( 'All Categories', 'versatile' ); ?></option>
									<?php
									// Get categories used by this author.
									$author_categories = get_categories(
										array(
											'hide_empty' => true,
										)
									);

									foreach ( $author_categories as $category ) {
										// Check if author has posts in this category.
										$cat_posts = get_posts(
											array(
												'author'   => get_the_author_meta( 'ID' ),
												'category' => $category->term_id,
												'numberposts' => 1,
											)
										);

										if ( $cat_posts ) {
											echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
										}
									}
									?>
								</select>
							</div>
							
							<div class="sort-group">
								<label for="author-post-sort"><?php esc_html_e( 'Sort by:', 'versatile' ); ?></label>
								<select id="author-post-sort" onchange="location = this.value;">
									<option value="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>?orderby=date">
										<?php esc_html_e( 'Newest First', 'versatile' ); ?>
									</option>
									<option value="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>?orderby=title">
										<?php esc_html_e( 'Title A-Z', 'versatile' ); ?>
									</option>
									<option value="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>?orderby=comment_count">
										<?php esc_html_e( 'Most Comments', 'versatile' ); ?>
									</option>
								</select>
							</div>
						</div>
					</div>
					
					<?php if ( have_posts() ) : ?>
						<div class="author-posts-grid" id="author-posts">
							<?php
							while ( have_posts() ) :
								the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'author-post-item' ); ?> data-categories="<?php echo esc_attr( implode( ',', wp_get_post_categories( get_the_ID(), array( 'fields' => 'slugs' ) ) ) ); ?>">
									
									<div class="post-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php echo wp_kses_post( versatile_get_post_image( get_the_ID(), 'medium', array( 'class' => 'img-fluid' ) ) ); ?>
										</a>
									</div>
									
									<div class="post-content">
										<div class="post-meta">
											<span class="post-date">
												<i class="fas fa-calendar-alt"></i>
												<?php echo get_the_date(); ?>
											</span>
											<?php if ( has_category() ) : ?>
												<span class="post-categories">
													<i class="fas fa-folder"></i>
													<?php the_category( ', ' ); ?>
												</span>
											<?php endif; ?>
											<?php if ( comments_open() || get_comments_number() ) : ?>
												<span class="post-comments">
													<i class="fas fa-comments"></i>
													<?php comments_number( '0', '1', '%' ); ?>
												</span>
											<?php endif; ?>
										</div>
										
										<h3 class="post-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										
										<div class="post-excerpt">
											<?php
											if ( has_excerpt() ) {
												the_excerpt();
											} else {
												echo wp_kses_post( wp_trim_words( get_the_content(), 20, '...' ) );
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
													<?php
													$tags = get_the_tags();
													if ( $tags ) {
														$tag_count = 0;
														foreach ( $tags as $tag_item ) {
															if ( $tag_count >= 2 ) {
																break;
															}
															echo '<a href="' . esc_url( get_tag_link( $tag_item->term_id ) ) . '" class="tag-link">' . esc_html( $tag_item->name ) . '</a>';
															++$tag_count;
														}
													}
													?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
						
						<!-- Pagination -->
						<nav class="author-pagination" aria-label="Author Posts Pagination">
							<?php
							$pagination = paginate_links(
								array(
									'prev_text' => '<i class="fas fa-chevron-left"></i> ' . esc_html__( 'Previous', 'versatile' ),
									'next_text' => esc_html__( 'Next', 'versatile' ) . ' <i class="fas fa-chevron-right"></i>',
									'type'      => 'array',
								)
							);

							if ( $pagination ) {
								echo '<ul class="pagination">';
								foreach ( $pagination as $page_item ) {
									echo '<li class="page-item">' . wp_kses_post( $page_item ) . '</li>';
								}
								echo '</ul>';
							}
							?>
						</nav>
						
					<?php else : ?>
						<div class="no-posts-found">
							<div class="no-posts-content">
								<i class="fas fa-file-alt fa-3x"></i>
								<h3><?php esc_html_e( 'No Posts Yet', 'versatile' ); ?></h3>
<p>
									<?php
									// translators: %s is the author name.
									printf( esc_html__( '%s hasn\'t published any posts yet.', 'versatile' ), esc_html( get_the_author() ) );
									?>
								</p>
							</div>
						</div>
					<?php endif; ?>
				</div>
				
				<!-- Sidebar -->
				<div class="col-lg-4">
					<aside class="author-sidebar">
						
						<!-- Author Quick Stats -->
						<div class="widget author-stats-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Author Statistics', 'versatile' ); ?></h3>
							<div class="author-stats-grid">
								<div class="stat-item">
									<div class="stat-number"><?php echo esc_html( count_user_posts( get_the_author_meta( 'ID' ) ) ); ?></div>
									<div class="stat-label"><?php esc_html_e( 'Total Posts', 'versatile' ); ?></div>
								</div>
								<div class="stat-item">
									<div class="stat-number">
										<?php
										// Count total comments on author's posts.
										$author_posts   = get_posts(
											array(
												'author' => get_the_author_meta( 'ID' ),
												'numberposts' => -1,
												'fields' => 'ids',
											)
										);
										$total_comments = 0;
										foreach ( $author_posts as $post_item_id ) {
											$total_comments += get_comments_number( $post_item_id );
										}
										echo esc_html( number_format_i18n( $total_comments ) );
										?>
									</div>
									<div class="stat-label"><?php esc_html_e( 'Comments Received', 'versatile' ); ?></div>
								</div>
								<div class="stat-item">
									<div class="stat-number">
										<?php
										// Count categories author has posted in.
										$author_categories = get_categories(
											array(
												'hide_empty' => true,
											)
										);
										$categories_count  = 0;
										foreach ( $author_categories as $category ) {
											$cat_posts = get_posts(
												array(
													'author'   => get_the_author_meta( 'ID' ),
													'category' => $category->term_id,
													'numberposts' => 1,
												)
											);
											if ( $cat_posts ) {
												++$categories_count;
											}
										}
										echo esc_html( $categories_count );
										?>
									</div>
									<div class="stat-label"><?php esc_html_e( 'Categories', 'versatile' ); ?></div>
								</div>
							</div>
						</div>
						
						<!-- Author's Popular Posts -->
						<div class="widget author-popular-posts-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Popular Posts', 'versatile' ); ?></h3>
							<?php
							$popular_posts = get_posts(
								array(
									'author'      => get_the_author_meta( 'ID' ),
									'numberposts' => 5,
									'orderby'     => 'comment_count',
									'order'       => 'DESC',
								)
							);

							if ( $popular_posts ) :
								?>
								<div class="popular-posts-list">
									<?php foreach ( $popular_posts as $popular_post ) : ?>
										<div class="popular-post-item">
											<?php if ( has_post_thumbnail( $popular_post->ID ) ) : ?>
												<div class="popular-post-thumb">
													<a href="<?php echo esc_url( get_permalink( $popular_post->ID ) ); ?>">
														<?php echo wp_kses_post( get_the_post_thumbnail( $popular_post->ID, array( 60, 60 ) ) ); ?>
													</a>
												</div>
											<?php endif; ?>
											<div class="popular-post-content">
												<h5><a href="<?php echo esc_url( get_permalink( $popular_post->ID ) ); ?>"><?php echo esc_html( wp_trim_words( get_the_title( $popular_post->ID ), 6, '...' ) ); ?></a></h5>
												<div class="popular-post-meta">
													<span class="post-date"><?php echo esc_html( get_the_date( 'M j, Y', $popular_post->ID ) ); ?></span>
													<span class="post-comments"><?php echo esc_html( get_comments_number( $popular_post->ID ) ); ?> comments</span>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php else : ?>
								<p><?php esc_html_e( 'No posts available.', 'versatile' ); ?></p>
							<?php endif; ?>
						</div>
						
						<!-- Author's Categories -->
						<div class="widget author-categories-widget">
							<h3 class="widget-title"><?php esc_html_e( 'Categories', 'versatile' ); ?></h3>
							<?php
							$author_categories_with_posts = array();
							foreach ( $author_categories as $category ) {
								$cat_posts = get_posts(
									array(
										'author'      => get_the_author_meta( 'ID' ),
										'category'    => $category->term_id,
										'numberposts' => -1,
									)
								);
								if ( $cat_posts ) {
									$author_categories_with_posts[] = array(
										'category' => $category,
										'count'    => count( $cat_posts ),
									);
								}
							}

							if ( $author_categories_with_posts ) :
								?>
								<div class="author-categories-list">
									<?php foreach ( $author_categories_with_posts as $cat_data ) : ?>
										<a href="<?php echo esc_url( get_category_link( $cat_data['category']->term_id ) ); ?>" class="author-category-link">
											<?php echo esc_html( $cat_data['category']->name ); ?>
											<span class="category-count">(<?php echo esc_html( $cat_data['count'] ); ?>)</span>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
						
						<!-- Regular Sidebar -->
						<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
							<?php dynamic_sidebar( 'sidebar-1' ); ?>
						<?php endif; ?>
						
					</aside>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>