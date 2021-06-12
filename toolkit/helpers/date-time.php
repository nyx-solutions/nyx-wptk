<?php

    #region Date/Time

    if (nyx_wptk_is_function_enabled('time_elapsed_string')) {
        /**
         * @param string $datetime
         * @param bool   $full
         *
         * @return string
         * @throws Exception
         */
        function time_elapsed_string(string $datetime, bool $full = false): string
        {
            $now  = new DateTime();
            $ago  = new DateTime($datetime);
            $diff = $now->diff($ago);

            /** @noinspection PhpUndefinedFieldInspection */
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = [
                'y' => 'ano',
                'm' => 'mês',
                'w' => 'semana',
                'd' => 'dia',
                'h' => 'hora',
                'i' => 'minuto',
                's' => 'segundo',
            ];

            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k.' '.$v.($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            unset($v);

            if (!$full) {
                $string = array_slice($string, 0, 1);
            }

            return $string ? implode(', ', $string).' atrás' : 'agora';
        }
    }

    #endregion