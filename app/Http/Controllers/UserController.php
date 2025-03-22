<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;
use App\Services\DiscordService;
use App\Models\TempRegisterCode;
use Carbon\Carbon;
use App\Models\User;
use App\Services\UserService;
use \App\Models\Profile;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private const LENGTH = 16;

    protected $discordService;
    protected $userService;

    public function __construct(DiscordService $discordService, UserService $userService)
    {
        $this->discordService = $discordService;
        $this->userService = $userService;
    }

    //新規登録
    public function showRegisterForm1()
    {
        $terms = Term::all(); // 全ての期生データを取得
        return view('users.register_step1_discord',compact('terms'));
    }

    //discordに確認コードを送る
    public function sendDiscordRegisterCode(Request $request)
    {   
        $discordId = $request['discord-ID'];

        session(['discord_ID' => $discordId]);

        //ランダムな16桁のコードを生成
        $registerCode = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, self::LENGTH);

        //ここでサービスを使用してランダムなコードをディスコードのidあてに送ります
        $this->discordService->sendDiscordRegisterCode($discordId, $registerCode);

        //これをdbに登録します
        // 翌日の日付を取得
        $expiresAt = $this->userService->getTomorrowDate();
        //dd($expiresAt);

        // データを保存
        $this->userService->createTempRegisterCode($discordId, $registerCode, $expiresAt);

        //新規登録画面2を送る
        return redirect()->route('register2', ['discord-ID' => $discordId]);
    }

    public function showRegisterForm2()
    {
        $terms = Term::all(); // 全ての期生データを取得
        return view('users.register_step2_info',compact('terms'));
    }

    public function newRegister(UserRequest $request)
    {
        $validated = $request->validated();

        //ここで入力されたdiscordIDと確認コードが一致するなら
        //apprenticeのグループにいるの確認できたっけ？
        $discordId = $request->input('discord-ID');
        $registerCode = $request->input('register-code');

        // テーブルに該当するレコードが存在するか確認
        //requestで対処してるンゴねぇ
        //$exists = $this->userService->checkTempRegisterCode($discordId, $registerCode);

            //userを登録
            $user = $this->userService->createUser($validated);

            //profileを登録
            $profileImage = $request->profile_image ?? 'public/assets/images/sample_image.png';

            $this->userService->createProfile($user->id, $validated, $profileImage);

            // 登録後にログインさせる
            auth()->login($user);
        

        //登録完了後に教材ページに移動する
        return redirect('/materials');
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
        $user = User::create([
            'userid' => $request->userid,
            'term_id' => $request->term,
            'password' => bcrypt($request->password),
        ]);

        \App\Models\Profile::create([
            'user_id' => $user->id, // Userの主キーを取得して関連付け
            'username' => $request->userid,
            'profile_image' => $request->profile_image,
            'discord_id' => '1292759239600767032',
        ]);
    
        // ユーザーに紐づくプロフィールを取得
        $profile = $user->profile;
        // dd($profile);

        // // 確認用ページへリダイレクト(後から消す)
        // return redirect()->route('register.confirmation')->with([
        //     'userid' => $request->userid,
        //     'password' => $request->password,
        //     'username' => $profile->username,
        //     'profile_image' => $request->profile_image ?? 'public/assets/images/sample_image.png',
        // ]);
        // 登録後にログインさせる
        auth()->login($user);    
        // 登録後のリダイレクト
        return redirect('/')->with('success', 'ユーザー登録が完了しました！');
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
        if (auth()->attempt(['userid'=>$request->userid, 'password'=>$request->password])) {
            // 認証成功時のリダイレクト
            return redirect('/')->with('success', 'ログインに成功しました！');
        }

        // 認証失敗時のリダイレクト
        return back()->withErrors([
            'userid' => 'メールアドレスまたはパスワードが間違っています。',
        ])->withInput();
    }

    public function boot()
    {
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('profile', auth()->user()->profile);
            }
        });
    }

    public function logout()
    {
        auth()->logout(); // ログアウト処理
        return redirect('/')->with('success', 'ログアウトしました！');
    }
    public function logindashboard()
    {
        // ログインユーザー情報を取得
        $user = auth()->user();  // 現在ログインしているユーザー情報を取得
    
        // logindashboard ページを返す（ユーザーIDをビューに渡す）
        return view('tests.logindashboard', ['user' => $user]);
    }
    //マイページ関連
    //マイページへの遷移
    public function showMyPage()
    {
        $profile = auth()->user()->profile;  // ログイン中のユーザーのプロフィールを取得
        return view('users.mypage', compact('profile'));
    }    
}
