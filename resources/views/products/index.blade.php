@extends('layouts.layout')

@section('title', '作品一覧 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_style.css') }}">
@endpush

@section('content')
<main class="products">
    <h1 class="popular-tag-title">人気のタグ</h1>
    <div class="product-menu">
        <div class="popular-tag">
            <a href="#">タグ</a>
            <a href="#">タグ</a>
            <a href="#">タグ</a>
            <a href="#">タグ</a>
            <a href="#">タグ</a>
            <a href="#">タグ</a>
        </div>
        <div class="filter">絞り込み<img src="{{ asset('assets/images/Audio Settings 01.svg') }}" alt="通知"></div>
    </div>
    
    
    <div class="main-contents">
        <h1 class="title">アプレンティス生オリジナルプロダクト</h1>

        <article class="product">
            <div class="article-left">
            <img src="{{ asset('assets/images/Group 226.png') }}" alt="" class="product-image">                <div class="post-user-info">
                    <a href="">
                        <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                        <p class="post-user-name">ユーザー名</p>
                    </a>
                </div>
            </div>
            <div class="article-right">
                <p class="product-element">テスター募集</p>
                <h3 class="product-title">オリプロのタイトル</h3>
                <p class="product-subtitle">オリプロの内容を一言で紹介</p>
                <p class="product-date">2025/1/8</p>
                <ul class="product-tag">
                    <li>タグ</li>
                    <li>タグ</li>
                </ul>

            </div>        
        </article>
    </div>
</main>


@endsection



