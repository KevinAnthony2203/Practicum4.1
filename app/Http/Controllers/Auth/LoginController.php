<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        $tipo = $request->query('tipo', 'personal');
        return view('auth.login', compact('tipo'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasRole('patient')) {
                return redirect()->route('patients.dashboard');
            } else {
                // Para todo el personal (Doctor, Secretaria, Gerencia, admin)
                if ($user->hasRole('doctor')) {
                    return redirect()->route('doctor.dashboard');
                } elseif ($user->hasRole('secretaria')) {
                    return redirect()->route('secretaria.dashboard');
                } elseif ($user->hasRole('gerencia')) {
                    return redirect()->route('gerencia.dashboard');
                } elseif ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                }
            }

            return redirect()->intended('dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
