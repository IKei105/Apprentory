{
    const form = document.querySelector('#delete-form');
    if (form) { // delete-form が存在する場合のみ処理を実行
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // formのbuttonは押すとactionで指定したページに飛んでしまうのでとりあえず防ぐ

            if (confirm('投稿記事を削除していいでしょうか？') === false) {
                return;
            }

            form.submit();
        });
    }
}


document.querySelectorAll('.heart').forEach(heart => {
    heart.addEventListener('click', () => {
        heart.textContent = heart.textContent === '♡' ? '♥' : '♡';

        const table = 'user_like'; // または 'original_project_likes'

        const path = location.pathname; // URLを取得
        const segments = path.split('/'); // パスを "/" で分割
        const materialId = segments[segments.length - 1]; // 最後の要素を取得 (教材ID)

        console.log(materialId);

        fetch(`/like/${table}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ material_id: materialId }),
        })
        
        .then(response => response.json())
        .then(data => console.log(data));

    });
});