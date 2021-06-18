<?php

    #region Login Verifications

    if (!function_exists('is_login')) {
        /**
         * @return bool
         */
        function is_login(): bool
        {
            global $pagenow;

            if (empty($pagenow) || $pagenow === 'index.php') {
                $pagenow = preg_replace('/(.*?\/|\?.*$)/', '', $_SERVER['REQUEST_URI']);
            }

            $loginPages       = ['wp-login.php', 'wp-register.php', 'administration', 'administracao', 'administracao-interna'];
            $customLoginPages = apply_filters('nyx_wptk_valid_login_pages', null);

            if (!is_array($customLoginPages)) {
                $customLoginPages = [];
            }

            return in_array(
                $pagenow,
                array_merge($loginPages, $customLoginPages),
                true
            );
        }
    }

    #endregion
