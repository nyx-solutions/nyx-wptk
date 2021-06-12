<?php

    /**
     * @todo tornar o avatar padrão dinâmico
     */

    add_action(
        'login_head',
        static function () {
            $logoUrl = get_images_url('admin-logo-v1.png');

            echo <<<TEXT
<style>
h1 a { background-image:url('{$logoUrl}') !important;height:170px !important;background-size: auto auto !important; width: auto !important;}
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