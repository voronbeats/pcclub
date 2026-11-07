@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// личный кабинет</p>
        <h1>Привет, {{ $name }}</h1>
        <p>{{ $phone }}</p>
        <form class="logout" method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn--sm btn--ghost" type="submit">Выйти</button>
        </form>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <h2 class="h2">Бонусные баллы</h2>
        <div class="bonus">
            <div class="bonus__card">
                <div class="bonus__num">{{ $balance_fmt }}<small>баллов</small></div>
                <p class="bonus__rule">1 балл = 1 рубль. Баллами можно оплатить не более {{ $percent }}% стоимости сеанса. Баллы привязаны к номеру телефона — назовите его администратору.</p>
                <p class="bonus__rule">Всего начислено: {{ $earned_total }} · списано: {{ $spent_total }}</p>
            </div>
            <div class="calc" id="calc" data-balance="{{ $balance }}" data-percent="{{ $percent }}">
                <h3>Сколько можно списать</h3>
                <label class="field">
                    <span>Сумма сеанса, ₽</span>
                    <input type="number" inputmode="numeric" min="0" step="1" placeholder="например, 480">
                </label>
                <p class="calc__out" data-out>Введите сумму сеанса</p>
            </div>
        </div>
    </div>
</section>

<section class="block block--alt">
    <div class="wrap">
        <h2 class="h2">Мои оплаты</h2>
        @if ($has_purchases)
            <div class="plist">
                @foreach ($purchases as $p)
                    <div class="pur">
                        <div class="pur__date">{{ $p['date'] }}</div>
                        <div class="pur__branch">{{ $p['branch'] }}<small>Чек {{ $p['receipt_no'] }}</small></div>
                        <div class="pur__sum">{{ $p['total'] }} ₽</div>
                        <div class="pur__bonus">−{{ $p['spent'] }} / +{{ $p['earned'] }} баллов</div>
                        <a class="btn btn--sm btn--ghost" href="{{ $p['url'] }}">Чек</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="muted">Оплат пока нет. Назовите номер телефона администратору — сеансы, чеки и баллы появятся здесь.</p>
        @endif
    </div>
</section>
@endsection
