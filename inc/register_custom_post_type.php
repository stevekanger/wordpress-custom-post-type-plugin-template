<?php

namespace TemplateCustomPost\Inc;

function register_custom_post_type() {
    $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
    );

    $labels = array(
        'name'                  => _x('Project', 'Post type general name', 'template-custom-post-0.0.1'),
        'singular_name'         => _x('Project', 'Post type singular name', 'template-custom-post-0.0.1'),
        'menu_name'             => _x('Projects', 'Admin Menu text', 'template-custom-post-0.0.1'),
        'name_admin_bar'        => _x('Projects', 'Add New on Toolbar', 'template-custom-post-0.0.1'),
        'add_new'               => __('Add New', 'template-custom-post-0.0.1'),
        'add_new_item'          => __('Add New project', 'template-custom-post-0.0.1'),
        'new_item'              => __('New project', 'template-custom-post-0.0.1'),
        'edit_item'             => __('Edit project', 'template-custom-post-0.0.1'),
        'view_item'             => __('View project', 'template-custom-post-0.0.1'),
        'all_items'             => __('All projects', 'template-custom-post-0.0.1'),
        'search_items'          => __('Search projects', 'template-custom-post-0.0.1'),
        'parent_item_colon'     => __('Parent project:', 'template-custom-post-0.0.1'),
        'not_found'             => __('No project found.', 'template-custom-post-0.0.1'),
        'not_found_in_trash'    => __('No project found in Trash.', 'template-custom-post-0.0.1'),
        'featured_image'        => _x('Project Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'template-custom-post-0.0.1'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'template-custom-post-0.0.1'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'template-custom-post-0.0.1'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'template-custom-post-0.0.1'),
        'archives'              => _x('Project archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'template-custom-post-0.0.1'),
        'insert_into_item'      => _x('Insert into project', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'template-custom-post-0.0.1'),
        'uploaded_to_this_item' => _x('Uploaded to this project', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'template-custom-post-0.0.1'),
        'filter_items_list'     => _x('Filter project list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'template-custom-post-0.0.1'),
        'items_list_navigation' => _x('Project list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'template-custom-post-0.0.1'),
        'items_list'            => _x('Project list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'template-custom-post-0.0.1'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'projects'),
        'has_archive' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rest_base' => 'projects',
        'taxonomies' => array('post_tag'),
    );

    register_post_type('projects', $args);
}

add_action('init', __NAMESPACE__ . '\register_custom_post_type');
