<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="icon" type="image/png" href="<?php if ( basiczone_option( 'favicon' ) ): echo basiczone_option( 'favicon' ); ?><?php else: ?><?php echo get_template_directory_uri(); ?>/images/favicon.png<?php endif; ?>"/>
<meta name="viewport" content="width=device-width" />
<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'basiczone' ), max( $paged, $page ) );
	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php if (basiczone_option( 'style' ) =='0') {
		echo '<link rel="stylesheet" type="text/css" media="all" href="' . get_template_directory_uri() . '/css/red.css" />';
	} elseif (basiczone_option( 'style' ) =='1') {
		echo '<link rel="stylesheet" type="text/css" media="all" href="' . get_template_directory_uri() . '/css/blue.css" />';
	} else {
		echo '<link rel="stylesheet" type="text/css" media="all" href="' . get_template_directory_uri() . '/css/green.css" />';
	}	?>
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php if (basiczone_option( 'soc_button' ) =='1') {?>
	<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
	<script type="text/javascript">
window.___gcfg={lang:"en"};(function(){var a=document.createElement("script");a.type="text/javascript";a.async=true;a.src="https://apis.google.com/js/plusone.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})();
	</script>	
<?php } ?>
<?php wp_head(); ?>

<?php if ( is_home()) {?>
	<script type="text/javascript">
$(document).ready(function(){$("#slider").easySlider({loop:true,orientation:"fade",autoplayDuration:3000,autogeneratePagination:true,restartDuration:3000,nextId:"next",prevId:"prev",pauseable:true})});
	</script>
<?php } ?>

</head>
<body <?php body_class(); ?>>
	<?php if (basiczone_option( 'fb_code' ) !=='') {
			echo basiczone_option( 'fb_code' );
	} ?>
<div id="page" class="hfeed">
	<header id="branding" role="banner">
		<hgroup>
			<?php if(!is_home()) echo('<h4 id="site-title">'); else echo('<h1 id="site-title">'); ?>
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php if (basiczone_option( 'custom_logo' ) =='1'): ?>
					<img src="<?php if ( basiczone_option( 'header_logo' ) ):	echo basiczone_option( 'header_logo' ); ?><?php else: ?><?php echo get_template_directory_uri();?>/images/logo.png<?php endif; ?>" width="200" height="100" />
					<span class="hide"><?php bloginfo( 'name' ); ?></span>
				<?php else: ?>
					<?php bloginfo( 'name' ); ?>
				<?php endif; ?>	
				</a>
			<?php if(!is_home()) echo('</h4>'); else echo('</h1>'); ?>
			
			<?php if(!is_home()) echo('<h5 id="site-description">'); else echo('<h2 id="site-description">'); ?>
				<?php if (basiczone_option( 'custom_logo' ) =='1'): ?>
					<span class="hide"><?php bloginfo( 'description' ); ?></span>
				<?php else: ?>
					<?php bloginfo( 'description' ); ?>
				<?php endif; ?>					
			<?php if(!is_home()) echo('</h5>'); else echo('</h2>'); ?>
		</hgroup>			
		<div class="hgright">
			<?php if (basiczone_option( 'custom_logo' ) =='1'): ?>
				<?php if ( basiczone_option( 'ads_728' ) ) 
					echo basiczone_option( 'ads_728' );
				?>
			<?php else: ?>
				<?php if ( basiczone_option( 'ads_468' ) ) 
					echo basiczone_option( 'ads_468' );
				?>
			<?php endif; ?>		
		</div>
		<div style="clear:both;"></div>
		<nav id="access" role="navigation">
			<h4 class="assistive-text section-heading"><?php _e( 'Main menu', 'basiczone' ); ?></h4>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'basiczone' ); ?>"><?php _e( 'Skip to content', 'basiczone' ); ?></a></div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #access -->
		<div style="clear:both;"></div>
		<?php if ( ! is_404()) {?>
			<?php get_template_part( 'searchform' ); ?>
		<?php } ?>	
	</header><!-- #branding -->
	<div id="main">