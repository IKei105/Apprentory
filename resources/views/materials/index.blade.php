<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教材一覧 | Apprentory</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <header>
        <div class="header-top">
            <div class="header-left">
                <div class="header-logo">Apprentory</div>
            </div>
            <div class="header-right">
                <img src="{{ asset('assets/images/Search 02.svg') }}" alt="検索">
                <img src="{{ asset('assets/images/Icon.svg') }}" alt="通知">
                <a href="#" class="mypage">マイページ</a>
                <button class="new-post">新規投稿<img src="{{ asset('assets/images/Pencil 01.svg') }}"></button>
            </div>
        </div>
        <div class="header-bottom">
            <li>教材共有</li>
            <li>オリプロ共有</li>
        </div>
    </header>
</body>
</html>
