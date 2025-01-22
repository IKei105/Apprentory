
const recommendedMaterials = document.getElementById('recommended_materials'); //推奨教材
const highRatedMaterials = document.getElementById('high-rated-materials'); //高評価教材
const latestMaterials = document.getElementById('latest-materials'); //新着教材

const recommendedMaterialsAll = document.getElementById('recommended_materials_all'); //もっと見る推奨教材
const highRatedMaterialsAll = document.getElementById('high-rated-materials-all'); //もっと見る高評価教材
const latestMaterialsAll = document.getElementById('latest-materials-all'); //もっと見る新着教材

// すべての教材を非表示にする関数
function hideAllMaterials() {
    recommendedMaterials.classList.add('hidden');
    highRatedMaterials.classList.add('hidden');
    latestMaterials.classList.add('hidden');
    recommendedMaterialsAll.classList.add('hidden');
    highRatedMaterialsAll.classList.add('hidden');
    latestMaterialsAll.classList.add('hidden');
}

document.getElementById('recommended-button').addEventListener('click', () => {
    hideAllMaterials(); // 全て非表示
    recommendedMaterialsAll.classList.remove('hidden'); // 推奨教材を表示
});

document.getElementById('new-button').addEventListener('click', () => {
    hideAllMaterials(); // 全て非表示
    latestMaterialsAll.classList.remove('hidden'); // 新着教材を表示
});

document.getElementById('high-rated-button').addEventListener('click', () => {
    hideAllMaterials(); // 全て非表示
    highRatedMaterialsAll.classList.remove('hidden'); // 高評価教材を表示
});

