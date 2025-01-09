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
    <div class="menu-button">
        <button>←</button>
        <button>投稿</button>
    </div>
    <div class="post-material-item">
    <form action="" method="POST">
            @csrf
            <div class="material-flex-container">
                <div class="post-material-img">
                    <label for="image" class="custom-file-label"><img class="material-book-image" src="{{ asset('assets/material_images/sample.png') }}" alt=""></label>
                    <input class="post-material-img-upload custom-file-input" type="file" id="image" name="image" accept="image/*">
                </div>
                <div class="post-material-title-review-container">
                    <div class="post-material-title">
                        <h3>タイトルですねぇ</h3>
                    </div>
                    <div class="post-material-review">
                        <p>感想だすえ</p>
                    </div>
                </div>
            </div>
            <div class="post-material-rating">
                <p>★★★★★</p>
            </div>
            <div class="post-material-price">
                <p>¥ 3000</p>
            </div>
            <div class="post-material-url">
                <a href="">それのリンク</a>
            </div>
            <div class="post-material-tags">
                <select name="" id="">タグ</select>
            </div>
        </form>
    </div>

    <div class="post-material-item">
        <div class="material-flex-container">
            <div class="post-material-img"><img src="" alt=""></div>
            <div class="post-material-title-review-container">
                <div class="post-material-title">
                    <h3>タイトルですねぇ</h3>
                </div>
                <div class="post-material-review">
                    <p>感想だすえ</p>
                </div>
            </div>
        </div>
        <div class="post-material-rating">
            <p>★★★★★</p>
        </div>
        <div class="post-material-price">
            <p>¥ 3000</p>
        </div>
        <div class="post-material-url">
            <a href="">それのリンク</a>
        </div>
        <div class="post-material-tags">
            <select name="" id="">タグ</select>
        </div>
    </div>
</body>