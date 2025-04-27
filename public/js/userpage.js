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
});
