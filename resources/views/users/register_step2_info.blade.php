<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="//demo.productionready.io/main.css" />
        <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
        <link rel="stylesheet" href="{{ asset('css/register_step2_info.css') }}">
        <title>新規登録 | Apprentory</title>
    </head>
    <body>
        <header>
            <a href="" class="header-logo">Apprentory</a>
            <a class="header-login-link" id="header-register-link" href="{{ route('login') }}">ログイン</a>
        </header>
        <div class="login">
            <p class="login-title" >新規登録</p>
            <form action="{{ route('register2') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-user-profile-image">
                    <label for="user-profile-image">
                        <img class="user-profile-image" id="user-profile-image-preview" src="{{ asset('storage/user_profile_images/sample_profile_image.png') }}" alt="User Profile Image">
                        <p class="image-upload-text">プロフィール画像を選択</p>
                    </label>
                    <input class="hidden" type="file" id="user-profile-image" name="user-profile-image" >
                </div>
                <div class="input-info {{ $errors->has('userid') ? 'border-red' : '' }}">
                    <div class="userid">
                        <input name="userid" class="userid-input" type="text" placeholder="ユーザーID" value="{{ old('userid') }}"/>
                    </div>
                    <div class="term">
                        <select id="term" class="term-input" name="term">
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}" {{ old('term') == $term->id ? 'selected' : '' }}>
                                    {{ $term->term }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if($errors->has('userid'))
                    @if($errors->first('userid') === 'ユーザーIDを入力してください。')
                        <p class="error-message">ユーザーIDを入力してください。</p>
                    @elseif($errors->first('userid') === 'このユーザーIDはすでに使用されています。')
                        <p class="error-message">このユーザーIDはすでに使用されています。</p>
                    @endif
                @endif
                <div class="password-section">
                    <div class="password-info {{ $errors->has('password') ? 'border-red' : '' }}">
                        <div class="password password-upper">
                            <input class="password-input " name="password" type="password" placeholder="パスワード" />
                        </div>
                        <div class="password">
                            <input class="password-input" name="password_confirmation" type="password" placeholder="もう一度パスワードを入力" />
                        </div>
                    </div>
                    @if($errors->has('password'))
                        @if($errors->first('password') === 'パスワードを入力してください。')
                            <p class="error-message">パスワードを入力してください。</p>
                        @elseif($errors->first('password') === 'パスワードは8文字以上で入力してください。')
                            <p class="error-message">パスワードは8文字以上で入力してください。</p>
                        @elseif($errors->first('password') === 'パスワード確認が一致しません。')
                            <p class="error-message">パスワード確認が一致しません。</p>
                        @endif
                    @endif
                </div>
                <div class="input-register-code {{ $errors->has('register-code') ? 'border-red' : '' }}" >
                    <div class="password password-upper">
                        <input class="password-input " name="discord-ID" type="text" placeholder="Discord IDを入力" value="{{ old('discord-ID') ?? session('discord_ID') }}"  />
                    </div>
                    <div class="password">
                        <input class="password-input" name="register-code" type="text" placeholder="確認コードを入力" value="{{ old('register-code') }}" />
                    </div>
                </div>
                @if($errors->has('register-code'))
                    <p class="error-message">{{ $errors->first('register-code') }}</p>
                @endif
                <button class="login-button">新規登録</button>
                </form>
        </div>
    </body>
    <script src="{{ asset('/js/register_step2_info.js') }}"></script>
</html>