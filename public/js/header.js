document.getElementById('search-button').addEventListener('click', () => {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.classList.toggle('hidden'); // hiddenクラスを付与・除去を切り替え
    }
});


// 現在のページURLを取得
const currentUrl = window.location.href;

// インジケーター要素を取得
const materialIndicator = document.querySelector(".material-indicator");
const productIndicator = document.querySelector(".product-indicator");

// URLに応じて hidden クラスを削除
if (currentUrl.includes("/products")) {
    // products ページの場合
    productIndicator.classList.remove("hidden");
} else if (currentUrl.includes("/materials")) {
    // materials ページの場合
    materialIndicator.classList.remove("hidden");
}


