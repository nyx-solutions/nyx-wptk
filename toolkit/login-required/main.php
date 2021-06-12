<?php

    $configurations     = ['enabled' => false, 'restEnabled' => false, 'useLoginRedirect' => false, 'htmlFilePath' => null];
    $userConfigurations = apply_filters('nyx_wptk_login_required', null);

    if (is_array($userConfigurations) && isset($userConfigurations['enabled'], $userConfigurations['restEnabled'], $userConfigurations['useLoginRedirect'], $userConfigurations['htmlFilePath'])) {
        $userConfigurations['enabled']          = (bool)$userConfigurations['enabled'];
        $userConfigurations['restEnabled']      = (bool)$userConfigurations['restEnabled'];
        $userConfigurations['useLoginRedirect'] = (bool)$userConfigurations['useLoginRedirect'];

        if ($userConfigurations['htmlFilePath'] !== null && !is_file($userConfigurations['htmlFilePath'])) {
            $userConfigurations['htmlFilePath'] = null;
        }

        $configurations = $userConfigurations;
    }

    if ($configurations['enabled']) {
        add_action(
            'template_redirect',
            static function () use ($configurations) {
                if (!is_user_logged_in()) {
                    $canRedirect = $configurations['useLoginRedirect'];

                    if (!$canRedirect) {
                        $htmlFilePath = $configurations['htmlFilePath'];

                        if (is_file($htmlFilePath)) {
                            echo file_get_contents($htmlFilePath);

                            http_response_code(200);

                            exit;
                        }

                        $canRedirect = true;
                    }

                    if ($canRedirect) {
                        auth_redirect();
                    }
                }
            }
        );

        add_action(
            'plugins_loaded',
            static function () {
                /** @noinspection PhpUndefinedCallbackInspection */
                remove_filter('lostpassword_url', 'wc_lostpassword_url');
            }
        );

        if (!$configurations['restEnabled']) {
            add_filter(
                'rest_authentication_errors',
                function ($result) {
                    if (!empty($result)) {
                        return $result;
                    }

                    if (!is_user_logged_in()) {
                        return new WP_Error('rest_not_logged_in', 'API Requests are only supported for authenticated requests.', ['status' => 401]);
                    }

                    return $result;
                }
            );
        }
    }

    unset($configurations, $userConfigurations);