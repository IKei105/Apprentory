<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Apprentory')</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
    @include('layouts.header')

    <div class="main-content">
        @yield('content')
    </div>

    <!-- 共通フッター（必要なら作成） -->
    {{-- @include('layouts.footer') --}}
    
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