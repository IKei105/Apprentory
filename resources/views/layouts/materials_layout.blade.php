<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Apprentory')</title>
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/apprentory_logo.png') }}">
    @stack('styles')
</head>
<body>
    @include('layouts.header')


    @yield('content')
    <div id="notification-popup" class="notification hidden">
        <div class="notification-content">
            @foreach($notifications as $notification)
                @php
                    $type = $notification->notificationType->name ?? null;
                    $from = $notification->fromUser->profile->username ?? $notification->fromUser->userid ?? '不明';
                    $target = $notification->notifiable;

                    // 遷移先リンク（デフォルトは「#」）
                    $link = '#';

                    // 通知タイプ別にリンクを設定
                    if ($type === 'like' && $target) {
                        $link = route('materials.show', ['material' => $target->id]);
                    } elseif ($type === 'comment' && $target) {
                        $link = route('products.show', ['product' => $target->id]);
                    } elseif ($type === 'follow' && $notification->fromUser) {
                        $link = route('users.show', ['user' => $notification->fromUser->id]);
                    }
                @endphp

                <a href="{{ $link }}" class="notification-link">
                    <p>
                        {{ $from }} さんが
                        @if ($type === 'like' && $target)
                            あなたの教材「{{ $target->title }}」にいいねしました！
                        @elseif ($type === 'comment' && $target)
                            あなたのオリプロ「{{ $target->title }}」にコメントしました！
                        @elseif ($type === 'follow')
                            あなたをフォローしました！
                        @else
                            通知があります。
                        @endif
                    </p>
                </a>
            @endforeach
        </div>
    </div>

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
    <script src="{{ asset('js/notification_menu.js') }}"></script>

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