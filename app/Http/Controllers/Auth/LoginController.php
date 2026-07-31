<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Koristi korisničko ime umjesto email adrese za prijavu.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Podaci koji se provjeravaju prilikom prijave.
     */
    protected function credentials(Request $request)
    {
        return [
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => true,
        ];
    }

    /**
     * Preusmjeravanje korisnika nakon uspješne prijave.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'owner') {
            return redirect('/owner/dashboard');
        }

        if ($user->role === 'employee') {
            return redirect('/employee/dashboard');
        }

        return redirect('/client/dashboard');
    }
}