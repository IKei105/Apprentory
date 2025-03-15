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
            <button class="new-button" id="new-button">高評価</button>
            <button class="high-rated-button" id="high-rated-button">新着</button>
        </div>
        <div class="filter-menu">
            <div class="filter">
                <select name="tag" id="tag" class="filter-tag"  >
                    <option value="">技術タグ</option>
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
            <div class="filter">
                <select name="tag" id="tag" class="filter-tag">
                    <option value="">カテゴリー</option>
                    <option value="1">書籍</option>
                    <option value="2">オンライン記事</option>
                    <option value="3">動画教材</option>
                </select>
            </div>
        </div>
    </div>
    <div class="recommended_materials" id="recommended_materials">
        <h2 class="recommended_materials-title">推奨教材一覧</h2>
        <div class="materials-list">
        <?php $recommendedMaterialCount = 1?>
        @foreach ($officialRecommendedMaterials as $recommendedMaterial)
            <div class="material-item recommended-material" data-tags="{{ $recommendedMaterial->technologies->pluck('id')->implode(',') }}">
                <a href="{{ route('materials.show', $recommendedMaterial->id) }}">
                    <?php sleep(0.3); ?>
                        <img class="material-book-image" src="{{ $recommendedMaterial->image_dir }}" alt="教材画像"  >
                        <?php sleep(0.3); ?>
                        <h3 class="material-title">{!! nl2br(e($recommendedMaterial->title)) !!}</h3>
                        <div class="post-likes">
                            <p>♡ {{ $recommendedMaterial->likes_count }}</p>
                        </div>
                        @foreach ($recommendedMaterial->technologies as $tech)
                            <a href="" class="technology-tag">{{ $tech->name }}</a>
                        @endforeach
                    </a>
                </div>
                @if ($recommendedMaterialCount >= 6)
                    @break
                @else
                    <?php $recommendedMaterialCount++; ?>
                @endif
        @endforeach
        </div>
    </div>
    <!--------------------
            新着の教材
    ---------------------->
    <div class="high-rated-materials" id="high-rated-materials">
        <h1 class="high-rated-title">新着の教材</h1>
        <div class="articles">
            <?php $topRatedMaterialCount = 1; ?>
            @foreach ($latestMaterials as $latestMaterial)
            @php
                $post = $latestMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <?php sleep(0.3); ?>
                <div class="article latest-material {{ $topRatedMaterialCount > 4 ? 'hidden' : '' }}" data-tags="{{ $latestMaterial->technologies->pluck('id')->implode(',') }}">
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
                            <h3 class="material-title">{!! nl2br(e(mb_strimwidth($latestMaterial->title, 0, 40, '...'))) !!}</h3>
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
                        @foreach ($latestMaterial->technologies as $tech)
                            <a href="" class="technology-tag">{{ $tech->name }}</a>
                        @endforeach
                    </div>    
                </div>
                <?php $topRatedMaterialCount++; ?> 
            @endforeach    
        </div>
    </div>
    <!-------------------
        評価の高い教材
    -------------------->
    <div class="high-rated-materials " id="latest-materials">
        <h1 class="high-rated-title">評価の高い教材</h1>
        <div class="articles">
            <?php $topRatedMaterialCount = 1; ?>
            @foreach ($topRatedMaterials as $topRatedMaterial)
            @php
                $post = $topRatedMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article high-rate-material {{ $topRatedMaterialCount > 4 ? 'hidden' : '' }}" data-tags="{{ $topRatedMaterial->technologies->pluck('id')->implode(',') }}">
                    
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
                            <h3 class="material-title">{!! nl2br(e(mb_strimwidth($topRatedMaterial->title, 0, 40, '...'))) !!}</h3>
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
                        @foreach ($topRatedMaterial->technologies as $tech)
                            <a href="" class="technology-tag">{{ $tech->name }}</a>
                        @endforeach
                    </div>    
                </div>
                    <?php $topRatedMaterialCount++; ?>
            @endforeach    
        </div>
    </div>
    <!-- 以下はもっと見る、または推奨教材を押した時に表示するようのhtmlです -->
    <div class="recommended_materials_all hidden" id="recommended_materials_all">
        <h2 class="recommended_materials-title">推奨教材一覧</h2>
        <div class="materials-list">
        @foreach ($officialRecommendedMaterials as $recommendedMaterial)
            <div class="recommended-material-all material-item material" data-tags="{{ $recommendedMaterial->technologies->pluck('id')->implode(',') }}">
            <a href="{{ route('materials.show', $recommendedMaterial->id) }}">
                    <img class="material-book-image" data-src="{{ asset($recommendedMaterial->image_dir) }}" alt="教材画像">
                    <h3 class="material-title">{!! nl2br(e(mb_strimwidth($recommendedMaterial->title, 0, 40, '...'))) !!}</h3>
                    <div class="post-likes">
                        <p>♡ {{ $recommendedMaterial->likes_count }}</p>
                    </div>
                </a>
                @foreach ($recommendedMaterial->technologies as $tech)
                    <a href="" class="technology-tag">{{ $tech->name }}</a>
                @endforeach
            </div>
        @endforeach
        </div>
    </div>
    <!-- もっと見るを押した評価の高い教材 -->
    <div class="high-rated-materials-all hidden" id="high-rated-materials-all">
        <h1 class="high-rated-title">新着の教材</h1>
        <div class="articles">
            @foreach ($latestMaterials as $latestMaterial)
            @php
                $post = $latestMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article latest-materials" data-tags="{{ $latestMaterial->technologies->pluck('id')->implode(',') }}">
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
                            <h3 class="material-title">{!! nl2br(e(mb_strimwidth($latestMaterial->title, 0, 40, '...'))) !!}</h3>
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
                        @foreach ($latestMaterial->technologies as $tech)
                            <a href="" class="technology-tag">{{ $tech->name }}</a>
                        @endforeach
                    </div>    
                </div>
            @endforeach    
        </div>
    </div>
    <!-- もっと見るを押した新着の教材 -->
    <div class="high-rated-materials hidden" id="latest-materials-all">
        <h1 class="high-rated-title">評価の高い教材</h1>
        <div class="articles">
            @foreach ($topRatedMaterials as $topRatedMaterial)
            @php
                $post = $topRatedMaterial->posts->first(); // 最初の投稿を取得
            @endphp
                <div class="article high-rate-materials material" data-tags="{{ $topRatedMaterial->technologies->pluck('id')->implode(',') }}">
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
                            <h3 class="material-title">{!! nl2br(e(mb_strimwidth($topRatedMaterial->title, 0, 40, '...'))) !!}</h3>
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
                        @foreach ($topRatedMaterial->technologies as $tech)
                            <a href="" class="technology-tag">{{ $tech->name }}</a>
                        @endforeach
                    </div>    
                </div>
            @endforeach    
        </div>
    </div>
    <script src="{{ asset('/js/materials_index.js') }}">
    </script>
    <script src="{{ asset('/js/image_load.js') }}"></script>
@endsection
