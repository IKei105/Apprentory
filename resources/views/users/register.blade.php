<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="login_style.css">
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
                <fieldset class="email">
                    <input name="email" class="form-control form-control-lg" type="text" placeholder="ユーザーID" />
                </fieldset>
                <fieldset class="term">
                    <select class="term" name="term" id="">
                        <option value="">期生を選択</option>
                    </select>
                </fieldset>
            </div>
            
            <button class="login-button">新規登録</button>
            </form>
    </div>
    
</body>
</html>