document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const menuContent = document.getElementById('menu-content');

    if (menuToggle) {
        menuToggle.addEventListener('click', function(event) {
            event.stopPropagation(); // クリックイベントが親に伝わらないようにする
            if (menuContent.style.display === 'none' || menuContent.style.display === '') {
                menuContent.style.display = 'block';
            } else {
                menuContent.style.display = 'none';
            }
        });
    }

    // メニュー以外をクリックしたら閉じる
    document.addEventListener('click', function(event) {
        if (menuContent && menuContent.style.display === 'block') {
            if (!menuContent.contains(event.target) && event.target !== menuToggle) {
                menuContent.style.display = 'none';
            }
        }
    });

    //以下教材・オリプロ切り替えボタン
    const showMaterialsButton = document.getElementById('show-materials');
    const showProductsButton = document.getElementById('show-products');
    const materialsSection = document.getElementById('userpage-materials');
    const productsSection = document.getElementById('userpage-products');

    if (showMaterialsButton && showProductsButton && materialsSection && productsSection) {
        materialsSection.style.display = 'block';
        productsSection.style.display = 'none';

        showMaterialsButton.addEventListener('click', function() {
            materialsSection.style.display = 'block';
            productsSection.style.display = 'none';
        });

        showProductsButton.addEventListener('click', function() {
            materialsSection.style.display = 'none';
            productsSection.style.display = 'block';
        });
    }
});