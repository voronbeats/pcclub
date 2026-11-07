@extends('layouts.app')

@section('title', 'Электронные устройства — smoke Line')

@section('content')
<section class="page-head">
    <div class="wrap">
        <a class="back" href="{{ route('home') }}#catalog">← Каталог</a>
        <h1>Электронные устройства</h1>
        <p>Модели, которые есть в нашем магазине. Информация носит ознакомительный характер — приходите, покажем и подскажем.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <div class="grid grid--3">
            @foreach ($devices as $d)
                <article class="card" style="--accent: {{ $d['accent'] }}">
                    <div class="card__pic"></div>
                    <h3>{{ $d['name'] }}</h3>
                    <p>{{ $d['desc'] }}</p>
                    <div class="card__tag">Приходите в магазин</div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="visit">
    <div class="wrap">
        <h2>Приходите в магазин</h2>
        <p>Все устройства можно посмотреть и подобрать на месте. Возраст подтверждается документом.</p>
        <a class="btn" href="{{ route('contacts') }}">Адреса и телефоны</a>
    </div>
</section>
@endsection
