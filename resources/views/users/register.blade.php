<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="register_style.css">
    <title>新規登録</title>
</head>
<body>
    <header>
        <a id="logo" href="">アプレントリィ</a>
        <a class="header-login-link" id="header-register-link" href="">ログイン</a>
    </header>
    <div class="login">
        <p class="login-title" >新規登録</p>
        <form action="" method="POST">
              @csrf
            <div class=input-info>
                <div class="email">
                    <input name="email" class="email-input" type="text" placeholder="ユーザーID" />
                </div>
                <div class="term">
                    <select id="term" class="term-input" name="term">
                        <option value="">期生を選択</option>
                        <option value="1">1期生</option>
                        <option value="2">2期生</option>
                        <option value="3">3期生</option>
                        <option value="4">4期生</option>
                        <option value="5">5期生</option>
                        <option value="6">6期生</option>
                        <option value="7">7期生</option>
                    </select>
                </div>
            </div>
            <div class="password-info" >
                <div class="password password-upper">
                    <input class="password-input " name="password" type="password" placeholder="パスワード" />
                </div>
                <div class="password">
                    <input class="password-input" name="confirm-password" type="password" placeholder="もう一度パスワードを入力" />
                </div>
            </div>
            
            
            <button class="login-button">新規登録</button>
            </form>
    </div>
    
</body>
</html>