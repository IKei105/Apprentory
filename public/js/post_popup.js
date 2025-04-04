document.addEventListener('DOMContentLoaded', function () {
    const postPopup = document.getElementById('post-popup');
    const newPostButton = document.querySelector('.new-post');
    const popupContent = document.querySelector('.post-popup-content');

    // 新規投稿ボタンをクリックしたらポップアップを表示
    newPostButton.addEventListener('click', function () {
        postPopup.style.display = 'flex';
    });

    // ポップアップ外をクリックで閉じる
    postPopup.addEventListener('click', function (event) {
        postPopup.style.display = 'none';
    });

    // ポップアップ内部のクリックは伝播を止めて閉じないようにする
    popupContent.addEventListener('click', function (event) {
        event.stopPropagation();
    });


    // 各オプションボタンをクリックしたら遷移
    document.querySelectorAll('.popup-option').forEach(option => {
        option.addEventListener('click', function () {
            const url = this.getAttribute('data-url'); // data-url属性から遷移先を取得
            window.location.href = url;
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const userMenu = document.getElementById('user-menu');
    const mypageButton = document.querySelector('.mypage-button');
    const userMenuContent = document.querySelector('.user-menu-content');

    mypageButton.addEventListener('click', function (event) {
        userMenu.style.display = 'flex';
    });


    userMenu.addEventListener('click', function () {
        event.stopPropagation();
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
