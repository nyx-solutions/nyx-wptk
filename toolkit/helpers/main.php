<?php

    /**
     * @param string $name
     *
     * @return bool
     */
    function nyx_wptk_is_function_enabled(string $name): bool
    {
        static $verified = [];

        if (array_key_exists($name, $verified)) {
            return $verified[$name];
        }

        $functions = nyx_wptk_available_functions();
        $enabled   = apply_filters('nyx_wptk_enabled_functions', $functions, $functions);

        if (!is_array($enabled)) {
            $enabled = [];
        }

        $isFunctionEnabled = (in_array($name, $enabled, true) && !function_exists($name));

        $verified[$name] = $isFunctionEnabled;

        return $isFunctionEnabled;
    }

    /**
     * @return string[]
     */
    function nyx_wptk_available_functions(): array
    {
        return [
            'validate_url',
            'get_template_url',
            'get_assets_url',
            'get_images_url',
            'get_fonts_url',
            'get_scripts_url',
            'get_styles_url',
            'get_svg_url',
            'get_as_content',
            'get_as_description',
            'get_parsed_keywords',
            'get_page_excerpt',
            'get_page_excerpt_length',
            'get_page_trim_excerpt',
            'add_ellipsis',
            'get_current_page_template_slug',
            'is_on_template',
            'do_template_partial',
            'do_template_partial_default_vars',
            'just_numbers',
            'html_implode',
            'html_array_map',
            'get_formated_date',
            'get_attr_field',
            'get_url_field',
            'get_content_field',
            'get_phone_as_url',
            'get_phone_formated',
            'get_whatsapp_url',
            'get_image_field',
            'get_gmaps_embed_url',
            'find_post_category_name',
            'get_vimeo_or_youtube_id_from_url',
            'time_elapsed_string',
        ];
    }
