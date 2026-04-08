<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
// use App\Http\Controllers\Auth\Hash;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {

    // super-admin:123456 admin@example.com
    // admin : 1234567 admin2@example.com
    // manager : 12345678 manager@example.com
    // test : 123456789  user@example.com

    // $abc =  Hash::make('123456789');
    // dd($abc);

    // dd(Auth::attempt($request->only('email', 'password')));

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return back()->withErrors([
                'email' => trans('auth.failed'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate($request);

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
