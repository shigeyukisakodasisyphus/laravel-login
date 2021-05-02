<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;//useでインポートする。

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

        $user = User::where('email', '=', $credentials['email'])->first();
        if (!is_null($user)) {
            if ($user->locked_flg === 1) {//ロックドフラグが1ならばログインさせず戻す。
                return back()->withErrors([
                    'danger' => 'アカウントがロックされています。'
                ]);
            }
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                if ($user->error_count > 0) {
                    $user->error_count = 0;
                    $user->save();
                }//エラーカウントが0より大きい場合は0に戻して保存する。
                // return redirect()->route('home')->with('login_success', 'ログイン成功');
                return redirect()->route('home')->with('success', 'ログイン成功');
            }
            $user->error_count = $user->error_count + 1;
            if ($user->error_count > 5) {
                $user->locked_flg = 1;//この時点でエラーの数が5より大きければロックドフラグを1にする。
                $user->save();
                return back()->withErrors([
                    'danger' => 'アカウントがロックされました。解除したい場合は運営者に連絡してください。'
                ]);
            }
            
            $user->save();//ログイン失敗したらエラーカウントを1増やして保存する。
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
