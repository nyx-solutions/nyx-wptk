<?php

    #region SEO & Content

    if (nyx_wptk_is_function_enabled('get_as_content')) {
        /**
         * @param        $content
         * @param string $p_class
         *
         * @return mixed
         */
        function get_as_content($content, $p_class = '')
        {
            $content = preg_replace('/<ul([^>]+)>/i', '<ul>', $content);
            $content = preg_replace('/<ol([^>]+)>/i', '<ol>', $content);
            $content = preg_replace('/<h1/i', '<h4', $content);
            $content = preg_replace('/h1>/i', 'h4>', $content);
            $content = preg_replace('/<h2/i', '<h4', $content);
            $content = preg_replace('/h2>/i', 'h4>', $content);
            $content = preg_replace('/<h3/i', '<h4', $content);
            $content = preg_replace('/h3>/i', 'h4>', $content);
            $content = preg_replace('/<div/i', '<p', $content);
            $content = preg_replace('/div>/i', 'p>', $content);
            $content = apply_filters('the_content', $content);

            /** @noinspection RequiredAttributes */
            $content = strip_tags($content, '<strong><b><em><i><ul><ol><li><a><h4><h5><h6><p><img><blockquote><br><br/><br />');
            $content = preg_replace('/<(p|h4|h5|h6) ?([^>]+)?>/', '<$1>', $content);
            $content = preg_replace('/<p><\/p>/', '', $content);
            $content = preg_replace('/<p>&nbsp;<\/p>/', '', $content);
            $content = preg_replace('/<p>(.*)<\/p>/', '<p class="'.$p_class.'">$1</p>', $content);
            $content = preg_replace('/\[fl](.*)\[\/fl]/', '<span class="first-letter">$1</span>', $content);

            return $content;
        }
    }

    if (nyx_wptk_is_function_enabled('get_as_description')) {
        /**
         * @param string $content
         *
         * @return mixed|string
         */
        function get_as_description(string $content): string
        {
            $content = strip_tags($content);
            $content = preg_replace('/(\n|\r\n|\n\r)/', '', $content);

            return (string)$content;
        }
    }

    if (nyx_wptk_is_function_enabled('get_parsed_keywords')) {
        /**
         * @param $keywords
         *
         * @return array|string
         */
        function get_parsed_keywords($keywords)
        {
            $tmpKeywords = [];

            if (is_array($keywords) && !empty($keywords)) {
                foreach ($keywords as $item) {
                    if (!empty($item['word'])) {
                        $tmpKeywords[] = esc_attr($item['word']);
                    }
                }

                if (count($tmpKeywords) > 0) {
                    return $tmpKeywords;
                }
            }

            return '';
        }
    }

    #region Excerpts

    if (nyx_wptk_is_function_enabled('get_page_excerpt')) {
        /**
         * @param string $content
         *
         * @return mixed|string
         */
        function get_page_excerpt($content = '')
        {
            if (empty($content)) {
                return $content;
            }

            $result  = '';
            $matches = [];

            preg_match_all('#<\s*p[^>]*>(.*?)<\s*/\s*p>#ui', $content, $matches);

            if (!empty($matches)) {
                $result = $matches[0][0];

                if (isset($matches[0][1])) {
                    $result .= $matches[0][1];
                }

                add_filter('excerpt_length', 'get_page_excerpt_length');

                $result = get_page_trim_excerpt($result);
            }

            return $result;
        }
    }

    if (nyx_wptk_is_function_enabled('get_page_excerpt_length')) {
        /**
         * @return int
         */
        function get_page_excerpt_length()
        {
            return 295;
        }
    }

    if (nyx_wptk_is_function_enabled('get_page_trim_excerpt')) {
        /**
         * @param string $text
         *
         * @return mixed|string
         */
        function get_page_trim_excerpt($text = '')
        {
            $text = strip_shortcodes($text);

            $text           = apply_filters('the_content', $text);
            $text           = str_replace(']]>', ']]&gt;', $text);
            $excerpt_length = apply_filters('excerpt_length', 55);
            $excerpt_more   = apply_filters('excerpt_more', ' '.'[...]');
            $text           = wp_trim_words($text, $excerpt_length, $excerpt_more);

            return $text;
        }
    }

    if (nyx_wptk_is_function_enabled('add_ellipsis')) {
        /**
         * @param string $str
         * @param int    $max
         * @param string $ellipsis
         *
         * @return string
         */
        function add_ellipsis(string $str, int $max, $ellipsis = '...')
        {
            $new = '';

            if (strlen($str) > $max) {
                foreach (explode(' ', $str) as $item) {
                    $aux_new_str = $new.' '.$item;

                    if (strlen($aux_new_str) <= $max) {
                        $new = $aux_new_str;
                    } else {
                        break;
                    }
                }

                $new = trim($new).$ellipsis;
            } else {
                $new = $str;
            }

            return $new;
        }
    }

    #endregion
    #endregion