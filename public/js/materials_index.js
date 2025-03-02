// const recommendedMaterials = document.getElementById('recommended_materials'); // 推奨教材
// const highRatedMaterials = document.getElementById('high-rated-materials'); // 高評価教材
// const latestMaterials = document.getElementById('latest-materials'); // 新着教材

// const recommendedMaterialsAll = document.getElementById('recommended_materials_all'); // もっと見る推奨教材
// const highRatedMaterialsAll = document.getElementById('high-rated-materials-all'); // もっと見る高評価教材
// const latestMaterialsAll = document.getElementById('latest-materials-all'); // もっと見る新着教材

// // すべての教材を非表示にする関数
// function hideAllMaterials() {
//     recommendedMaterials.classList.add('hidden');
//     highRatedMaterials.classList.add('hidden');
//     latestMaterials.classList.add('hidden');
//     recommendedMaterialsAll.classList.add('hidden');
//     highRatedMaterialsAll.classList.add('hidden');
//     latestMaterialsAll.classList.add('hidden');
// }

// // 各ボタンのクリックイベント
// document.getElementById('recommended-button').addEventListener('click', () => {
//     hideAllMaterials();
//     recommendedMaterialsAll.classList.remove('hidden'); // 推奨教材を表示
// });

// document.getElementById('new-button').addEventListener('click', () => {
//     hideAllMaterials();
//     latestMaterialsAll.classList.remove('hidden'); // 新着教材を表示
// });

// document.getElementById('high-rated-button').addEventListener('click', () => {
//     hideAllMaterials();
//     highRatedMaterialsAll.classList.remove('hidden'); // 高評価教材を表示
// });

// // タグによるフィルタリング処理
// document.getElementById("tag").addEventListener("change", function() {
//     let selectedTag = this.value; // 選択したタグのID
//     let materials = document.querySelectorAll(".material"); // すべてのmaterial要素を取得

//     // 一旦全ての `material` を表示する
//     materials.forEach(material => material.classList.remove("hidden"));

//     // 選択したタグに一致しないものだけを `hidden` にする
//     if (selectedTag !== "") {
//         materials.forEach(material => {
//             let tags = material.dataset.tags ? material.dataset.tags.split(",") : []; // data-tags を配列化

//             if (!tags.includes(selectedTag)) {
//                 material.classList.add("hidden"); // 選択タグを含まない場合は非表示
//             }
//         });
//     }
// });



/*******************************************************************

*************************    新しいコード    *************************

*******************************************************************/


document.getElementById('tag').addEventListener('change', function () {
    const selectedTag = this.value;

    // 表示制限のあるセクション
    const limitedSections = [
        { selector: '.recommended-material', maxCount: 6 },
        { selector: '.latest-material', maxCount: 4 },
        { selector: '.high-rate-material', maxCount: 4 },
    ];

    // 全表示のセクション
    const allSections = ['.recommended-material-all', '.latest-materials', '.high-rate-materials'];

    // 🎯 関数: 一致する要素を表示（最大表示数あり）
    function showLimitedMaterials(selector, maxCount) {
        const materials = Array.from(document.querySelectorAll(selector));

        // 全て非表示にしてから一致するものを取得
        materials.forEach(item => item.classList.add('hidden'));

        const matched = materials.filter(item => {
            const tags = item.dataset.tags?.split(',') ?? [];
            return tags.includes(selectedTag);
        });

        matched.slice(0, maxCount).forEach(item => item.classList.remove('hidden'));
    }

    // 🎯 関数: 一致する要素をすべて表示（制限なし）
    function showAllMatchingMaterials(selector) {
        const materials = Array.from(document.querySelectorAll(selector));

        materials.forEach(item => {
            const tags = item.dataset.tags?.split(',') ?? [];
            item.classList.toggle('hidden', !tags.includes(selectedTag));
        });
    }

    // ✅ 表示制限付きセクションの処理
    limitedSections.forEach(({ selector, maxCount }) => {
        showLimitedMaterials(selector, maxCount);
    });

    // ✅ 全表示セクションの処理
    allSections.forEach(selector => {
        showAllMatchingMaterials(selector);
    });
});

// ボタンクリック時の処理
document.getElementById('recommended-button').addEventListener('click', function() {
    // すべて非表示
    document.getElementById('recommended_materials').classList.add('hidden');
    document.getElementById('high-rated-materials').classList.add('hidden');
    document.getElementById('latest-materials').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.add('hidden');
    document.getElementById('latest-materials-all').classList.add('hidden');
    document.getElementById('high-rated-materials-all').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.remove('hidden');
});

document.getElementById('new-button').addEventListener('click', function() {
    document.getElementById('recommended_materials').classList.add('hidden');
    document.getElementById('high-rated-materials').classList.add('hidden');
    document.getElementById('latest-materials').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.add('hidden');
    document.getElementById('latest-materials-all').classList.remove('hidden');
    document.getElementById('high-rated-materials-all').classList.add('hidden');
});

document.getElementById('high-rated-button').addEventListener('click', function() {
    document.getElementById('recommended_materials').classList.add('hidden');
    document.getElementById('high-rated-materials').classList.add('hidden');
    document.getElementById('latest-materials').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.add('hidden');
    document.getElementById('latest-materials-all').classList.add('hidden');
    document.getElementById('high-rated-materials-all').classList.remove('hidden');
});
