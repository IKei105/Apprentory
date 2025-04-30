document.addEventListener('DOMContentLoaded', () => {
    const uploadArea = document.getElementById('image-upload-area');
    if (!uploadArea) return;

    const sampleImagePath = uploadArea.dataset.sampleImage;
    const maxImages = 5;
    let initialFiles;

    try {
        initialFiles = JSON.parse(uploadArea.dataset.initial || '[]');
    } catch {
        return;
    }

    if (!Array.isArray(initialFiles)) return;
    window.selectedFiles = [];

    // fetchで画像をFileに変換しselectedFilesへ
    const fetchPromises = initialFiles.map(fileInfo =>
        fetch(fileInfo.url)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], fileInfo.name, { type: blob.type });
                file._imageId = fileInfo.id;
                file._objectUrl = URL.createObjectURL(file);
                window.selectedFiles.push(file);
            })
            .catch(err => console.error('画像の取得に失敗:', fileInfo.url, err))
    );

    // 編集画面用の画像表示ロジックを定義
    window.renderImageInputs = function () {
        uploadArea.innerHTML = '';

        window.selectedFiles.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('image-input-wrapper');

            const label = document.createElement('label');
            label.className = index === 0 ? 'main-image' : 'sub-image';
            label.setAttribute('for', `image-input-${index + 1}`);

            const img = document.createElement('img');
            img.src = file._objectUrl || URL.createObjectURL(file);
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
                const removed = window.selectedFiles.splice(index, 1)[0];
            
                if (removed._imageId) {
                    const hiddenDelete = document.createElement('input');
                    hiddenDelete.type = 'hidden';
                    hiddenDelete.name = 'deleted_image_ids[]';
                    hiddenDelete.value = removed._imageId;
            
                    const form = uploadArea.closest('form');  // ← ここ追加
                    form.appendChild(hiddenDelete);           // ← ここ修正
                }
            
                window.renderImageInputs();
            });
            

            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'images[]';
            input.id = `image-input-${index + 1}`;
            input.style.display = 'none';

            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            input.addEventListener('change', (event) => {
                const changedFile = event.target.files[0];
                if (!changedFile || !changedFile.type.startsWith('image/')) return;
                window.selectedFiles[index] = changedFile;
                window.renderImageInputs();
            });

            wrapper.appendChild(label);
            wrapper.appendChild(input);
            wrapper.appendChild(deleteBtn);

            if (file._imageId) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'existing_image_ids[]';
                hidden.value = file._imageId;
                wrapper.appendChild(hidden);
            }

            uploadArea.appendChild(wrapper);
        });

        if (window.selectedFiles.length < maxImages) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('image-input-wrapper');

            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'images[]';
            input.id = `image-input-${window.selectedFiles.length + 1}`;
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
                window.renderImageInputs();
            });

            wrapper.appendChild(label);
            wrapper.appendChild(input);
            uploadArea.appendChild(wrapper);
        }
    };

    Promise.all(fetchPromises).then(() => {
        window.renderImageInputs();
    });
});