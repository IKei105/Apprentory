console.log("こんばんはs");

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#productform');
    if (!form) return; // 念のため null チェック

    form.addEventListener('submit', (e) => {
        e.preventDefault(); // デフォルト送信防止

        if (confirm('この内容で投稿していいですか？')) {
            form.submit(); // OK なら送信
        }
    });
});
