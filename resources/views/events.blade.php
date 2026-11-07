@extends('layouts.app')

@section('title', 'Мероприятия')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// мероприятия</p>
        <h1>Праздники и турниры</h1>
        <p>День рождения, корпоратив или командная тренировка — подберём формат и подготовим зону.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <div class="grid grid--3">
            @foreach (config('club.events') as $e)
                <article class="ev">
                    <h3>{{ $e['title'] }}</h3>
                    <p>{{ $e['text'] }}</p>
                    <ul>@foreach ($e['points'] as $pt)<li>{{ $pt }}</li>@endforeach</ul>
                    <a class="btn btn--sm" href="{{ route('book') }}?zone=event">Оставить заявку</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
