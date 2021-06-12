<?php

    #region Taxonomies

    if (nyx_wptk_is_function_enabled('find_post_category_name')) {
        /**
         * @param int $postId
         *
         * @return string
         */
        function find_post_category_name(int $postId): string
        {
            $category = wp_get_post_categories($postId);

            if (is_array($category) && !empty($category)) {
                $category = reset($category);

                if ($category instanceof WP_Term) {
                    $category = $category->name;
                } else {
                    $category = get_term($category);

                    if ($category instanceof WP_Term) {
                        $category = $category->name;
                    }
                }
            } else {
                $category = '';
            }

            return (string)$category;
        }
    }

    #endregion