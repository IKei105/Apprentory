document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('lightbox-modal');
    const modalImage = document.getElementById('lightbox-image');
    const thumbs = document.querySelectorAll('.products-images img, .product-image');

    thumbs.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => {
            console.log('画像クリック！'); // ← ここで反応するか見る
            modalImage.src = img.src;
            modal.classList.remove('hidden');
        });
    });

    modal.addEventListener('click', () => {
        console.log('モーダル閉じる！'); // ← モーダルクリック時の確認
        modal.classList.add('hidden');
        modalImage.src = '';
    });
});
