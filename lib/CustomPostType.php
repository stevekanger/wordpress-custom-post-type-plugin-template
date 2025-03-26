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
    private string $single_label;
    private string $plural_label;
    private array $args;
    private ?\WP_Post_Type $wp_post_type = null;

    /**
     * Custom post type constructor.
     *
     * @param string $slug The slug used for the custom post.
     * @param string $label The capitalized name used when there is only one of the post.
     * @param array $args The args for the post type. (see: https://developer.wordpress.org/reference/functions/register_post_type/#parameters)
     * @return void
     *
     * @since 0.0.1
     */
    public function __construct(string $slug, string $single_label, string $plural_label, array $args = []) {
        $this->slug = $slug;
        $this->single_label = $single_label;
        $this->plural_label = $plural_label;
        $this->args = $this->create_args($args);
        $this->register();
    }

    /**
     * Registers the custom post type
     *
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    private function register(): void {
        add_action('init', function () {
            $this->wp_post_type = register_post_type($this->slug, $this->args);
        });
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
     * Create the args array 
     *
     * Merges in the defaults with the specified args
     *
     * @param array $args The specified args from the constructor
     * @return array The merged args
     *
     * @since 0.0.1
     */
    private function create_args(array $args): array {
        return array_merge([
            'supports' => [
                'title',
                'editor',
                'comments',
                'revisions',
                'trackbacks',
                'author',
                'excerpt',
                'page-attributes',
                'thumbnail',
                'custom-fields',
                'post-formats'
            ],
            'labels' => [
                'name'                  => sprintf(_x('%s', 'Post type general name', 'template-custom-post'), $this->plural_label),
                'singular_name'         => sprintf(_x('%s', 'Post type singular name', 'template-custom-post'), $this->single_label),
                'menu_name'             => sprintf(_x('%s', 'Admin Menu text', 'template-custom-post'), $this->plural_label),
                'name_admin_bar'        => sprintf(_x('%s', 'Add New on Toolbar', 'template-custom-post'), $this->plural_label),
                'add_new'               => __('Add New', 'template-custom-post'),
                'add_new_item'          => sprintf(__('Add New %s', 'template-custom-post'), $this->single_label),
                'new_item'              => sprintf(__('New %s', 'template-custom-post'), $this->single_label),
                'edit_item'             => sprintf(__('Edit %s', 'template-custom-post'), $this->single_label),
                'view_item'             => sprintf(__('View %s', 'template-custom-post'), $this->single_label),
                'all_items'             => sprintf(__('All %s', 'template-custom-post'),  $this->plural_label),
                'search_items'          => sprintf(__('Search %s', 'template-custom-post'), $this->plural_label),
                'parent_item_colon'     => sprintf(__('Parent %s:', 'template-custom-post'), $this->single_label),
                'not_found'             => sprintf(__('No %s found.', 'template-custom-post'), strtolower($this->plural_label)),
                'not_found_in_trash'    => sprintf(__('No %s found in Trash.', 'template-custom-post'), strtolower($this->plural_label)),
                'featured_image'        => sprintf(_x('%s featured image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'template-custom-post'), $this->single_label),
                'set_featured_image'    => _x('Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'template-custom-post'),
                'remove_featured_image' => _x('Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'template-custom-post'),
                'use_featured_image'    => _x('Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'template-custom-post'),
                'archives'              => sprintf(_x('%s archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'template-custom-post'), $this->plural_label),
                'insert_into_item'      => sprintf(_x('Insert into %s', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'template-custom-post'), strtolower($this->single_label)),
                'uploaded_to_this_item' => sprintf(_x('Uploaded to this %s', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'template-custom-post'), strtolower($this->single_label)),
                'filter_items_list'     => sprintf(_x('Filter %s list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'template-custom-post'), strtolower($this->plural_label)),
                'items_list_navigation' => sprintf(_x('%s list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'template-custom-post'), $this->single_label),
                'items_list'            => sprintf(_x('%s list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'template-custom-post'), $this->plural_label),
            ],
            'public' => true,
            'query_var' => true,
            'rewrite' => ['slug' => $this->slug],
            'has_archive' => true,
            'hierarchical' => false,
            'show_in_rest' => true,
            'rest_base' => $this->slug,
            'taxonomies' => []
        ], $args);
    }

    /**
     * Change a label from the defaults to something different
     *
     * @param array $labels Key/value array of label to change and value 
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function labels(array $labels): CustomPostType {
        $this->args['labels'] = array_merge($this->args['labels'], $labels);
        return $this;
    }

    /**
     * Registers the theme support for the custom post type
     * eg 'post-thumbnails'
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function theme_support(...$supports): CustomPostType {
        add_action('after_setup_theme', function () use ($supports) {
            add_theme_support(...$supports);
        });

        return $this;
    }


    /**
     * Add the custom post type to an archive
     *
     * @param callable $qualifier_cb The wordpress function that determines whether the query is for an existing archive page. Eg. is_tag, is_author, is_category.
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function archive(callable $qualifier_cb): CustomPostType {
        add_action('pre_get_posts', function ($query) use ($qualifier_cb) {
            if (call_user_func($qualifier_cb) && $query->is_main_query()) {
                $query->set('post_type', ['post', $this->slug]);
            }
        });
        return $this;
    }

    /**
     * Sets a default for the categories taxonomy if none selected when first saved
     *
     * @param string $defalut_value The default value
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function category_default(string $default_value = "Uncategorized"): CustomPostType {
        if (in_array('category', $this->args['taxonomies'])) {
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
     * Register a custom template for the post type
     *
     * This should really not be used and the theme should house the template.
     * Use this only if you must.
     *
     * @param callable $qualifier_cb The wordpress function that determines whether the template is for an existing page. Eg. is_singular, is_post_type_archive.
     * @param string $template_file The template file to display 
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function template(string $qualifier_cb, string $template_file): CustomPostType {
        add_filter('template_include', function ($template) use ($qualifier_cb, $template_file) {
            if (file_exists($template_file) && call_user_func($qualifier_cb, $this->slug)) {
                return $template_file;
            }
            return $template;
        });

        return $this;
    }

    /**
     * Register a taxonomy for the custom post type
     *
     * @param string $taxonomy_slug The slug of the taxonomy
     * @param array $args the args for creating the taxonomy (see https://developer.wordpress.org/reference/functions/register_taxonomy/#parameters)
     * @return CustomPostType
     *
     * @since 0.0.1
     */
    public function register_taxonomy(string $taxonomy_slug, array $args): CustomPostType {
        add_action('init', function () use ($taxonomy_slug, $args) {
            register_taxonomy(
                $taxonomy_slug,
                $this->slug,
                $args
            );
        });

        return $this;
    }
}
