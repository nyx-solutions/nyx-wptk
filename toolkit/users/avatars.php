<?php

    $configurations     = ['enabled' => false, 'image' => null, 'height' => null];
    $userConfigurations = apply_filters('nyx_wptk_login_user_avatars', null);

    if (is_array($userConfigurations) && isset($userConfigurations['enabled'], $userConfigurations['default'], $userConfigurations['devDefault'])) {
        $userConfigurations['enabled'] = (bool)$userConfigurations['enabled'];
        $userConfigurations['default']   = (string)$userConfigurations['default'];
        $userConfigurations['devDefault']  = (string)$userConfigurations['devDefault'];

        $configurations = $userConfigurations;
    }

    if ($userConfigurations['enabled']) {
        add_filter(
            'get_avatar_data',
            static function ($args, $id_or_email) use ($configurations) {
                $default = $configurations['default'];

                if (ENV_IS_DEVELOPMENT) {
                    $args['url'] = $configurations['devDefault'];
                } else {
                    $email = null;

                    if (!is_numeric($id_or_email) && filter_var($id_or_email, FILTER_VALIDATE_EMAIL)) {
                        $email = $id_or_email;
                    } elseif (is_numeric($id_or_email)) {
                        $user = get_user_by('id', (int)$id_or_email);

                        if ($user instanceof WP_User) {
                            $email = $user->user_email;
                        }
                    }

                    if ($email !== null) {
                        $email   = md5(strtolower(trim($email)));
                        $default = urlencode($default);

                        $args['url'] = "https://www.gravatar.com/avatar/{$email}?d={$default}";
                    }
                }

                return $args;
            },
            100,
            2
        );
    }

    unset($configurations, $userConfigurations);