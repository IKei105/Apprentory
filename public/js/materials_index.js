const recommendedMaterials = document.getElementById('recommended_materials'); // 推奨教材
const highRatedMaterials = document.getElementById('high-rated-materials'); // 高評価教材
const latestMaterials = document.getElementById('latest-materials'); // 新着教材

const recommendedMaterialsAll = document.getElementById('recommended_materials_all'); // もっと見る推奨教材
const highRatedMaterialsAll = document.getElementById('high-rated-materials-all'); // もっと見る高評価教材
const latestMaterialsAll = document.getElementById('latest-materials-all'); // もっと見る新着教材

// すべての教材を非表示にする関数
function hideAllMaterials() {
    recommendedMaterials.classList.add('hidden');
    highRatedMaterials.classList.add('hidden');
    latestMaterials.classList.add('hidden');
    recommendedMaterialsAll.classList.add('hidden');
    highRatedMaterialsAll.classList.add('hidden');
    latestMaterialsAll.classList.add('hidden');
}

// 各ボタンのクリックイベント
document.getElementById('recommended-button').addEventListener('click', () => {
    hideAllMaterials();
    recommendedMaterialsAll.classList.remove('hidden'); // 推奨教材を表示
});

document.getElementById('new-button').addEventListener('click', () => {
    hideAllMaterials();
    latestMaterialsAll.classList.remove('hidden'); // 新着教材を表示
});

document.getElementById('high-rated-button').addEventListener('click', () => {
    hideAllMaterials();
    highRatedMaterialsAll.classList.remove('hidden'); // 高評価教材を表示
});

// タグによるフィルタリング処理
document.getElementById("tag").addEventListener("change", function() {
    let selectedTag = this.value; // 選択したタグのID
    let materials = document.querySelectorAll(".material"); // すべてのmaterial要素を取得

    // 一旦全ての `material` を表示する
    materials.forEach(material => material.classList.remove("hidden"));

    // 選択したタグに一致しないものだけを `hidden` にする
    if (selectedTag !== "") {
        materials.forEach(material => {
            let tags = material.dataset.tags ? material.dataset.tags.split(",") : []; // data-tags を配列化

            if (!tags.includes(selectedTag)) {
                material.classList.add("hidden"); // 選択タグを含まない場合は非表示
            }
        });
    }
});

