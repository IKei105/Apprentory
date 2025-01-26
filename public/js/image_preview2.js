// // document.addEventListener("DOMContentLoaded", () => {
// //     const inputs = document.querySelectorAll('[id^="image-input"]'); // inputをすべて取得
// //     const previewContainer = document.querySelector(".post-images-preview");
// //     let currentIndex = 0; // 現在割り当て中のinput index

// //     // 初期選択ラベル
// //     const label = document.getElementById("image-label");

// //     // 画像が選択されたときの処理
// //     inputs.forEach((input, index) => {
// //         console.log("選択されました");
// //         input.addEventListener("change", (event) => {
// //             const files = Array.from(event.target.files);

// //             files.forEach((file) => {
// //                 if (!file.type.startsWith("image/")) return;

// //                 const reader = new FileReader();
// //                 reader.onload = (e) => {
// //                     // プレビュー用のラッパーを作成
// //                     const imageWrapper = document.createElement("div");
// //                     imageWrapper.classList.add("image-wrapper");

// //                     // プレビュー画像
// //                     const img = document.createElement("img");
// //                     img.src = e.target.result;
// //                     img.alt = "プレビュー画像";
// //                     img.classList.add("preview-image");

// //                     // 削除ボタン
// //                     const deleteBtn = document.createElement("button");
// //                     deleteBtn.innerText = "×";
// //                     deleteBtn.classList.add("delete-btn");
// //                     deleteBtn.addEventListener("click", () => {
// //                         previewContainer.removeChild(imageWrapper);
// //                         input.value = ""; // 該当するinputを空に
// //                         if (currentIndex > index) {
// //                             currentIndex = index; // 削除された位置を再利用可能に
// //                         }
// //                         updateLabel();
// //                     });

// //                     // プレビューに要素を追加
// //                     imageWrapper.appendChild(img);
// //                     imageWrapper.appendChild(deleteBtn);
// //                     previewContainer.appendChild(imageWrapper);
// //                 };
// //                 reader.readAsDataURL(file);
// //             });

// //             // 次のinputに進む
// //             if (currentIndex < inputs.length - 1) {
// //                 currentIndex++;
// //                 updateLabel();
// //             } else {
// //                 label.style.display = "none"; // 最大数に達したらlabelを非表示
// //             }
// //         });
// //     });

// //     // ラベルを現在のinputに割り当てる関数
// //     function updateLabel() {
// //         const nextInput = inputs[currentIndex];
// //         if (nextInput) {
// //             label.setAttribute("for", nextInput.id);
// //             label.style.display = "inline-block"; // ラベルを再表示
// //         }
// //     }
// // });


// document.addEventListener("DOMContentLoaded", () => {
//     const maxImages = 5; // 最大画像数
//     let currentInputIndex = 1; // 現在のinputインデックス
//     const label = document.getElementById("image-label");
//     const previewContainer = document.querySelector(".post-images-preview");

//     // 画像が選択された時の処理
//     const updateLabelFor = (nextIndex) => {
//         console.log("x");
//         if (nextIndex <= maxImages) {
//             label.setAttribute("for", `image-input-${nextIndex}`);
//         } else {
//             label.style.display = "none"; // 最大画像数を超えたらlabelを非表示
//         }
//     };

//     // input要素のイベントリスナー設定
//     for (let i = 1; i <= maxImages; i++) {
//         const input = document.getElementById(`image-input-${i}`);

//         input.addEventListener("change", (event) => {
//             const files = Array.from(event.target.files);

//             files.forEach((file) => {
//                 if (!file.type.startsWith("image/")) return;

//                 const reader = new FileReader();
//                 reader.onload = (e) => {
//                     const imageWrapper = document.createElement("div");
//                     imageWrapper.classList.add("image-wrapper");

//                     const img = document.createElement("img");
//                     img.src = e.target.result;
//                     img.alt = "プレビュー画像";
//                     img.classList.add("preview-image");

//                     const deleteBtn = document.createElement("button");
//                     deleteBtn.innerText = "×";
//                     deleteBtn.classList.add("delete-btn");
//                     deleteBtn.addEventListener("click", () => {
//                         previewContainer.removeChild(imageWrapper);
//                         input.value = ""; // 該当するinputの値をクリア
//                         label.style.display = "block"; // labelを再表示
//                         updateLabelFor(i); // 削除されたinputにlabelを戻す
//                     });

//                     imageWrapper.appendChild(img);
//                     imageWrapper.appendChild(deleteBtn);
//                     previewContainer.appendChild(imageWrapper);
//                 };
//                 reader.readAsDataURL(file);
//             });

//             // 次のinputにlabelを紐付け
//             currentInputIndex++;
//             updateLabelFor(currentInputIndex);
//         });
//     }
// });









//ここからホンちゃんコード
document.addEventListener("DOMContentLoaded", () => {
    // 各inputタグにイベントリスナーを追加
    for (let i = 1; i <= 5; i++) {
        const input = document.getElementById(`image-input-${i}`);
        const label = document.querySelector(`label[for="image-input-${i}"]`);
        const img = label.querySelector("img");

        input.addEventListener("change", (event) => {
            const file = event.target.files[0]; // 1つの画像を取得
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    img.src = e.target.result; // 選択した画像をプレビュー
                };

                reader.readAsDataURL(file); // 画像データを読み込む
            }
        });
    }
});
