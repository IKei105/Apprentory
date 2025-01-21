
const recommendedMaterials = document.getElementById('recommended_materials'); //推奨教材
const highRatedMaterials = document.getElementById('high-rated-materials'); //高評価教材
const latestMaterials = document.getElementById('latest-materials'); //新着教材

const recommendedMaterialsAll = document.getElementById('recommended_materials_all'); //もっと見る推奨教材
const highRatedMaterialsAll = document.getElementById('high-rated-materials-all'); //もっと見る高評価教材
const latestMaterialsAll = document.getElementById('latest-materials-all'); //もっと見る新着教材

// 推奨教材ボタン
document.getElementById('recommended-button').addEventListener('click', () => {
    // 見えるようにするやつ
    recommendedMaterialsAll.classList.remove('hidden');
    // 見えなくするやつ
    recommendedMaterials.classList.add('hidden');
    highRatedMaterials.classList.add('hidden');
    latestMaterials.classList.add('hidden');
    
    highRatedMaterialsAll.classList.add('hidden');
    latestMaterialsAll.classList.add('hidden');

});

// 新着ボタン
document.getElementById('new-button').addEventListener('click', () => {
    // 見えるようにするやつ
    latestMaterialsAll.classList.remove('hidden');
    // 見えなくするやつ
    recommendedMaterials.classList.add('hidden');
    highRatedMaterials.classList.add('hidden');
    latestMaterials.classList.add('hidden');

    recommendedMaterialsAll.classList.add('hidden');
    highRatedMaterialsAll.classList.add('hidden');
});

// 評価の高い教材ボタン
document.getElementById('high-rated-button').addEventListener('click', () => {
    // 見えるようにするやつ
    highRatedMaterialsAll.classList.remove('hidden');
    // 見えなくするやつ
    recommendedMaterials.classList.add('hidden');
    highRatedMaterials.classList.add('hidden');
    latestMaterials.classList.add('hidden');

    recommendedMaterialsAll.classList.add('hidden');
    latestMaterialsAll.classList.add('hidden');
});