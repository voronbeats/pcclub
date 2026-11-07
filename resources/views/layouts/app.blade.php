<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#07060d">
    <title>@yield('title') — {{ config('club.name') }}</title>
    <meta name="description" content="{{ config('club.name') }} — {{ config('club.tagline') }}. Мощные ПК, VIP-зоны и PlayStation. Бронируйте место онлайн.">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="icon" type="image/png" href="{{ asset('icons/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,600;0,800;1,800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/club.css') }}">
</head>
<body>
    <header class="top">
        <div class="wrap top__in">
            <a class="logo" href="{{ route('home') }}"><i class="logo__mark" aria-hidden="true"></i><span>{{ config('club.name') }}</span></a>
            <nav class="menu" id="menu">
                <a href="{{ route('zones') }}">Залы</a>
                <a href="{{ route('prices') }}">Цены</a>
                <a href="{{ route('promo') }}">Акции</a>
                <a href="{{ route('events') }}">Мероприятия</a>
                <a href="{{ route('contacts') }}">Контакты</a>
                <a class="menu__book" href="{{ route('book') }}">Забронировать</a>
            </nav>
            <div class="tools">
                <a class="btn btn--sm tools__book" href="{{ route('book') }}">Забронировать</a>
                <a class="acc" href="{{ route('account') }}" aria-label="Личный кабинет" title="Личный кабинет">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></svg>
                    @auth<i class="acc__on" aria-hidden="true"></i>@endauth
                </a>
                <button class="burger" id="burger" type="button" aria-label="Меню" aria-expanded="false" aria-controls="menu"><span></span><span></span><span></span></button>
            </div>
        </div>
    </header>

    <main>@yield('content')</main>

    <footer class="foot">
        <div class="wrap">
            <div class="foot__grid">
                <div>
                    <a class="logo" href="{{ route('home') }}"><i class="logo__mark" aria-hidden="true"></i><span>{{ config('club.name') }}</span></a>
                    <p class="foot__text">{{ config('club.tagline') }}. Мощные ПК, VIP-зоны и PlayStation — бронируйте место онлайн.</p>
                </div>
                <div>
                    <h4>Разделы</h4>
                    <a href="{{ route('zones') }}">Залы</a>
                    <a href="{{ route('prices') }}">Цены</a>
                    <a href="{{ route('promo') }}">Акции</a>
                    <a href="{{ route('events') }}">Мероприятия</a>
                </div>
                <div>
                    <h4>Контакты</h4>
                    <a href="tel:{{ config('club.phone_tel') }}">{{ config('club.phone') }}</a>
                    <span>{{ config('club.hours') }}</span>
                    <a href="{{ route('contacts') }}">Адреса</a>
                    <button class="btn btn--sm btn--ghost" id="install" type="button" hidden>Установить приложение</button>
                </div>
            </div>
            <div class="foot__bottom">
                <a href="{{ route('rules') }}">Правила клуба</a>
                <a href="{{ route('privacy') }}">Политика конфиденциальности</a>
                <span>© {{ date('Y') }} {{ config('club.name') }}</span>
            </div>
        </div>
    </footer>

    <div class="cookie" id="cookie" hidden>
        <p><b>Мы используем cookies</b><br>Продолжая пользоваться сайтом, вы соглашаетесь с их использованием.</p>
        <button class="btn btn--sm" id="cookie-ok" type="button">Принять</button>
    </div>

    <script src="{{ asset('js/club.js') }}"></script>
</body>
</html>
