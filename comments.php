<?php
/**
 * Template for displaying comments and comment form
 * Versatile WordPress Theme
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-section">
	<div class="comments-wrapper">
		
		<?php if ( have_comments() ) : ?>
			<div class="comments-header">
				<h3 class="comments-title">
					<i class="fas fa-comments"></i>
					<?php
					$comment_count = get_comments_number();
					if ( $comment_count == 1 ) {
						printf( esc_html__( 'One Comment', 'versatile' ) );
					} else {
						printf(
							esc_html( _n( '%1$s Comment', '%1$s Comments', $comment_count, 'versatile' ) ),
							number_format_i18n( $comment_count )
						);
					}
					?>
				</h3>
				
				<div class="comments-meta">
					<span class="comments-count"><?php echo get_comments_number(); ?> <?php echo _n( 'response', 'responses', get_comments_number(), 'versatile' ); ?></span>
					<?php if ( comments_open() ) : ?>
						<a href="#respond" class="scroll-to-form">
							<i class="fas fa-reply"></i>
							<?php esc_html_e( 'Leave a Comment', 'versatile' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="comments-list-wrapper">
				<ol class="comments-list">
					<?php
					wp_list_comments(
						array(
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 60,
							'callback'    => 'versatilecomment_callback',
						)
					);
					?>
				</ol>
			</div>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav class="comments-navigation" aria-label="Comments Navigation">
					<div class="nav-links">
						<?php
						if ( $prev_link = get_previous_comments_link() ) {
							echo '<div class="nav-previous">' . $prev_link . '</div>';
						}
						if ( $next_link = get_next_comments_link() ) {
							echo '<div class="nav-next">' . $next_link . '</div>';
						}
						?>
					</div>
				</nav>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<div class="comments-closed">
				<i class="fas fa-lock"></i>
				<p><?php esc_html_e( 'Comments are closed for this post.', 'versatile' ); ?></p>
			</div>
		<?php endif; ?>

		<?php
		// Comment form
		if ( comments_open() ) :
			$commenter = wp_get_current_commenter();
			$req       = get_option( 'require_name_email' );
			$html_req  = ( $req ? ' required="required"' : '' );
			$aria_req  = ( $req ? ' aria-required="true"' : '' );

			$comment_form_args = array(
				'title_reply'          => esc_html__( 'Leave a Comment', 'versatile' ),
				'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'versatile' ),
				'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'versatile' ),
				'label_submit'         => esc_html__( 'Post Comment', 'versatile' ),
				'submit_button'        => '<button type="submit" id="%2$s" class="%3$s btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> %4$s</button>',
				'comment_notes_before' => '<div class="comment-notes"><p>' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'versatile' ) . '</p></div>',
				'comment_notes_after'  => '',
				'fields'               => array(
					'author' => '<div class="comment-form-row"><div class="comment-form-author">' .
								'<label for="author">' . esc_html__( 'Name', 'versatile' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
								'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' class="form-control" placeholder="' . esc_attr__( 'Your Name', 'versatile' ) . '">' .
								'</div>',
					'email'  => '<div class="comment-form-email">' .
								'<label for="email">' . esc_html__( 'Email', 'versatile' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>' .
								'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $html_req . ' class="form-control" placeholder="' . esc_attr__( 'your@email.com', 'versatile' ) . '">' .
								'</div></div>',
					'url'    => '<div class="comment-form-url">' .
								'<label for="url">' . esc_html__( 'Website', 'versatile' ) . '</label>' .
								'<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" class="form-control" placeholder="' . esc_attr__( 'https://yourwebsite.com (optional)', 'versatile' ) . '">' .
								'</div>',
				),
				'comment_field'        => '<div class="comment-form-comment">' .
									'<label for="comment">' . esc_html__( 'Comment', 'versatile' ) . ' <span class="required">*</span></label>' .
									'<textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required="required" class="form-control" placeholder="' . esc_attr__( 'Share your thoughts...', 'versatile' ) . '"></textarea>' .
									'</div>',
				'class_form'           => 'comment-form',
				'class_submit'         => 'submit',
			);

			comment_form( $comment_form_args );
		endif;
		?>
	</div>
</section>

<?php
// Custom comment callback function
if ( ! function_exists( 'versatilecomment_callback' ) ) {
	function versatile_comment_callback( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		
		<<?php echo $tag; ?> <?php comment_class( 'comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
			
			<div class="comment-body" id="div-comment-<?php comment_ID(); ?>">
				
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>
				
				<div class="comment-content">
					
					<div class="comment-header">
						<div class="comment-author-info">
							<h4 class="comment-author">
								<?php
								printf( '<cite class="fn">%s</cite>', get_comment_author_link() );
								?>
								<?php if ( $comment->user_id === get_the_author_meta( 'ID' ) ) : ?>
									<span class="author-badge">
										<i class="fas fa-crown"></i>
										<?php esc_html_e( 'Author', 'versatile' ); ?>
									</span>
								<?php endif; ?>
							</h4>
							
							<div class="comment-meta">
								<time class="comment-date" datetime="<?php comment_time( 'c' ); ?>">
									<i class="fas fa-clock"></i>
									<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
										<?php
										printf(
											esc_html__( '%1$s at %2$s', 'versatile' ),
											get_comment_date(),
											get_comment_time()
										);
										?>
									</a>
								</time>
								
								<?php if ( $comment->comment_approved == '0' ) : ?>
									<span class="comment-awaiting-moderation">
										<i class="fas fa-hourglass-half"></i>
										<?php esc_html_e( 'Your comment is awaiting moderation.', 'versatile' ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="comment-actions">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'add_below'  => $add_below,
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
										'before'     => '<div class="reply-link">',
										'after'      => '</div>',
										'reply_text' => '<i class="fas fa-reply"></i> ' . esc_html__( 'Reply', 'versatile' ),
									)
								)
							);
							?>
							
							<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
								<div class="edit-link">
									<a href="<?php echo get_edit_comment_link(); ?>">
										<i class="fas fa-edit"></i>
										<?php esc_html_e( 'Edit', 'versatile' ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
					
					<div class="comment-text">
						<?php comment_text(); ?>
					</div>
					
					<!-- Comment Rating (if using a plugin) -->
					<?php if ( function_exists( 'the_ratings' ) && get_post_type() === 'product' ) : ?>
						<div class="comment-rating">
							<?php the_ratings(); ?>
						</div>
					<?php endif; ?>
					
					<!-- Comment Likes (optional feature) -->
					<div class="comment-footer">
						<div class="comment-likes" data-comment-id="<?php comment_ID(); ?>">
							<button class="like-btn" onclick="toggleCommentLike(<?php comment_ID(); ?>)">
								<i class="far fa-heart"></i>
								<span class="like-count">0</span>
							</button>
						</div>
						
						<div class="comment-share">
							<button class="share-btn" onclick="shareComment(<?php comment_ID(); ?>)">
								<i class="fas fa-share"></i>
								<?php esc_html_e( 'Share', 'versatile' ); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
			
			<?php if ( 'div' != $args['style'] ) : ?>
				</li>
				<?php
			endif;
	}
}
?>

<style>
/* Comments Section Styles */
.comments-section {
	margin-top: 60px;
	padding: 40px;
	background: #f8f9fa;
	border-radius: 10px;
}

.comments-wrapper {
	max-width: 100%;
}

.comments-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 30px;
	padding-bottom: 20px;
	border-bottom: 2px solid #e9ecef;
}

.comments-title {
	margin: 0;
	color: #333;
	font-size: 1.5rem;
}

.comments-meta {
	display: flex;
	gap: 20px;
	align-items: center;
}

.scroll-to-form {
	color: #667eea;
	text-decoration: none;
	font-weight: 600;
	transition: color 0.3s ease;
}

.scroll-to-form:hover {
	color: #5a67d8;
	text-decoration: none;
}

.comments-list {
	list-style: none;
	padding: 0;
	margin: 0;
}

.comment-item {
	margin-bottom: 30px;
	background: white;
	border-radius: 10px;
	padding: 25px;
	box-shadow: 0 2px 10px rgba(0,0,0,0.1);
	transition: box-shadow 0.3s ease;
}

.comment-item:hover {
	box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.comment-body {
	display: flex;
	gap: 20px;
}

.comment-avatar {
	flex-shrink: 0;
}

.comment-avatar img {
	border-radius: 50%;
	border: 3px solid #e9ecef;
}

.comment-content {
	flex: 1;
}

.comment-header {
	display: flex;
	justify-content: space-between;
	align-items: flex-start;
	margin-bottom: 15px;
}

.comment-author {
	margin: 0 0 5px 0;
	font-size: 1.1rem;
}

.comment-author cite {
	font-style: normal;
	font-weight: 600;
	color: #333;
}

.author-badge {
	display: inline-block;
	background: #667eea;
	color: white;
	padding: 2px 8px;
	border-radius: 15px;
	font-size: 11px;
	margin-left: 10px;
	font-weight: normal;
}

.comment-meta {
	display: flex;
	gap: 15px;
	align-items: center;
	font-size: 14px;
	color: #666;
}

.comment-date a {
	color: #666;
	text-decoration: none;
}

.comment-date a:hover {
	color: #667eea;
}

.comment-awaiting-moderation {
	background: #fff3cd;
	color: #856404;
	padding: 5px 10px;
	border-radius: 5px;
	font-size: 12px;
}

.comment-actions {
	display: flex;
	gap: 10px;
}

.reply-link,
.edit-link {
	display: flex;
	align-items: center;
}

.reply-link a,
.edit-link a {
	color: #667eea;
	text-decoration: none;
	font-size: 14px;
	padding: 5px 10px;
	border-radius: 5px;
	transition: all 0.3s ease;
}

.reply-link a:hover,
.edit-link a:hover {
	background: #667eea;
	color: white;
	text-decoration: none;
}

.comment-text {
	line-height: 1.6;
	color: #555;
	margin-bottom: 15px;
}

.comment-text p {
	margin-bottom: 15px;
}

.comment-text p:last-child {
	margin-bottom: 0;
}

.comment-footer {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding-top: 15px;
	border-top: 1px solid #f0f0f0;
}

.like-btn,
.share-btn {
	background: none;
	border: none;
	color: #666;
	cursor: pointer;
	font-size: 14px;
	padding: 5px 10px;
	border-radius: 5px;
	transition: all 0.3s ease;
}

.like-btn:hover {
	background: #ffebee;
	color: #e91e63;
}

.share-btn:hover {
	background: #e3f2fd;
	color: #2196f3;
}

.like-btn.liked {
	color: #e91e63;
}

.like-btn.liked i {
	color: #e91e63;
}

/* Nested Comments */
.children {
	list-style: none;
	margin: 20px 0 0 0;
	padding: 0;
}

.children .comment-item {
	margin-left: 30px;
	margin-top: 20px;
	background: #f8f9fa;
	border-left: 3px solid #667eea;
}

.children .children .comment-item {
	margin-left: 20px;
	background: #f0f0f0;
}

/* Comment Form */
.comment-form {
	background: white;
	padding: 30px;
	border-radius: 10px;
	margin-top: 40px;
	box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.comment-form h3 {
	margin-bottom: 20px;
	color: #333;
}

.comment-notes {
	margin-bottom: 20px;
	padding: 15px;
	background: #e7f3ff;
	border-radius: 5px;
	font-size: 14px;
	color: #0c5460;
}

.comment-form-row {
	display: flex;
	gap: 20px;
	margin-bottom: 20px;
}

.comment-form-author,
.comment-form-email {
	flex: 1;
}

.comment-form-url,
.comment-form-comment {
	margin-bottom: 20px;
}

.comment-form label {
	display: block;
	margin-bottom: 5px;
	font-weight: 600;
	color: #333;
}

.required {
	color: #e74c3c;
}

.comment-form input,
.comment-form textarea {
	width: 100%;
	padding: 12px 15px;
	border: 2px solid #e9ecef;
	border-radius: 8px;
	font-size: 16px;
	transition: border-color 0.3s ease;
}

.comment-form input:focus,
.comment-form textarea:focus {
	outline: none;
	border-color: #667eea;
	box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.comment-form textarea {
	resize: vertical;
	min-height: 120px;
}

.comment-form .btn {
	margin-top: 10px;
}

.comments-closed {
	text-align: center;
	padding: 40px;
	background: #fff3cd;
	border-radius: 10px;
	margin-top: 30px;
}

.comments-closed i {
	font-size: 2rem;
	color: #856404;
	margin-bottom: 10px;
}

.comments-navigation {
	margin-top: 30px;
	text-align: center;
}

.comments-navigation .nav-links {
	display: flex;
	justify-content: space-between;
	align-items: center;
}

.comments-navigation a {
	padding: 10px 20px;
	background: #667eea;
	color: white;
	text-decoration: none;
	border-radius: 5px;
	transition: background 0.3s ease;
}

.comments-navigation a:hover {
	background: #5a67d8;
	text-decoration: none;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
	.comments-header {
		flex-direction: column;
		align-items: flex-start;
		gap: 15px;
	}
	
	.comment-body {
		flex-direction: column;
		gap: 15px;
	}
	
	.comment-header {
		flex-direction: column;
		align-items: flex-start;
		gap: 10px;
	}
	
	.comment-form-row {
		flex-direction: column;
		gap: 15px;
	}
	
	.children .comment-item {
		margin-left: 15px;
	}
	
	.children .children .comment-item {
		margin-left: 10px;
	}
	
	.comment-footer {
		flex-direction: column;
		align-items: flex-start;
		gap: 10px;
	}
}

/* Dark mode support (if enabled) */
.dark-mode .comments-section {
	background: #2d3748;
}

.dark-mode .comment-item {
	background: #4a5568;
	color: #e2e8f0;
}

.dark-mode .comment-author cite {
	color: #e2e8f0;
}

.dark-mode .comment-form {
	background: #4a5568;
	color: #e2e8f0;
}

.dark-mode .comment-form input,
.dark-mode .comment-form textarea {
	background: #2d3748;
	border-color: #4a5568;
	color: #e2e8f0;
}
</style>

<script>
// Comment interactions
function toggleCommentLike(commentId) {
	const likeBtn = document.querySelector(`[data-comment-id="${commentId}"] .like-btn`);
	const likeCount = likeBtn.querySelector('.like-count');
	const icon = likeBtn.querySelector('i');
	
	if (likeBtn.classList.contains('liked')) {
		likeBtn.classList.remove('liked');
		icon.classList.remove('fas');
		icon.classList.add('far');
		likeCount.textContent = parseInt(likeCount.textContent) - 1;
	} else {
		likeBtn.classList.add('liked');
		icon.classList.remove('far');
		icon.classList.add('fas');
		likeCount.textContent = parseInt(likeCount.textContent) + 1;
	}
}

function shareComment(commentId) {
	const commentUrl = `${window.location.href}#comment-${commentId}`;
	
	if (navigator.share) {
		navigator.share({
			title: 'Check out this comment',
			url: commentUrl
		});
	} else {
		// Fallback: copy to clipboard
		navigator.clipboard.writeText(commentUrl).then(function() {
			alert('Comment link copied to clipboard!');
		});
	}
}

// Smooth scroll to comment form
document.addEventListener('DOMContentLoaded', function() {
	const scrollToFormLinks = document.querySelectorAll('.scroll-to-form');
	
	scrollToFormLinks.forEach(link => {
		link.addEventListener('click', function(e) {
			e.preventDefault();
			const commentForm = document.getElementById('respond');
			if (commentForm) {
				commentForm.scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
				
				// Focus on comment textarea after scroll
				setTimeout(() => {
					const commentTextarea = document.getElementById('comment');
					if (commentTextarea) {
						commentTextarea.focus();
					}
				}, 500);
			}
		});
	});
});
</script>