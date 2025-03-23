<?php

namespace TemplateCustomPost\lib;

defined('ABSPATH') || exit;

/**
 * Utilities for the plugin
 *
 * @since 0.0.1
 */
class Utils {
    /**
     * Debug utility
     *
     * Logs to wordpress debug.log file
     *
     * @param mixed ...$items The items to log
     * @return void
     *
     * @since 0.0.1
     */
    public static function debug(mixed ...$items) {
        $backtrace = debug_backtrace();
        $caller = array_shift($backtrace);
        if (true === \WP_DEBUG) {
            $line = '--- START DEBUG --- in file: ' . $caller['file'] . ' On line: ' . strval($caller['line']);
            error_log($line);
            foreach ($items as $item) {
                if (is_array($item) || is_object($item)) {
                    error_log(print_r($item, true));
                } else {
                    error_log($item ?? '');
                }
            }
            error_log('--- END DEBUG ---');
        }
    }
}
