<?php get_header(); ?>
	<div id="primary">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<?php get_template_part( 'content', 'single' ); ?>
					<div id="tabContainer">
						<div class="tabs">
							<ul>
								<li id="tabHeader_1"><?php _e( 'Other Recommendations', 'basiczone' ); ?></li>
								<li id="tabHeader_2"><?php _e( 'Best Selling Products', 'basiczone' ); ?></li>
								<?php $comment_count = get_comment_count($post->ID); ?>
								<?php if ($comment_count['approved'] >= 1) {
									echo '<li id="tabHeader_3">' . __( 'Product Reviews', 'basiczone' ) . '</li>';
								} ?>
								<?php if (basiczone_option( 'fb_comment' ) =='1') {
									echo '<li id="tabHeader_4">' . __( 'Feedback', 'basiczone' ) . '</li>';
								} ?>
							</ul>
						</div>
					<div class="tabscontent">
						<div class="tabpage" id="tabpage_1">
							<?php echo do_shortcode("[related_posts]"); ?>
					  	</div>
					  	<div class="tabpage" id="tabpage_2">
							<?php if (function_exists('random_posts')) random_posts(8); ?>
					  	</div>
					  	<div class="tabpage" id="tabpage_3">
							<?php if ( comments_open() || '0' != get_comments_number() ) comments_template( '', true ); ?>
					  	</div>
					  	<div class="tabpage" id="tabpage_4">
							<div id="fbkemon">
								<p><strong><?php _e( 'Share your experience about this product', 'basiczone' ); ?></strong></p>
									<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="10" data-width="560"></div>
						  	</div>
					  	</div>
					</div>
				</div>
				<?php if(function_exists('stt_terms_list')) echo stt_terms_list() ;?>
			<?php endwhile; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>