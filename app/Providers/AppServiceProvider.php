<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if (request()->header('x-forwarded-proto') == 'https') {
            URL::forceScheme('https');
        }
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('profile', Auth::user()->profile);
                $view->with('notifications', session('user_notifications', []));
            } else {
                $view->with('notifications', []);
            }
        });
    }
}
