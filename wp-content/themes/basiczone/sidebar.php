<div id="secondary" class="widget-area" role="complementary">
	<?php if ( is_single() ) {?>
		<?php if ( basiczone_option( 'ads_300' ) !=="" ) {
			echo '<aside id="ads300" class="widget">'; 
			echo basiczone_option( 'ads_300' );
			echo '</aside>';
		} ?>
		<?php if (function_exists('recent_posts')) recent_posts(5); ?>
		<?php if (basiczone_option( 'fb_like' ) =='1') { 
			echo '<aside class="widget">';
				$permalink = basiczone_option( 'fb_page' );
					echo '<div class="fb-like-box" data-href="' . $permalink . '" data-width="300" data-show-faces="true" data-border-color="#EFEFEF" data-stream="false" data-header="true"></div></aside>';
			} ?>
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	<?php } else { ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php } ?>
</div><!-- #secondary .widget-area -->
