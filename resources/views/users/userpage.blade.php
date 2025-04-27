@extends('layouts.layout')

@section('title', $user->userid . ' | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/userpage_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/font.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush
@section('content')
<main>
    <div class="profile-container">
        <div class="profile-layout-top">
            <div class="profile-info">
                <img src="{{ asset($user->profile->profile_image) }}" alt="プロフィール画像" width="50">

            </div>

            {{-- ボタン部分 --}}
            <div class="profile-action">
                @if (auth()->check())
                    @if (auth()->id() == $user->id)
                        <a href="/mypage/edit" class="action-button">プロフィールを編集</a>
                        {{-- ログイン本人のときは、フォローボタン両方hidden --}}
                        <button id="follow" class="action-button follow-button hidden">フォローする</button>
                        <button id="unfollow" class="action-button following-button hidden">フォロー中</button>
                    @else
                        {{-- ログインしてる他人のページ --}}
                        <button id="follow" class="action-button follow-button {{ auth()->user()->isFollowing($user->id) ? 'hidden' : '' }}">フォローする</button>
                        <button id="unfollow" class="action-button following-button {{ auth()->user()->isFollowing($user->id) ? '' : 'hidden' }}">フォロー中</button>
                    @endif
                @else
                    {{-- ゲストの場合は両方hidden --}}
                    <button id="follow" class="action-button follow-button hidden">フォローする</button>
                    <button id="unfollow" class="action-button following-button hidden">フォロー中</button>
                @endif
            </div>
        </div>
    {{-- ユーザー基本情報 --}}
        <div class="profile-info-text">
            <p class = "username">{{ $user->profile->username }}</p>
            <p class = "userid">{{ $user->userid }}</p>
            <p class="term">{{ $user->term->term }}</p>
        </div>


        {{-- 投稿一覧 --}}
        <div class="profile-post">
            <h2>投稿一覧</h2>
            {{-- 投稿教材 --}}
                <section style="margin-top: 40px;">
                    <ul>
                        @forelse ($user->materials as $material)
                            <li>{{ $material->title ?? 'タイトル未設定' }}</li>
                        @empty
                            <li>まだ教材の投稿はありません</li>
                        @endforelse
                    </ul>
                </section>
            {{-- オリプロ一覧 --}}
                <section style="margin-top: 40px;">
                    <ul>
                        @forelse ($user->products as $product)
                            <li>{{ $product->title ?? 'タイトル未設定' }}</li>
                        @empty
                            <li>まだオリプロの投稿はありません</li>
                        @endforelse
                    </ul>
                </section>
        </div>

        <div class="logout">
            @if (auth()->id() == $user->id)
                    <a href="{{ route('logout') }}">ログアウト</a>
            @endif
        </div>





    </div>
</main>
<script src="{{ asset('js/userpage.js') }}" defer></script>
<script src="{{ asset('js/follow.js') }}" defer></script>
@endsection
