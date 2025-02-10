@extends('layouts.materials_layout')

@section('title', '教材一覧 | Apprentory')

@push('styles')
    <link rel="stylesheet" href="css/menu-select.css">
    <link rel="stylesheet" href="{{ asset('css/post_material.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="css/material_index.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush
@section('content')
    <div class="post-material-item">
        <form action="{{ route('materials.update', $material->id) }}" method="POST" id="edit-form" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="layout-top">
            <a href="{{ route('materials.index') }}" class="back">←</a>
            <button class="submit" >編集</button>
        </div>
            
            <div class="material-flex-container">
                <div class="post-material-img">
                    <label for="image" class="post-material-image-label">
                        <img class="material-book-sample-image" id="material-book-sample-image" src="{{ asset($material->image_dir) }}" alt="" >
                        <p>カバー画像を変更</p>
                    </label>
                    <input class="post-material-img-upload custom-file-input" type="file" id="image" name="material_image" accept="" >
                    <div class="input-error">
                        <p class="error-img-message" id="image-error">画像を選択してください。</p>
                    </div>
                    
                </div>
                <div class="post-material-title-review-container">
                    <div class="post-material-title">
                        <input class="post-material-title-text"  name="material_title" type="text" class="" placeholder="教材タイトル" value="{!! nl2br(e($material->title)) !!}" />
                    </div>
                    <div class="post-material-thoughts">
                    <textarea
                        name="material_thoughts" 
                        class="post-material-thoughts-text"
                        rows="8"
                        placeholder="教材の感想を入力"  
                    >{!! nl2br(e($material-> material_detail)) !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="post-material-rate-text">
                <label for="post-material-rate-text">評価</label>
                <div class="post-material-rate rate-form">
                    <input id="star5" type="radio" name="material_rate" value="5" <?= $material->rating_id == 5 ? 'checked' : '' ?> >
                    <label for="star5" class="star">★</label>

                    <input id="star4" type="radio" name="material_rate" value="4" <?= $material->rating_id == 4 ? 'checked' : '' ?>>
                    <label for="star4" class="star">★</label>

                    <input id="star3" type="radio" name="material_rate" value="3" <?= $material->rating_id == 3 ? 'checked' : '' ?>>
                    <label for="star3" class="star">★</label>

                    <input id="star2" type="radio" name="material_rate" value="2" <?= $material->rating_id == 2 ? 'checked' : '' ?>>
                    <label for="star2" class="star">★</label>

                    <input id="star1" type="radio" name="material_rate" value="1" <?= $material->rating_id == 1 ? 'checked' : '' ?>>
                    <label for="star1" class="star">★</label>
                </div>
            </div>
            <div class="post-material-price">
                <label for="material_price">価格</label>
                <input 
                    id = "material_price"
                    class="post-material-price-text"
                    type="number" 
                    name="material_price" 
                    placeholder="金額を入力" 
                    min="0" 
                    step="1" 
                    oninput="this.value = this.value.replace(/^0+/, '');"
                    value="{!! nl2br(e($material->price)) !!}"
                />
            </div>
            <div class="post-material-url">
                <label for="url">URL</label>
                <input type="url" id="url" name="material_url" value="{!! nl2br(e($material->material_url)) !!}">
            </div>
            <!-- これから下はタグ数に依存するので変更する必要あり -->
            <div class="post-material-tags" id="post-material-tags">
                <p>タグ設定(5つまで)</p>
                <?php $foreachCount = 1 ?>
                @foreach ($technologieIds as $technologieId)
                    <select name="select<?= $foreachCount ?>" id="select<?= $foreachCount ?>" class="post-material-tags-select" <?= $foreachCount == 1 ? 'required' : '' ?>  >
                        <option value="">選択してください</option>
                        <option value="1" <?= $technologieId == 1 ? 'selected' : '' ?> >Ruby</option>
                        <option value="2" <?= $technologieId == 2 ? 'selected' : '' ?> >PHP</option>
                        <option value="3" <?= $technologieId == 3 ? 'selected' : '' ?> >SQL</option>
                        <option value="4" <?= $technologieId == 4 ? 'selected' : '' ?> >HTML</option>
                        <option value="5" <?= $technologieId == 5 ? 'selected' : '' ?> >CSS</option>
                        <option value="6" <?= $technologieId == 6 ? 'selected' : '' ?> >JavaScript</option>
                        <option value="7" <?= $technologieId == 7 ? 'selected' : '' ?> >GitHub</option>
                        <option value="8" <?= $technologieId == 8 ? 'selected' : '' ?> >Linux</option>
                        <option value="9" <?= $technologieId == 9 ? 'selected' : '' ?> >docker</option>
                        <option value="10" <?= $technologieId == 10 ? 'selected' : '' ?> >AWS</option>
                        <option value="11" <?= $technologieId == 11 ? 'selected' : '' ?> >その他</option>
                    </select>
                    <?php $foreachCount++ ?>
                @endforeach
                <?php $countTechnologieIds = count($technologieIds) ?>
                @if($countTechnologieIds < 5)
                <?php $countTechnologieIds++ ?>
                    <select name="select<?= $countTechnologieIds ?>" id="select<?= $countTechnologieIds ?>" class="post-material-tags-select latest">
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
                @endif
            </div>
        </form>
        <script src="{{ asset('/js/edit_material.js') }}"></script>
    </div>
@endsection
