<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $zones = array_keys(config('club.booking_zones'));
        $zone = $request->query('zone');

        return view('book', ['zone' => in_array($zone, $zones, true) ? $zone : 'standard']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'phone' => ['required', function ($attribute, $value, $fail) {
                if (! Phone::normalize($value)) {
                    $fail('Введите номер телефона полностью, например +7 (900) 000-00-00.');
                }
            }],
            'club' => ['required', Rule::in(array_keys(config('club.locations')))],
            'zone' => ['required', Rule::in(array_keys(config('club.booking_zones')))],
            'guests' => 'required|integer|min:1|max:30',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'comment' => 'nullable|string|max:500',
            'consent' => 'accepted',
        ], [
            'name.required' => 'Укажите имя.',
            'phone.required' => 'Укажите номер телефона.',
            'club.required' => 'Выберите клуб.',
            'club.in' => 'Выберите клуб из списка.',
            'zone.required' => 'Выберите, что бронируем.',
            'zone.in' => 'Выберите зону из списка.',
            'guests.required' => 'Укажите, сколько вас будет.',
            'guests.min' => 'Минимум 1 гость.',
            'guests.max' => 'Для больших компаний позвоните нам.',
            'date.required' => 'Выберите дату.',
            'date.after_or_equal' => 'Дата не может быть в прошлом.',
            'time.required' => 'Выберите время.',
            'time.date_format' => 'Укажите время в формате 18:30.',
            'consent.accepted' => 'Нужно согласие на обработку персональных данных.',
        ]);

        $booking = Booking::create([
            'name' => $data['name'],
            'phone' => Phone::normalize($data['phone']),
            'club' => $data['club'],
            'zone' => $data['zone'],
            'guests' => $data['guests'],
            'date' => $data['date'],
            'time' => $data['time'],
            'comment' => $data['comment'] ?? null,
        ]);

        return redirect()->route('book')->with('booked', [
            'id' => $booking->id,
            'date' => date('d.m.Y', strtotime((string) $data['date'])),
            'time' => $data['time'],
            'zone' => config('club.booking_zones.' . $data['zone']),
        ]);
    }
}
