document.addEventListener('DOMContentLoaded', function () {
    console.log('野獣先輩');
    const userMenu = document.getElementById('user-menu');
    const mypageButton = document.querySelector('.mypage-button');
    const userMenuContent = document.querySelector('.user-menu-content');

    // ✅ マイページボタンをクリックでポップアップ表示
    mypageButton.addEventListener('click', function (event) {
        event.stopPropagation();
        userMenu.style.display = (userMenu.style.display === 'flex') ? 'none' : 'flex';
    });

    // ✅ ポップアップ外クリックで閉じる
    userMenu.addEventListener('click', function () {
        userMenu.style.display = 'none';
    });

    // ✅ ポップアップ内クリックは閉じない
    userMenuContent.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    // ✅ 各オプションボタンをクリックで遷移
    document.querySelectorAll('.user-menu-option').forEach(option => {
        option.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            if (url) window.location.href = url;
        });
    });
});
