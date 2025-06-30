<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Adiciona uma mensagem de sucesso para o Toast
            return redirect()->intended('/dashboard')->with('success', 'Login realizado com sucesso!');
        }

        // Adiciona uma mensagem de erro para o Toast, além de manter os erros de validação
        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos.',
        ])->withInput()->with('error', 'Falha no login. Verifique suas credenciais.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Adiciona uma mensagem de sucesso para o Toast após o logout
        return redirect('/auth/login')->with('success', 'Você foi desconectado com sucesso!');
    }
}