<?php get_header(); ?>
	<div id="primary" class="full-width">
		<div id="content" role="main">
			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Well this is somewhat embarrassing, isn&rsquo;t it?', 'basiczone' ); ?></h1>
				</header>
				<div class="entry-content-page">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below can help.', 'basiczone' ); ?></p>
					<?php get_search_form(); ?>
					<div class="widget">
						<h3 class="widget-title"><?php _e( 'Most Used Categories', 'basiczone' ); ?></h3>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 15 ) ); ?>
						</ul>
					</div>
					<?php
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'basiczone' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=0', "before_title=<h3 class='widget-title'>&after_title=</h3>$archive_content" );
					?>
					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>