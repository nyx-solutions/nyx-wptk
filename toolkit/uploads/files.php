<?php

    add_filter(
        'sanitize_file_name',
        static function ($name)
        {
            $name = (string)$name;
            $ext  = strtolower(preg_replace('/^(.*)\.([A-Za-z0-9]+)$/', '$2', $name));
            $name = preg_replace('/\.([A-Za-z0-9]+)$/', '', $name);

            $sanitizedName = remove_accents($name);

            $sanitizedName = str_replace([' ', '.', '_'], '-', $sanitizedName);

            $sanitizedName = preg_replace('/[^a-zA-Z0-9-]/', '', $sanitizedName);

            return strtolower("{$sanitizedName}.{$ext}");
        },
        10
    );
