<?php

    /**
     * @todo tornar o avatar padrão dinâmico
     */

    add_filter(
        'get_avatar_data',
        static function ($args, $id_or_email) {
            $default = get_images_url('default-avatar.png');

            if (ENV_IS_DEVELOPMENT) {
                $args['url'] = $default;
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
