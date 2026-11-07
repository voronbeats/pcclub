@extends('layouts.app')

@section('title', 'Компьютерный клуб')

@section('content')
<section class="hero">
    <div class="wrap hero__in">
        <div class="hero__main">
            <p class="kicker">[ {{ config('club.tagline') }} ]</p>
            <h1 class="hero__title">{{ config('club.name') }}</h1>
            <p class="hero__text">Мощные ПК, VIP-зоны и PlayStation. Бронируйте место онлайн и приходите играть — без очередей и ожидания.</p>
            <div class="hero__btns">
                <a class="btn" href="{{ route('book') }}">Забронировать</a>
                <a class="btn btn--ghost" href="{{ route('prices') }}">Смотреть цены</a>
            </div>
        </div>
        <div class="stats">
            @foreach (config('club.stats') as $s)
                <div class="stat"><b>{{ $s['value'] }}</b><span>{{ $s['label'] }}</span></div>
            @endforeach
        </div>
    </div>
</section>

<section class="block" id="zones">
    <div class="wrap">
        <p class="kicker">// залы</p>
        <h2 class="h2">Выберите свою зону</h2>
        <div class="grid grid--4">
            @foreach (config('club.zones') as $z)
                <a class="zone" href="{{ route('book') }}?zone={{ $z['key'] }}">
                    <span class="zone__tag">{{ $z['tag'] }}</span>
                    <h3>{{ $z['name'] }}</h3>
                    <p>{{ $z['text'] }}</p>
                    <span class="zone__go">Забронировать →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="block block--alt" id="prices">
    <div class="wrap">
        <p class="kicker">// тарифы</p>
        <h2 class="h2">Прозрачные цены</h2>
        @include('partials.tariffs')
    </div>
</section>

<section class="block" id="games">
    <div class="wrap">
        <p class="kicker">// игры</p>
        <h2 class="h2">Во что поиграть</h2>
        <p class="lead">Популярные новинки и проверенная классика. Нужной игры нет — можно войти в свой аккаунт.</p>
        <div class="tags">
            @foreach (config('club.games') as $g)
                <span class="tag">{{ $g }}</span>
            @endforeach
        </div>
    </div>
</section>

<section class="block block--alt" id="promo">
    <div class="wrap">
        <p class="kicker">// акции</p>
        <h2 class="h2">Играйте выгоднее</h2>
        @include('partials.promos')
    </div>
</section>

<section class="block" id="events">
    <div class="wrap">
        <p class="kicker">// мероприятия</p>
        <h2 class="h2">Праздники и турниры</h2>
        <div class="grid grid--3">
            @foreach (config('club.events') as $e)
                <article class="ev">
                    <h3>{{ $e['title'] }}</h3>
                    <p>{{ $e['text'] }}</p>
                    <ul>@foreach ($e['points'] as $pt)<li>{{ $pt }}</li>@endforeach</ul>
                    <a class="btn btn--sm btn--ghost" href="{{ route('book') }}?zone=event">Оставить заявку</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="block block--alt">
    <div class="wrap">
        <p class="kicker">// как это работает</p>
        <h2 class="h2">Три шага до игры</h2>
        <div class="steps">
            @foreach (config('club.steps') as $s)
                <div><h3>{{ $s['title'] }}</h3><p>{{ $s['text'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>

<section class="block" id="faq">
    <div class="wrap">
        <p class="kicker">// faq</p>
        <h2 class="h2">Вопросы и ответы</h2>
        @include('partials.faq')
    </div>
</section>

<section class="cta">
    <div class="wrap">
        <h2>Займите место заранее</h2>
        <p>Выберите зону, дату и время — администратор подтвердит бронь.</p>
        <div class="hero__btns cta__btns">
            <a class="btn" href="{{ route('book') }}">Забронировать</a>
            <a class="btn btn--ghost" href="{{ route('contacts') }}">Адреса и телефоны</a>
        </div>
    </div>
</section>
@endsection
