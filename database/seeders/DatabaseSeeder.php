<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Демо-данные только для локальной разработки. */
    public function run(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        User::create(['name' => 'Анна', 'phone' => '+79990000000', 'password' => 'demo12345']);

        $rows = [
            [20, 330, 0, 16, [['Standard — 3 часа', 330, 1]]],
            [9, 760, 16, 37, [['VIP — 5 часов', 760, 1]]],
            [2, 1090, 37, 52, [['VIP — 8 часов', 1090, 1]]],
        ];

        foreach ($rows as $i => [$daysAgo, $total, $spent, $earned, $items]) {
            $purchase = Purchase::create([
                'phone' => '+79990000000',
                'receipt_no' => 'CL-DEMO-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'branch' => config('club.locations.main.name'),
                'total' => $total,
                'bonus_spent' => $spent,
                'bonus_earned' => $earned,
                'purchased_at' => now()->subDays($daysAgo),
            ]);

            foreach ($items as [$name, $price, $qty]) {
                $purchase->items()->create(['name' => $name, 'price' => $price, 'qty' => $qty]);
            }
        }
    }
}
