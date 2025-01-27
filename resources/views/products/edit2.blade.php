@extends('layouts.layout')

@section('title', 'オリプロ投稿内容更新 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_create_style.css') }}">
@endpush
@section('content')


<form action="{{ route('products.update',['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- レイアウト上部 -->
    <div class="layout-top">
        <a href="{{ url()->previous() }}" class="back">←</a>
        <button class=submit type="submit">更新</button>
    </div>

    <!-- レイアウトメイン部分 -->
    <div class="layout-main">
        <div class="post-title"><!-- タイトル -->
            <input type="text" id="title" name="title" placeholder="オリプロのタイトルを入力" value="{{old('title',$product->title)}}" required>
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="post-images">
            <div class="post-images-left">
                <label for="image-input" id="image-label">
                    <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="sample-image">
                    <p>ファイルを選択</p>
                </label>
                <input type="file" id="image-input" name="images[]" style="display: none;" multiple>
            </div>    
            <div class="post-images-right">
                <!-- 投稿した画像のプレビュー表示(javascriptで実装)　-->
                <div class="post-images-preview">

                @foreach ($product->images as $image)
                    <div class="image-wrapper">
                        <img src="{{ $image->image_dir }}" class="preview-image" alt="Uploaded Image">
                        <!-- 消去ボタン -->
                        <button type="button" class="delete-btn" data-image-id="{{ $image->id }}">×</button>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <div class="post-subtitle">
            <label for="subtitle">オリプロ概要</label>
            <input type="text" id="subtitle" name="subtitle" placeholder="オリプロの概要を一言で紹介" value="{{old('subtitle',$product->subtitle)}}" required>
            @error('subtitle')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-detail">
            <label for="detail">オリプロ詳細</label>
            <textarea id="detail" name="product_detail" placeholder="オリプロのサービス詳細を記載"  required>{{ old('product_detail',$product->product_detail) }}</textarea>
            @error('product_detail')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-product-url">
            <label for="product-url">サイトURL</label>
            <input type="url" id="product_url" name="product_url" placeholder="オリプロのURL" value="{{old('product_url',$product->product_url)}}">
        </div>
        <div class="post-github-url">
            <label for="github-url">GithubURL</label>
            <input type="url" id="github_url" name="github_url" placeholder="GithubURL" value="{{old('github_url',$product->github_url)}}">
        </div>
        <div class="post-element">
            <p>投稿のカテゴリ</p>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-tester" value="need-tester" {{ old('element', $product->element) === 'need-tester' ? 'checked' : '' }}required>
                <label for="need-tester">テスター募集中</label>
            </div>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-review" value="need-review" {{ old('element', $product->element) === 'need-review' ? 'checked' : '' }}>
                <label for="need-review">レビュー募集中</label>
            </div>
            @error('radio')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="post-tags" id="tag-container">
            <p>タグ設定(5つまで)</p>
            
            @foreach ($product->technologies as $index => $technology)
                <select name="tag_select{{ $index + 1 }}" id="tag_select{{ $index + 1 }}" class="tag-select">
                    <option value="">選択してください</option>
                    <option value="1" {{ old("tag_select$index", $technology->id) == 1 ? 'selected' : '' }}>Ruby</option>
                    <option value="2" {{ old("tag_select$index", $technology->id) == 2 ? 'selected' : '' }}>PHP</option>
                    <option value="3" {{ old("tag_select$index", $technology->id) == 3 ? 'selected' : '' }}>SQL</option>
                    <option value="4" {{ old("tag_select$index", $technology->id) == 4 ? 'selected' : '' }}>HTML</option>
                    <option value="5" {{ old("tag_select$index", $technology->id) == 5 ? 'selected' : '' }}>CSS</option>
                    <option value="6" {{ old("tag_select$index", $technology->id) == 6 ? 'selected' : '' }}>JavaScript</option>
                    <option value="7" {{ old("tag_select$index", $technology->id) == 7 ? 'selected' : '' }}>GitHub</option>
                    <option value="8" {{ old("tag_select$index", $technology->id) == 8 ? 'selected' : '' }}>Linux</option>
                    <option value="9" {{ old("tag_select$index", $technology->id) == 9 ? 'selected' : '' }}>docker</option>
                    <option value="10" {{ old("tag_select$index", $technology->id) == 10 ? 'selected' : '' }}>AWS</option>
                    <!-- <option value="">選択してください</option>
                    <option value="1">Ruby</option>
                    <option value="2">PHP</option>
                    <option value="3">SQL</option>
                    <option value="4">HTML</option>
                    <option value="5">CSS</option>
                    <option value="6">JavaScript</option>
                    <option value="7">GitHub</option>
                    <option value="8">Linux</option>
                    <option value="9">docker</option>
                    <option value="10">AWS</option> -->
                </select>
            @endforeach            
            @error('tag_select1')
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
<script src="{{ asset('/js/image_preview.js') }}"></script>

@endsection