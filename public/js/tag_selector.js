let selectCount = 1;
function createNewSelect() {
    // 新しいselectタグを作成
    const newSelect = document.createElement('select');
    newSelect.className = 'tag-select'; // クラスを付与

    selectCount++;
    const idName = `tag_select${selectCount}`; //付与するidを作成
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
    document.getElementById('tag-container').appendChild(newSelect);

    // 新しいselectタグにもイベントリスナーを追加
    newSelect.addEventListener('change', handleSelectChange);
}
// selectタグの変更時に新しいselectを作成するイベントハンドラ
function handleSelectChange(event) {
    const selectedId = event.target.id;
    const recentId = `tag_select${selectCount}`;

    if (event.target.value !== "" && recentId == selectedId && selectCount < 5) { // 値が選択された場合のみ
        createNewSelect();
    }
}

// 最初のselectタグにイベントリスナーを追加
document.addEventListener('DOMContentLoaded', () => {
    const initialTagSelect = document.querySelector('.tag-select');
    if (initialTagSelect) {
        initialTagSelect.addEventListener('change', handleSelectChange);
    }
});