document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("images");
    const previewContainer = document.querySelector(".post-images-preview");

    imageInput.addEventListener("change", (event) => {
        // プレビューエリアをクリア
        previewContainer.innerHTML = "";

        // 選択されたファイルを取得
        const files = event.target.files;

        // ファイルごとに処理
        Array.from(files).forEach((file) => {
            if (!file.type.startsWith("image/")) {
                return; // 画像以外は無視
            }

            const reader = new FileReader();

            // ファイルが読み込まれたらプレビュー表示
            reader.onload = (e) => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("preview-image");
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    });
});
