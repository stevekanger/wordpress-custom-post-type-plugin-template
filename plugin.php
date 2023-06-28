<?php

namespace TemplateCustomPost;

/**
 * @package template-custom-post-0.0.1
 * 
 * Plugin Name: Template Custom Post Type
 * Plugin URI: http://stevekanger.com
 * Description: Template for custom post types
 * Version: 0.0.1
 * Author: Steve Kanger
 * Author URI: https://stevekanger.com
 * License: GPLv2 or later
 * Text Domain: template-custom-post-0.0.1
 * 
 * */

const PLUGINROOT = __FILE__;

// Utils
require 'utils/write_log.php';

// Includes
require 'inc/activate.php';
require 'inc/deactivate.php';
require 'inc/theme_setup.php';
require 'inc/register_custom_post_type.php';
