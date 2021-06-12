<?php

    #region Dashboard Widgets

    add_action(
        'wp_dashboard_setup',
        static function () {
            global $wp_meta_boxes;

            $side   = [];
            $normal = [];

            if (isset($wp_meta_boxes['dashboard']['normal']['core'])) {
                foreach ($wp_meta_boxes['dashboard']['normal']['core'] as $key => $item) {
                    if ($key === 'dashboard_right_now') {
                        continue;
                    }

                    $normal[] = $key;
                }
            }

            if (isset($wp_meta_boxes['dashboard']['side']['core'])) {
                foreach ($wp_meta_boxes['dashboard']['side']['core'] as $key => $item) {
                    $side[] = $key;
                }
            }


            foreach ($normal as $current) {
                unset($wp_meta_boxes['dashboard']['normal']['core'][$current]);
            }

            $current = null;

            foreach ($side as $current) {
                unset($wp_meta_boxes['dashboard']['side']['core'][$current]);
            }
        }
    );

    #endregion

    #region At a Glance

    add_action(
        'dashboard_glance_items',
        static function () {
            $args = [
                'public'   => true,
                '_builtin' => false
            ];

            $output    = 'object';
            $operator  = 'and';
            $postTypes = apply_filters('nyx_wptk_dashboard_post_types', null);

            if (!is_array($postTypes)) {
                $postTypes = [];
            }

            foreach (get_post_types($args, $output, $operator) as $postType) {
                $numPosts = wp_count_posts($postType->name);
                $num      = number_format_i18n($numPosts->publish);
                $text     = _n($postType->labels->singular_name, $postType->labels->name, (int)$numPosts->publish);
                $cptName  = '';

                if (current_user_can('edit_posts')) {
                    $cptName = $postType->name;
                }

                if (str_starts_with($cptName, 'frm_')) {
                    continue;
                }

                $menuIcon = 'f155';
                $noneText = 'Nenhum';

                if (!empty($cptName) && array_key_exists($cptName, $postTypes) && isset($postTypes[$cptName]['icon'], $postTypes[$cptName]['male'])) {
                    $menuIcon = $postTypes[$cptName]['icon'];

                    if (!$postTypes[$cptName]['male']) {
                        $noneText = 'Nenhuma';
                    }
                }

                $cptLabel = (((int)$num === 0) ? "{$noneText} {$postType->labels->singular_name}" : "{$num}&nbsp;{$text}");

                /** @noinspection CssInvalidHtmlTagReference */
                echo <<<HTML
<li class="page-count {$cptName}-count">
    <a href="edit.php?post_type={$cptName}">{$cptLabel}</a>
    <style>.page-count.{$cptName}-count a:before {content:'\\{$menuIcon}' !important;}</style>
</li>
HTML;
            }
        }
    );

    #endregion

    #region Welcome Panel

    add_action(
        'load-index.php',
        static function () {
            remove_action('welcome_panel', 'wp_welcome_panel');

            $user_id = get_current_user_id();

            if (get_user_meta($user_id, 'show_welcome_panel', true) !== 0) {
                update_user_meta($user_id, 'show_welcome_panel', 0);
            }
        }
    );

    #endregion

    #region Disabled Menus

    add_action(
        'admin_menu',
        static function () {
            global $menu;

            $restricted = apply_filters('nyx_wptk_disabled_admin_menus', null);

            if (!is_array($restricted)) {
                $restricted = [];
            }

            if (empty($restricted)) {
                $restricted = ['menu-posts', 'menu-links', 'menu-comments'];
            }

            foreach ($menu as $key => $value) {
                if (isset($value[5]) && in_array((string)$value[5], $restricted, true)) {
                    unset($menu[$key]);
                }
            }
        }
    );

    #endregion
