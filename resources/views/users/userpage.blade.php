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
            <p class = "userid">{!! '@' . e($user->userid) !!}</p>
            <p class="term">{{ $user->term->term }}</p>
        </div>


        {{-- 投稿一覧 --}}

        <div class="userpage-switch-buttons" style="margin-top: 30px;">
            <button id="show-materials" class="userpage-switch-button">教材</button>
            <button id="show-products" class="userpage-switch-button">オリプロ</button>
        </div>

        <div class="profile-post">
            <h2>投稿一覧</h2>
            {{-- 投稿教材 --}}
            <section class="userpage-posts-section" id="userpage-materials" style="margin-top: 40px;">
                <h2>投稿した教材</h2>
                <div class="userpage-posts-list">
                    @forelse ($user->materials as $material)
                        <div class="userpage-post-item">
                            <a href="{{ route('materials.show', $material->id) }}">
                                <img src="{{ asset($material->image_dir) }}" alt="教材サムネイル" class="userpage-post-image">
                                <h3 class="userpage-post-title">{{ $material->title ?? 'タイトル未設定' }}</h3>
                            </a>
                            <div class="userpage-post-tags">
                                @foreach ($material->technologies as $tech)
                                    <span class="userpage-post-tag">{{ $tech->name }}</span>
                                @endforeach
                            </div>
                            <p class="userpage-post-likes">♡ {{ $material->likes_count ?? 0 }}</p>
                        </div>
                    @empty
                        <p>まだ教材の投稿はありません</p>
                    @endforelse
                </div>
            </section>

            {{-- オリプロ一覧 --}}
            <section class="userpage-posts-section" id="userpage-products" style="margin-top: 40px;">
                <h2>投稿したオリプロ</h2>
                <div class="userpage-posts-list">
                    @forelse ($user->products as $product)
                        <div class="userpage-post-item">
                            <a href="{{ route('products.show', $product->id) }}">
                                <img src="{{ asset($product->images[0]->image_dir ?? 'assets/material_images/no_image.png') }}" alt="オリプロサムネイル" class="userpage-post-image-product">
                                <h3 class="userpage-post-title">{{ $product->title ?? 'タイトル未設定' }}</h3>
                                @if (!empty($product->subtitle))
                                    <p class="userpage-post-subtitle">{{ $product->subtitle }}</p>
                                @endif
                            </a>
                            <div class="userpage-post-tags">
                                @foreach ($product->technologies as $tech)
                                    <span class="userpage-post-tag">{{ $tech->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p>まだオリプロの投稿はありません</p>
                    @endforelse
                </div>
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
