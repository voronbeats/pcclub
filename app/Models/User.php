<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['name', 'phone', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    /** Покупки привязаны к номеру телефона. */
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'phone', 'phone');
    }

    public function bonusBalance(): int
    {
        $earned = (int) Purchase::where('phone', $this->phone)->sum('bonus_earned');
        $spent = (int) Purchase::where('phone', $this->phone)->sum('bonus_spent');

        return max(0, $earned - $spent);
    }
}
