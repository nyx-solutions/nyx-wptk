<?php

    if (!is_admin() && !is_login()) {
        show_admin_bar(false);

        add_filter('show_admin_bar', '__return_false');
    }

    add_action(
        'admin_init',
        static function () {
            $pageEditorEnabled = (bool)apply_filters('nyx_wptk_page_editor_enabled', false);

            if (!$pageEditorEnabled) {
                remove_post_type_support('page', 'editor');
            }
        }
    );

    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('template_redirect', 'rest_output_link_header', 11);

    unset($isAdmin, $isLogin);
