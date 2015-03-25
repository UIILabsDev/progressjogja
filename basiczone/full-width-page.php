<?php get_header(); ?>
	<div id="primary" class="full-width">
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>