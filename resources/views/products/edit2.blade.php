@extends('layouts.layout')

@section('title', 'オリプロ投稿内容更新 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_create_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/font.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<form action="{{ route('products.update',['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="layout-top">
        <a href="{{ url()->previous() }}" class="back">←</a>
        <button class="submit" type="submit">更新</button>
    </div>

    <div class="layout-main">
        <div class="post-title">
            <input type="text" id="title" name="title" placeholder="オリプロのタイトルを入力" value="{{ old('title',$product->title) }}" required>
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="post-images">
            <div class="post-images-left">
                @for ($i = 0; $i < 5; $i++)
                    @php
                        $imageModel = $product->images[$i] ?? null;
                        $imagePath = $imageModel->image_dir ?? null;
                    @endphp
                    <div class="image-wrapper" data-index="{{ $i }}">
                        <label for="image-input-{{ $i + 1 }}" class="{{ $i === 0 ? 'main-image' : 'sub-image' }}">
                            <img 
                                src="{{ $imagePath ? asset($imagePath) : asset('assets/images/sample_image.png') }}" 
                                alt="" 
                                class="sample-image preview-target" 
                                id="preview-image-{{ $i }}"
                            >
                            <p>ファイルを選択</p>
                        </label>
                        <input type="file" name="images[]" id="image-input-{{ $i + 1 }}" style="display: none;" onchange="previewImage(event, {{ $i }})">

                        @if ($imageModel)
                            <input type="hidden" name="existing_image_ids[]" id="existing-image-id-{{ $i }}" value="{{ $imageModel->id }}">
                            <input type="hidden" name="deleted_image_ids[]" id="deleted-image-id-{{ $i }}" value="">
                        @endif

                        <button type="button" class="delete-btn" data-index="{{ $i }}">×</button>
                    </div>
                @endfor
            </div>
        </div>

        <div class="post-subtitle">
            <label for="subtitle">オリプロ概要</label>
            <input type="text" id="subtitle" name="subtitle" placeholder="オリプロの概要を一言で紹介" value="{{ old('subtitle',$product->subtitle) }}" required>
            @error('subtitle')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="post-detail">
            <label for="detail">オリプロ詳細</label>
            <textarea id="detail" name="product_detail" placeholder="オリプロのサービス詳細を記載" required>{{ old('product_detail',$product->product_detail) }}</textarea>
            @error('product_detail')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="post-product-url">
            <label for="product-url">サイトURL</label>
            <input type="url" id="product_url" name="product_url" placeholder="オリプロのURL" value="{{ old('product_url',$product->product_url) }}">
        </div>

        <div class="post-github-url">
            <label for="github-url">GithubURL</label>
            <input type="url" id="github_url" name="github_url" placeholder="GithubURL" value="{{ old('github_url',$product->github_url) }}">
        </div>

        <div class="post-element">
            <p>投稿のカテゴリ</p>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-tester" value="need-tester" {{ old('element', $product->element) == 'need-tester' ? 'checked' : '' }}>
                <label for="need-tester">テスター募集中</label>
            </div>
            <div class="custom-radio">
                <input type="radio" name="element" id="need-review" value="need-review" {{ old('element', $product->element) == 'need-review' ? 'checked' : '' }}>
                <label for="need-review">レビュー募集中</label>
            </div>
            @error('radio')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="post-tags" id="tag-container">
            <p>タグ設定(5つまで)</p>
            @php $maxTags = 5; @endphp
            @foreach ($technologieIds as $index => $technologieId)
                <select name="tag_select{{ $index + 1 }}" id="tag_select{{ $index + 1 }}" class="tag-select" {{ $index == 0 ? 'required' : '' }}>
                    <option value="">選択してください</option>
                    @foreach ([1 => 'Ruby', 2 => 'PHP', 3 => 'SQL', 4 => 'HTML', 5 => 'CSS', 6 => 'JavaScript', 7 => 'GitHub', 8 => 'Linux', 9 => 'docker', 10 => 'AWS', 11 => 'その他'] as $id => $name)
                        <option value="{{ $id }}" {{ $technologieId == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            @endforeach
            @for ($i = count($technologieIds) + 1; $i <= $maxTags; $i++)
                <select name="tag_select{{ $i }}" id="tag_select{{ $i }}" class="tag-select">
                    <option value="">選択してください</option>
                    @foreach ([1 => 'Ruby', 2 => 'PHP', 3 => 'SQL', 4 => 'HTML', 5 => 'CSS', 6 => 'JavaScript', 7 => 'GitHub', 8 => 'Linux', 9 => 'docker', 10 => 'AWS', 11 => 'その他'] as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            @endfor
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
<script src="{{ asset('/js/edit_product.js') }}"></script>
@endsection
