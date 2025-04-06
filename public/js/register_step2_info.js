document.getElementById('user-profile-image').addEventListener('change', function(event) {
    const file = event.target.files[0]; // ファイル選択があった場合、そのファイルを取得

    if (file) {
        const reader = new FileReader();

        // 画像が読み込まれた後に実行される
        reader.onload = function(e) {
            const previewImage = document.getElementById('user-profile-image-preview');
            previewImage.src = e.target.result; // 選ばれた画像をプレビューにセット
        }

        reader.readAsDataURL(file); // ファイルを読み込み、Base64エンコードされた画像データを生成
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const button = document.getElementById('register-button');

    form.addEventListener('submit', () => {
        // ボタンを無効化して二重送信防止
        button.disabled = true;
        button.innerText = '送信中...'; // 任意：処理中の表示
    });
});
