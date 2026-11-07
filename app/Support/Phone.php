<?php

namespace App\Support;

class Phone
{
    /** Приводит номер к виду +7XXXXXXXXXX или возвращает null, если номер неполный. */
    public static function normalize(?string $raw): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $raw);

        if (strlen($digits) === 11 && ($digits[0] === '8' || $digits[0] === '7')) {
            $digits = '7' . substr($digits, 1);
        } elseif (strlen($digits) === 10) {
            $digits = '7' . $digits;
        } else {
            return null;
        }

        return '+' . $digits;
    }

    /** +79956818005 → +7 (995) 681-80-05 */
    public static function pretty(string $phone): string
    {
        $d = preg_replace('/\D+/', '', $phone);
        if (strlen($d) !== 11) {
            return $phone;
        }

        return sprintf('+7 (%s) %s-%s-%s', substr($d, 1, 3), substr($d, 4, 3), substr($d, 7, 2), substr($d, 9, 2));
    }
}
