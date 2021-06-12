<?php

    /**
     * @todo criar formato mais customizável
     */

    add_action(
        'init',
        static function () {
            global $wp_rewrite;

            $author     = 'autores';
            $search     = 'busca';
            $comments   = 'comentarios';
            $pagination = 'pagina';
            $feed       = 'feed';

            $wp_rewrite->author_base      = $author;
            $wp_rewrite->author_structure = $author.'/%author%';

            $wp_rewrite->search_base      = $search;
            $wp_rewrite->search_structure = $search.'/%search%';

            $wp_rewrite->comments_base   = $comments;
            $wp_rewrite->pagination_base = $pagination;
            $wp_rewrite->feed_base       = $feed;

            $wp_rewrite->flush_rules();
        },
        11
    );
