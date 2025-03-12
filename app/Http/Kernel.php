<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * グローバルミドルウェア（すべてのリクエストに適用される）
     */
    protected $middleware = [
        \App\Http\Middleware\ForceHttps::class, // HTTPSリダイレクトミドルウェアを追加
    ];

    /**
     * ルートミドルウェア（特定のルートで使用）
     */
    protected $routeMiddleware = [
        'https' => \App\Http\Middleware\ForceHttps::class,
    ];
}

