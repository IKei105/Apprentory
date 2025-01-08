@extends('layouts.layout')

@section('title', '作品詳細 | Apprentory')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products_show_style.css') }}">
@endpush

@section('content')
<div class="product">
    <div class="layout-top">
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
        <a class="product-tag" href="#">タグ</a>
    </div>
    <div class="layout-main">
        <div class="main-left">
            <img src="{{ asset('assets/images/sample_image.png') }}" alt="" class="product-image">
        </div>
        <div class="main-right">
            <div class="main-right-top">
                <p class="product-date">{{ $product->created_at }}</p>
                <p class="product-element">{{ $product->element }}</p>
            </div>
            <h3 class="product-title">{{ $product->title }}</h3>
            <p class="product-subtitle">{{ $product->subtitle }}</p>
            <div class="post-user-layout">
                <a href="" class="post-user">
                    <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="M">
                    <p class="post-user-name">ユーザー名</p>
                </a>
                <p class="follow">フォロー</p>                
            </div>
        </div>
    </div>
    <div class="layout-bottom">
        <img src="{{ asset('assets/images/edit.svg') }}" alt="" class="edit-button">
        <img src="{{ asset('assets/images/trash.svg') }}" alt="" class="trash-button">
    </div>
@endsection