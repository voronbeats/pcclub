@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<section class="auth wrap">
    <h1>Регистрация</h1>
    <p>Аккаунта с этим номером ещё нет. Создайте его, чтобы видеть свои оплаты, чеки и бонусные баллы.</p>

    @if ($errors->any())
        <div class="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <div class="auth__phone"><strong>{{ $phone }}</strong><a href="{{ route('login') }}">Изменить номер</a></div>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <label class="field">
            <span>Как вас зовут</span>
            <input type="text" name="name" value="{{ old('name') }}" autocomplete="given-name" maxlength="60" required autofocus>
        </label>
        <label class="field">
            <span>Пароль (не короче 8 символов)</span>
            <input type="password" name="password" autocomplete="new-password" minlength="8" required>
        </label>
        <label class="field">
            <span>Повторите пароль</span>
            <input type="password" name="password_confirmation" autocomplete="new-password" minlength="8" required>
        </label>
        <label class="check"><input type="checkbox" name="consent" value="1" required><span>Я согласен на обработку персональных данных и принимаю <a href="{{ route('privacy') }}" target="_blank">политику конфиденциальности</a></span></label>
        <button class="btn" type="submit">Зарегистрироваться</button>
    </form>
</section>
@endsection
