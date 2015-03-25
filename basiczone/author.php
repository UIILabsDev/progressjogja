<?php get_header(); ?>
		<section id="primary">
			<div id="content" role="main">
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<?php if ( have_posts() ) : ?>
					<?php the_post(); ?>
					<div class="entry-content">
						<header class="page-header">
							<h1 class="page-title author"><?php printf( __( 'Author Archives: %s', 'basiczone' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
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
				<span style="display:none;"><a class="url fn n" href="<?php the_author_meta('gplus'); ?>" rel ="me" target="_blank"><img src="https://ssl.gstatic.com/images/icons/gplus-32.png" title="Google Profile" alt="Google Profile"/></a></span>
			</div><!-- #content -->
		</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>