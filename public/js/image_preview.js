document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("image-input");
    const previewContainer = document.querySelector(".post-images-preview");
    let imageCount = 0; // 現在の画像枚数

    // ファイル選択時にプレビューを追加
    imageInput.addEventListener("change", (event) => {
        const files = event.target.files;

        // 画像制限チェック
        if (imageCount + files.length > 5) {
            alert("投稿できる画像は5枚までです");
            return;
        }

        Array.from(files).forEach((file) => {
            if (!file.type.startsWith("image/")) {
                return; // 画像以外は無視
            }

            // 新しい画像を追加
            const reader = new FileReader();
            reader.onload = (e) => {
                // プレビュー画像コンテナを作成
                const imageWrapper = document.createElement("div");
                imageWrapper.classList.add("image-wrapper");

                // プレビュー画像
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("preview-image");

                // 削除ボタン
                const deleteBtn = document.createElement("button");
                deleteBtn.innerText = "×";
                deleteBtn.classList.add("delete-btn");
                deleteBtn.addEventListener("click", () => {
                    previewContainer.removeChild(imageWrapper);
                    imageCount--; // 画像枚数を減らす
                });
                
                // hidden inputを作成して画像データを送信
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = `images[]`; // name属性を設定
                hiddenInput.value = e.target.result; // Base64データを格納
                imageWrapper.appendChild(img);
                imageWrapper.appendChild(deleteBtn);
                previewContainer.appendChild(imageWrapper);
                imageCount++; // 画像枚数を増やす
            };
            reader.readAsDataURL(file);
        });

        // ファイル選択後にinputの値をリセット
        //imageInput.value = "";
    });
});
