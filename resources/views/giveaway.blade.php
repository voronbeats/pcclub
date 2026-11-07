@extends('layouts.app')

@section('title', 'Розыгрыш призов — smoke Line')

@section('content')
<section class="page-head">
    <div class="wrap">
        <a class="back" href="{{ route('home') }}">← На главную</a>
        <h1>Розыгрыш призов</h1>
        <p>Сейчас в наших магазинах проходит розыгрыш. Совершите покупку товаров Darksidecorp на сумму 1000 рублей и примите участие.</p>
    </div>
</section>

<section class="block">
    <div class="wrap">
        <h2 class="h2">Призы</h2>
        <div class="prizes">
            @foreach ($prizes as $p)
                <div class="prize">
                    <div class="prize__place">{{ $p['place'] }}<small>место</small></div>
                    <h3>{{ $p['name'] }}</h3>
                    <span class="prize__tag">Приз</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="block block--alt">
    <div class="wrap">
        <h2 class="h2">Как участвовать</h2>
        <div class="steps">
            <div><h3>Приходите в магазин</h3><p>Любой из наших 9 филиалов в Йошкар-Оле и Медведеве.</p></div>
            <div><h3>Сделайте покупку</h3><p>Купите товары Darksidecorp на сумму 1000 рублей.</p></div>
            <div><h3>Уточните условия</h3><p>Продавец расскажет, как стать участником и когда подведут итоги.</p></div>
        </div>
        <p class="fine">Сроки проведения, порядок определения победителей и подробные условия уточняйте в магазине. Только для лиц старше 18 лет.</p>
    </div>
</section>

<section class="visit">
    <div class="wrap">
        <h2>Приходите в магазин</h2>
        <p>Выберите ближайший филиал и позвоните, если остались вопросы.</p>
        <a class="btn" href="{{ route('contacts') }}">Адреса и телефоны</a>
    </div>
</section>
@endsection
