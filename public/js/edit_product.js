document.addEventListener('DOMContentLoaded', () => {
    // 画像差し替え時の処理
    function previewImage(event, index) {
        const input = event.target;
        const preview = document.getElementById('preview-image-' + index);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);

            // 差し替えたら、元画像を削除対象にする
            const deletedId = document.getElementById('deleted-image-id-' + index);
            const existingId = document.getElementById('existing-image-id-' + index);
            if (deletedId && existingId) {
                deletedId.value = existingId.value;
            }
        }
    }

    // バツボタン押下時の処理
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const index = this.dataset.index;
            const preview = document.getElementById('preview-image-' + index);
            const deletedId = document.getElementById('deleted-image-id-' + index);
            const existingId = document.getElementById('existing-image-id-' + index);
            const fileInput = document.getElementById('image-input-' + (parseInt(index) + 1));

            if (preview) {
                preview.src = '/assets/images/sample_image.png';
            }
            if (deletedId && existingId) {
                deletedId.value = existingId.value;
            }
            if (fileInput) {
                fileInput.value = '';
            }
        });
    });

    // 全 input に previewImage 関数を関連付け
    for (let i = 0; i < 5; i++) {
        const fileInput = document.getElementById('image-input-' + (i + 1));
        if (fileInput) {
            fileInput.addEventListener('change', function (event) {
                previewImage(event, i);
            });
        }
    }
});
