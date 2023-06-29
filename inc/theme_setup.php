<?php

namespace TemplateCustomPost\inc;

function theme_setup() {
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', __NAMESPACE__ . '\theme_setup');
