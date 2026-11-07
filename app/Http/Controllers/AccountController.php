<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Support\Bonus;
use App\Support\Phone;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rows = Purchase::where('phone', $user->phone)->orderByDesc('purchased_at')->get();
        $balance = max(0, (int) $rows->sum('bonus_earned') - (int) $rows->sum('bonus_spent'));

        $purchases = $rows->map(fn ($p) => [
            'date' => $p->purchased_at->format('d.m.Y H:i'),
            'branch' => $p->branch ?: config('club.name'),
            'total' => Bonus::money($p->total),
            'spent' => Bonus::money($p->bonus_spent),
            'earned' => Bonus::money($p->bonus_earned),
            'receipt_no' => $p->receipt_no ?: ('№ ' . $p->id),
            'url' => route('account.receipt', $p),
        ])->all();

        return view('account.index', [
            'name' => $user->name,
            'phone' => Phone::pretty($user->phone),
            'balance' => $balance,
            'balance_fmt' => Bonus::money($balance),
            'percent' => (int) config('bonus.max_spend_percent', 30),
            'earned_total' => Bonus::money($rows->sum('bonus_earned')),
            'spent_total' => Bonus::money($rows->sum('bonus_spent')),
            'purchases' => $purchases,
            'has_purchases' => count($purchases) > 0,
            'count' => count($purchases),
        ]);
    }

    public function receipt(Purchase $purchase)
    {
        // Чужие чеки открывать нельзя
        abort_unless($purchase->phone === Auth::user()->phone, 404);

        $items = $purchase->items->map(fn ($i) => [
            'name' => $i->name,
            'qty' => $i->qty,
            'price' => Bonus::money($i->price),
            'sum' => Bonus::money($i->price * $i->qty),
        ])->all();

        return view('account.receipt', [
            'receipt_no' => $purchase->receipt_no ?: ('№ ' . $purchase->id),
            'date' => $purchase->purchased_at->format('d.m.Y H:i'),
            'branch' => $purchase->branch ?: config('club.name'),
            'items' => $items,
            'has_items' => count($items) > 0,
            'total' => Bonus::money($purchase->total),
            'spent' => Bonus::money($purchase->bonus_spent),
            'paid' => Bonus::money($purchase->total - $purchase->bonus_spent),
            'earned' => Bonus::money($purchase->bonus_earned),
        ]);
    }
}
