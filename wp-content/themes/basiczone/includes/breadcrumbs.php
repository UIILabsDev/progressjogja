<?php

function breadcrumbs( $args = '' ) {

	$defaults = array(
		'prefix' => '',
		'suffix' => '',
		'title' => __( ' ', 'basiczone' ),
		'home' => __( 'Home', 'basiczone' ),
		'separator' => '&#187;&#160;',
		'front_page' => false,
		'show_blog' => false,
		'singular_post_taxonomy' => 'category',
		'echo' => true
	);

	$args = apply_filters( 'breadcrumbs_args', $args );

	$args = wp_parse_args( $args, $defaults );

	if ( is_front_page() && !$args['front_page'] )
		return apply_filters( 'breadcrumbs', false );

	$title = ( !empty( $args['title'] ) ? '' . $args['title'] . '': '' );

	$separator = ( !empty( $args['separator'] ) ) ? "{$args['separator']}" : "/";

	$items = breadcrumbs_get_items( $args );

	$breadcrumbs  = $args['prefix'];
	$breadcrumbs .= $title;
	$breadcrumbs .= join( " {$separator} ", $items );
	$breadcrumbs .= $args['suffix'];

	$breadcrumbs = apply_filters( 'breadcrumbs', $breadcrumbs );

	if ( !$args['echo'] )
		return $breadcrumbs;
	else
		echo $breadcrumbs;
}

function breadcrumbs_get_items( $args ) {
	global $wp_query;

	$item = array();

	$show_on_front = get_option( 'show_on_front' );

	if ( is_front_page() ) {
		$item['last'] = $args['home'];
	}

	if ( !is_front_page() )
		$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="'. home_url( '/' ) .'" itemprop="url"><span itemprop="title">' . $args['home'] . '</span></a></div>';

	if ( function_exists( 'is_bbpress' ) && is_bbpress() )
		$item = array_merge( $item, breadcrumbs_get_bbpress_items() );

	elseif ( is_home() ) {
		$home_page = get_page( $wp_query->get_queried_object_id() );
		$item = array_merge( $item, breadcrumbs_get_parents( $home_page->post_parent ) );
		$item['last'] = get_the_title( $home_page->ID );
	}

	elseif ( is_singular() ) {

		$post = $wp_query->get_queried_object();
		$post_id = (int) $wp_query->get_queried_object_id();
		$post_type = $post->post_type;

		$post_type_object = get_post_type_object( $post_type );

		if ( 'post' === $wp_query->post->post_type && $args['show_blog'] ) {
			$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '" itemprop="url"><span itemprop="title">' . get_the_title( get_option( 'page_for_posts' ) ) . '</span></a></div>';
		}

		if ( 'page' !== $wp_query->post->post_type ) {

			if ( function_exists( 'get_post_type_archive_link' ) && !empty( $post_type_object->has_archive ) )
				$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '" itemprop="url"><span itemprop="title">' . $post_type_object->labels->name . '</span></a></div>';

			if ( isset( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) && is_taxonomy_hierarchical( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) ) {
				$terms = wp_get_object_terms( $post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"] );
				$item = array_merge( $item, breadcrumbs_get_term_parents( $terms[0], $args["singular_{$wp_query->post->post_type}_taxonomy"] ) );
			}

			elseif ( isset( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) )
				$item[] = get_the_term_list( $post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"], '', ', ', '' );
		}

		if ( ( is_post_type_hierarchical( $wp_query->post->post_type ) || 'attachment' === $wp_query->post->post_type ) && $parents = breadcrumbs_get_parents( $wp_query->post->post_parent ) ) {
			$item = array_merge( $item, $parents );
		}

		$item['last'] = get_the_title();
	}

	else if ( is_archive() ) {

		if ( is_category() || is_tag() || is_tax() ) {

			$term = $wp_query->get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );

			if ( ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) && $parents = breadcrumbs_get_term_parents( $term->parent, $term->taxonomy ) )
				$item = array_merge( $item, $parents );

			$item['last'] = $term->name;
		}

		else if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {
			$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );
			$item['last'] = $post_type_object->labels->name;
		}

		else if ( is_date() ) {

			if ( is_day() )
				$item['last'] = __( 'Archives for ', 'basiczone' ) . get_the_time( 'F j, Y' );

			elseif ( is_month() )
				$item['last'] = __( 'Archives for ', 'basiczone' ) . single_month_title( ' ', false );

			elseif ( is_year() )
				$item['last'] = __( 'Archives for ', 'basiczone' ) . get_the_time( 'Y' );
		}

		else if ( is_author() )
			$item['last'] = __( 'Archives by: ', 'basiczone' ) . get_the_author_meta( 'display_name', $wp_query->post->post_author );
	}

	else if ( is_search() )
		$item['last'] = __( 'Search results for "', 'basiczone' ) . stripslashes( strip_tags( get_search_query() ) ) . '"';

	else if ( is_404() )
		$item['last'] = __( 'Page Not Found', 'basiczone' );

	return apply_filters( 'breadcrumbs_items', $item );
}

function breadcrumbs_get_bbpress_items( $args = array() ) {

	$item = array();

	$post_type_object = get_post_type_object( bbp_get_forum_post_type() );

	if ( !empty( $post_type_object->has_archive ) && !bbp_is_forum_archive() )
		$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . get_post_type_archive_link( bbp_get_forum_post_type() ) . '" itemprop="url"><span itemprop="title">' . bbp_get_forum_archive_title() . '</span></a></div>';

	if ( bbp_is_forum_archive() )
		$item[] = bbp_get_forum_archive_title();

	elseif ( bbp_is_topic_archive() )
		$item[] = bbp_get_topic_archive_title();

	elseif ( bbp_is_single_view() )
		$item[] = bbp_get_view_title();

	elseif ( bbp_is_single_topic() ) {

		$topic_id = get_queried_object_id();

		$item = array_merge( $item, breadcrumbs_get_parents( bbp_get_topic_forum_id( $topic_id ) ) );

		if ( bbp_is_topic_split() || bbp_is_topic_merge() || bbp_is_topic_edit() )
			$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . bbp_get_topic_permalink( $topic_id ) . '" itemprop="url"><span itemprop="title">' . bbp_get_topic_title( $topic_id ) . '</span></a></div>';
		else
			$item[] = bbp_get_topic_title( $topic_id );

		if ( bbp_is_topic_split() )
			$item[] = __( 'Split', 'basiczone' );

		elseif ( bbp_is_topic_merge() )
			$item[] = __( 'Merge', 'basiczone' );

		elseif ( bbp_is_topic_edit() )
			$item[] = __( 'Edit', 'basiczone' );
	}

	elseif ( bbp_is_single_reply() ) {

		$reply_id = get_queried_object_id();

		$item = array_merge( $item, breadcrumbs_get_parents( bbp_get_reply_topic_id( $reply_id ) ) );

		if ( !bbp_is_reply_edit() ) {
			$item[] = bbp_get_reply_title( $reply_id );

		} else {
			$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . bbp_get_reply_url( $reply_id ) . '" itemprop="url"><span itemprop="title">' . bbp_get_reply_title( $reply_id ) . '</span></a></div>';
			$item[] = __( 'Edit', 'basiczone' );
		}

	}

	elseif ( bbp_is_single_forum() ) {

		$forum_id = get_queried_object_id();
		$forum_parent_id = bbp_get_forum_parent( $forum_id );

		if ( 0 !== $forum_parent_id)
			$item = array_merge( $item, breadcrumbs_get_parents( $forum_parent_id ) );

		$item[] = bbp_get_forum_title( $forum_id );
	}

	elseif ( bbp_is_single_user() || bbp_is_single_user_edit() ) {

		if ( bbp_is_single_user_edit() ) {
			$item[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . bbp_get_user_profile_url() . '" itemprop="url"><span itemprop="title">' . bbp_get_displayed_user_field( 'display_name' ) . '</span></a></div>';
			$item[] = __( 'Edit', 'basiczone' );
		} else {
			$item[] = bbp_get_displayed_user_field( 'display_name' );
		}
	}

	return apply_filters( 'breadcrumbs_get_bbpress_items', $item, $args );
}

function breadcrumbs_get_parents( $post_id = '', $separator = '/' ) {

	$parents = array();

	if ( $post_id == 0 )
		return $parents;

	while ( $post_id ) {
		$page = get_page( $post_id );
		$parents[]  = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '" itemprop="url"><span itemprop="title">' . get_the_title( $post_id ) . '</span></a></div>';
		$post_id = $page->post_parent;
	}

	if ( $parents )
		$parents = array_reverse( $parents );

	return $parents;
}

function breadcrumbs_get_term_parents( $parent_id = '', $taxonomy = '', $separator = '/' ) {

	$html = array();
	$parents = array();

	if ( empty( $parent_id ) || empty( $taxonomy ) )
		return $parents;

	while ( $parent_id ) {
		$parent = get_term( $parent_id, $taxonomy );
		$parents[] = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="basiczone-bread"><a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '" itemprop="url"><span itemprop="title">' . $parent->name . '</span></a></div>';
		$parent_id = $parent->parent;
	}

	if ( $parents )
		$parents = array_reverse( $parents );

	return $parents;
}
