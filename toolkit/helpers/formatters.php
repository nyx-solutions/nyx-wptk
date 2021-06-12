<?php

    #region Formatters

    if (nyx_wptk_is_function_enabled('just_numbers')) {
        /**
         * @param string $string
         *
         * @return string
         */
        function just_numbers(string $string)
        {
            return (string)preg_replace('/([\D]+)/', '', $string);
        }
    }

    if (nyx_wptk_is_function_enabled('html_implode')) {
        /**
         * @param array $pieces
         *
         * @return string
         */
        function html_implode(array $pieces)
        {
            return implode("\n", $pieces);
        }
    }

    if (nyx_wptk_is_function_enabled('html_array_map')) {
        /**
         * @param callable $callback
         * @param array    $pieces
         *
         * @return string
         */
        function html_array_map(callable $callback, array $pieces)
        {
            return html_implode(array_map($callback, $pieces));
        }
    }

    if (nyx_wptk_is_function_enabled('get_formated_date')) {
        /**
         * @param string $date
         * @param string $format
         *
         * @return string
         *
         * @throws Exception
         */
        function get_formated_date(string $date, string $format = 'Y-m-d H:i:s')
        {
            if (preg_match('/^([\d]{4})-([\d]{2})-([\d]{2}) ([\d]{2}):([\d]{2}):([\d]{2})$/', $date)) {
                $formatedDate = new DateTime($date);

                if ($formatedDate) {
                    return $formatedDate->format($format);
                }

                return $date;
            }

            if (preg_match('/^([\d]{4})-([\d]{2})-([\d]{2})$/', $date)) {
                $formatedDate = new DateTime($date.' 00:00:00');

                if ($formatedDate) {
                    return $formatedDate->format($format);
                }

                return $date;
            }

            return $date;
        }
    }

    #region ACF

    if (nyx_wptk_is_function_enabled('get_attr_field')) {
        /**
         * @param bool $selector
         * @param bool $post_id
         * @param bool $format_value
         *
         * @return mixed
         */
        function get_attr_field($selector = false, $post_id = false, $format_value = false)
        {
            if (function_exists('get_field')) {
                return esc_attr(get_field($selector, $post_id, $format_value));
            }

            return '';
        }
    }

    if (nyx_wptk_is_function_enabled('get_url_field')) {
        /**
         * @param string   $selector
         * @param bool|int $postId
         * @param bool     $formatValue
         *
         * @return string
         */
        function get_url_field(string $selector, $postId = false, bool $formatValue = false)
        {
            if (function_exists('get_field')) {
                $url = esc_url(get_field($selector, $postId, $formatValue));

                if (validate_url($url)) {
                    return $url;
                }
            }

            return '';
        }
    }

    if (nyx_wptk_is_function_enabled('get_content_field')) {
        /**
         * @param        $selector
         * @param bool   $post_id
         * @param bool   $format_value
         * @param string $p_class
         *
         * @return mixed
         */
        function get_content_field($selector, $post_id = false, $format_value = false, $p_class = '')
        {
            if (function_exists('get_field')) {
                return get_as_content(get_field($selector, $post_id, $format_value), $p_class);
            }

            return '';
        }
    }
    #endregion

    #region Phones
    if (nyx_wptk_is_function_enabled('get_phone_as_url')) {
        /**
         * @param string $phone
         *
         * @return string
         */
        function get_phone_as_url(string $phone)
        {
            $phone = get_phone_formated($phone);
            $phone = preg_replace('/([\D]+)/', '', $phone);

            return "tel:+55{$phone}";
        }
    }

    if (nyx_wptk_is_function_enabled('get_phone_formated')) {
        /**
         * @param string $phone
         *
         * @return string
         */
        function get_phone_formated(string $phone)
        {
            $phone = str_replace('+55', '', $phone);
            $phone = preg_replace('/([\D]+)/', '', $phone);
            $phone = preg_replace('/^([\d]{2})([\d]{4,5})([\d]{4})$/', '$1 $2.$3', $phone);

            return $phone;
        }
    }

    if (nyx_wptk_is_function_enabled('get_whatsapp_url')) {
        /**
         * @param string $phone
         *
         * @return string
         */
        function get_whatsapp_url(string $phone)
        {
            $phone = get_phone_formated($phone);
            $phone = preg_replace('/([\D]+)/', '', $phone);

            return "https://api.whatsapp.com/send?phone=55{$phone}";
        }
    }

    #endregion
    #endregion