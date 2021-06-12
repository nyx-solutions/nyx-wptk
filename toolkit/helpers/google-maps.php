<?php

    #region Google Maps

    if (nyx_wptk_is_function_enabled('get_gmaps_embed_url')) {
        /**
         * @param string $lat
         * @param string $lng
         * @param string $address
         *
         * @return string
         */
        function get_gmaps_embed_url(string $lat, string $lng, string $address): string
        {
            $params = [
                'hl'     => 'pt-BR',
                'coord'  => "{$lat},{$lng}",
                'q'      => $address,
                'ie'     => 'UTF8',
                't'      => '',
                'z'      => '16',
                'output' => 'embed',
            ];

            /** @noinspection ImplodeMissUseInspection */
            $params = implode(
                '&',
                array_map(
                    static fn($param, $key) => "{$key}=".urlencode($param),
                    $params,
                    array_keys($params)
                )
            );

            return "https://maps.google.com/maps?{$params}";
        }
    }

    #endregion