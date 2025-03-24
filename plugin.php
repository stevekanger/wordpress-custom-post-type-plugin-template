<?php

namespace TemplateCustomPost;

use TemplateCustomPost\lib\Plugin;
use TemplateCustomPost\lib\CustomPostType;

/**
 * Plugin Name: Template Custom Post Type
 * Author: Steve Kanger
 * Author URI: https://stevekanger.com
 * Description: Simple custom post type
 * Version: 0.0.1
 * Requires at least: 6.7
 * Tested up to: 6.7
 * Requires PHP: 7.4
 * Liscense: GNU General Public License v3.0
 * Liscense URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: template-custom-post
 */

// Define plugin constants
const PLUGIN_NAME = 'Template Custom Post';
const PLUGIN_PREFIX = 'template_custom_post';
const PLUGIN_SLUG = 'template-custom-post';
const PLUGIN_API_ROUTE = PLUGIN_SLUG . '/v1';
const PLUGIN_ROOT_FILE = __FILE__;
const PLUGIN_ROOT_DIR = __DIR__;

// Include Files
require_once PLUGIN_ROOT_DIR . '/lib/Plugin.php';
require_once PLUGIN_ROOT_DIR . '/lib/CustomPostType.php';
require_once PLUGIN_ROOT_DIR . '/lib/Utils.php';

// Init Plugin
Plugin::init();

// Create some custom post types
$custom_post_type = new CustomPostType(
    'post-slug',
    'Custom Post',
    'Custom Posts',
    ['post_tag', 'category']
);

$custom_post_type
    ->with_category_default()
    ->with_template('archive', PLUGIN_ROOT_DIR . '/templates/single.html')
    ->register_taxonomy('some-taxonomy', [
        'label' => __('Some Taxonomy', 'template-custom-post'),
        'public' => true,
        'show_in_rest' => true,
        'default_term' => [
            'slug' => 'uncategorized-some-taxonomy',
            'name' => __('Uncategorized Some Taxonomy', 'template-custom-post'),
        ]
    ]);
