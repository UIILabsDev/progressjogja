<?php get_header(); ?>
	<section id="primary">
		<div id="content" role="main">
			<?php if ( have_posts() ) : ?>
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<div class="entry-content">
					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search results for: %s', 'basiczone' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'search' ); ?>
					<?php endwhile; ?>
					<?php if (function_exists('pagenavi')) pagenavi(); ?>
					<div style="clear:both;"></div>
				</div>
			<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'basiczone' ); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'basiczone' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			<?php endif; ?>
			<?php if (function_exists('random_posts')) random_posts(8); ?>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>