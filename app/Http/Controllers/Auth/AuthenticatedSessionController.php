<?php

namespace App\Http\Controllers\Auth;

use Laratrust\Laratrust;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        // if($user->hasRole('user')) {
        if($user->hasRole('user')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect('/dashboard');
        }
        // if(Auth::user()->role == 'normal') {
        //     return redirect()->intended(RouteServiceProvider::HOME);
        // } else {
        //     return redirect('/dashboard');
        // }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
