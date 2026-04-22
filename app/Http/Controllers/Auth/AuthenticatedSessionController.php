<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        $user = User::where('email', $request->email)->first();

         if ($user) {

        // Cek jika password belum dibuat
        if ($user->password === null) {
            return back()->withErrors([
                'email' => 'Akun ini belum dibuat password. Silakan cek email untuk membuat password.',
            ]);
        }

        // ✅ Cek jika akun diblokir
        if ($user->status_blokir) {
            return back()->withErrors([
                'email' => 'Akun Anda telah diblokir. Silakan hubungi admin.',
            ]);
        }
    }

        if($user && $user->password === null){
            return back()->withErrors(['email' => 'Akun ini belum dibuat password. Silakan cek email untuk membuat password.',
    ]);
        }
        
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        
       if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }


        return redirect()->route('dashboard');

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