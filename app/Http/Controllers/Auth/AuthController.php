<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function showLogin() 
    {
        return view('login.login_form');
    }

    /**
     * @param App\Http\Requests\LoginFormRequest $request
     */
    public function login(LoginFormRequest $request) 
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // return redirect()->route('home')->with('login_success', 'ログイン成功');
            return redirect()->route('home')->with('success', 'ログイン成功');
        }

        return back()->withErrors([
            // 'login_error' => 'メールアドレスかパスワードが間違ってます。'
            'danger' => 'メールアドレスかパスワードが間違ってます。'
        ]);
    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        // return redirect()->route('login.show')->with('logout', 'ログアウトしました');
        return redirect()->route('login.show')->with('danger', 'ログアウトしました');
    }
}
