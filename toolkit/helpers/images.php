<?php

    #region Images

    if (nyx_wptk_is_function_enabled('get_image_field')) {
        /**
         * @param string   $selector
         * @param bool|int $post_id
         * @param string   $size
         *
         * @return string
         *
         * @noinspection ParameterDefaultValueIsNotNullInspection
         */
        function get_image_field(string $selector, $post_id = false, string $size = 'thumbnail'): string
        {
            if (function_exists('get_field')) {
                $imageId = (int)get_field($selector, $post_id, false);

                if ($imageId > 0) {
                    $image = wp_get_attachment_image_src($imageId, $size);

                    if (is_array($image) && isset($image[0]) && validate_url($image[0])) {
                        return $image[0];
                    }
                }
            }

            return '';
        }
    }

    #endregion