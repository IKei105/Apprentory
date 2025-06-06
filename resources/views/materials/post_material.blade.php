@extends('layouts.materials_layout')

@section('title', '教材投稿 | Apprentory')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post_material.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush
@section('content')

<div class="post-material-item">
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" id="post-material">
        @csrf
        <div class="layout-top">
            <a href="{{ route('materials.index') }}" class="back">←</a>
            <button class="submit" id="form-submit">投稿</button>
        </div>
            
            <div class="material-flex-container">
                <div class="post-material-img">
                    <label for="image" class="post-material-image-label">
                        <img class="material-book-sample-image" id="material-book-sample-image" src="{{ session('material_image', asset('assets/images/sample_material_image.jpg')) }}" alt="" >
                        <p>カバー画像を変更</p>
                    </label>
                    <input class="post-material-img-upload custom-file-input" type="file" id="image" name="material-image" accept="" >
                    <div class="input-error">
                        <p class="error-img-message" id="image-error">画像を選択してください。</p>
                    </div>
                    
                </div>
                <div class="post-material-title-review-container">
                    <div class="post-material-title">
                        <input class="post-material-title-text"  name="material-title" type="text" class="" placeholder="教材タイトル" value="{{ old('material-title') }}" required />
                        @error('material-title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="post-material-thoughts">
                    <textarea
                        name="material-thoughts" 
                        class="post-material-thoughts-text"
                        rows="8"
                        placeholder="教材の感想を入力"
                        required
                    ></textarea>
                    </div>
                </div>
            </div>
            <div class="post-material-rate-text">
                <label for="post-material-rate-text">評価</label>
                <div class="post-material-rate rate-form">
                    <input id="star5" type="radio" name="material-rate" value="5" required>
                    <label for="star5" class="star">★</label>
                    <input id="star4" type="radio" name="material-rate" value="4">
                    <label for="star4" class="star">★</label>
                    <input id="star3" type="radio" name="material-rate" value="3">
                    <label for="star3" class="star">★</label>
                    <input id="star2" type="radio" name="material-rate" value="2">
                    <label for="star2" class="star">★</label>
                    <input id="star1" type="radio" name="material-rate" value="1">
                    <label for="star1" class="star">★</label>
                </div>
            </div>            
            <div class="post-material-price">
                <label for="material_price">価格</label>
                <input 
                    id = "material_price"
                    class="post-material-price-text"
                    type="number" 
                    name="material-price" 
                    placeholder="金額を入力" 
                    min="0" 
                    step="1" 
                    oninput="this.value = this.value.replace(/^0+/, '');"
                />
                <!-- <div class="custom-radio material-price-radio-button">
                    <input type="radio" name="is_free" id="material-price-free-button" value="0">
                    <label class="material-price-free-button-label" for="material-price-free-button">無料</label>
                </div> -->
                <div>
                    <label class="custom-radio material-price-radio-button">
                        <input class="material-free-button" type="checkbox" name="is_free" id="material-price-free-button" value="0" />
                        無料
                    </label>
                </div>
            </div>
            <div class="post-material-url">
                <label for="url">URL</label>
                <input type="url" id="url" name="material-url">
            </div>
            <div class="post-material-tags" id="post-material-tags">
                <p>タグ設定(5つまで)</p>
                    <select name="select1" id="select1" class="post-material-tags-select" required>
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
                        <option value="11">その他</option>
                    </select>
            </div>
            <div class="post-material-tags" id="material-category">
                <p>カテゴリー選択</p>
                    <select name="material-category" id="material-category" class="post-material-tags-select" required>
                        <option value="">選択してください</option>
                        <option value="1">書籍</option>
                        <option value="2">webサイト・オンライン記事</option>
                        <option value="3">動画口座・オンラインコース</option>
                    </select>
            </div>
        </form>
        <script src="{{ asset('/js/post_material.js') }}"></script>
@endsection
