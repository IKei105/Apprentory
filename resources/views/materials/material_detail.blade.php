@extends('layouts.materials_layout')

@section('title', '教材詳細 | Apprentory')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/material_detail.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
    <div class="material-actions">
        <div class="material-actions-left">
            <a class="posted-profile" href="">
                <img class="posted-userimage" src="" alt="">
                <p class="posted-username">{!! nl2br(e($material->posts[0]->user->profile['username'])) !!}</p>
            </a>
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
<!--         
    <div class="material-info">
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
        <div class="material_url">
            <p>URL</p>
            <a href="{!! nl2br(e($material->material_url)) !!}" target="_blank" rel="noopener noreferrer">{!! nl2br(e($material->material_url)) !!}</a>
        </div>
    </div> -->
    <script src="{{ asset('/js/material_detail.js') }}"></script>
@endsection

