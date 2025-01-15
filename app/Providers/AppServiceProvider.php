<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // ログイン中のユーザーがいる場合のみ、プロフィール情報を共有
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('profile', Auth::user()->profile);
            }
        });    
    }
}
