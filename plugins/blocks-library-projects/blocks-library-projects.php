<?php
/**
 * Plugin Name: Blocks Library — Projects
 * Description: Registers the Project custom post type.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'blp_register_project_post_type' );

function blp_register_project_post_type() {
	register_post_type( 'project', [
		'labels'              => [
			'name'               => 'Projects',
			'singular_name'      => 'Project',
			'add_new_item'       => 'Add New Project',
			'edit_item'          => 'Edit Project',
			'view_item'          => 'View Project',
			'search_items'       => 'Search Projects',
			'not_found'          => 'No projects found',
			'not_found_in_trash' => 'No projects found in trash',
		],
		'public'              => true,
		'has_archive'         => true,
		'rewrite'             => [ 'slug' => 'projects' ],
		'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
		'show_in_rest'        => true,
		'show_in_graphql'     => true,
		'graphql_single_name' => 'project',
		'graphql_plural_name' => 'projects',
	] );
}
