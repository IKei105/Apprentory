document.addEventListener('DOMContentLoaded', function () {
    const userMenu = document.getElementById('user-menu'); //user-menu idを取得
    const mypageButton = document.querySelector('.mypage-button'); //マイページボタンを取得
    const userMenuContent = document.querySelector('.user-menu-content');//user-menu-contentクラスを取得

    mypageButton.addEventListener('click', function (event) { //mypage-buttonをクリックしたら
        event.stopPropagation();
        userMenu.style.display = (userMenu.style.display === 'flex') ? 'none' : 'flex';
    });

    userMenu.addEventListener('click', function () {
        userMenu.style.display = 'none';
    });

    userMenuContent.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.querySelectorAll('.user-menu-option').forEach(option => {
        option.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            if (url) window.location.href = url;
        });
    });
});
