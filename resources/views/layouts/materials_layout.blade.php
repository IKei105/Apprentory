<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Apprentory')</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>
<body>
    @include('layouts.header')


    @yield('content')

    <!-- プロフィール画像押下時ポップアップ -->
    <div class="user-menu" id="user-menu">
        <div class="user-menu-content">
            <button class="user-menu-option" id="move-mypage" data-url="{{ route('mypage') }}">
                マイページへ移動
            </button>
            <button class="user-menu-option" id="logout" data-url="{{ route('logout') }}">
                ログアウトする
            </button>
        </div>
    </div>

    <!--投稿ボタン押下時ポップアップ-->
    <div class="post-popup" id="post-popup">
        <div class="post-popup-content">
            <button class="popup-option" id="post-material" data-url="{{ route('materials.create') }}">
                教材を投稿
            </button>
            <button class="popup-option" id="post-product" data-url="{{ route('products.create') }}">
                オリプロを投稿
            </button>
        </div>
    </div>

    <!-- 共通フッター（必要なら作成） -->
    {{-- @include('layouts.footer') --}}

    <!-- 共通スクリプト -->
    <script src="{{ asset('js/post_popup.js') }}"></script>

    @stack('scripts')
</body>
</html>

{{--
    呼び出し方法
    @extends('layouts.layout')

    @section('title', 'ホーム | Apprentory')

    @section('content')
        <h1>Apprentoryへようこそ！</h1>
        <p>ここにメインコンテンツを記述します。</p>
    @endsection
--}}