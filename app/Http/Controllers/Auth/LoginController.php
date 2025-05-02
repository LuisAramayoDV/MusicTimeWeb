<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // ✅ Esta línea es necesaria

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirección personalizada después del login.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        return redirect('/home');
    }
}
