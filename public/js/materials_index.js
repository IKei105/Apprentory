let currentTag = '0';
let currentCategory = '0';

// 技術タグの変更イベント
document.getElementById('tag').addEventListener('change', function () {
    currentTag = this.value;
    filterMaterials();
});

// カテゴリタグの変更イベント
document.getElementById('category-tag').addEventListener('change', function () {
    currentCategory = this.value;
    filterMaterials();
});

// 教材フィルタリング関数
function filterMaterials() {
    const sections = [
        { selector: '.recommended-material', maxCount: 6 },
        { selector: '.latest-material', maxCount: 4 },
        { selector: '.high-rate-material', maxCount: 4 },
        { selector: '.recommended-material-all', maxCount: null },
        { selector: '.latest-materials', maxCount: null },
        { selector: '.high-rate-materials', maxCount: null },
    ];

    sections.forEach(({ selector, maxCount }) => {
        const materials = Array.from(document.querySelectorAll(selector));

        // 一旦全て非表示
        materials.forEach(item => item.classList.add('hidden'));

        // タグとカテゴリでフィルター
        let matched = materials.filter(item => {
            const tags = item.dataset.tags?.split(',') ?? [];
            const category = item.dataset.category;

            const tagMatch = currentTag === '0' || tags.includes(currentTag);
            const categoryMatch = currentCategory === '0' || category === currentCategory;

            return tagMatch && categoryMatch;
        });

        // 表示数制限がある場合はslice
        if (maxCount !== null) {
            matched = matched.slice(0, maxCount);
        }

        // マッチした教材を表示
        matched.forEach(item => item.classList.remove('hidden'));
    });
}

// ボタンクリック時のセクション切り替え
document.getElementById('recommended-button').addEventListener('click', function () {
    document.getElementById('recommended_materials').classList.add('hidden');
    document.getElementById('high-rated-materials').classList.add('hidden');
    document.getElementById('latest-materials').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.remove('hidden');
    document.getElementById('latest-materials-all').classList.add('hidden');
    document.getElementById('high-rated-materials-all').classList.add('hidden');
});

document.getElementById('new-button').addEventListener('click', function () {
    document.getElementById('recommended_materials').classList.add('hidden');
    document.getElementById('high-rated-materials').classList.add('hidden');
    document.getElementById('latest-materials').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.add('hidden');
    document.getElementById('latest-materials-all').classList.remove('hidden');
    document.getElementById('high-rated-materials-all').classList.add('hidden');
});

document.getElementById('high-rated-button').addEventListener('click', function () {
    document.getElementById('recommended_materials').classList.add('hidden');
    document.getElementById('high-rated-materials').classList.add('hidden');
    document.getElementById('latest-materials').classList.add('hidden');
    document.getElementById('recommended_materials_all').classList.add('hidden');
    document.getElementById('latest-materials-all').classList.add('hidden');
    document.getElementById('high-rated-materials-all').classList.remove('hidden');
});
