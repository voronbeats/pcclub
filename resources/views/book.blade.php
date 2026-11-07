@extends('layouts.app')

@section('title', 'Бронирование')

@section('content')
<section class="page-head">
    <div class="wrap">
        <p class="kicker">// бронирование</p>
        <h1>Забронировать место</h1>
        <p>Заполните форму — администратор свяжется с вами и подтвердит бронь.</p>
    </div>
</section>

<section class="block">
    <div class="wrap wrap--narrow">
        @if (session('booked'))
            <div class="done">
                <h2>Заявка №{{ session('booked')['id'] }} принята</h2>
                <p>{{ session('booked')['zone'] }} · {{ session('booked')['date'] }} в {{ session('booked')['time'] }}</p>
                <p class="muted">Администратор свяжется с вами по указанному номеру и подтвердит бронь.</p>
                <div class="hero__btns left">
                    <a class="btn" href="{{ route('home') }}">На главную</a>
                    <a class="btn btn--ghost" href="{{ route('book') }}">Ещё одна бронь</a>
                </div>
            </div>
        @else
            @if ($errors->any())
                <div class="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            @endif
            <form method="POST" action="{{ route('book.store') }}" class="bform" novalidate>
                @csrf
                <fieldset>
                    <legend>Что бронируем</legend>
                    <div class="opts">
                        @foreach (config('club.booking_zones') as $key => $label)
                            <label class="opt"><input type="radio" name="zone" value="{{ $key }}" @checked(old('zone', $zone) === $key)><span>{{ $label }}</span></label>
                        @endforeach
                    </div>
                </fieldset>

                <div class="row2">
                    <label class="field"><span>Ваше имя</span><input type="text" name="name" value="{{ old('name') }}" autocomplete="given-name" maxlength="60" required></label>
                    <label class="field"><span>Телефон</span><input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+7 (___) ___-__-__" autocomplete="tel" inputmode="tel" data-phone required></label>
                </div>

                <label class="field"><span>Клуб</span>
                    <select name="club" required>
                        @foreach (config('club.locations') as $key => $loc)
                            <option value="{{ $key }}" @selected(old('club') === $key)>{{ $loc['name'] }} — {{ $loc['address'] }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="row3">
                    <label class="field"><span>Сколько вас</span><input type="number" name="guests" value="{{ old('guests', 1) }}" min="1" max="30" required></label>
                    <label class="field"><span>Дата</span><input type="date" name="date" value="{{ old('date') }}" data-today required></label>
                    <label class="field"><span>Время</span><input type="time" name="time" value="{{ old('time') }}" required></label>
                </div>

                <label class="field"><span>Комментарий (необязательно)</span><input type="text" name="comment" value="{{ old('comment') }}" maxlength="500" placeholder="Например: нужны места рядом"></label>

                <label class="check"><input type="checkbox" name="consent" value="1" required><span>Я согласен на обработку персональных данных и принимаю <a href="{{ route('privacy') }}" target="_blank">политику конфиденциальности</a></span></label>
                <button class="btn" type="submit">Отправить заявку</button>
            </form>
        @endif
    </div>
</section>
@endsection
