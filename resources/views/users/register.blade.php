<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/register_style.css') }}">
    <title>新規登録 | Apprentory</title>
</head>
<body>
    <header>
        <a id="logo" href="">アプレントリィ</a>
        <a class="header-login-link" id="header-register-link" href="{{ route('login') }}">ログイン</a>
    </header>
    <div class="login">
        <p class="login-title" >新規登録</p>
        <form action="{{ route('register') }}" method="POST">
              @csrf
            <div class=input-info>
                <div class="email">
                    <input name="email" class="email-input" type="text" placeholder="ユーザーID" />
                </div>
                <div class="term">
                    <select id="term" class="term-input" name="term">
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}">{{ $term->term }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="password-info" >
                <div class="password password-upper">
                    <input class="password-input " name="password" type="password" placeholder="パスワード" />
                </div>
                <div class="password">
                    <input class="password-input" name="password_confirmation" type="password" placeholder="もう一度パスワードを入力" />
                </div>
            </div>
            
            
            <button class="login-button">新規登録</button>
            </form>
    </div>
    
</body>
</html>