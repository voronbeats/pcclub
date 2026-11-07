@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<section class="auth wrap">
    <h1>С возвращением</h1>
    <p>Аккаунт с этим номером уже зарегистрирован. Введите пароль, чтобы войти.</p>

    @if (session('notice'))
        <div class="ok">{{ session('notice') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <div class="auth__phone"><strong>{{ $phone }}</strong><a href="{{ route('login') }}">Изменить номер</a></div>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <label class="field">
            <span>Пароль</span>
            <input type="password" name="password" autocomplete="current-password" required autofocus>
        </label>
        <label class="check"><input type="checkbox" name="remember" value="1"><span>Запомнить меня на этом устройстве</span></label>
        <button class="btn" type="submit">Войти</button>
    </form>
</section>
@endsection
