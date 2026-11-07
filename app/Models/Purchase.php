<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['phone', 'receipt_no', 'branch', 'total', 'bonus_spent', 'bonus_earned', 'purchased_at'];

    protected $casts = ['purchased_at' => 'datetime'];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
