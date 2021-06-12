<?php

    #region Videos

    if (nyx_wptk_is_function_enabled('get_vimeo_or_youtube_id_from_url')) {
        /**
         * @param string $url
         * @param bool   $checkOnly
         * @param string $type
         *
         * @return bool|string
         */
        function get_vimeo_or_youtube_id_from_url(string $url, bool $checkOnly = false, string $type = 'youtube')
        {
            if (validate_url($url)) {
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches)) {
                    return (($checkOnly) ? ($type === 'youtube') : $matches[1]);
                }

                if (preg_match('/^(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([\d]{6,11})[?]?(.*)?$/', $url, $matches)) {
                    return (($checkOnly) ? ($type === 'vimeo') : $matches[5]);
                }
            }

            return false;
        }
    }

    #endregion