@extends('layouts.materials_layout')

@section('title', '教材詳細 | Apprentory')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show_material.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material_category.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div id="auth-data" data-auth-user-id="{{ auth()->id() }}">@if(auth()->check())
    <p>ログイン中のユーザーID: {{ auth()->id() }}</p>
@else
    <p>ログインしていません</p>
@endif
</div>
    <div class="material-actions">
        <div class="material-actions-left">
            <a class="posted-profile" href="">
                <img class="posted-user-image" src="{{ asset($material->posts[0]->user->profile['profile_image'] ?? '') }}" alt="">
                <p class="posted-username">{!! nl2br(e($material->posts[0]->user->profile['username'])) !!}</p>
            </a>
            <div class="follow-action">
                <button id="follow" class="follow-button {{ $isFollow->value == 'not_following' ? '' : 'hidden' }}" >
                    フォロー
                </button>
                <button id="unfollow" class="unfollow-button {{ $isFollow->value == 'following' ? '' : 'hidden' }}">
                    フォロー中
                </button>
            </div>
            <div class="product-technology-tags">
                @foreach ($material->technologies as $technology)
                    <a href="" class="product-tag">{{ $technology->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="material-actions-right">
            <a class="purchase-button" href="{!! nl2br(e($material->material_url)) !!}" target="_blank" rel="noopener noreferrer">購入する</a>
            @if ($isLikedByCurrentUser) <!-- いいねをしていたら -->
                <button class="heart liked">♥</button>
            @else
                <button class="heart non-liked">♡</button>
            @endif
        </div>
    </div>
    <div class="material-info">
        <div class="material-info-left">
            <div class="material-category">
                @if($material->category_id == 1)
                    <a href=""class="material-category-text material-category-book-style">{{ $material->category->category_name }}</a>
                @elseif($material->category_id == 2)
                    <a href=""class="material-category-text material-category-web-style">{{ $material->category->category_name }}</a>
                @elseif($material->category_id == 3)
                    <a href=""class="material-category-text material-category-movie-style">{{ $material->category->category_name }}</a>
                @endif
            </div>
            <div class="material_posted_date">
                <p>{{ $post->created_at->isoFormat('YYYY/MM/DD') }}</p>
            </div>
            <div class="material-title">
                <p> {!! nl2br(e($material->title)) !!}</p>
            </div>
            <div class="material_price">
                <p>¥ {!! nl2br(e($material->price)) !!}</p>
            </div>
            <div class="material_rating">
                @for ($i = 0; $i < $material->rating_id; $i++)
                    <p class="material_rating-bright-star">★</p>
                @endfor
            </div>
            <div class="material_detail">
                <p class="material-detail-title">教材詳細</p>
                <p class="material-thoughts">{!! nl2br(e($material->material_detail)) !!}</p>
            </div> 
            <div class="actions-container">
                @if($isOwner)
                    <div class="action-buttons">
                        <a href="{{ route('materials.edit', $material->id) }}"><img src="{{ asset('assets/images/edit.svg') }}" alt=""></a>
                        <form method="POST" action="{{ route('materials.destroy', $material) }}" class="delete-form" id="delete-form">
                            @method('DELETE')
                            @csrf
                            <button class="delete-button"><img src="{{ asset('assets/images/trash.svg') }}" alt=""></button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="material-info-right">
            <img class="material-book-image" src="{{ asset($material->image_dir) }}" alt="Material Image">
        </div>
    </div>
    <div class="recommended-section">
        <div class="recommended-section-title-wrapper">
            <p class="recommended-section-title">あなたにおすすめ</p>
        </div>
        <div class="recommended-item-list">
        @foreach ($getPersonalizedRecommendations as $material)
            <div class="recommended-item">
                <a class="recommended-item-link" href="{{ route('materials.show', $material->id) }}">
                        <img class="recommended-item-img" src="{{ $material->image_dir }}" alt="">
                        <p class="recommended-item-title">{!! nl2br(e($material->title)) !!}</p>
                </a>
            </div>
        @endforeach
        </div>
    </div>
    <script src="{{ asset('/js/material_detail.js') }}"></script>
    <script>
        const loggedInUserId = @json(auth()->id());
        const followTargetUserId = @json($material->posts[0]->user->id);
        const isFollow = @json($isFollow);
        const discordId = @json($material->posts[0]->user->profile->discord_id);
    </script>
    <script src="{{ asset('/js/follow.js') }}"></script>
    <script src="{{ asset('/js/discord.js') }}"></script>
@endsection

