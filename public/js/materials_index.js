/*******************************************************************

*************************    技術タグです    *************************

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

        let matched;

        if (selectedTag === '0') {
            // value="0" のときは全て表示対象にする
            matched = materials;
        } else {
            // タグに一致するものだけ抽出
            matched = materials.filter(item => {
                const tags = item.dataset.tags?.split(',') ?? [];
                return tags.includes(selectedTag);
            });
        }

        // 最大数だけ表示
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

/*******************************************************************

*************************    カテゴリーだ    *************************

*******************************************************************/
//あとでやれお（＾ω＾）
document.getElementById('category-tag').addEventListener('change', function () {
    const selectedCategoryTag = this.value;

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

        let matched;

        if (selectedCategoryTag === '0') {
            // value="0" のときはすべて表示対象
            matched = materials;
        } else {
            // カテゴリー一致するものだけ抽出
            matched = materials.filter(item => {
                const tag = item.dataset.category;
                return tag === selectedCategoryTag;
            });
        }

        // 最大数だけ表示
        matched.slice(0, maxCount).forEach(item => item.classList.remove('hidden'));
    }


    // 🎯 関数: 一致する要素をすべて表示（制限なし）
    function showAllMatchingMaterials(selector) {
        const materials = Array.from(document.querySelectorAll(selector));

        materials.forEach(item => {
            const tags = item.dataset.category?.split(',') ?? [];
            item.classList.toggle('hidden', !tags.includes(selectedCategoryTag));
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

// const tag = item.dataset.category; // 直接categoryを取得
// return tag === selectedTag;