<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <link rel="stylesheet" href="css/material_index.css">
    <link rel="stylesheet" href="css/menu-select.css">
    <title>教材一覧ページ</title>
</head>
<body>
    <div class="menu-select">
        <div class="content-switch">
            <button class="recommended-button">推奨教材</button>
            <button class="new-button">新着</button>
            <button class="high-rated-button">高評価</button>
        </div>
        <div class="filter">
            <p>絞り込み</p>
        </div>
    </div>
    <div class="recommended_materials">
    <h2 class="recommended_materials-title">推奨教材一覧</h2>
        <div class="materials-list">
        <?php $recommendedMaterialCount = 1?>
        @foreach ($recommendedMaterials as $recommendedMaterial)
            <div class="material-item">
                <a href="">
                    <img class="material-book-image" src="{{ asset($recommendedMaterial->image_dir) }}" alt="教材画像">
                    <h3 class="material-title">{!! nl2br(e($recommendedMaterial->title)) !!}</h3>
                    <div class="post-likes">
                        <p>♡ {{ $recommendedMaterial->likes_count }}</p>
                    </div>
                </a>
            </div>
            @if ($recommendedMaterialCount >= 5)
                @break
            @else
                <?php $recommendedMaterialCount++; ?>
            @endif
        @endforeach
        </div>
    </div>
    <div class="high-rated-materials">
        <h1 class="high-rated-title">評価の高い教材</h1>
        <div class="articles">
            <?php $topRatedMaterialCount = 1; ?>
            @foreach ($topRatedMaterials as $topRatedMaterial)
                <div class="article">
                    <img class="material-book-image" src="{{ asset($topRatedMaterial->image_dir) }}" alt="">
                    <div class="article-text-info">
                        <div class="post-user-info">
                            <a href="">
                                <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                                <p class="post-user-name">ポストユーザー名</p>
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
                                <p>♡ {{ $topRatedMaterial->likeCount }}人がいいね</p>
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

            
            
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
        </div>
    </div>
    <div class="high-rated-materials">
        <h1 class="high-rated-title">新着の教材</h1>
        <div class="articles">
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
            <div class="article">
                <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <a href="">
                        <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                        <div class="book-rating">
                            <p>★★★★★</p>
                        </div>
                        <div class="material-price">
                            <p>¥</p>
                            <p>114,514</p>
                        </div>
                        <div class="post-likes">
                            <p>♡</p>
                            <p>810人がいいね</p>
                        </div>
                    </a>
                </div>    
            </div>
        </div>
    </div>
</body>