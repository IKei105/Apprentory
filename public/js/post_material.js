
let selectCount = 1;
function createNewSelect() {
    // 新しいselectタグを作成
    const newSelect = document.createElement('select');
    newSelect.className = 'post-material-tags-select'; // クラスを付与

    selectCount++;
    const idName = `select${selectCount}`; //付与するidを作成
    newSelect.id = idName;
    newSelect.name = idName;

    // 選択肢を追加
    newSelect.innerHTML = `
        <option value="">選択してください</option>
        <option value="1">Ruby</option>
        <option value="2">PHP</option>
        <option value="3">SQL</option>
        <option value="4">HTML</option>
        <option value="5">CSS</option>
        <option value="6">JavaScript</option>
        <option value="7">GitHub</option>
        <option value="8">Linux</option>
        <option value="9">docker</option>
        <option value="10">AWS</option>
    `;

    // 作成したselectタグをdivに追加
    document.getElementById('post-material-tags').appendChild(newSelect);

    // 新しいselectタグにもイベントリスナーを追加
    newSelect.addEventListener('change', handleSelectChange);
}

// selectタグの変更時に新しいselectを作成するイベントハンドラ
function handleSelectChange(event) {
    const selectedId = event.target.id;
    const recentId = `select${selectCount}`

    if (event.target.value !== "" && recentId == selectedId && selectCount < 5) { // 値が選択された場合のみ
        createNewSelect();
    }
}

// 最初のselectタグにイベントリスナーを追加
const initialSelect = document.querySelector('.post-material-tags-select');
initialSelect.addEventListener('change', handleSelectChange);







document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll(".star");

    stars.forEach(star => {
        star.addEventListener("click", (event) => {
            // 選択された星のIDを取得
            const selectedRating = parseInt(event.target.getAttribute("for").replace("star", ""));

            // 星のハイライトをリセット
            stars.forEach(star => star.classList.remove("highlight"));

            // 選択された星とそれ以下をハイライト
            for (let i = 1; i <= selectedRating; i++) {
                document.querySelector(`label[for="star${i}"]`).classList.add("highlight");
            }
        });
    });
});



document.querySelector('form').addEventListener('submit', function(event) {
    const imageInput = document.getElementById('image');
    const errorMessage = document.getElementById('image-error');

    // 画像が選択されていない場合
    if (!imageInput.files.length) {
        event.preventDefault(); // フォームの送信をキャンセル
        errorMessage.style.display = 'block'; // エラーメッセージを表示
    } else {
        errorMessage.style.display = 'none'; // エラーメッセージを非表示
    }
});