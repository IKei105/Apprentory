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
            'userid' => 'required|unique:users', // ユーザーIDが必須かつユニーク
            'term' => 'required|exists:terms,id',
            'password' => 'required|min:8|confirmed', // 'confirmed' はパスワード確認用フィールドと一致するかチェック
        ]);
    
        // ユーザーの作成
        $user = \App\Models\User::create([
            'userid' => $request->userid,
            'term_id' => $request->term,
            'password' => bcrypt($request->password),
        ]);


        // 確認用ページへリダイレクト(後から消す)
        return redirect()->route('register.confirmation')->with([
            'userid' => $request->userid,
            'password' => $request->password,
        ]);
        // // 登録後にログインさせる
        // auth()->login($user);    
        // // 登録後のリダイレクト
        // return redirect('/')->with('success', 'ユーザー登録が完了しました！');
    }

    public function showConfirmation()
    {
        $userid = session('userid');
        $password = session('password');

        if (!$userid || !$password) {
            return redirect('/register')->with('error', '登録情報が見つかりません。');
        }

        return view('tests.confirmation', compact('userid', 'password'));
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
            'userid' => 'required',
            'password' => 'required',
        ]);

        // 認証を試みる
        if (auth()->attempt($request->only('userid', 'password'))) {
            // 認証成功時のリダイレクト
            return redirect('/')->with('success', 'ログインに成功しました！');
        }

        // 認証失敗時のリダイレクト
        return back()->withErrors([
            'userid' => 'メールアドレスまたはパスワードが間違っています。',
        ])->withInput();
    }
    public function logout()
    {
        auth()->logout(); // ログアウト処理
        return redirect('/')->with('success', 'ログアウトしました！');
    }



}
