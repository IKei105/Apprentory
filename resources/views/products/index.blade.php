@extends('layouts.layout')

@section('title', '作品一覧 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/font.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<main class="products">
    <h1 class="popular-tag-title">人気のタグ</h1>
    <div class="product-menu">
        <div class="popular-tag">
            @if (!empty($popularTags))
                @foreach ($popularTags as $tag)
                <a href="{{ route('products.indexTag', $tag->id) }}">{{ $tag->name }}</a>
                @endforeach
            @endif
        </div>
        <div class="filter">絞り込み<img src="{{ asset('assets/images/Audio Settings 01.svg') }}" alt="通知"></div>
    </div>
    <div>
        <div class="filter">
            <select name="tag" id="technology-tag" class="filter-tag"  >
                <option value="">技術タグ</option>
                <option value="1">Ruby</option>
                <option value="2">PHP</option>
                <option value="3">SQL</option>
                <option value="4">HTML</option>
                <option value="5">CSS</option>
                <option value="6">JavaScript</option>
                <option value="7">GitHub</option>
                <option value="8">Linux</option>
                <option value="9">docker</option>
                <option value="10">AWS</option>
                <option value="11">その他</option>
            </select>
        </div>
    </div>
    <div class="main-contents">
        <h1 class="title">アプレンティス生オリジナルプロダクト</h1>

        
        @foreach ($products as $product)
            <article class="product" data-tag="{{ $product->technologies->pluck('id')->implode(',') }}">
                <div class="article-left">
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset($product->images[0]->image_dir ?? '') }}" alt="" class="product-image">  
                </a>              
                <div class="post-user-info">
                        <a href="" class="post-user">
                            <img class="post-user-image" src="{{ asset(ltrim($product->posts->first()->user->profile->profile_image ?? 'assets/material_images/user_profile_image.png', '/')) }}" alt="M">
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
                            <a href="{{ route('products.indexTag', $technology->id) }}">{{ $technology->name }}</a>
                        @endforeach
                    </div>
                </div>        
            </article>
        @endforeach
    </div>
</main>
<script src="{{ asset('/js/product_index.js') }}"></script>


@endsection



