@extends('layouts.materials_layout')

@section('title', '教材一覧 | Apprentory')

@push('styles')
    <link rel="stylesheet" href="css/menu-select.css">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="css/material_index.css">
    <link rel="stylesheet" href="{{ asset('css/products_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search_result.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush
@section('content')
<div class="menu-select">
        <div class="content-switch">
            <button class="recommended-button material-button" id="recommended-button">教材</button>
            <button class="high-rated-button original-product-button" id="high-rated-button">オリプロ</button>
        </div>
    </div>
<!-- 検索する時に教材を表示していたら教材を表示するようにする -->
<div class="high-rated-materials hidden" id="latest-materials-all">
        <h1 class="high-rated-title">教材検索結果({{ $materialsCount }}件)</h1>
        <div class="articles">
            @foreach ($materials as $material)
            @php
                $post = $material->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article material" data-tags="{{ $material->technologies->pluck('id')->implode(',') }}">
                    <a href="{{ route('materials.show', $material->id) }}">
                        <img class="material-book-image" src="{{ asset($material->image_dir) }}" alt="">
                    </a>
                    <div class="article-text-info">
                        <div class="post-user-info">
                            <a href="">
                                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                                <p class="post-user-name">{{ $post->user->profile->username  }}</p>
                            </a>
                        </div>
                        <a href="">
                            <h3 class="material-title">{!! nl2br(e(mb_strimwidth($material->title, 0, 40, '...'))) !!}</h3>
                            <div class="book-rating">
                            @for ($i = 1; $i <= $material->rating_id; $i++)
                                <p>★</p>
                            @endfor
                            </div>
                            <div class="material-price">
                                <p>¥</p>
                                <p>{{ $material->price }}</p>
                            </div>
                            <div class="post-likes">
                                <p>♡ {{ $material->likes_count }}人がいいね</p>
                            </div>
                        </a>
                        @foreach ($material->technologies as $tech)
                            <a href="" class="technology-tag">{{ $tech->name }}</a>
                        @endforeach
                    </div>    
                </div>
            @endforeach    
        </div>
</div>
<div class="main-contents hidden">
    <h1 class="title">アプレンティス生オリジナルプロダクト検索結果({{ $productsCount }})</h1>
    @foreach ($products as $product)
        <article class="product">
            <div class="article-left">
            <a href="{{ route('products.show', $product->id) }}">
                <img src="{{ asset($product->images[0]->image_dir ?? '') }}" alt="" class="product-image search-product-img">  
            </a>              
            <div class="post-user-info">
                    <a href="" class="post-user">
                        <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                        <p class="post-user-name">{!! nl2br(e($product->posts->first()->user->profile->username ?? '未設定')) !!}
                        </p>
                    </a>
                </div>
            </div>
            <div class="article-right">
                <p class="product-element">
                    @if ($product->element === 'need-tester')
                        テスター募集
                    @elseif ($product->element === 'need-review')
                        レビュー募集
                    @else
                        未定義
                    @endif
                </p>
                <a href="{{ route('products.show', $product->id) }}">
                    <h3 class="product-title">{!! nl2br(e($product->title ?? '未設定')) !!}</h3>
                    <p class="product-subtitle">{!! nl2br(e($product->subtitle ?? '未設定')) !!}</p>
                    {{-- <p class="product-date">{{ $product->created_at->isoFormat('YYYY/MM/DD') }}</p> --}}
                </a>   
                <div class="product-tag">
                    @foreach ($product->technologies as $technology)
                        <a href="">{{ $technology->name }}</a>
                    @endforeach
                </div>
            </div>        
        </article>
    @endforeach
</div>
<script src="{{ asset('/js/search.js') }}"></script>
    @endsection