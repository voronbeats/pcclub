@extends('layouts.app')

@section('title', 'Товары в наличии — smoke Line')

@section('content')
<section class="page-head">
    <div class="wrap">
        <a class="back" href="{{ route('home') }}">← На главную</a>
        <h1>Товары в наличии</h1>
        <p>Что можно найти в наших магазинах. Информация носит ознакомительный характер — приходите, покажем и подскажем.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <p class="note">Наличие в конкретном филиале лучше уточнить по телефону — номера всех магазинов на странице <a href="{{ route('contacts') }}">«Контакты»</a>.</p>

        <div class="filters" role="group" aria-label="Категории">
            <button type="button" class="chip is-active" data-filter="all">Все</button>
            <button type="button" class="chip" data-filter="hookah">Кальяны</button>
            <button type="button" class="chip" data-filter="tobacco">Табак и смеси</button>
            <button type="button" class="chip" data-filter="acc">Угли и аксессуары</button>
            <button type="button" class="chip" data-filter="devices">Электронные устройства</button>
        </div>

        <div class="grid">
            @foreach ($items as $i)
                <article class="card" data-cat="{{ $i['cat'] }}">
                    <div class="card__pic"></div>
                    <div class="card__cat">{{ $i['catname'] }}</div>
                    <h3>{{ $i['name'] }}</h3>
                    <p>{{ $i['desc'] }}</p>
                    <div class="card__tag card__tag--in">В наличии · приходите в магазин</div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="visit">
    <div class="wrap">
        <h2>Приходите в магазин</h2>
        <p>Все товары можно посмотреть и подобрать на месте. Возраст подтверждается документом.</p>
        <a class="btn" href="{{ route('contacts') }}">Адреса и телефоны</a>
    </div>
</section>
@endsection
