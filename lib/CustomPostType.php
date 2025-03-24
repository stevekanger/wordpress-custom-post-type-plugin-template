<?php

namespace TemplateCustomPost\lib;

defined('ABSPATH') || exit;

/**
 * A custom class to register a custom post type
 *
 * @since 0.0.1
 */
final class CustomPostType {
    private string $slug;
    private string $singular_name;
    private string $plural_name;
    private array $taxonomies;
    private ?\WP_Post_Type $wp_post_type;

    /**
     * Custom post type constructor.
     *
     * @param string $slug The slug used for the custom post.
     * @param string $singular_name The capitalized name used when there is only one of the post.
     * @param string $plural_name The capitalized name used when there is multiple of the post.
     * @return void
     *
     * @since 0.0.1
     */
    public function __construct(string $slug, string $singular_name, string $plural_name, array $taxonomies = []) {
        $this->slug = $slug;
        $this->singular_name = $singular_name;
        $this->plural_name = $plural_name;
        $this->taxonomies = $taxonomies;

        add_action('init', [$this, 'register_custom_post_type']);
        add_action('after_setup_theme', [$this, 'theme_setup']);
    }

    /**
     * Get the wordpress post type
     *
     * @return ?WP_Post_Type
     *
     * @since 0.0.1
     */
    public function get_wp_post_type(): ?\WP_Post_Type {
        return $this->wp_post_type;
    }

    /**
     * Registers the theme support for the custom post type
     *
     * @return void.
     *
     * @since 0.0.1
     */
    public function theme_setup(): void {
        add_theme_support('post-thumbnails');
    }

    /**
     * Registers the custom post type
     *
     * @return void.
     *
     * @since 0.0.1
     */
    public function register_custom_post_type(): void {
        $supports = [
            'title', // post title
            'editor', // post content
            'author', // post author
            'thumbnail', // featured images
            'excerpt', // post excerpt
            'custom-fields', // custom fields
            'comments', // post comments
            'revisions', // post revisions
            'post-formats', // post formats
        ];

        $labels = [
            'name'                  => sprintf(_x('%s', 'Post type general name', 'template-custom-post'), $this->singular_name),
            'singular_name'         => sprintf(_x('%s', 'Post type singular name', 'template-custom-post'), $this->singular_name),
            'menu_name'             => sprintf(_x('%s', 'Admin Menu text', 'template-custom-post'), $this->plural_name),
            'name_admin_bar'        => sprintf(_x('%s', 'Add New on Toolbar', 'template-custom-post'), $this->singular_name),
            'add_new'               => __('Add New', 'template-custom-post'),
            'add_new_item'          => sprintf(__('Add New %s', 'template-custom-post'), $this->singular_name),
            'new_item'              => sprintf(__('New %s', 'template-custom-post'), $this->singular_name),
            'edit_item'             => sprintf(__('Edit %s', 'template-custom-post'), $this->singular_name),
            'view_item'             => sprintf(__('View %s', 'template-custom-post'), $this->singular_name),
            'all_items'             => sprintf(__('All %s', 'template-custom-post'),  $this->plural_name),
            'search_items'          => sprintf(__('Search %s', 'template-custom-post'), $this->plural_name),
            'parent_item_colon'     => sprintf(__('Parent %s:', 'template-custom-post'), $this->singular_name),
            'not_found'             => sprintf(__('No %s found.', 'template-custom-post'), strtolower($this->singular_name)),
            'not_found_in_trash'    => sprintf(__('No %s found in Trash.', 'template-custom-post'), strtolower($this->singular_name)),
            'featured_image'        => sprintf(_x('%s featured image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'template-custom-post'), $this->plural_name),
            'set_featured_image'    => _x('Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'template-custom-post'),
            'remove_featured_image' => _x('Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'template-custom-post'),
            'use_featured_image'    => _x('Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'template-custom-post'),
            'archives'              => sprintf(_x('%s archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'template-custom-post'), $this->singular_name),
            'insert_into_item'      => sprintf(_x('Insert into %s', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'template-custom-post'), strtolower($this->singular_name)),
            'uploaded_to_this_item' => sprintf(_x('Uploaded to this %s', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'template-custom-post'), strtolower($this->singular_name)),
            'filter_items_list'     => sprintf(_x('Filter %s list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'template-custom-post'), strtolower($this->singular_name)),
            'items_list_navigation' => sprintf(_x('%s list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'template-custom-post'), $this->singular_name),
            'items_list'            => sprintf(_x('%s list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'template-custom-post'), $this->singular_name),
        ];

        $args = [
            'supports' => $supports,
            'labels' => $labels,
            'public' => true,
            'query_var' => true,
            'rewrite' => ['slug' => $this->slug],
            'has_archive' => true,
            'hierarchical' => false,
            'show_in_rest' => true,
            'rest_base' => $this->slug,
            'taxonomies' => $this->taxonomies,
        ];

        $this->wp_post_type = register_post_type($this->slug, $args);
        $this->after_post_type_registered();
    }

    /**
     * Do some stuff after the post type is registered
     *
     * Add post type to archives
     *
     * @return void
     *
     * @since 0.0.1
     */
    public function after_post_type_registered(): void {
        add_action('pre_get_posts', function ($query) {
            // add to categories archive
            if ($query->is_category() && $query->is_main_query()) {
                $query->set('post_type', ['post', $this->slug]);
            }

            // Add to author archive
            if ($query->is_author() && $query->is_main_query()) {
                $query->set('post_type', ['post', $this->slug]);
            }
        });
    }

    /**
     * Sets a default for the categories taxonomy if none selected when first saved
     *
     * @param string $defalut_value The default value
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function with_category_default(string $default_value = "Uncategorized"): CustomPostType {
        if (in_array('category', $this->taxonomies)) {
            add_action('save_post', function (int $post_id, \WP_POST $post, bool $update) use ($default_value) {
                if ($this->slug != $post->post_type) {
                    return;
                }

                if (!has_term('', 'category', $post_id)) {
                    $default_category_id = get_cat_ID($default_value);
                    if ($default_category_id) {
                        wp_set_post_categories($post_id, [$default_category_id]);
                    }
                }
            }, 10, 3);
        }

        return $this;
    }

    /**
     * Register a taxonomy for the custom post type
     *
     * @param string $taxonomy_slug The slug of the taxonomy
     * @param string $label The label to use for the taxonomy
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function register_taxonomy(string $taxonomy_slug, string $label): CustomPostType {
        add_action('init', function () use ($taxonomy_slug, $label) {
            register_taxonomy(
                $taxonomy_slug,
                $this->slug, // Custom post type slug (from the class property)
                array(
                    'label' => sprintf(__('%s', 'template-custom-post'), $label),
                    'hierarchical' => true, // Set to true for category-like behavior
                    'public' => true,
                    'has_archive' => true,
                    'show_ui' => true,
                    'show_admin_column' => true,
                    'show_in_rest' => true,
                    'query_var' => true,
                    'rewrite' => array('slug' => $taxonomy_slug),
                    'default_term' => [
                        'name' => $label . ' Uncategorized',
                        'slug' => $taxonomy_slug . '_uncategorized',
                        'description' => 'Uncategorized posts for ' . $label
                    ]
                )
            );
        });

        return $this;
    }
}
