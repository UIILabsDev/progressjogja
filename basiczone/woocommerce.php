<?php get_header(); ?>
	<div id="primary">
		<div id="content" role="main">
			<?php if ( have_posts() ) :?>
				<div id="breadcrumbs"><?php if(function_exists('breadcrumbs')){ breadcrumbs(); } ?></div>
				<?php woocommerce_content(); ?>
			<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>