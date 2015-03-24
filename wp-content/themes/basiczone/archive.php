<?php get_header(); ?>
		<section id="primary">
			<div id="content" role="main">
			<?php if ( have_posts() ) : ?>
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<div class="entry-content">
					<header class="page-header">
						<h1 class="page-title">
							<?php
								if ( is_day() ) :
									printf( __( 'Daily Archives: %s', 'basiczone' ), '<span>' . get_the_date() . '</span>' );
								elseif ( is_month() ) :
									printf( __( 'Monthly Archives: %s', 'basiczone' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
								elseif ( is_year() ) :
									printf( __( 'Yearly Archives: %s', 'basiczone' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
								else :
									_e( 'Archives', 'basiczone' );
								endif;
							?>
						</h1>
					</header>
				<?php rewind_posts(); ?>
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