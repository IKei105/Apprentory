document.addEventListener("DOMContentLoaded", function () {
    let images = Array.from(document.querySelectorAll(".material-book-image"));
    let index = 0;

    // 画像をロードする関数
    function loadImage(img, retries = 0, maxRetries = 5) {
        return new Promise((resolve, reject) => {
            let src = img.getAttribute("data-src");
            if (!src) {
                reject("画像のパスが存在しません");
                return;
            }

            img.src = src;

            img.onload = function () {
                console.log(`画像読み込み成功: ${src}`);
                resolve(); // 読み込み成功
            };

            img.onerror = function () {
                console.warn(`画像読み込み失敗: ${src} (リトライ: ${retries + 1})`);
                if (retries < maxRetries) {
                    setTimeout(() => {
                        loadImage(img, retries + 1, maxRetries).then(resolve).catch(reject);
                    }, 1000); // 1秒後に再試行
                } else {
                    console.error(`画像読み込み最終失敗: ${src}`);
                    img.src = "/assets/material_images/no-image.png"; // デフォルト画像を表示
                    resolve(); // 失敗しても次に進む
                }
            };
        });
    }

    // 画像を順番にロードする関数
    async function loadImagesSequentially() {
        for (let img of images) {
            try {
                await loadImage(img); // 画像の読み込み完了を待つ
            } catch (error) {
                console.error(error);
            }
        }
        console.log("すべての画像の読み込みが完了しました！");
    }

    loadImagesSequentially(); // 実行
});
