<?php

    #region Template

    if (nyx_wptk_is_function_enabled('get_current_page_template_slug')) {
        /**
         * @param int $id
         *
         * @return bool|mixed|string
         */
        function get_current_page_template_slug($id = 0)
        {
            $id = (int)$id;

            if ($id === 0) {
                global $post;

                if (isset($post->ID)) {
                    $id = (int)$post->ID;
                } else {
                    $id = 0;
                }

                if (empty($id)) {
                    return '';
                }
            }

            $templateName = get_page_template_slug($id);
            $templateName = preg_replace('/\.php.*?$/', '', $templateName);

            /** @noinspection RegExpSingleCharAlternation */
            $templateName = preg_replace('/(\/|\\\)/', '::', $templateName);

            return $templateName;
        }
    }

    if (nyx_wptk_is_function_enabled('is_on_template')) {
        /**
         * @param string $slug
         * @param int    $id
         *
         * @return bool
         */
        function is_on_template(string $slug, $id = 0)
        {
            $templateName = get_current_page_template_slug($id);

            return $slug === (string)$templateName;
        }
    }

    if (nyx_wptk_is_function_enabled('do_template_partial')) {
        /**
         * @param string $name
         * @param array  $vars
         */
        function do_template_partial(string $name, array $vars = [])
        {
            $defaultVars = do_template_partial_default_vars();

            if (!is_array($defaultVars)) {
                $defaultVars = [];
            }

            extract($defaultVars, EXTR_OVERWRITE);
            extract($vars, EXTR_OVERWRITE);

            $templateDir = get_template_directory();

            $file = "{$templateDir}/components/{$name}.php";

            if (is_file($file)) {
                /** @noinspection PhpIncludeInspection */
                /** @noinspection UntrustedInclusionInspection */
                include($file);
            }
        }

        if (nyx_wptk_is_function_enabled('do_template_partial_default_vars')) {
            /**
             * @return array
             */
            function do_template_partial_default_vars(): array
            {
                return [];
            }
        }
    }

    #endregion