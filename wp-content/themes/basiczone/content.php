<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="item-content">
		<div class="item-price">
			<?php 
				$price = get_post_meta($post->ID, 'price', true);
				if ($price =="") {
					echo '<span class="pricetag"><a href="' . get_permalink() . '">' . __( 'Click Here', 'basiczone') . '</a></span>';
				} else {
					echo '<span class="pricetag"><a href="' . get_permalink() . '">' . $price . '</a></span>';
				}	
			?>
		</div>
		<div class="item-image">
			<a class="info" href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span><img src="<?php get_custom_field('thumb', TRUE); ?>" alt="<?php the_title(); ?>" /></a>
		</div>
		<div class="item-title">
			<?php if(!is_single()) echo('<h2 class="entry-title">'); else echo('<h1 class="entry-title">'); ?><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'basiczone' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a><?php if(!is_single()) echo('</h2>'); else echo('</h1>'); ?>
		</div>
		<div style="display:none;">
			<?php basiczone_posted_on(); ?>
		</div>
	</div><!-- .item-content -->
</article><!-- #post-<?php the_ID(); ?> -->


