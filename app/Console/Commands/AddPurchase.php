<?php

namespace App\Console\Commands;

use App\Models\Purchase;
use App\Support\Bonus;
use App\Support\Phone;
use Illuminate\Console\Command;

class AddPurchase extends Command
{
    protected $signature = 'smokeline:purchase
        {phone : Номер телефона клиента}
        {total : Сумма покупки, руб.}
        {--branch= : Адрес филиала}
        {--spend=0 : Сколько баллов списать}
        {--item=* : Позиция в формате название:цена:количество}';

    protected $description = 'Записать покупку клиента: чек, списание и начисление баллов';

    public function handle(): int
    {
        $phone = Phone::normalize($this->argument('phone'));
        if (! $phone) {
            $this->error('Неверный номер телефона.');

            return self::FAILURE;
        }

        $total = (int) $this->argument('total');
        if ($total <= 0) {
            $this->error('Сумма покупки должна быть больше нуля.');

            return self::FAILURE;
        }

        $earnedSum = (int) Purchase::where('phone', $phone)->sum('bonus_earned');
        $spentSum = (int) Purchase::where('phone', $phone)->sum('bonus_spent');
        $balance = max(0, $earnedSum - $spentSum);

        $spend = max(0, (int) $this->option('spend'));
        $max = Bonus::maxSpend($total, $balance);
        if ($spend > $max) {
            $this->error("Можно списать не больше {$max} баллов (не более 30% от суммы, баланс клиента: {$balance}).");

            return self::FAILURE;
        }

        $earned = Bonus::earn($total - $spend);

        $purchase = Purchase::create([
            'phone' => $phone,
            'branch' => $this->option('branch') ?: null,
            'total' => $total,
            'bonus_spent' => $spend,
            'bonus_earned' => $earned,
            'purchased_at' => now(),
        ]);
        $purchase->update([
            'receipt_no' => 'SL-' . now()->format('Ymd') . '-' . str_pad((string) $purchase->id, 5, '0', STR_PAD_LEFT),
        ]);

        foreach ((array) $this->option('item') as $raw) {
            [$name, $price, $qty] = array_pad(explode(':', $raw), 3, null);
            if (! $name || ! is_numeric($price)) {
                $this->warn("Позиция пропущена (формат название:цена:количество): {$raw}");
                continue;
            }
            $purchase->items()->create(['name' => $name, 'price' => (int) $price, 'qty' => max(1, (int) ($qty ?: 1))]);
        }

        $this->info("Чек {$purchase->receipt_no}: покупка {$total} ₽, списано {$spend}, начислено {$earned}. Баланс: " . ($balance - $spend + $earned));

        return self::SUCCESS;
    }
}
