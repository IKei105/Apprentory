document.addEventListener("DOMContentLoaded", function () {
    // 1つ前のURL（リファラー）を取得
    let previousUrl = document.referrer;

    // material-indicator と product-indicator の要素を取得
    let materialIndicator = document.querySelector(".material-indicator");
    let productIndicator = document.querySelector(".product-indicator");

    if (previousUrl.includes("materials")) {
        // URLに 'materials' が含まれていたら、material-indicator の hidden を削除
        materialIndicator.classList.remove("hidden");
    } else if (previousUrl.includes("products")) {
        // URLに 'products' が含まれていたら、product-indicator の hidden を削除
        productIndicator.classList.remove("hidden");
    } else {
        // どちらでもなかった場合は、material-indicator の hidden を削除（デフォルト）
        materialIndicator.classList.remove("hidden");
    }
});

window.onload = function() {
    let previousUrl = document.referrer; // 直前のURLを取得
    let materialsSection = document.getElementById("latest-materials-all"); // 教材の検索結果
    let productsSection = document.querySelector(".main-contents"); // オリプロの検索結果

    if (previousUrl.includes("materials")) {
        materialsSection.classList.remove("hidden");
    } else if (previousUrl.includes("products")) {
        productsSection.classList.remove("hidden");
    } else {
        // デフォルトで教材の方を表示
        materialsSection.classList.remove("hidden");
    }
};

document.addEventListener("DOMContentLoaded", function() {
    let materialsSection = document.getElementById("latest-materials-all"); // 教材の検索結果
    let productsSection = document.querySelector(".main-contents"); // オリプロの検索結果
    let materialButton = document.getElementById("recommended-button"); // 教材ボタン
    let productButton = document.getElementById("high-rated-button"); // オリプロボタン

    // 教材ボタンをクリックしたとき
    materialButton.addEventListener("click", function() {
        materialsSection.classList.remove("hidden");
        productsSection.classList.add("hidden"); // オリプロを隠す
    });

    // オリプロボタンをクリックしたとき
    productButton.addEventListener("click", function() {
        productsSection.classList.remove("hidden");
        materialsSection.classList.add("hidden"); // 教材を隠す
    });
});