<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->header('x-forwarded-proto') == 'https') {
            URL::forceScheme('https');
        }
        // ログイン中のユーザーがいる場合のみ、プロフィール情報を共有
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('profile', Auth::user()->profile);
                $view->with('notifications', session('user_notifications', [])); // ←これを追加！
            } else {
                $view->with('notifications', []); // 未ログインでも空配列を渡す
            }
        });
    }
}
