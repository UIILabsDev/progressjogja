<?php get_header(); ?>
	<section id="primary" class="full-width">
		<div id="content" role="main">
			<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
			<?php if ( have_posts() ) : ?>
				<div class="entry-content">
					<header class="page-header">
						<h1 class="page-title"><?php
							printf( __( '%s', 'basiczone' ), '<span>' . __( 'Bestseller ', 'basiczone' ) . single_cat_title( '', false ) . '</span>' );
						?></h1>
						<?php
							$category_description = category_description();
							if ( ! empty( $category_description ) )
								echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
						?>
					</header>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
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
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'basiczone' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			<?php endif; ?>
				<?php if (function_exists('random_posts')) random_posts(8); ?>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>