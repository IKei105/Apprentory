@extends('layouts.layout')

@section('title', '新規オリプロ投稿 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_create_style.css') }}">
@endpush
@section('content')
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- レイアウト上部 -->
    <div class="layout-top">
        <a href="" class="back">←</a>
        <button class=submit type="submit">投稿</button>
    </div>

    <!-- レイアウトメイン部分 -->
    <div class="lauout-main">
        <div class="post-title"><!-- タイトル -->
            <input type="text" id="title" name="title" placeholder="オリプロのタイトルを入力">
        </div>

        <div class="post-images">
            <div class="post-images-left">
                <label for="images">
                    <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="sample-image">
                </label>
                <input type="file" id="images" name="images[]" multiple>
            </div>
            <div class="post-images-right">
                <!-- 投稿した画像のプレビュー表示(javascriptで実装)　-->
                <div class="post-images-preview"></div>
                <!-- 消去ボタンをどこかに作る -->
            </div>
        </div>
        <div class="post-subtitle">
            <label for="subtitle">オリプロ概要</label>
            <input type="text" id="subtitle" name="subtitle" placeholder="オリプロの概要を一言で紹介" >
        </div>
        <div class="post-detail">
            <label for="detail">オリプロ概要</label>
            <input type="text" id="detail" name="detail" placeholder="オリプロのサービス詳細を記載" >
        </div>
        <div class="post-product-url">
            <label for="product-url">サイトURL</label>
            <input type="url" id="product-url" name="product-url" placeholder="オリプロのURL" >
        </div>
        <div class="post-github-url">
            <label for="github-url">サイトURL</label>
            <input type="url" id="github-url" name="github-url" placeholder="GithubURL" >
        </div>
        <div class="post-element">
            <p>投稿のカテゴリ</p>
            <input type="radio" name="radio" id="radio"><label for="need-tester">テスター募集中</label>
            <input type="radio" name="radio" id="radio"><label for="need-review">レビュー募集中</label>
        </div>
        <div class="post-tag">
            <label for="tags">タグ設定 (5つまで)</label>
            <select id="tag" name="tag">
                <option value="PHP">PHP</option>
                <option value="Laravel">Laravel</option>
            </select>
        </div>
    </div>
</form>


@endsection