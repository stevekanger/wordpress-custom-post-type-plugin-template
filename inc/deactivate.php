<?php

namespace TemplateCustomPost\inc;

use const TemplateCustomPost\PLUGINROOT;

function deactivate() {
    flush_rewrite_rules(); // Use when creating custom post types
}
register_activation_hook(PLUGINROOT, __NAMESPACE__ . '\deactivate');
