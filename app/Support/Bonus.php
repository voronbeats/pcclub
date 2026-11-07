<?php

namespace App\Support;

class Bonus
{
    /** 1 балл = 1 рубль. Максимум к списанию: не более 30% от покупки и не больше баланса. */
    public static function maxSpend(int $total, int $balance): int
    {
        $limit = intdiv($total * (int) config('bonus.max_spend_percent', 30), 100);

        return max(0, min($balance, $limit));
    }

    /** Баллы за покупку считаются от суммы, оплаченной деньгами. */
    public static function earn(int $paidMoney): int
    {
        return max(0, intdiv($paidMoney * (int) config('bonus.earn_percent', 5), 100));
    }

    public static function money(int|float $value): string
    {
        return number_format((float) $value, 0, ',', "\u{00A0}");
    }
}
