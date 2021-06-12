<?php

    $configurations     = ['enabled' => false, 'token' => null, 'name' => 'NYX - Server Report', 'slug' => 'nyx-server-report'];
    $userConfigurations = apply_filters('nyx_wptk_server_report', null);

    if (is_array($userConfigurations) && isset($userConfigurations['enabled'], $userConfigurations['token'], $userConfigurations['name'], $userConfigurations['slug'])) {
        $userConfigurations['enabled'] = (bool)$userConfigurations['enabled'];

        $configurations = $userConfigurations;
    }

    if ($configurations['enabled']) {
        /**
         * @param array $configurations
         *
         * @return array
         *
         * @throws Exception
         */
        function nyx_sr_generate_report(array $configurations): array
        {
            global $wp_version, $wpdb;

            $snapshotName = $configurations['slug'];

            $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

            $m = $now->format('m');
            $y = $now->format('Y');

            $report  = [];
            $plugins = get_plugins();

            $report[] = ['type' => 'cms', 'name' => 'WordPress', 'version' => $wp_version, 'description' => 'WordPress is open source software you can use to create a beautiful website, blog, or app.'];

            if (is_array($plugins) && !empty($plugins)) {
                foreach ($plugins as $plugin) {
                    if (isset($plugin['Name'], $plugin['Version'], $plugin['Description'], $plugin['PluginURI'])) {
                        $report[] = ['type' => 'plugin', 'uri' => $plugin['PluginURI'], 'name' => $plugin['Name'], 'version' => $plugin['Version'], 'description' => $plugin['Description']];
                    }
                }
            }

            $webServer     = $_SERVER['SERVER_SOFTWARE'];
            $isNginx       = str_contains(strtolower($webServer), 'nginx');
            $webServerName = (($isNginx) ? 'NGINX' : 'Apache HTTPD');

            $report[] = ['type' => 'server', 'name' => 'Linux (Ubuntu)', 'version' => php_uname(), 'description' => ''];
            $report[] = ['type' => 'web-server', 'name' => "Web Server ({$webServerName})", 'version' => $webServer, 'description' => ''];
            $report[] = ['type' => 'php', 'name' => 'PHP', 'version' => PHP_VERSION, 'description' => ''];

            $dbVersion = $wpdb->get_results("SHOW VARIABLES LIKE 'version'");

            if (is_array($dbVersion) && isset($dbVersion[0]->Value)) {
                $dbVersion = $dbVersion[0]->Value;
            } else {
                $dbVersion = '';
            }

            $isMariaDb = str_contains(strtolower($dbVersion), 'mariadb');
            $dbName    = (($isMariaDb) ? 'MariaDB' : 'MySQL');

            $report[] = ['type' => 'db', 'name' => $dbName, 'version' => $dbVersion, 'description' => ''];
            $report[] = ['type' => 'snapshot', 'name' => 'Snapshot', 'version' => "{$snapshotName}-{$m}-{$y}", 'description' => ''];

            return [
                'name'     => $configurations['name'],
                'siteName' => get_bloginfo('name'),
                'url'      => site_url('/'),
                'date'     => date('d/m/Y H:i'),
                'entries'  => $report,
            ];
        }

        add_action(
            'rest_api_init',
            static function () use ($configurations) {
                register_rest_route(
                    'nyx/v1',
                    '/server-report',
                    [
                        'methods' => 'POST',
                        'callback' => static function (WP_REST_Request $request) use ($configurations) {
                            $token       = $configurations['token'];
                            $sendedToken = (string)$request->get_param('nyx-sr-token');

                            if (!empty($token) && $token === $sendedToken) {
                                return new WP_REST_Response(
                                    nyx_sr_generate_report($configurations),
                                    200
                                );
                            }

                            return new WP_REST_Response([], 401);
                        }
                    ]
                );
            }
        );
    }

    unset($configurations, $userConfigurations);