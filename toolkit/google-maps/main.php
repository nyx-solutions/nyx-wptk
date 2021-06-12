<?php

    add_action(
        'acf/init',
        static function () {
            if (function_exists('get_field') && function_exists('acf_update_setting')) {
                $gmapsKey = apply_filters('nyx_wptk_google_maps_api_key', null);

                if (is_string($gmapsKey) && !empty($gmapsKey)) {
                    acf_update_setting('google_api_key', $gmapsKey);
                }
            }
        }
    );
