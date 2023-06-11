<?php

    #region URLs

    if (nyx_wptk_is_function_enabled('validate_url')) {
        /**
         * @param string $url
         * @param array  $allowedSchemes
         *
         * @return bool
         */
        function validate_url(string $url, array $allowedSchemes = ['http', 'https']): bool
        {
            /** @noinspection BypassedUrlValidationInspection */
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $parts = parse_url($url);

                $scheme = strtolower(($parts['scheme'] ?? ''));
                $host   = strtolower(($parts['host'] ?? ''));

                return (in_array($scheme, $allowedSchemes, true) && !empty($host));
            }

            return false;
        }
    }

    if (nyx_wptk_is_function_enabled('get_template_url')) {
        /**
         * @param string $path
         * @param string $prefix
         *
         * @return string
         *
         * @throws Exception
         */
        function get_template_url(string $path, string $prefix = ''): string
        {
            $template_url = get_stylesheet_directory_uri();

            if (!empty($prefix) && $prefix[0] !== '/') {
                $prefix = "/{$prefix}";
            }

            if (!empty($path) && $path[0] !== '/') {
                $path = "/{$path}";
            }

            $cache = ((ENV_IS_DEVELOPMENT) ? ((!str_contains($path, '?')) ? '?' : '&').'_cv='.random_int(100000, 999999) : '');

            return "{$template_url}{$prefix}{$path}{$cache}";
        }
    }

    #region Assets

    if (nyx_wptk_is_function_enabled('get_assets_url')) {
        /**
         * @param string $path
         * @param string $prefix
         *
         * @return string
         *
         * @throws Exception
         *
         * @todo Aplicar método mais eficiente para verificar o caminho padrão
         */
        function get_assets_url(string $path, string $prefix = ''): string
        {
            $relativePath = apply_filters('nyx_wptk_assets_relative_path', null);

            if ($relativePath === null || !is_string($relativePath)) {
                $relativePath = '/assets';
            }

            return get_template_url("{$prefix}/{$path}", $relativePath);
        }

        if (nyx_wptk_is_function_enabled('get_images_url')) {
            /**
             * @param string $path
             *
             * @return string
             *
             * @throws Exception
             */
            function get_images_url(string $path): string
            {
                return get_assets_url($path, '/images');
            }
        }

        if (nyx_wptk_is_function_enabled('get_fonts_url')) {
            /**
             * @param string $path
             *
             * @return string
             *
             * @throws Exception
             */
            function get_fonts_url(string $path): string
            {
                return get_assets_url($path, '/fonts');
            }
        }

        if (nyx_wptk_is_function_enabled('get_scripts_url')) {
            /**
             * @param string $path
             *
             * @return string
             *
             * @throws Exception
             */
            function get_scripts_url(string $path): string
            {
                return get_assets_url($path, '/scripts');
            }
        }

        if (nyx_wptk_is_function_enabled('get_styles_url')) {
            /**
             * @param string $path
             *
             * @return string
             *
             * @throws Exception
             */
            function get_styles_url(string $path): string
            {
                return get_assets_url($path, '/styles');
            }
        }

        if (nyx_wptk_is_function_enabled('get_svg_url')) {
            /**
             * @param string $path
             *
             * @return string
             *
             * @throws Exception
             */
            function get_svg_url(string $path): string
            {
                return get_assets_url($path, '/svg');
            }
        }
    }

    #endregion

    #endregion
