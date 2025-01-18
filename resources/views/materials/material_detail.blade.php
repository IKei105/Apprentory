<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <link rel="stylesheet" href="{{ asset('css/material_detail.css') }}">
    <title>推奨教材ページ</title>
</head>
<body>
    <div class="material-book-image">
        <img src="{{ asset($material->image_dir) }}" alt="Material Image">
        </div>
    <div class="material-info">
        <!-- 投稿ユーザーの記事だったら -->
        <div class="action-buttons">
            <button><img src="{{ asset('assets/images/trash.svg') }}" alt=""></button>
            <a href="{{ route('materials.edit', $material->id) }}"><img src="{{ asset('assets/images/edit.svg') }}" alt=""></a>
        </div>
        <div class="material_posted_date">
        <p>{{ $post->created_at->isoFormat('YYYY/MM/DD') }}</p>
        </div>
        <div class="material-title">
            <p> {!! nl2br(e($material->title)) !!}</p>
        </div>
        <div class="material_price">
            <p>¥ {!! nl2br(e($material->price)) !!}</p>
        </div>
        <div class="material_rating">
            @for ($i = 0; $i < $material->rating_id; $i++)
                <p class="material_rating-bright-star">★</p>
            @endfor
        </div>
        <div class="material_detail">
            <p class="material-detail-title">教材詳細</p>
            <p class="material-thoughts">{!! nl2br(e($material->material_detail)) !!}</p>
        </div> 
        <div class="material_url">
            <p>URL</p>
            <a href="">{!! nl2br(e($material->material_url)) !!}</a>
        </div>
    </div>
</body>