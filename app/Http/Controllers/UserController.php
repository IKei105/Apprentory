<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Term;
use App\Models\User;
use App\Models\Profile;
use App\Models\TempRegisterCode;
use App\Models\Notification;
use App\Services\DiscordService;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\SendDiscordRegisterCode;

class UserController extends Controller
{
    private const LENGTH = 16;
    private const price = 100;

    protected $discordService;
    protected $userService;

    public function __construct(DiscordService $discordService, UserService $userService)
    {
        $this->discordService = $discordService;
        $this->userService = $userService;
    }

    public function showRegisterForm1()
    {
        $terms = Term::all();
        return view('users.register_step1_discord',compact('terms'));
    }

    public function sendDiscordRegisterCode(SendDiscordRegisterCode $request)
    {   
        $validated = $request->validated();
        $discordId = $request->input('discord-ID');

        session(['discord_ID' => $discordId]);

        $registerCode = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, self::LENGTH);
        $this->discordService->sendDiscordRegisterCode($discordId, $registerCode);

        $expiresAt = $this->userService->getTomorrowDate();

        $this->userService->createTempRegisterCode($discordId, $registerCode, $expiresAt);

        return redirect()->route('register2', ['discord-ID' => $discordId]);
    }

    public function showRegisterForm2()
    {
        $terms = Term::all();
        return view('users.register_step2_info',compact('terms'));
    }

    public function newRegister(UserRequest $request)
    {
        $validated = $request->validated();

        $discordId = $request->input('discord-ID');
        $registerCode = $request->input('register-code');

            $user = $this->userService->createUser($validated);

            $profileImage = $request->profile_image ?? 'public/assets/images/sample_image.png';

            $this->userService->createProfile($user->id, $validated);

            auth()->login($user);
        
        return redirect('/materials');
    }

    public function register(Request $request)
    {
        $request->validate([
            'userid' => 'required|unique:users',
            'term' => 'required|exists:terms,id',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $user = User::create([
            'userid' => $request->userid,
            'term_id' => $request->term,
            'password' => bcrypt($request->password),
        ]);

        \App\Models\Profile::create([
            'user_id' => $user->id,
            'username' => $request->userid,
            'profile_image' => $request->profile_image,
            'discord_id' => '1292759239600767032',
        ]);
    
        $profile = $user->profile;

        auth()->login($user);    
        
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

    public function showLoginForm()
    {
        return view('users.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt(['userid'=>$request->userid, 'password'=>$request->password])) {
            $user = auth()->user();

            $notifications = Notification::with(['fromUser.profile', 'notificationType'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();

            session(['user_notifications' => $notifications]);
            return redirect('/')->with('success', 'ログインに成功しました！');
        }

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
        auth()->logout();
        return redirect('/')->with('success', 'ログアウトしました！');
    }
    public function logindashboard()
    {
        $user = auth()->user();
    
        return view('tests.logindashboard', ['user' => $user]);
    }

    public function showMyPage()
    {
        $userId = auth()->id();
        return redirect()->route('users.show', ['user' => $userId]);
    }
    
    public function showUserPage($userId)
    {
        $user = User::with('profile', 'materials', 'products')->findOrFail($userId);

        return view('users.userpage', compact('user'));
    }

}
