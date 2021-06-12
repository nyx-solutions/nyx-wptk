<?php

    #region PHP 8

    if (!function_exists('str_contains')) {
        /**
         * @param string $haystack
         * @param string $needle
         *
         * @return bool
         *
         * @noinspection ComparisonOperandsOrderInspection
         * @noinspection StrContainsCanBeUsedInspection
         */
        function str_contains(string $haystack, string $needle): bool
        {
            return '' === $needle || false !== strpos($haystack, $needle);
        }
    }

    if (!function_exists('str_starts_with')) {
        /**
         * @param string $haystack
         * @param string $needle
         *
         * @return bool
         * @noinspection ComparisonOperandsOrderInspection
         * @noinspection StrStartsWithCanBeUsedInspection
         */
        function str_starts_with(string $haystack, string $needle): bool
        {
            return 0 === strncmp($haystack, $needle, strlen($needle));
        }
    }

    #endregion