@extends('layouts.app')

@section('title', 'Залы')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// залы</p>
        <h1>Залы и оборудование</h1>
        <p>Четыре формата игры: от общего зала до отдельной комнаты для вашей компании.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <div class="grid grid--2">
            @foreach (config('club.zones') as $z)
                <article class="zone zone--big">
                    <span class="zone__tag">{{ $z['tag'] }}</span>
                    <h3>{{ $z['name'] }}</h3>
                    <p>{{ $z['text'] }}</p>
                    <ul class="specs">@foreach ($z['specs'] as $sp)<li>{{ $sp }}</li>@endforeach</ul>
                    <a class="btn btn--sm" href="{{ route('book') }}?zone={{ $z['key'] }}">Забронировать</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="block block--alt">
    <div class="wrap">
        <p class="kicker">// игры</p>
        <h2 class="h2">Во что поиграть</h2>
        <div class="tags">
            @foreach (config('club.games') as $g)
                <span class="tag">{{ $g }}</span>
            @endforeach
        </div>
    </div>
</section>
@endsection
