document.addEventListener("DOMContentLoaded", () => {

    const imageInput = document.getElementById("image-input");
    const previewContainer = document.querySelector(".post-images-preview");

    // グローバル変数として window.selectedFiles を初期化
    if (!window.selectedFiles) {
        window.selectedFiles = [];
    }
    // ファイル選択時の処理
    imageInput.addEventListener("change", (event) => {
        console.log("changeイベントが発火しました"); // イベントが発火したか確認
        const files = Array.from(event.target.files);
        // console.log("選択されたファイル:", files); // 現在選択されたファイルを確認
        // console.log("変更前の保持ファイル:", selectedFiles); // 配列の状態を確認
            files.forEach((file) => {
            if (!file.type.startsWith("image/")) return;

            window.selectedFiles.push(file);

            const reader = new FileReader();
            reader.onload = (e) => {
                const imageWrapper = document.createElement("div");
                imageWrapper.classList.add("image-wrapper");

                const img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "プレビュー画像";
                img.classList.add("preview-image");

                const deleteBtn = document.createElement("button");
                deleteBtn.innerText = "×";
                deleteBtn.classList.add("delete-btn");
                deleteBtn.addEventListener("click", () => {
                    previewContainer.removeChild(imageWrapper);
                    window.selectedFiles = window.selectedFiles.filter((f) => f !== file);
                });

                imageWrapper.appendChild(img);
                imageWrapper.appendChild(deleteBtn);
                previewContainer.appendChild(imageWrapper);
            };
            reader.readAsDataURL(file);
        });
    });
});
