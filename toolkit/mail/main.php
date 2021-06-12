<?php

    add_filter(
        'wp_mail_content_type',
        fn() => 'text/html'
    );
