<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use ErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function Login() 
    {
        return view('modules.auth.login');
    }

    public function Authenticate(LoginRequest $request) 
    {
        try {
            $creds = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if(!Auth::attempt($creds)) {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.'
                ]);
            }

            return redirect()->to('/dashboard');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    public function Destroy()
    {
        try {
            Auth::logout();

            return redirect()->to('/');
        } catch (ErrorException $e) {
            throw new ErrorException($e->getMessage());
        }
    }
}
