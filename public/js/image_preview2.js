document.addEventListener('DOMContentLoaded', () => {
    const uploadArea = document.getElementById('image-upload-area');
    const sampleImagePath = uploadArea.dataset.sampleImage;
    const maxImages = 5;

    let imageInputCount = 0; // inputのIDに使うだけのカウンター
    window.selectedFiles = [];

    function renderImageInputs() {
        uploadArea.innerHTML = '';

        window.selectedFiles.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('image-input-wrapper');

            const label = document.createElement('label');
            label.className = index === 0 ? 'main-image' : 'sub-image';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = 'プレビュー画像';
            img.classList.add('sample-image');
            label.appendChild(img);

            const text = document.createElement('p');
            text.textContent = 'ファイルを選択';
            label.appendChild(text);

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'delete-btn';
            deleteBtn.innerText = '×';
            deleteBtn.addEventListener('click', () => {
                window.selectedFiles.splice(index, 1);
                renderImageInputs();
            });

            // 実際に送信用の input（hiddenではないが非表示にする）
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'images[]';
            input.style.display = 'none';

            // File を input に直接セット（DataTransfer使う）
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            wrapper.appendChild(label);
            wrapper.appendChild(input);
            wrapper.appendChild(deleteBtn);
            uploadArea.appendChild(wrapper);
        });

        if (window.selectedFiles.length < maxImages) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('image-input-wrapper');

            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'images[]';
            input.id = `image-input-${++imageInputCount}`;
            input.style.display = 'none';

            const label = document.createElement('label');
            label.setAttribute('for', input.id);
            label.className = window.selectedFiles.length === 0 ? 'main-image' : 'sub-image';
            label.innerHTML = `
                <img src="${sampleImagePath}" alt="" class="sample-image">
                <p>ファイルを選択</p>
            `;

            input.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (!file || !file.type.startsWith('image/')) return;

                window.selectedFiles.push(file);
                renderImageInputs();
            });

            wrapper.appendChild(label);
            wrapper.appendChild(input);
            uploadArea.appendChild(wrapper);
        }
    }

    renderImageInputs();
});
// document.addEventListener('DOMContentLoaded', () => {
//     const uploadArea = document.getElementById('image-upload-area');
//     const sampleImagePath = uploadArea.dataset.sampleImage;
//     let imageInputCount = 0;
//     const maxImages = 5;

//     function createImageInput() {
//         if (imageInputCount >= maxImages) return;

//         imageInputCount++;

//         const wrapper = document.createElement('div'); // ここでラッパーdivを作る
//         wrapper.classList.add('image-input-wrapper');

//         const input = document.createElement('input');
//         input.type = 'file';
//         input.name = 'images[]';
//         input.id = `image-input-${imageInputCount}`;
//         input.style.display = 'none';

//         const label = document.createElement('label');
//         label.setAttribute('for', input.id);
//         label.className = imageInputCount === 1 ? 'main-image' : 'sub-image';
//         label.innerHTML = `
//             <img src="${sampleImagePath}" alt="" class="sample-image">
//             <p>ファイルを選択</p>
//         `;

//         const img = label.querySelector('img');

//         // 削除ボタン追加
//         const deleteBtn = document.createElement('button');
//         deleteBtn.type = 'button';
//         deleteBtn.className = 'delete-btn';
//         deleteBtn.innerText = '×';
//         deleteBtn.addEventListener('click', () => {
//             img.src = sampleImagePath;
//             input.value = '';
//         });

//         wrapper.appendChild(label);
//         wrapper.appendChild(input);
//         wrapper.appendChild(deleteBtn);
//         uploadArea.appendChild(wrapper);

//         input.addEventListener('change', function (event) {
//             const file = event.target.files[0];

//             if (!file || !file.type.startsWith('image/')) {
//                 return;
//             }

//             const img = wrapper.querySelector('img'); // ★wrapper内だけ探す！！
//             if (img) {
//                 const reader = new FileReader();
//                 reader.onload = (e) => {
//                     img.src = e.target.result;
//                 };
//                 reader.readAsDataURL(file);

//                 createImageInput();
//             }
//         });
//     }

//     createImageInput();
// });