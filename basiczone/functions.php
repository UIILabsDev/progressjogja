<?php
require_once( STYLESHEETPATH . '/includes/basiczone-options.php' );
require_once( STYLESHEETPATH . '/includes/breadcrumbs.php' );

function basiczone_option( $option ) {
	$options = get_option( 'basiczone_options' );
	if ( isset( $options[$option] ) )
		return $options[$option];
	else
		return false;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<section id="main">';
}

function my_theme_wrapper_end() {
  echo '</section>';
}

add_action( 'after_setup_theme', 'woocommerce_support' );

function woocommerce_support() {
add_theme_support( 'woocommerce' );
} 

function remove_category_rel_from_category_list($thelist){
     return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}
add_filter('the_category', 'remove_category_rel_from_category_list');

if ( ! isset( $content_width ) )
	$content_width = 565; 

if ( ! function_exists( 'basiczone_setup' ) ):
function basiczone_setup() {
	load_theme_textdomain( 'basiczone', get_template_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	add_theme_support( 'automatic-feed-links' );
	add_custom_background();
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'basiczone' ),
		'secondary' => __( 'Secondary Navigation', 'basiczone'),
	) );
}
endif; 

add_action( 'after_setup_theme', 'basiczone_setup' );

$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

function basiczone_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'basiczone_page_menu_args' );

function basiczone_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'basiczone' ),
		'id' => 'sidebar-1',
		'description' => __( 'Non Single Page Sidebar', 'basiczone' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'basiczone' ),
		'id' => 'sidebar-2',
		'description' => __( 'Single post sidebar area', 'basiczone' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 3', 'basiczone' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional bottom sidebar area', 'basiczone' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'init', 'basiczone_widgets_init' );

if ( ! function_exists( 'basiczone_comment' ) ) :
function basiczone_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'basiczone' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'basiczone' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php printf( __( '%s <span class="says">says:</span>', 'basiczone' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is waiting moderation.', 'basiczone' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( __( '%1$s at %2$s', 'basiczone' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'basiczone' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;



if ( ! function_exists( 'basiczone_posted_on' ) ) :
function basiczone_posted_on() {
	printf( __( '<span class="sep"></span><span class="updated"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a></span><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><span class="fn"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span></span>', 'basiczone' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'basiczone' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;
function basiczone_body_classes( $classes ) {
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}
	return $classes;
}
add_filter( 'body_class', 'basiczone_body_classes' );

function basiczone_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}
	if ( '1' != $all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}

function basiczone_category_transient_flusher() {
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'basiczone_category_transient_flusher' );
add_action( 'save_post', 'basiczone_category_transient_flusher' );

function basiczone_enhanced_image_navigation( $url ) {
	global $post;

	if ( wp_attachment_is_image( $post->ID ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'basiczone_enhanced_image_navigation' );

function basiczone_scripts() {
	if ( is_home() ) {
		wp_enqueue_script('basiczonejquery', get_template_directory_uri() . '/js/jquery.js', '', '', false);
		wp_enqueue_script('basiczoneslide', get_template_directory_uri() . '/js/slider.js', '', '', true);
	}
	if ( is_single() ) {	
		wp_enqueue_script('basiczonetabs', get_template_directory_uri() . '/js/tabs.js', '', '', true);
	}	
}    
add_action('wp_enqueue_scripts', 'basiczone_scripts');

function get_custom_field($key, $echo = FALSE) {
	global $post;
	$custom_field = get_post_meta($post->ID, $key, true);
	if ($echo == FALSE) return $custom_field;
	echo $custom_field;
}

function related_posts_shortcode( $atts ) {
	extract(shortcode_atts(array(
	    'limit' => '8',
	), $atts));

	global $wpdb, $post, $table_prefix;

	if ($post->ID) {
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";
			
		$related = $wpdb->get_results($q);

 		if ( $related ) {
		echo '<div id="related_posts"><h3 class="widget-title">' . __( 'Related Products', 'basiczone' ) . '</h3><ul>';
		
			foreach($related as $r) {
				$thumb = get_post_meta($r->ID, 'thumb', true);
				$price = get_post_meta($r->ID, 'price', true);
				
				echo '
	<li>
		<div class="item-content">

			<div class="item-price">';
				if ($price =="") {
				echo '<span class="pricetag"><a href="'.get_permalink($r->ID).'">' . __( 'Click Here', 'basiczone' ) . '</a></span>';
				} else {
				echo '<span class="pricetag"><a href="'.get_permalink($r->ID).'">'.$price.'</a></span>';
				}
			echo '</div>
			
			<div class="item-image">
				<a class="info" href="'.get_permalink($r->ID).'"><span>'.wptexturize($r->post_title).'</span><img src="'.$thumb.'"/></a>
			</div>
			
			<div class="item-title">
				<h2><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></h2>

			</div>

		</div>
	</li>';
			}
		} else {

		$categories = get_the_category($post->ID);
		if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		
			$random = array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'numberposts' => 8, // Number of related posts that will be shown.
				'orderby' => 'rand'
			);
			
		$rand_posts = get_posts( $random );
		
		echo '<div id="related_posts"><h3 class="widget-title">' . __( 'Related Products', 'basiczone' ) . '</h3><ul>';
		
		foreach( $rand_posts as $rnd ) {
			$thumb = get_post_meta($rnd->ID, 'thumb', true);
			$price = get_post_meta($rnd->ID, 'price', true);
		
			echo '
	<li>
		<div class="item-content">

			<div class="item-price">';
				if ($price =="") {
				echo '<span class="pricetag"><a href="'.get_permalink($rnd->ID).'">' . __( 'Click Here', 'basiczone' ) . '</a></span>';
				} else {
				echo '<span class="pricetag"><a href="'.get_permalink($rnd->ID).'">'.$price.'</a></span>';
				}
			echo '</div>
			
			<div class="item-image">
				<a class="info" href="'.get_permalink($rnd->ID).'"><span>'.wptexturize($rnd->post_title).'</span><img src="'.$thumb.'"/></a>
			</div>
			
			<div class="item-title">
				<h2><a title="'.wptexturize($rnd->post_title).'" href="'.get_permalink($post->ID).'">'.wptexturize($rnd->post_title).'</a></h2>
			</div>

		</div>
	</li>
';

				}
			}
		}
		
		echo '</ul><div style="clear:both;"></div></div>
';
	}
}
add_shortcode('related_posts', 'related_posts_shortcode');

function recent_posts($num) {
	$args = array( 'numberposts' => $num, 'post_status' => 'publish' );
	$recent_posts = wp_get_recent_posts( $args );
	echo '<aside id="recentposts" class="widget">';
	echo '<h3 class="widget-title">' . __( 'New Arrival', 'basiczone' ) . '</h3>';
	echo '<div class="recentposts">';
	echo '<ul>';
					
	foreach( $recent_posts as $recent ){
		$thumb = get_post_meta($recent["ID"], 'thumb', true);
		$price = get_post_meta($recent["ID"], 'price', true);
		$listprice = get_post_meta($recent["ID"], 'list_price', true);
							
		echo '	
						
		<li>
			<div class="item-content-sidebar">
				<div class="recentposts-img">
					<a class="info" href="'.get_permalink($recent["ID"]).'"><span>'.$recent["post_title"].'</span><img src="'.$thumb.'" style="max-width:60px; max-height:60px; margin:0; padding:0px;"/></a>
				</div>
				<div class="recentposts-detail">
					<div class="rp-title">
						<span class="recent-title"><a href="' . get_permalink($recent["ID"]) . '" title="Look '.$recent["post_title"].'" >' . $recent["post_title"].'</a></span>
					</div>';
					if ($price !== $listprice) {
					echo '<div class="rp-price">
						<span class="listprice" style="float:left;">'.$listprice.'</span><span class="pricetag-sidebar"><a href="'.get_permalink($recent["ID"]).'">'.$price.'</a></span>
					</div>';
					} elseif ($price =="") {
					echo '<span class="pricetag-sidebar"><a href="'.get_permalink($recent["ID"]).'">' . __( 'Click Here', 'basiczone' ) . '</a></span>';
					} else {
					echo '<span class="pricetag-sidebar"><a href="'.get_permalink($recent["ID"]).'">' .$price.'</a></span>';
					}
					
				echo '</div>
			</div>	
		</li>
		 ';
		}
	echo '</ul>';
	echo '<div style="clear:both;"></div>';
	echo '</div>';
	echo '</aside>';
}

function random_posts ($num) {
		$random = array( 'numberposts' => $num, 'orderby' => 'rand' );
		$rand_posts = get_posts( $random );
		
		echo '<div id="random_posts"><h3 class="widget-title">' . __( 'Bestsellers Products', 'basiczone' ) . '</h3><ul>';
		
		foreach( $rand_posts as $rnd ) {
			$thumb = get_post_meta($rnd->ID, 'thumb', true);
			$price = get_post_meta($rnd->ID, 'price', true);
		
			echo '
	<li>
		<div class="item-content">

			<div class="item-price">';
				if ($price =="") {
				echo '<span class="pricetag"><a href="'.get_permalink($rnd->ID).'">' . __( 'Click Here', 'basiczone' ) . '</a></span>';
				} else {
				echo '<span class="pricetag"><a href="'.get_permalink($rnd->ID).'">'.$price.'</a></span>';
				}
			echo '</div>
			
			<div class="item-image">
				<a class="info" href="'.get_permalink($rnd->ID).'"><span>'.wptexturize($rnd->post_title).'</span><img src="'.$thumb.'"/></a>
			</div>
			
			<div class="item-title">
				<h2><a title="'.wptexturize($rnd->post_title).'" href="'.get_permalink($rnd->ID).'">'.wptexturize($rnd->post_title).'</a></h2>
			</div>

		</div>
	</li>
';
		}
	echo '</ul>';
	echo '<div style="clear:both;"></div>';
	echo '</div>';		
}

function new_excerpt_length($length) {
	return 40;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
       global $post;
	return ' - <a href="'. get_permalink($post->ID) . '">' . __( 'Read Product Details ...', 'basiczone' ) . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function pagenavi() {
  global $wp_query, $wp_rewrite;
  $pages = '';
  $max = $wp_query->max_num_pages;
  if (!$current = get_query_var('paged')) $current = 1;
  $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
  $a['total'] = $max;
  $a['current'] = $current;
 
  $total = 1; 
  $a['mid_size'] = 3; 
  $a['end_size'] = 1; 
  $a['prev_text'] = __('&laquo; Previous', 'basiczone'); 
  $a['next_text'] = __('Next &raquo;', 'basiczone'); 
 
  if ($max > 1) echo '<div class="navigation">';
  if ($total == 1 && $max > 1) $pages = __('<span class="pages">Page ' . $current . ' of ' . $max . '</span>'."\r\n", 'basiczone');
  echo $pages . paginate_links($a);
  if ($max > 1) echo '</div>';
}

function basiczone_extended_profile( $contactmethods ) { // Add Google Profile 
	$contactmethods += array( 
		 'gplus' => __('Google+ Profile URL', 'basiczone')
		 );
	return $contactmethods; 
} 
add_filter( 'user_contactmethods', 'basiczone_extended_profile');

function basiczone_soc_sharing() {
	if (basiczone_option( 'soc_button' ) =='1') {
		echo '<div class="social">
				<ul id="social">
					<li class="facebook"><div class="fb-like" data-send="true" data-layout="button_count" data-width="190" data-show-faces="false" data-action="recommend"></div></li>
					<li class="twitter"><div><a href="' . esc_url( __( 'https://twitter.com/share', 'basiczone' ) ) . '" class="twitter-share-button">Tweet</a></div></li>
					<li class="gplusone"><div class="g-plusone" data-size="medium"></div></li>
					<li class="stumble"><script src="http://www.stumbleupon.com/hostedbadge.php?s=1"></script></li>
				</ul>
				<div style="clear:both;"></div>
			</div>';
	}
}			

function basiczone_frating() {
	global $post;

	if (basiczone_option( 'target' ) =='0') {
		$variable = array("$ ", "$", ",");
		$curr = '$';
	} elseif (basiczone_option( 'target' ) =='1') {
		$variable = array("EUR ", "EUR", ".", '&#8364;');
		$curr = '&#8364;';
	} else {
		$variable = array("GBP ", "GBP", ",", "&pound;");
		$curr = '&#163;';
	}

	$price = get_post_meta($post->ID, 'price', true);
	$pricevalue = str_replace($variable, "", $price);
	$listprice = get_post_meta($post->ID, 'list_price', true);
	$listpricevalue = str_replace($variable, "", $listprice);
	
	if (basiczone_option( 'target' ) =='0') {
		$var1 = str_replace($variable, "", $price);
		$var2 = str_replace($variable, "", $listprice);
		if (isset($var1)) $var1 = 0;
		if (isset($var2)) $var2 = 0;
	    $pricevalue = number_format($var1, 2, '.', ',');
	    $listpricevalue = number_format($var2, 2, '.', ',');
	} elseif (basiczone_option( 'target' ) =='1') {
		$var1 = str_replace($variable, "", $price);
		$var2 = str_replace($variable, "", $listprice);
                if(isset($var1))
		     $pricevalue = number_format($var1, 2, ',', '.');
                if(isset($var2))
		     $listpricevalue = number_format($var2, 2, ',', '.');
	} else {
		$var1 = ereg_replace("[^0-9.]", "", $price);
		$var2 = ereg_replace("[^0-9.]", "", $listprice);
                if(isset($var1))
		     $pricevalue = number_format($var1, 2, '.', ',');
                if(isset($var2))
		     $listpricevalue = number_format($var2, 2, '.', ',');
	}	
										
	$rateavg = get_post_meta($post->ID,'rating', TRUE);
	$favg = rand(70, 90);
	$pavg = ( $rateavg / 5) * 100;
	
	if ( $pricevalue == "") {
		echo '';
	} else {
		if ( $pricevalue == $listpricevalue ) {
			echo '<span itemprop="pricerange" style="display:none">' . $curr . $pricevalue . '</span>';
		} elseif ( $pricevalue > $listpricevalue ) {
			echo '<span itemprop="pricerange" style="display:none">' . $curr . $listpricevalue . ' - ' . $curr . $pricevalue . '</span>';
		} else {	
			echo '<span itemprop="pricerange" style="display:none">' . $curr . $pricevalue . ' - ' . $curr . $listpricevalue . '</span>';
		}
	}
		
	if ($rateavg =="") {
		echo '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating" style="display:none;">Rating: <span itemprop="average">' . $favg . '%</span></span>';
	} else {
		echo '<span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating" style="display:none;">Rating: <span itemprop="average">' . $rateavg . '</span> ' . __( 'out of', 'basiczone' ) . ' <span itemprop="best">5</span>';
		echo ' <span itemprop="average">' . $pavg . '%</span></span>';	
	}
}

function basiczone_asin() {
	global $post;
	$asin = get_post_meta($post->ID, 'asin', true);

	if ($asin != "") {
		echo $asin;
	} else {
		echo 'BSP';
		$cat = get_the_category();
		$cat = $cat[0];
		$cats = $cat->cat_ID;
		echo $cats . '-';
		echo the_ID(', ');
	}	
}
	
function basiczone_listprice() {
	global $post;
	$price = get_post_meta($post->ID, 'price', true);

	if (basiczone_option( 'target' ) =='0') {
		$variable = array("$ ", "$", ",");
	} elseif (basiczone_option( 'target' ) =='1') {
		$variable = array("EUR ", "EUR", ".", '&#8364;');
	} else {
		$variable = array("GBP ", "GBP ", ",", "&pound;");
	}
		
	$pricevalue = str_replace($variable, "", $price);
	$listprice = get_post_meta($post->ID, 'list_price', true);
	$listpricevalue = str_replace($variable, "", $listprice);
						
	if ( $pricevalue == "" ) {
		echo '-';
	} elseif ( $pricevalue == $listpricevalue ) {
		echo '<span class="lisprice">' . $price . '</span>';
	} else {			
		echo '<span class="lisprice" style="text-decoration:line-through;">' . $listprice . '</span>';
	}	
}

function basiczone_price() {
	global $post;
	$price = get_post_meta($post->ID, 'price', true);
	
	if ( $price !== "" ) { ?>
		<span class="price"><a class="info" href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>','_self')" rel="nofollow">
		<?php echo $price; ?><span style="margin:10px; padding:10px; font-size:15px;"><?php _e( 'Click Here for Special Offer', 'basiczone' ); ?></span></a></span>
	<?php } else { ?>
		<span class="price"><a class="info" href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>','_self')" rel="nofollow"><?php _e( 'Unspecified', 'basiczone'); ?><span style="margin:10px; padding:10px; font-size:15px;"><?php _e( 'Why don&rsquo;t we show the price? Click here to find out', 'basiczone' ); ?></span></a></span>	
	<?php }
}

function basiczone_spoffer() {
	global $post;
	$thumb = get_post_meta($post->ID, 'thumb', true);
	$price = get_post_meta($post->ID, 'price', true);
	$listprice = get_post_meta($post->ID, 'list_price', true);
	
	if (basiczone_option( 'target' ) =='0') {
		$variable = array("$ ", "$", ",");
		$curr = '$';
	} elseif (basiczone_option( 'target' ) =='1') {
		$variable = array("EUR ", "EUR", ".", '&#8364;');
		$curr = '&#8364;';
		$pricestr = str_replace($variable, "", $price);
		$listpricestr = str_replace($variable, "", $listprice);
	} else {
		$variable = array("GBP ", "GBP", ",", "&pound;");
		$curr = "&#163;";
	}
	
	if (basiczone_option( 'target' ) =='0') {
		$savings = str_replace($variable, "", $listprice) - str_replace($variable, "", $price);
	} elseif (basiczone_option( 'target' ) =='1') {
		$savings = str_replace(",", ".", $listpricestr) - str_replace(",", ".", $pricestr);
	} else {
		$savingslist = ereg_replace("[^0-9.]", "", $listprice);
		$savingsprice = ereg_replace("[^0-9.]", "", $price);
		$savings = $savingslist - $savingsprice;
	}	
			
	if (basiczone_option( 'target' ) =='0') {
		$yousave = number_format($savings, 2, '.', ',');
	} elseif (basiczone_option( 'target' ) =='1') {
		$yousave = number_format($savings, 2, ',', '.');
	} else {
		$yousave = number_format($savings, 2, '.', ',');
	}

	echo '<div class="specialoffer">
			<div class="inspecimg">
				<div class="inimg">
					<img src=" ' . $thumb . '" />
				</div>
				<div class="inoption">
					<ul>
						<li>' . __( 'Low Price Guarantee', 'basiczone' ) . '</li>
						<li>' . __( 'Free Super Saver Shipping', 'basiczone' ) . '</li>
						<li>' . __( 'One-Day Shipping', 'basiczone' ) . '</li>
					</ul>
					<div class="inbutton">'; ?>
						<a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>','_self')" rel="nofollow">
						<?php	if ( $yousave <= 0 ) {
								echo __( 'Click Here for Special Offer', 'basiczone' ) . '</a>';
							} else {
								echo __( 'You Save ', 'basiczone' ) . $curr . ' ' . $yousave . '</a>';
							} ?>
		<?php	echo	'</div>
				</div>
			</div>
		</div>';					
}

function basiczone_trapmenu() {
	global $post;
	echo '<div id="singlemenu">'; ?>
			<ul>
				<li class="tab1"><a href="javascript:void(0)" onclick="window.open('<?php get_custom_field('detail', TRUE); ?>#productDescription','_self')" rel="nofollow"><?php _e( 'Product Descriptions', 'basiczone' ); ?></a></li>
				<li class="tab2"><a href="javascript:void(0)" onclick="window.open('<?php get_custom_field('detail', TRUE); ?>#technical_details','_self')" rel="nofollow"><?php _e( 'Product Features', 'basiczone' ); ?></a></li>
				<li><a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>#productDetails','_self')" rel="nofollow"><?php _e( 'Technical Details', 'basiczone' ); ?></a></li>
			</ul>
			<div style="clear:both;"></div>
		<?php echo '</div>';	
}

function basiczone_featured() {
	global $post;
	$args = array(
	'numberposts' => 5,
	'orderby' => 'rand'
	);
	
	$featposts = get_posts( $args );
	
	echo '<div id="slider">
			<ul>';
			
	foreach ( $featposts as $post ) {
		$thumb = get_post_meta($post->ID, 'thumb', true);
		$listprice = get_post_meta($post->ID, 'list_price', true);
		$price = get_post_meta($post->ID, 'price', true);
		$excr = wp_html_excerpt($post->post_content, 300);
		
		echo '
			<li><h2 class="featured-title"><a href="' . get_permalink($post->ID) . '">' . wptexturize($post->post_title) . '</a></h2>
			<div class="featbox">
				<div class="featured-img">
					<img class="featimg" src="' . $thumb . '" alt="' . wptexturize($post->post_title) . '"/>
				</div>
				
				<div class="featured-detail">';
					echo '<p>' . $excr . '</p>';
					if ( $listprice == "") {
						echo '<span class="featprice"><a href="' . get_permalink($post->ID) . '">' . __( 'Check It Out', 'basiczone' ) . '</a></span>';
					} elseif ($listprice == $price) {
						echo '<span class="featprice"><a href="' . get_permalink($post->ID) . '">' . $price . '</a></span>';
					} else {
						echo '<span class="listprice">' . $listprice . '</span>';
						echo '<span class="featprice"><a href="' . get_permalink($post->ID) . '">' . __( 'Now Only ', 'basiczone' ) . $price . '</a></span>';
					}
				echo '			
				</div><div style="clear:both;"></div>
			</div></li>';
	}	
	echo '</ul></div>';
}

?>