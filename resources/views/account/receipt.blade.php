@extends('layouts.app')

@section('title', 'Чек')

@section('content')
<section class="block receipt-wrap">
    <div class="wrap">
        <a class="back no-print" href="{{ route('account') }}">← Личный кабинет</a>
        <div class="receipt">
            <h2>{{ config('club.name') }}</h2>
            <p class="receipt__c">Кассовый чек</p>
            <div class="receipt__row"><span>Чек</span><span>{{ $receipt_no }}</span></div>
            <div class="receipt__row"><span>Дата</span><span>{{ $date }}</span></div>
            <div class="receipt__row"><span>Клуб</span><span>{{ $branch }}</span></div>
            <hr>
            @if ($has_items)
                @foreach ($items as $i)
                    <div class="receipt__item">
                        <div>{{ $i['name'] }}</div>
                        <div class="receipt__row"><span>{{ $i['qty'] }} × {{ $i['price'] }}</span><span>{{ $i['sum'] }} ₽</span></div>
                    </div>
                @endforeach
            @else
                <p class="receipt__c">Состав оплаты не указан</p>
            @endif
            <hr>
            <div class="receipt__row receipt__total"><span>Итого</span><span>{{ $total }} ₽</span></div>
            <div class="receipt__row"><span>Списано баллов</span><span>−{{ $spent }}</span></div>
            <div class="receipt__row"><span>Оплачено деньгами</span><span>{{ $paid }} ₽</span></div>
            <div class="receipt__row"><span>Начислено баллов</span><span>+{{ $earned }}</span></div>
            <hr>
            <p class="receipt__c">Спасибо, что играете с нами!</p>
        </div>
        <p class="no-print receipt__print"><button class="btn btn--sm btn--ghost" type="button" onclick="window.print()">Распечатать</button></p>
    </div>
</section>
@endsection
