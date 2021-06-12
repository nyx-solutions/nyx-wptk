<?php

    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page([
            'page_title'  => __('Theme'),
            'menu_title'  => __('Theme'),
            'menu_slug'   => 'theme-general-settings',
            'parent_slug' => 'options-general.php',
            'capability'  => 'edit_posts',
        ]);

        unset($pageTitle);
    }
