<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'basiczone' ); ?></p>
	</div><!-- #comments -->
	<?php
			return;
		endif;
	?>
	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'basiczone' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above">
				<h4 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'basiczone' ); ?></h4>
				<div class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'basiczone' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'basiczone' ) ); ?></div>
			</nav>
		<?php endif; ?>
		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'basiczone_comment' ) ); ?>
		</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below">
				<h4 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'basiczone' ); ?></h4>
				<div class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'basiczone' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'basiczone' ) ); ?></div>
			</nav>
		<?php endif; ?>
		<div class="inbutton"><a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>#customerReviews','_self')" rel="nofollow"><?php _e( 'See All Reviews &raquo;', 'basiczone' ); ?></a></div>
	<?php endif; ?>
	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments"><?php _e( ' ', 'basiczone' ); ?></p>
	<?php endif; ?>
</div><!-- #comments -->
