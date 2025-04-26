// //ここからホンちゃんコード
// document.addEventListener("DOMContentLoaded", () => {
//     // 各inputタグにイベントリスナーを追加
//     for (let i = 1; i <= 5; i++) {
//         const input = document.getElementById(`image-input-${i}`);
//         const label = document.querySelector(`label[for="image-input-${i}"]`);
//         const img = label.querySelector("img");

//         input.addEventListener("change", (event) => {
//             const file = event.target.files[0]; // 1つの画像を取得
//             if (file && file.type.startsWith("image/")) {
//                 const reader = new FileReader();

//                 reader.onload = (e) => {
//                     img.src = e.target.result; // 選択した画像をプレビュー
//                 };

//                 reader.readAsDataURL(file); // 画像データを読み込む
//             }
//         });
//     }
// });
document.addEventListener('DOMContentLoaded', () => {
    const uploadArea = document.getElementById('image-upload-area');
    const sampleImagePath = uploadArea.dataset.sampleImage;
    let imageInputCount = 0;
    const maxImages = 5;

    function createImageInput() {
        if (imageInputCount >= maxImages) return;

        imageInputCount++;

        const wrapper = document.createElement('div'); // ここでラッパーdivを作る
        wrapper.classList.add('image-input-wrapper');

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.id = `image-input-${imageInputCount}`;
        input.style.display = 'none';

        const label = document.createElement('label');
        label.setAttribute('for', input.id);
        label.className = imageInputCount === 1 ? 'main-image' : 'sub-image';
        label.innerHTML = `
            <img src="${sampleImagePath}" alt="" class="sample-image">
            <p>ファイルを選択</p>
        `;

        wrapper.appendChild(label);
        wrapper.appendChild(input);
        uploadArea.appendChild(wrapper);

        input.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const img = wrapper.querySelector('img'); // ★wrapper内だけ探す！！
            if (img) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

                createImageInput();
            }
        });
    }

    createImageInput();
});
