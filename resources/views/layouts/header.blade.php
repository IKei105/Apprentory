<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <div class="header-top">
            <div class="header-left">
                <a href="{{ route('materials.index') }}"><div class="header-logo">Apprentory</div></a>
            </div>
            <div class="header-right">
                <img src="{{ asset('assets/images/Search 02.svg') }}" class="search-button" id="search-button" alt="検索">
                <img src="{{ asset('assets/images/Icon.svg') }}" alt="通知">
                <a href="{{ route('mypage') }}" class="mypage">
                    <img src="{{ asset($profile->profile_image ?? '') }}" alt="M" class="profile-img">
                </a>
                <button class="new-post">新規投稿<img src="{{ asset('assets/images/Pencil 01.svg') }}"></button>
            </div>
        </div>
        <div>
            <form  class="search-form hidden" action="" method="POST">
                <input class="search-input" type="text" name="search" placeholder="タグとか言語とかさぁ、入れろよお前">
                <!-- <button type="submit">検索</button> -->
            </form>
        </div>
        <div class="header-bottom">
            <a href="{{ route('materials.index') }}" class="tab active">教材共有</a>
            <a href="{{ route('products.index') }}" class="tab">オリプロ共有</a>
            <div class="indicator"></div>
        </div>
    </header>
    <script src="{{ asset('/js/header.js') }}"></script>
</body>
</html>