@extends('layouts.layout')

@section('title', '新規オリプロ投稿 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_create_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/font.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush
@section('content')


<form id="productform" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- レイアウト上部 -->
    <div class="layout-top">
        <div class="top-content">
            <a href="{{ url()->previous() }}" class="back">←</a>
            <button class=submit type="submit" id="post-product">投稿</button>
        </div>
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
            <div class="post-images-left" id="image-upload-area" data-sample-image="{{ asset('assets/images/sample_image.png') }}">
                <!--以下js -->
            </div>
            <div class="post-images-preview">
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
                <input type="radio" name="element" id="need-tester" value="need-tester" required>
                <label for="need-tester">テスター募集中</label>
            </div>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-review" value="need-review" >
                <label for="need-review">レビュー募集中</label>
            </div>
            @error('radio')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-tags" id="tag-container">
            <p>タグ設定(5つまで)</p>
            <select name="tag_select1" id="tag_select1" class="tag-select" required>
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
@push('scripts')
    <script src="{{ asset('/js/tag_selector.js') }}"></script>
    <script src="{{ asset('/js/image_preview2.js') }}"></script>
    <script src="{{ asset('/js/create_product.js') }}"></script>
@endpush
@endsection