<?php

/**
* Function for redirect if user ip is 77.29.
* Task No 3
 */

function redirect_user() {
    $userIp = $_SERVER[ 'REMOTE_ADDR' ];
    if ( strpos( $userIp, '77.29.' ) === 0 ):
        wp_redirect( 'data:text/html' );
	endif;
}
add_action( 'template_redirect', 'redirect_user' );

/**
 * Register a custom post type Project.
 * Task No 4
 */

function rigster_project_posttype() {
	$labels = array(
		'name'                  => _x( 'Projects', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Project', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Projects', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Project', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Project', 'textdomain' ),
		'new_item'              => __( 'New Project', 'textdomain' ),
		'edit_item'             => __( 'Edit Project', 'textdomain' ),
		'view_item'             => __( 'View Project', 'textdomain' ),
		'all_items'             => __( 'All Projects', 'textdomain' ),
		'search_items'          => __( 'Search Projects', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent Projects:', 'textdomain' ),
		'not_found'             => __( 'No Projects found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No Projects found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Project Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'archives'              => _x( 'Project archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
		'insert_into_item'      => _x( 'Insert into Project', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Project', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
		'filter_items_list'     => _x( 'Filter Projects list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
		'items_list_navigation' => _x( 'Projects list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
		'items_list'            => _x( 'Projects list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( 'project', $args );
}

add_action( 'init', 'rigster_project_posttype' );

/**
 * Register Taxonomy for Project Post type 
 * Task No 4
 */

function register_taxonomy_projecttype() {
	$labels = array(
		'name'              => _x( 'Project Typies', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Project Type', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Project Typies', 'textdomain' ),
		'all_items'         => __( 'All Project Typies', 'textdomain' ),
		'parent_item'       => __( 'Parent Project Type', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Project Type:', 'textdomain' ),
		'edit_item'         => __( 'Edit Project Type', 'textdomain' ),
		'update_item'       => __( 'Update Project Type', 'textdomain' ),
		'add_new_item'      => __( 'Add New Project Type', 'textdomain' ),
		'new_item_name'     => __( 'New Project Type Name', 'textdomain' ),
		'menu_name'         => __( 'Project Type', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'project_type' ),
	);

	register_taxonomy( 'project_type', array( 'project' ), $args );
}

add_action( 'init', 'register_taxonomy_projecttype', 0 );

/**
 * Post per page for project
 * Task No 4
 */

function project_archive_query( $query ) {

    if ( $query->is_main_query() && is_post_type_archive( 'project' ) ):
        $query->set( 'posts_per_page', 6 );
	endif;
}

add_action( 'pre_get_posts', 'project_archive_query' );

/**
 * Get project post by ajax
 * Task No 6
 */

function enqueue_ajax_script() {
	wp_enqueue_script( 'ajax-script',get_template_directory_uri() . '/assets/js/ajax.js',['jquery'],null,true );
	wp_localize_script( 'ajax-script', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php'),'nonce'    => wp_create_nonce('ajax_nonce'),] );
}

add_action( 'wp_enqueue_scripts', 'enqueue_ajax_script' );
 

function get_projects_by_type() {
	$args = [
		'post_type'      => 'project',
		'posts_per_page' => 6,
		'order'=>'DESC',
		'orderby'=>'ID',
		'tax_query'      => [
			[
				'taxonomy' => 'project_type',
				'field'    => 'slug',
				'terms'    => 'architecture',
			],
		],
	];

	$query = new WP_Query( $args );
	$results = [];

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$results[] = [
				'id'    => get_the_ID(),
				'title' => get_the_title(),
				'link'  => get_permalink(),
			];
		}
	}
	wp_reset_postdata();
	wp_send_json( ['success' => true, 'data' => $results,] );
}

function get_projects_by_type_non_login() {
	$args = [
		'post_type'      => 'project',
		'posts_per_page' => 3,
		'order'=>'DESC',
		'orderby'=>'ID',
		'tax_query'      => [
			[
			'taxonomy' => 'project_type',
			'field'    => 'slug',
			'terms'    => 'architecture',
			],
		],
	];

	$query = new WP_Query( $args );
	$results = [];

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$results[] = [
				'id'    => get_the_ID(),
				'title' => get_the_title(),
				'link'  => get_permalink(),
			];
		}
	}

	wp_reset_postdata();

	wp_send_json( ['success' => true,'data' => $results,
	] );
}

add_action( 'wp_ajax_get_projects', 'get_projects_by_type' );
add_action( 'wp_ajax_nopriv_get_projects', 'get_projects_by_type_non_login' );
 
/**
 * Function for get random coffe api 
 * Task No 7
 */

function hs_give_me_coffee() {
	
	$apiUrl = 'https://coffee.alexflipnote.dev/random.json';
	$apiResponse = wp_remote_get( $apiUrl );
	if ( is_wp_error( $apiResponse ) ) {
		return 'Error getting coffe';
	}

	$data = json_decode( wp_remote_retrieve_body( $apiResponse ) , true);
	return isset( $data['file'] ) ? esc_url( $data['file'] ) : 'Sorry Not found';
	
}


/**
 * Function to show 5 quote
 * Task No 8
 */

function hs_give_me_quote() {

    $quotes = [];
    $apiUrl = 'https://api.kanye.rest/';
    for ( $i = 0; $i < 5; $i++ ) {
        $apiResponse = wp_remote_get( $apiUrl );
        if ( !is_wp_error( $apiResponse ) ) {
            $data = json_decode(wp_remote_retrieve_body( $apiResponse ), true);
            if ( isset( $data['quote'] ) ) {
                $quotes[] = $data['quote'];
            }
        }
    }

    if ( !empty($quotes) ):
        $output = '<div>';
        foreach ( $quotes as $index => $quote ) {
            $output .= '<p><strong>Quote ' . ( $index + 1 ) . ':</strong> ' . esc_html( $quote ) . '</p>';
        }
        $output .= '</div>';
        return $output;
    endif;

}
