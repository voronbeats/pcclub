@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// контакты</p>
        <h1>Контакты и адреса</h1>
        <p>Приходите в клуб или позвоните — подскажем свободные места и поможем с бронью.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <div class="grid grid--2">
            @foreach (config('club.locations') as $l)
                <article class="loc">
                    <h3>{{ $l['name'] }}</h3>
                    <p class="loc__addr">{{ $l['address'] }}</p>
                    <dl>
                        <dt>Режим работы</dt><dd>{{ $l['hours'] }}</dd>
                        <dt>Места</dt><dd>{{ $l['seats'] }}</dd>
                        <dt>Телефон</dt><dd><a href="tel:{{ $l['phone_tel'] }}">{{ $l['phone'] }}</a></dd>
                    </dl>
                    <div class="loc__act">
                        <a class="btn btn--sm" href="tel:{{ $l['phone_tel'] }}">Позвонить</a>
                        <a class="btn btn--sm btn--ghost" href="{{ $l['map'] }}" target="_blank" rel="noopener">На карте</a>
                        <a class="btn btn--sm btn--ghost" href="{{ route('book') }}">Забронировать</a>
                    </div>
                </article>
            @endforeach
            <article class="loc">
                <h3>Мы в сети</h3>
                <p class="loc__addr">Пишите нам — ответим в сообщениях.</p>
                <dl>
                    <dt>Почта</dt><dd><a href="mailto:{{ config('club.email') }}">{{ config('club.email') }}</a></dd>
                    <dt>Телефон</dt><dd><a href="tel:{{ config('club.phone_tel') }}">{{ config('club.phone') }}</a></dd>
                </dl>
                <div class="loc__act">
                    @foreach (config('club.socials') as $s)
                        <a class="btn btn--sm btn--ghost" href="{{ $s['url'] }}" target="_blank" rel="noopener">{{ $s['name'] }}</a>
                    @endforeach
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
