<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;

class UserController extends Controller
{
    //新規登録
    public function showRegisterForm()
    {
        $terms = Term::all(); // 全ての期生データを取得
        return view('users.register',compact('terms'));
    }

    public function register(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email|unique:users',
            'term' => 'required',
            'password' => 'required|min:8|confirmed', // 'confirmed' はパスワード確認用フィールドと一致するかチェック
        ]);
    
        // ユーザーの作成
        $user = \App\Models\User::create([
            'email' => $request->email,
            'term' => $request->term,
            'password' => bcrypt($request->password),
        ]);
    
        // 登録後にログインさせる
        auth()->login($user);    
        // 登録後のリダイレクト
        return redirect('/')->with('success', 'ユーザー登録が完了しました！');
    }
    //ログイン機能
    public function showLoginForm()
    {
        return view('users.login');
    }
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証を試みる
        if (auth()->attempt($request->only('email', 'password'))) {
            // 認証成功時のリダイレクト
            return redirect('/')->with('success', 'ログインに成功しました！');
        }

        // 認証失敗時のリダイレクト
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています。',
        ])->withInput();
    }
    public function logout()
    {
        auth()->logout(); // ログアウト処理
        return redirect('/')->with('success', 'ログアウトしました！');
    }



}
