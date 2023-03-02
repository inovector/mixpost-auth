<?php

namespace Inovector\MixpostAuth\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inovector\MixpostAuth\Http\Requests\LoginRequest;

class AuthenticatedController extends Controller
{
    public function create(): View
    {
        return view('mixpost-auth::login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(config('mixpost-auth.redirect_to_url'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
