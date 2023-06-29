<?php

namespace TemplateCustomPost\inc;

use const TemplateCustomPost\PLUGINROOT;

function activate() {
    flush_rewrite_rules(); // Use when creating custom post types
}
register_activation_hook(PLUGINROOT, __NAMESPACE__ . '\activate');
