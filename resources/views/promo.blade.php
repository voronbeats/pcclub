@extends('layouts.app')

@section('title', 'Акции')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// акции</p>
        <h1>Акции и бонусы</h1>
        <p>Играйте больше — платите меньше. Подробные условия акций уточняйте у администратора.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        @include('partials.promos')
        <div class="hero__btns cta__btns left">
            <a class="btn" href="{{ route('login') }}">Личный кабинет и баллы</a>
            <a class="btn btn--ghost" href="{{ route('book') }}">Забронировать</a>
        </div>
    </div>
</section>
@endsection
