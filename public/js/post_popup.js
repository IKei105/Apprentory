document.addEventListener('DOMContentLoaded', function () {
    console.log("等の");
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
    console.log('野獣先輩');
    const userMenu = document.getElementById('user-menu');
    const mypageButton = document.querySelector('.mypage-button');
    const userMenuContent = document.querySelector('.user-menu-content');

    mypageButton.addEventListener('click', function (event) {
        console.log("クリックしたよ");
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

document.addEventListener('DOMContentLoaded', function () {
    const userMenu = document.getElementById('user-menu');
    console.log("✅ userMenu:", userMenu); // nullならHTML読み込み前にJSが実行されている

    if (!userMenu) {
        console.error("❌ userMenuが見つかりません。HTMLのロード順かスペルミスを確認してください。");
        return;
    }

    const mypageButton = document.querySelector('.mypage-button');

    if (!mypageButton) {
        console.error("❌ mypageButtonが見つかりません。HTML内にclass='mypage-button'があるか確認してください。");
        return;
    }

    mypageButton.addEventListener('click', function () {
        console.log("✅ ボタンがクリックされました");
        userMenu.style.display = 'flex'; // エラー箇所
    });
});
