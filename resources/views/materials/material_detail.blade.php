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
            <img src="{{ asset('assets/material_images/sample2.png') }}" alt="">
        </div>
    <div class="material-info">
        <div class="action-buttons">
            <button><img src="{{ asset('assets/images/trash.svg') }}" alt=""></button>
            <button><img src="{{ asset('assets/images/edit.svg') }}" alt=""></button>
        </div>
        <div class="material_posted_date">
        <p>{{ $posts[0]->created_at->isoFormat('YYYY/MM/DD') }}</p>
        </div>
        <div class="material-title">
            <p>{{ $material->title; }}</p>
        </div>
        <div class="material_price">
            <p>{{ $material->price }}</p>
        </div>
        <div class="material_rating">
            <p>★★★★★</p>
        </div>
        <div class="material_detail">
            <p class="material-detail-title">教材詳細</p>
            <p class="material-thoughts">感想です感想です感想です感想です感想です感想です感想です感想です感想です感想です感想です感想です感想です感想です</p>
        </div> 
        <div class="material_url">
            <p>URL</p>
            <a href="">urlurlurlurlurlurlurlurlurlurlurlurl</a>
        </div>
    </div>
</body>