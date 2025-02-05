@extends('layouts.materials_layout')

@section('title', '教材一覧 | Apprentory')

@push('styles')
    <link rel="stylesheet" href="css/menu-select.css">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="css/material_index.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
@endpush
@section('content')
<div class="menu-select">
        <div class="content-switch">
            <button class="recommended-button" id="recommended-button">推奨教材</button>
            <button class="new-button" id="new-button">新着</button>
            <button class="high-rated-button" id="high-rated-button">高評価</button>
        </div>
        <div class="filter">
            <p>絞り込み</p>
        </div>
    </div>
    
    <div class="recommended_materials" id="recommended_materials">
        <h2 class="recommended_materials-title">推奨教材一覧</h2>
        <div class="materials-list">
        <?php $recommendedMaterialCount = 1?>
        @foreach ($recommendedMaterials as $recommendedMaterial)

            <div class="material-item">
            <a href="{{ route('materials.show', $recommendedMaterial->id) }}">
                    <img class="material-book-image" src="{{ $recommendedMaterial->image_dir }}" alt="教材画像"  >
                    <h3 class="material-title">{!! nl2br(e($recommendedMaterial->title)) !!}</h3>
                    <div class="post-likes">
                        <p>♡ {{ $recommendedMaterial->likes_count }}</p>
                    </div>
                </a>
            </div>
            @if ($recommendedMaterialCount >= 10)
                @break
            @else
                <?php $recommendedMaterialCount++; ?>
            @endif
        @endforeach
        </div>
    </div>

    <div class="high-rated-materials" id="high-rated-materials">
        <h1 class="high-rated-title">新着の教材</h1>
        <div class="articles">
            <?php $topRatedMaterialCount = 1; ?>
            @foreach ($latestMaterials as $latestMaterial)
            @php
                $post = $latestMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article">
                    <a href="{{ route('materials.show', $latestMaterial->id) }}">
                        
                        <img class="material-book-image" data-src="{{ asset($latestMaterial->image_dir) }}" alt="" loading="lazy">
                    </a>
                    <div class="article-text-info">
                        <div class="post-user-info">
                            <a href="">
                                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="" loading="lazy">
                                <p class="post-user-name">{{ $post->user->profile->username  }}</p>
                            </a>
                        </div>
                        <a href="{{ route('materials.show', $latestMaterial->id) }}">
                            <h3 class="material-title">{!! nl2br(e($latestMaterial->title)) !!}</h3>
                            <div class="book-rating">
                            @for ($i = 1; $i <= $latestMaterial->rating_id; $i++)
                                <p>★</p>
                            @endfor
                            </div>
                            <div class="material-price">
                                <p>¥</p>
                                <p>{{ $latestMaterial->price }}</p>
                            </div>
                            <div class="post-likes">
                                <p>♡ {{ $latestMaterial->likes_count }}人がいいね</p>
                            </div>
                        </a>
                    </div>    
                </div>
                @if ($topRatedMaterialCount >= 4)
                    @break
                @else
                    <?php $topRatedMaterialCount++; ?>
                @endif
            @endforeach    
        </div>
    </div>

    <div class="high-rated-materials latest-materials" id="latest-materials">
        <h1 class="high-rated-title">評価の高いの教材</h1>
        <div class="articles">
            <?php $topRatedMaterialCount = 1; ?>
            @foreach ($topRatedMaterials as $topRatedMaterial)
            @php
                $post = $topRatedMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article">
                    <a href="{{ route('materials.show', $topRatedMaterial->id) }}">
                        <img class="material-book-image" data-src="{{ asset($topRatedMaterial->image_dir) }}" alt="" loading="lazy">
                    </a>
                    <div class="article-text-info">
                        <div class="post-user-info">
                            <a href="">
                                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="" loading="lazy">
                                <p class="post-user-name">{{ $post->user->profile->username  }}</p>
                            </a>
                        </div>
                        <a href="{{ route('materials.show', $topRatedMaterial->id) }}">
                            <h3 class="material-title">{!! nl2br(e($topRatedMaterial->title)) !!}</h3>
                            <div class="book-rating">
                            @for ($i = 1; $i <= $topRatedMaterial->rating_id; $i++)
                                <p>★</p>
                            @endfor
                            </div>
                            <div class="material-price">
                                <p>¥</p>
                                <p>{{ $topRatedMaterial->price }}</p>
                            </div>
                            <div class="post-likes">
                                <p>♡ {{ $topRatedMaterial->likes_count }}人がいいね</p>
                            </div>
                        </a>
                    </div>    
                </div>
                @if ($topRatedMaterialCount >= 4)
                    @break
                @else
                    <?php $topRatedMaterialCount++; ?>
                @endif
            @endforeach    
        </div>
    </div>

    <!-- 以下はもっと見る、または推奨教材を押した時に表示するようのhtmlです -->
    <div class="recommended_materials_all hidden" id="recommended_materials_all">
        <h2 class="recommended_materials-title">推奨教材一覧</h2>
        <div class="materials-list">
        @foreach ($recommendedMaterials as $recommendedMaterial)
            <div class="material-item">
            <a href="{{ route('materials.show', $recommendedMaterial->id) }}">
                    <img class="material-book-image" data-src="{{ asset($recommendedMaterial->image_dir) }}" alt="教材画像">
                    <h3 class="material-title">{!! nl2br(e($recommendedMaterial->title)) !!}</h3>
                    <div class="post-likes">
                        <p>♡ {{ $recommendedMaterial->likes_count }}</p>
                    </div>
                </a>
            </div>
        @endforeach
        </div>
    </div>

    <!-- もっと見るを押した評価の高い教材 -->
    <div class="high-rated-materials-all hidden" id="high-rated-materials-all">
        <h1 class="high-rated-title">評価の高い教材</h1>
        <div class="articles">
            @foreach ($latestMaterials as $latestMaterial)
            @php
                $post = $latestMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article">
                    <a href="{{ route('materials.show', $latestMaterial->id) }}">
                        <img class="material-book-image" src="{{ asset($latestMaterial->image_dir) }}" alt="">
                    </a>
                    <div class="article-text-info">
                        <div class="post-user-info">
                            <a href="">
                                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                                <p class="post-user-name">{{ $post->user->profile->username  }}</p>
                            </a>
                        </div>
                        <a href="">
                            <h3 class="material-title">{!! nl2br(e($latestMaterial->title)) !!}</h3>
                            <div class="book-rating">
                            @for ($i = 1; $i <= $latestMaterial->rating_id; $i++)
                                <p>★</p>
                            @endfor
                            </div>
                            <div class="material-price">
                                <p>¥</p>
                                <p>{{ $latestMaterial->price }}</p>
                            </div>
                            <div class="post-likes">
                                <p>♡ {{ $latestMaterial->likes_count }}人がいいね</p>
                            </div>
                        </a>
                    </div>    
                </div>
            @endforeach    
        </div>
    </div>

    <!-- もっと見るを押した新着の教材 -->
    <div class="high-rated-materials hidden" id="latest-materials-all">
        <h1 class="high-rated-title">新着の教材</h1>
        <div class="articles">
            @foreach ($topRatedMaterials as $topRatedMaterial)
            @php
                $post = $topRatedMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article">
                    <a href="{{ route('materials.show', $topRatedMaterial->id) }}">
                        <img class="material-book-image" src="{{ asset($topRatedMaterial->image_dir) }}" alt="">
                    </a>
                    <div class="article-text-info">
                        <div class="post-user-info">
                            <a href="">
                                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                                <p class="post-user-name">{{ $post->user->profile->username  }}</p>
                            </a>
                        </div>
                        <a href="">
                            <h3 class="material-title">{!! nl2br(e($topRatedMaterial->title)) !!}</h3>
                            <div class="book-rating">
                            @for ($i = 1; $i <= $topRatedMaterial->rating_id; $i++)
                                <p>★</p>
                            @endfor
                            </div>
                            <div class="material-price">
                                <p>¥</p>
                                <p>{{ $topRatedMaterial->price }}</p>
                            </div>
                            <div class="post-likes">
                                <p>♡ {{ $topRatedMaterial->likes_count }}人がいいね</p>
                            </div>
                        </a>
                    </div>    
                </div>
            @endforeach    
        </div>
    </div>
    <script src="{{ asset('/js/materials_index.js') }}"></script>
    <script src="{{ asset('/js/image_load.js') }}"></script>
@endsection
