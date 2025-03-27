<?php

namespace TemplateCustomPost\lib;

use const TemplateCustomPost\PLUGIN_ROOT_FILE;

defined('ABSPATH') || exit;

/**
 * Plugin class
 *
 * This class handles plugin functions like activation and deactivation
 *
 * @since 0.1.0
 */
class Plugin {
    /**
     * Initialize any hooks 
     *
     * @return void
     *
     * @since 0.1.0
     */
    public static function init() {
        register_activation_hook(PLUGIN_ROOT_FILE, [self::class, 'activate']);
        register_deactivation_hook(PLUGIN_ROOT_FILE, [self::class, 'deactivate']);
    }

    /**
     * Activate the plugin
     *
     * Flush the rewrite rules on activation.
     *
     * @return void;
     *
     * @since 0.1.0
     */
    public static function activate() {
        flush_rewrite_rules(); // Use when creating custom post types
    }

    /**
     * Dectivate the plugin
     *
     * Flush the rewrite rules on deactivation.
     *
     * @return void;
     *
     * @since 0.1.0
     */
    public static function deactivate() {
        flush_rewrite_rules(); // Use when creating custom post types
    }
}
