<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認 | Apprentory</title>
</head>
<body>
    <h1>ユーザー登録が完了しました！</h1>
    <p>以下の情報で登録されました：</p>
    <ul>
        <li><strong>ユーザーID:</strong> {{ session('userid') }}</li>
        <li><strong>パスワード:</strong> {{ session('password') }}</li>
        <li><strong>ユーザーネーム:</strong> {{ session('username') }}</li>
    </ul>
    <p><strong>プロフィール画像:</strong></p>
    <img src="{{ session('profile_image') }}" alt="プロフィール画像" width="70">
    <a href="/">トップページへ戻る</a>
</body>
</html>
