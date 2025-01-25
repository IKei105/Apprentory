<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/login_style.css') }}">
    <title>ログイン</title>
</head>
<body>
    <header>
        <a href="" class="header-logo">Apprentory</a>
        <a class="header-register-link" id="header-register-link" href="{{ route('register') }}">アカウント登録</a>
    </header>
    <div class="login">
        <p class="login-title" >ログイン</p>
        <form action="{{ route('login') }}" method="POST">
              @csrf
            <div class=input-info>
                <fieldset class="userid">
                    <input class="userid-input" name="userid" type="text" placeholder="ユーザーID" />
                </fieldset>
                <fieldset class="password">
                    <input class="password-input" name="password" type="password" placeholder="パスワード" />
                </fieldset>
            </div>

            <a class="forgot-password" href="">パスワードを忘れた場合はこちら</a>
            
            <button class="login-button">ログイン</button>
            </form>
    </div>
    
</body>
</html>