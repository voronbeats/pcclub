<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Support\Phone;
use Illuminate\Console\Command;

class ListBookings extends Command
{
    protected $signature = 'club:bookings {--limit=20 : Сколько последних заявок показать}';

    protected $description = 'Показать последние заявки на бронирование';

    public function handle(): int
    {
        $rows = Booking::orderByDesc('id')->limit((int) $this->option('limit'))->get()->map(fn ($b) => [
            $b->id,
            $b->created_at->format('d.m H:i'),
            $b->name,
            Phone::pretty($b->phone),
            config('club.booking_zones.' . $b->zone, $b->zone),
            $b->guests,
            substr((string) $b->date, 0, 10) . ' ' . $b->time,
            $b->comment,
        ])->all();

        $this->table(['№', 'Заявка', 'Имя', 'Телефон', 'Зона', 'Гостей', 'Когда', 'Комментарий'], $rows);

        return self::SUCCESS;
    }
}
