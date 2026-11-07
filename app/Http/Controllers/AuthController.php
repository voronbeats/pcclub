<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** Шаг 1: ввод номера телефона. */
    public function enter()
    {
        if (Auth::check()) {
            return redirect()->route('account');
        }

        return view('auth.enter');
    }

    /** Проверяем, есть ли аккаунт с таким номером. */
    public function check(Request $request)
    {
        $phone = Phone::normalize($request->input('phone'));

        if (! $phone) {
            return back()->withInput()->withErrors([
                'phone' => 'Введите номер телефона полностью, например +7 (995) 681-80-05.',
            ]);
        }

        $request->session()->put('auth_phone', $phone);

        return redirect()->route(User::where('phone', $phone)->exists() ? 'enter.login' : 'enter.register');
    }

    /** Шаг 2а: аккаунт найден — просим пароль. */
    public function loginForm(Request $request)
    {
        $phone = $request->session()->get('auth_phone');

        if (! $phone) {
            return redirect()->route('login');
        }
        if (! User::where('phone', $phone)->exists()) {
            return redirect()->route('enter.register');
        }

        return view('auth.login', ['phone' => Phone::pretty($phone)]);
    }

    /** Шаг 2б: аккаунта нет — регистрация. */
    public function registerForm(Request $request)
    {
        $phone = $request->session()->get('auth_phone');

        if (! $phone) {
            return redirect()->route('login');
        }
        if (User::where('phone', $phone)->exists()) {
            return redirect()->route('enter.login')->with('notice', 'Такой аккаунт уже зарегистрирован — введите пароль.');
        }

        return view('auth.register', ['phone' => Phone::pretty($phone)]);
    }

    public function login(Request $request)
    {
        $phone = $request->session()->get('auth_phone');

        if (! $phone) {
            return redirect()->route('login');
        }

        $request->validate(['password' => 'required'], ['password.required' => 'Введите пароль.']);

        if (Auth::attempt(['phone' => $phone, 'password' => $request->input('password')], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->forget('auth_phone');

            return redirect()->intended(route('account'));
        }

        return back()->withErrors(['password' => 'Неверный пароль.']);
    }

    public function register(Request $request)
    {
        $phone = $request->session()->get('auth_phone');

        if (! $phone) {
            return redirect()->route('login');
        }
        if (User::where('phone', $phone)->exists()) {
            return redirect()->route('enter.login')->with('notice', 'Такой аккаунт уже зарегистрирован — введите пароль.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:60',
            'password' => 'required|string|min:8|confirmed',
            'consent' => 'accepted',
        ], [
            'name.required' => 'Укажите имя.',
            'password.required' => 'Придумайте пароль.',
            'password.min' => 'Пароль должен быть не короче 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
            'consent.accepted' => 'Нужно согласие на обработку персональных данных.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'phone' => $phone,
            'password' => $data['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->forget('auth_phone');

        return redirect()->route('account');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
