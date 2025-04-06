<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//demo.productionready.io/main.css" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/register_step1_discord.css') }}">
    <title>新規登録</title>
</head>
<body>
    <header>
        <a href="" class="header-logo">Apprentory</a>
        <a class="header-register-link" id="header-register-link" href="{{ route('login') }}">ログイン</a>
    </header>
    <div class="login">
        <p class="login-title" >新規登録</p>
        <form action="{{ route('register1') }}" method="POST">
            @csrf
            <div class="input-info  {{ $errors->has('discord-id') ? 'border-red' : '' }}">
                <fieldset class="userid">
                    <input class="userid-input" name="discord-ID" type="text" placeholder="Discord IDを入力" required/>
                </fieldset>
            </div>
            @error('discord-id')
                <div class="error-message">正しく入力してください</div>
            @enderror
            
            <button class="send-button">Discordに送信</button>
            </form>
    </div>
    
</body>
</html>