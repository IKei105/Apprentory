document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("image-input");
    const previewContainer = document.querySelector(".post-images-preview");

    // ファイル選択時にプレビューを追加
    imageInput.addEventListener("change", (event) => {
        const files = event.target.files;

        Array.from(files).forEach((file) => {
            if (!file.type.startsWith("image/")) {
                return; // 画像以外は無視
            }

            const reader = new FileReader();

            reader.onload = (e) => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("preview-image");
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        });

        // ファイル選択後にinputの値をリセット
        imageInput.value = "";
    });
});
