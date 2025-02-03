<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Apprentory')</title>
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @stack('styles')
</head>
<body>
    @include('layouts.header')

    <div class="main-content">
        @yield('content')
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