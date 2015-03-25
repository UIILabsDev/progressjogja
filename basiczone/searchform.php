<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<div class="srcwrap">
		<?php wp_dropdown_categories(__('hierarchical=1&depth=0&exclude=111&orderby=name&hide_empty=1&show_option_all=All Categories', 'basiczone' ) ); ?>
		<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="<?php _e( 'Search', 'basiczone' ); ?>" />
	</div>
</form>