<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="top_rated_materials.css">
    <title>ログイン</title>
</head>
<body>
    <div class="menu-select">
        <div class="content-switch">
            <button class="recommended-button">推奨教材</button>
            <button class="new-button">新着</button>
            <button class="high-rated-button">高評価</button>
        </div>
        <div class="filter"><p>絞り込み</p></div>
    </div>
    <div class="high-rated-materials">
        <h1>評価の高い教材</h1>
        <div class="articles">
            <div class="article">
                <img class="book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                <div class="article-text-info">
                    <div class="post-user-info">
                        <a href="">
                            <img class="post-user-image" src="{{ asset('assets/material_images/user_profile_image.png') }}" alt="">
                            <p class="post-user-name">ポストユーザー名</p>
                        </a>
                    </div>
                    <h3 class="material-title">ITエンジニアのためのプロンプトエンジニアリング</h3>
                    <div class="material-price">
                        <p>¥</p>
                        <p>114,514</p>
                    </div>
                    <div class="post-likes">
                        <p>♡</p>
                        <p>810人がいいね</p>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</body>