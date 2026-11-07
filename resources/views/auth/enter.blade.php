@extends('layouts.app')

@section('title', 'Вход и регистрация')

@section('content')
<section class="auth wrap">
    <h1>Вход и регистрация</h1>
    <p>Введите номер телефона — мы проверим, есть ли у вас аккаунт, и подскажем, что делать дальше.</p>

    @if ($errors->any())
        <div class="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('enter.check') }}" novalidate>
        @csrf
        <label class="field">
            <span>Номер телефона</span>
            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+7 (___) ___-__-__" autocomplete="tel" inputmode="tel" data-phone required autofocus>
        </label>
        <button class="btn" type="submit">Продолжить</button>
    </form>
</section>
@endsection
