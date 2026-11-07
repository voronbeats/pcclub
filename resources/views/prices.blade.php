@extends('layouts.app')

@section('title', 'Цены')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// тарифы</p>
        <h1>Цены и тарифы</h1>
        <p>Прозрачные цены без скрытых платежей. Выберите зону и время — платите только за игру.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        @include('partials.tariffs')
        <p class="muted fine">Копите баллы в личном кабинете: 1 балл = 1 рубль, ими можно оплатить до 30% сеанса. <a href="{{ route('login') }}">Войти или зарегистрироваться</a></p>
    </div>
</section>
@endsection
