<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @return mixed
     */
    public function loginPage()
    {
        if(auth()->check()) {
            return redirect()->route('dashboard');
        } else {
            $users = User::select(['email'])->get();
            return view('login', compact('users'));
        }
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request) : RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withInput()->withErrors('Username or password invalid.');
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() : RedirectResponse
    {
        if (Auth::check())
            Auth::logout();

        return redirect()->route('login-page')->with('status', 'Logout has been successfully.');
    }
}
