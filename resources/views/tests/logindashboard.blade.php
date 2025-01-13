<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード</title>
</head>
<body>
    <h1>ログイン成功!</h1>
    <p>ようこそ、{{ $user->userid }}さん！</p>
    <a href="{{ route('logout') }}">ログアウト</a>
</body>
</html>
