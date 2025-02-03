@extends('layouts.layout')

@section('title', '作品詳細 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_show_style.css') }}">
<link rel="stylesheet" href="{{ asset('css/font.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="product">
    <div class="layout-top">
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
    </div>
    <div class="rayout-main">
        <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="product-image">
        <div class="main-right">
        <p class="product-date">{{ $product->created_at }}</p>
        <p class="product-element">{{ $product->element }}</p>
        <h3 class="product-title">{{ $product->title }}</h3>
        <p class="product-subtitle">{{ $product->subtitle }}</p>
        <div class="post-user-rayout">
            <a href="" class="post-user">
                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                <p class="post-user-name">ユーザー名</p>
            </a>
            <p class="follow">フォロー</p>
        </div>
    </div>
    <div class="rayout-bottom">
        <img src="{{ asset('assets/images/edit.svg') }}" alt="" class="edit-button">
        <img src="{{ asset('assets/images/trash.svg') }}" alt="" class="trash-button">
    </div>
@endsection