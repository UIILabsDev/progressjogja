<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span itemprop="itemreviewed"><?php the_title(); ?></span></a></h1>
		</header><!-- .entry-header -->
	
		<footer class="entry-meta">
			<div class="content-single">		
				<div class="content-single-l">		
					<table id="tabsingleleft">
						<tr>
							<td class="imgmeta"><a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>','_self')" rel="nofollow"><img itemprop="photo" src="<?php get_custom_field('thumb', TRUE); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" /><span class="overlay"></span></a></td>
						</tr>
						<tr>
							<td class="imgtab"><h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></td>
						</tr>
						<tr>
							<td><?php basiczone_frating(); ?></td>
						</tr>
					</table>
				</div>			
				<div class="content-single-r">
					<table id="tabsingleright">
						<tr class="even">
							<td class="desc"><?php _e( 'Listed on', 'basiczone' ); ?></td>
							<td>:</td>
							<td><?php basiczone_posted_on(); ?></td>
						</tr>
						<tr>
							<td class="vtop"><?php _e( 'Category', 'basiczone' ); ?></td>
							<td class="vtop">:</td>
							<td><?php the_category(', ') ?></td>
						</tr>
						<tr class="even">
							<td><?php _e( 'Product ID', 'basiczone' ); ?></td>
							<td>:</td>
							<td><?php basiczone_asin(); ?></td>
						</tr>
						<tr>
							<td><?php _e( 'List Price', 'basiczone' ); ?></td>
							<td>:</td>
							<td><?php basiczone_listprice(); ?></td>
						</tr>
						<tr class="even">
							<td><?php _e( 'Price', 'basiczone' ); ?></td>
							<td>:</td>
							<td><?php basiczone_price(); ?></td>
						</tr>
						<tr>
							<td><?php _e( 'Viewed', 'basiczone' ); ?></td>
							<td>:</td>
							<td><span itemprop="votes"><?php if(function_exists('the_views')) { the_views(); } ?></span></td>
						</tr>
						<tr class="even">
							<td class="vtop"><?php _e( 'Tags', 'basiczone' ); ?></td>
							<td class="vtop">:</td>
							<td><?php the_tags('', ', ', ''); ?></td>
						</tr>
					</table>
				</div>
				<div style="clear:both;"></div>
			</div>
		</footer><!-- .entry-meta -->

		<?php basiczone_soc_sharing(); ?>	
		<?php basiczone_spoffer(); ?>		
		<?php basiczone_trapmenu(); ?>
				
		<div class="entry-content-single">
			<div class="singleads">
				<?php if ( basiczone_option( 'ads_336' ) ) 
					echo basiczone_option( 'ads_336' );
				?>	
			</div>
			<?php the_content(); ?>
			<div class="compareme">
				<ul class="comparison">
					<li class="reviews"><a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>#customerReviews','_self')" rel="nofollow"><?php _e( 'Customer Reviews', 'basiczone' ); ?></a></li>
	
					<li class="compare"><a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>','_self')" rel="nofollow"><?php _e( 'Compare Price', 'basiczone' ); ?></a></li>
					<li class="addtocart"><a href="javascript:void(0)" onclick="window.open ('<?php get_custom_field('detail', TRUE); ?>','_self')" rel="nofollow"><?php _e( 'Add to Cart', 'basiczone' ); ?></a></li>
				</ul>
			</div>		
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Page:', 'basiczone' ), 'after' => '</div>' ) ); ?>
			<div style="clear:both;"></div>
		</div><!-- .entry-content -->
	</div><!-- .hreview-aggregate -->
</article><!-- #post-<?php the_ID(); ?> -->
