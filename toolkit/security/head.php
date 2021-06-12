<?php

    add_action(
        'init',
        static function ()
        {
            remove_action('wp_head', 'feed_links', 2);
            remove_action('wp_head', 'feed_links_extra', 3);
            remove_action('wp_head', 'feed_links_extra', 3);
            remove_action('wp_head', 'feed_links', 2);
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'index_rel_link');
            remove_action('wp_head', 'parent_post_rel_link', 10);
            remove_action('wp_head', 'start_post_rel_link', 10);
            remove_action('wp_head', 'adjacent_posts_rel_link', 10);
            remove_action('wp_head', 'wp_generator');
            remove_action('wp_head', 'rel_canonical');
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
            remove_action('wp_head', 'wp_shortlink_wp_head', 10);
        }
    );

    foreach (['feed_link', 'author_feed_link', 'category_feed_link', 'post_comments_feed_link'] as $filter) {
        add_filter(
            $filter,
            static function () {}
        );
    }

    foreach (['do_feed', 'do_feed_rdf', 'do_feed_rss', 'do_feed_rss2', 'do_feed_atom'] as $filter) {
        add_filter(
            $filter,
            static function () {
                /**
                 * @noinspection ForgottenDebugOutputInspection
                 * @noinspection HtmlUnknownTarget
                 */
                wp_die(sprintf('Nenhum RSS feed disponível, por favor, visite nossa <a href="%s" title="Página Inicial">página inicial</a> para outras informações.', site_url('/')));
            },
            1
        );
    }
