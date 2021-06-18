<?php

    $configurations     = ['enabled' => false, 'image' => null, 'height' => null];
    $userConfigurations = apply_filters('nyx_wptk_login_logo', null);

    if (is_array($userConfigurations) && isset($userConfigurations['enabled'], $userConfigurations['image'], $userConfigurations['height'])) {
        $userConfigurations['enabled'] = (bool)$userConfigurations['enabled'];
        $userConfigurations['image']   = (string)$userConfigurations['image'];
        $userConfigurations['height']  = (string)$userConfigurations['height'];

        $configurations = $userConfigurations;
    }

    if ($userConfigurations['enabled']) {
        add_action(
            'login_head',
            static function () use ($configurations) {
                echo <<<TEXT
<style>
h1 a { background-image:url('{$configurations['image']}') !important;height:{$configurations['height']} !important;background-size: auto auto !important; width: auto !important;}
</style>
TEXT;
            }
        );

        add_action(
            'login_logo_title',
            static function () {
                return get_bloginfo('name');
            }
        );

        add_filter(
            'login_headerurl',
            static function () {
                return site_url('/');
            }
        );
    }

    unset($configurations, $userConfigurations);