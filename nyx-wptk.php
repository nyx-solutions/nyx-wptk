<?php

    /**
     * Plugin Name: NYX WordPress Tookit
     * Description: Common helpers for themes
     * Plugin URI:  https://github.com/nyx-solutions/nyx-wptk
     * Author:      NYX IT
     * Author URI:  https://github.com/nyx-solutions
     * License:     GNU General Public License v2 or later
     * License URI: http://www.gnu.org/licenses/gpl-2.0.html
     * Version:     1.0.3
     */

    use nyx\NyxWordPressToolkit;

    require_once(__DIR__ . '/toolkit/application/NyxWordPressToolkit.php');

    defined('ENV_IS_DEVELOPMENT') or define('ENV_IS_DEVELOPMENT', false);
    defined('ENV_IS_STAGING')     or define('ENV_IS_STAGING',     false);
    defined('ENV_IS_PRODUCTION')  or define('ENV_IS_PRODUCTION',  (!ENV_IS_DEVELOPMENT && !ENV_IS_STAGING));

    add_action(
        'init',
        static function () {
            NyxWordPressToolkit::init(['basePath' => __DIR__]);
        },
        1
    );