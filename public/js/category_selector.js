document.addEventListener("DOMContentLoaded", function () {
    const categorySelect = document.getElementById("category-tag"); // カテゴリーの `select`
    const materialItems = document.querySelectorAll(".material-item"); // 教材リスト

    categorySelect.addEventListener("change", function () {
        const selectedCategory = categorySelect.value; // 選択されたカテゴリーの値

        materialItems.forEach((item) => {
            const itemCategory = item.getAttribute("data-category"); // `data-category` を取得

            if (selectedCategory === "" || itemCategory === selectedCategory) {
                item.classList.remove("hidden"); // 一致する場合は表示
            } else {
                item.classList.add("hidden"); // 一致しない場合は非表示
            }
        });
    });
});
