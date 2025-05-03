@extends('layouts.layout')

@section('title')
    {!! $product->title !!} | Apprentory
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_show_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/font.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="product">
    <div class="layout-top">
        @foreach($product->technologies as $tag)
            <a class="product-tag" href="#">{{ htmlspecialchars($tag->name, ENT_QUOTES, 'UTF-8') }}</a>
        @endforeach
    </div>
    <div class="layout-main">
        <div class="main-left">
            @if($product->images->isNotEmpty())
                <img src="{{ asset(ltrim($product->images->first()->image_dir, '/')) }}" alt="投稿画像" class="product-image">
            @else
                <img src="{{ asset('assets/images/default_image.png') }}" alt="デフォルト画像" class="product-image">
            @endif            
            <div class="product-controler">
                @if (auth()->check() && auth()->id() === $product->profile->user_id)
                <a href="{{ route('products.edit', $product->id) }}" class="edit-button">
                    <img src="{{ asset('assets/images/edit.svg') }}" alt="編集">
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button">
                        <img src="{{ asset('assets/images/trash.svg') }}" alt="削除">
                    </button>
                </form>
                @endif
            </div>
        </div>
        <div class="main-right">
            <div class="main-right-top">
                <p class="product-date">{{ $product->created_at }}</p>
                <p class="product-element {{ $product->element === 'need-tester' ? 'tester' : 'reviewer' }}">
                    {{ $product->element === 'need-tester' ? 'テスター募集' : 'レビュー募集' }}
                </p>
            </div>
            <h3 class="product-title">{{ $product->title }}</h3>
            <p class="product-subtitle">{{ $product->subtitle }}</p>
            <div class="post-user-layout">
                <a href="" class="post-user">
                    <img class="post-user-image" src="{{ asset(ltrim($product->profile->profile_image, '/')) }}" alt="{{ $product->profile->username }}">
                    <p class="post-user-name">{{ $product->profile->username }}</p>
                </a>
                <p class="follow">フォロー</p>                
            </div>
        </div>
    </div>
    <div class="layout-bottom">
        <div class="select-summary"> 
        <p class="product-detail">{!! nl2br(e($product->product_detail)) !!}</p>
        <h3>プロダクトURL</h3>
            <a href="{{ $product->product_url }}" class="product-url">{{ $product->product_url }}</a>
            <h3>GithubURL</h3>
            <a href="{{ $product->github_url }}" class="github-url">{{ $product->github_url }}</a>
            <h3>紹介画像</h3>
            <div class="products-images">
                @foreach($product->images as $image)
                    <img src="{{ asset($image->image_dir) }}" alt="投稿画像">
                @endforeach            
            </div>
        </div>



        <!-- これがコメントを管理するコンテナだお（ ＾ω＾） -->
        <div class="comment-container">
            <div class="select-comment original-product-view">
                <p class="comment-count">{{ $product->comments->count() }}件のコメント</p>
                @foreach ($product->comments as $comment)
                    <div class="comment">
                        <div class="comment-left">
                            <a href="#" class="comment-user-image">
                                <!-- リファクタリングしてくださいね -->
                                <img class="comment-user-image" src="{{ asset($comment->user->profile->profile_image) }}" alt="M">
                            </a>
                        </div>
                        <div class="comment-right">
                            <div class="comment-user-info">
                                <a href="#" class="comment-user-name">{!! nl2br(e($comment->user->profile->username)) !!}</a>
                                <p class="comment-date">{{ $comment->created_at }}</p>
                            </div>
                            <p class="comment-detail">{!! nl2br(e($comment->comment)) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="comment-form-container">
                <form class="comment-form" action="{{ route('comments.store', $product->id) }}" method="POST">
                    @csrf
                    <textarea name="original-product-comment" id="original-product-comment" placeholder="コメントを入力"></textarea>
                    <button class="original-product-comment-button" type="submit">コメントを送信</button>
                </form>
            </div>
        </div>

        <!-- 画像の拡大表示機能 -->
        <!-- Lightbox モーダル -->
        <div id="lightbox-modal" class="hidden">
            <div id="lightbox-image-wrapper">
                <img id="lightbox-image" src="" alt="拡大画像">
            </div>
        </div>
    </div>
    <script src="{{ asset('/js/image_lightbox.js') }}"></script>
    <script src="{{ asset('/js/comment_button_control.js') }}"></script>

@endsection