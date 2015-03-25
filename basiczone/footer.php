		<div class="clear"></div><!-- #main -->
	</div><!-- #main -->
	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div id="tertiary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
			<div style="clear:both;"></div>
		</div><!-- #tertiary .widget-area -->
	<?php endif; ?>	
</div><!-- #page -->
<footer id="colophon" role="contentinfo">
	<div id="menu-generator">
		<ul>
			<li>&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></li> 
			<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>	
		</ul>
	</div>
	<?php wp_footer(); ?>	
	
	<?php generator(); ?>
	<?php if ( basiczone_option( 'analytics_code' ) ) 
		echo basiczone_option( 'analytics_code' );
	?>
</body>
</html>