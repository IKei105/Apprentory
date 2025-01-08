<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <link rel="stylesheet" href="css/recommended_materials.css">
    <link rel="stylesheet" href="css/menu-select.css">
    <title>推奨教材ページ</title>
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
            <div class="material-item">
                <a href="">
                    <img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt="">
                    <h3 class="material-title" >タイトル</h3>
                    <div class="post-likes">
                        <p>♡ 40</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>