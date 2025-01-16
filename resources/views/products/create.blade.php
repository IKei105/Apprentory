@extends('layouts.layout')

@section('title', '新規オリプロ投稿 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_create_style.css') }}">
@endpush
@section('content')

<!-- 本番用のルート（コメントアウト） -->
<!-- <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"> -->

<!-- テスト用のルート -->
<form action="{{ route('products.test-confirmation') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- レイアウト上部 -->
    <div class="layout-top">
        <a href="{{ url()->previous() }}" class="back">←</a>
        <button class=submit type="submit">投稿</button>
    </div>

    <!-- レイアウトメイン部分 -->
    <div class="layout-main">
        <div class="post-title"><!-- タイトル -->
            <input type="text" id="title" name="title" placeholder="オリプロのタイトルを入力" value="{{old('title')}}" required>
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="post-images">
            <div class="post-images-left">
                <label for="images">
                    <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="sample-image">
                    <p>ファイルを選択</p>
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
            <input type="text" id="subtitle" name="subtitle" placeholder="オリプロの概要を一言で紹介" value="{{old('subtitle')}}" required>
            @error('subtitle')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-detail">
            <label for="detail">オリプロ詳細</label>
            <textarea id="detail" name="product_detail" placeholder="オリプロのサービス詳細を記載"  required>{{ old('product_detail') }}</textarea>
            @error('product_detail')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-product-url">
            <label for="product-url">サイトURL</label>
            <input type="url" id="product_url" name="product_url" placeholder="オリプロのURL" >
        </div>
        <div class="post-github-url">
            <label for="github-url">GithubURL</label>
            <input type="url" id="github_url" name="github_url" placeholder="GithubURL" >
        </div>
        <div class="post-element">
            <p>投稿のカテゴリ</p>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-tester" value="need-tester" {{ old('radio') == 'need-tester' ? 'checked' : '' }}required>
                <label for="need-tester">テスター募集中</label>
            </div>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-review" value="need-review" {{ old('radio') == 'need-review' ? 'checked' : '' }}>
                <label for="need-review">レビュー募集中</label>
            </div>
            @error('radio')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-tags" id="tag-container">
            <p>タグ設定(5つまで)</p>
            <select name="tag-select" id="tag_select1" class="tag-select" required>
                <option value="">選択してください</option>
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
            </select>
            @error('tags')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
    </div>
</form>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<script src="{{ asset('/js/tag_selector.js') }}"></script>


@endsection