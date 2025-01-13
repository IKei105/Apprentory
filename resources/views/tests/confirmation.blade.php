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
        <li><strong>ユーザーID:</strong> {{ $userid }}</li>
        <li><strong>パスワード:</strong> {{ $password }}</li>
    </ul>
    <a href="/">トップページへ戻る</a>
</body>
</html>
