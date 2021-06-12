<?php

    if (!function_exists('add_wp_cron_job')) {
        /**
         * @param string   $name
         * @param string   $recurrence
         * @param callable $hook
         */
        function add_wp_cron_job(string $name, string $recurrence, callable $hook): void
        {
            add_action($name, $hook);

            add_action(
                'wp',
                static function () use ($name, $recurrence) {
                    if (!wp_next_scheduled($name)) {
                        wp_schedule_event(current_time('timestamp'), $recurrence, $name);
                    }
                }
            );
        }
    }

    add_filter(
        'cron_schedules',
        static function ($schedules) {
            $schedules['nyx_every_minute']       = ['interval' => 60,       'display' => 'Every Minute'];
            $schedules['nyx_every_five_minutes'] = ['interval' => (60 * 5), 'display' => 'Every Five Minutes'];

            return $schedules;
        }
    );
