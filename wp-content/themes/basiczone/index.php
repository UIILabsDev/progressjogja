<?php get_header(); ?>
	<div id="primary">
		<div id="content" role="main">
			<?php basiczone_featured(); ?>
			<?php if ( have_posts() ) : ?>
				<div class="entry-content">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
					<div style="clear:both;"></div>
					<?php if (function_exists('pagenavi')) pagenavi(); ?>
				</div>
				<?php if (function_exists('random_posts')) random_posts(4); ?>
			<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'basiczone' ); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'basiczone' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>