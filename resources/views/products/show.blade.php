@extends('layouts.layout')

@section('title', '作品詳細 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_show_style.css') }}">
@endpush

@section('content')
<div class="product">
    <div class="layout-top">
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
    </div>
    <div class="layout-main">
        <div class="main-left">
            <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="product-image">
            <div class="product-controler">
                <img src="{{ asset('assets/images/edit.svg') }}" alt="" class="edit-button">
                <img src="{{ asset('assets/images/trash.svg') }}" alt="" class="trash-button">
            </div>
        </div>
        <div class="main-right">
            <div class="main-right-top">
                <p class="product-date">{{ $product->created_at }}</p>
                <p class="product-element">{{ $product->element }}</p>
            </div>
            <h3 class="product-title">{{ $product->title }}</h3>
            <p class="product-subtitle">{{ $product->subtitle }}</p>
            <div class="post-user-layout">
                <a href="" class="post-user">
                    <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    <p class="post-user-name">ユーザー名</p>
                </a>
                <p class="follow">フォロー</p>                
            </div>
        </div>
    </div>
    <div class="layout-bottom">
        <div class="select-summary"> 
            <p class="product-detail">{{ $product->product_detail }}</p>
            <h3>プロダクトURL</h3>
            <a href="{{ $product->product_url }}" class="product-url">{{ $product->product_url }}</a>
            <h3>GithubURL</h3>
            <a href="{{ $product->github_url }}" class="github-url">{{ $product->github_url }}</a>
            <h3>紹介画像</h3>
            <div class="products-images">
                <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="product-image1">
                <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="product-image2">
                <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="product-image3">
            </div>
        </div>
        <div class="select-comment">
            <p class="comment-count">〇〇件のコメント</p>
            <div class="comment">
                <div class="comment-left">
                    <a href="#" class="comment-user-image">
                        <img class="comment-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    </a>
                </div>
                <div class="comment-right">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">ユーザー名</a>
                        <p class="comment-date">2025/12/22</p>
                    </div>
                    <p class="comment-detail">コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
            </div>
            <div class="comment">
                <div class="comment-left">
                    <a href="#" class="comment-user-image">
                        <img class="comment-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    </a>
                </div>
                <div class="comment-right">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">ユーザー名</a>
                        <p class="comment-date">2025/12/22</p>
                    </div>
                    <p class="comment-detail">コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
            </div>
            <div class="comment">
                <div class="comment-left">
                    <a href="#" class="comment-user-image">
                        <img class="comment-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    </a>
                </div>
                <div class="comment-right">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">ユーザー名</a>
                        <p class="comment-date">2025/12/22</p>
                    </div>
                    <p class="comment-detail">コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
            </div>
            <div class="comment">
                <div class="comment-left">
                    <a href="#" class="comment-user-image">
                        <img class="comment-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    </a>
                </div>
                <div class="comment-right">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">ユーザー名</a>
                        <p class="comment-date">2025/12/22</p>
                    </div>
                    <p class="comment-detail">コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
            </div>
            <div class="comment">
                <div class="comment-left">
                    <a href="#" class="comment-user-image">
                        <img class="comment-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    </a>
                </div>
                <div class="comment-right">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">ユーザー名</a>
                        <p class="comment-date">2025/12/22</p>
                    </div>
                    <p class="comment-detail">コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
            </div>
            <div class="comment">
                <div class="comment-left">
                    <a href="#" class="comment-user-image">
                        <img class="comment-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    </a>
                </div>
                <div class="comment-right">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">ユーザー名</a>
                        <p class="comment-date">2025/12/22</p>
                    </div>
                    <p class="comment-detail">コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
            </div>

        </div>

    </div>
@endsection