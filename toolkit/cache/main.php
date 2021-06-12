<?php

    if (!function_exists('clear_site_cache')) {
        /**
         * @return void
         */
        function clear_site_cache(): void
        {
            if (function_exists('rocket_clean_domain')) {
                rocket_clean_domain();
            }

            if (function_exists('run_rocket_sitemap_preload')) {
                run_rocket_sitemap_preload();
            }
        }
    }
