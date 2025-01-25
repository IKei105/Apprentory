// document.addEventListener("DOMContentLoaded", () => {
//     const imageInput = document.getElementById("image-input");
//     const previewContainer = document.querySelector(".post-images-preview");
//     let imageCount = 0; // 現在の画像枚数
//     let selectedFiles = []; // 選択されたすべてのファイルを保持する配列

//     imageInput.addEventListener("change", (event) => {
//         const files = Array.from(event.target.files);

//         console.log("現在の選択ファイル:", selectedFiles); // 現在の選択済みファイルを表示

//         // 画像制限チェック
//         if (imageCount + files.length > 5) {
//             alert("投稿できる画像は5枚までです");
//             return;
//         }

//         files.forEach((file) => {
//             if (!file.type.startsWith("image/")) return; // 画像以外は無視

//             selectedFiles.push(file); // 選択されたファイルを保持
//             imageCount++;

//             // プレビューを表示
//             const reader = new FileReader();
//             reader.onload = (e) => {
//                 const imageWrapper = document.createElement("div");
//                 imageWrapper.classList.add("image-wrapper");

//                 const img = document.createElement("img");
//                 img.src = e.target.result;
//                 img.classList.add("preview-image");

//                 const deleteBtn = document.createElement("button");
//                 deleteBtn.innerText = "×";
//                 deleteBtn.classList.add("delete-btn");
//                 deleteBtn.addEventListener("click", () => {
//                     previewContainer.removeChild(imageWrapper);
//                     imageCount--;
//                     selectedFiles = selectedFiles.filter((f) => f !== file); // 配列から削除
//                     console.log("削除後の選択ファイル:", selectedFiles); // 削除後のファイル一覧を表示
//                 });

//                 imageWrapper.appendChild(img);
//                 imageWrapper.appendChild(deleteBtn);
//                 previewContainer.appendChild(imageWrapper);
//             };
//             reader.readAsDataURL(file);
//         });
//     });

//     // フォーム送信時に保持されたすべてのファイルを追加
//     document.querySelector("form").addEventListener("submit", (e) => {
//         console.log("送信されるファイル:", selectedFiles); // 送信直前のファイル一覧を表示

//         const formData = new FormData();
//         selectedFiles.forEach((file) => formData.append("images[]", file));

//         // 必要に応じて、他のデータも追加
//         // formData.append("title", document.getElementById("title").value);

//         // デフォルトの送信処理をキャンセルし、AJAX送信などに変更する場合
//         // e.preventDefault();
//         // fetch("YOUR_API_ENDPOINT", { method: "POST", body: formData });
//     });
// });

document.addEventListener("DOMContentLoaded", () => {
    const imageInput = document.getElementById("image-input");
    const previewContainer = document.querySelector(".post-images-preview");
    let imageCount = 0; // 現在の画像枚数
    let selectedFiles = []; // 選択されたすべてのファイルを保持する配列

    imageInput.addEventListener("change", (event) => {
        const files = Array.from(event.target.files);
        console.log("選択されたファイル:", files); // デバッグポイント
        console.log("現在保持しているファイル:", selectedFiles); // デバッグポイント

        // 画像制限チェック
        if (imageCount + files.length > 5) {
            alert("投稿できる画像は5枚までです");
            return;
        }

        files.forEach((file) => {
            if (!file.type.startsWith("image/")) return; // 画像以外は無視

            selectedFiles.push(file); // 選択されたファイルを保持
            imageCount++;

            // プレビューを表示
            const reader = new FileReader();
            reader.onload = (e) => {
                const imageWrapper = document.createElement("div");
                imageWrapper.classList.add("image-wrapper");

                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("preview-image");

                const deleteBtn = document.createElement("button");
                deleteBtn.innerText = "×";
                deleteBtn.classList.add("delete-btn");
                deleteBtn.addEventListener("click", () => {
                    previewContainer.removeChild(imageWrapper);
                    imageCount--;
                    selectedFiles = selectedFiles.filter((f) => f !== file); // 配列から削除
                });

                imageWrapper.appendChild(img);
                imageWrapper.appendChild(deleteBtn);
                previewContainer.appendChild(imageWrapper);
            };
            reader.readAsDataURL(file);
        });
    });

    // フォーム送信時に保持されたすべてのファイルを追加
    document.querySelector("form").addEventListener("submit", (e) => {
        e.preventDefault();
        // 送信データを確認するデバッグ用コード
        console.log("送信されるファイル:", selectedFiles);
        const formData = new FormData();
        selectedFiles.forEach((file) => formData.append("images[]", file));

        // 他のフォームデータも追加する場合
        formData.append("title", document.getElementById("title").value);
        formData.append("subtitle", document.getElementById("subtitle").value);
        formData.append("product_detail", document.getElementById("detail").value);
        formData.append("product_url", document.getElementById("product_url").value);
        formData.append("github_url", document.getElementById("github_url").value);
        formData.append("element", document.querySelector('input[name="element"]:checked').value);

        // サーバーに送信
        fetch("/products", {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("サーバーエラーが発生しました。");
                }
                return response.json();
            })
            .then((data) => {
                console.log("送信成功:", data);
                window.location.href = `/products/${data.id}`; // 投稿成功後にリダイレクト
            })
            .catch((error) => {
                console.error("送信エラー:", error);
                alert("送信中にエラーが発生しました。");
            });
        
        fetch("YOUR_API_ENDPOINT", { method: "POST", body: formData });
    });
});
