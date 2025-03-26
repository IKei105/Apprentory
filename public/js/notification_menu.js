console.log('野獣先輩');

// document.addEventListener('DOMContentLoaded', function () {
//     const userMenu = document.getElementById('notification-menu');
//     const notificationButton = document.getElementById('notification-button');
//     const userMenuContent = document.querySelector('.user-menu-content');

//     notificationButton.addEventListener('click', function (event) {
//         console.log("通知ボタンをクリックしました");
//         event.stopPropagation();
//         userMenu.style.display = (userMenu.style.display === 'flex') ? 'none' : 'flex';
//     });

//     userMenu.addEventListener('click', function () {
//         userMenu.style.display = 'none';
//     });

//     userMenuContent.addEventListener('click', function (event) {
//         event.stopPropagation();
//     });

//     document.querySelectorAll('.user-menu-option').forEach(option => {
//         option.addEventListener('click', function () {
//             const url = this.getAttribute('data-url');
//             if (url) window.location.href = url;
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('notification-button');
    const popup = document.getElementById('notification-popup');

    // ボタンをクリックでポップアップの表示/非表示切り替え
    button.addEventListener('click', (e) => {
        e.stopPropagation(); // 他のクリックイベントと干渉しないように
        popup.classList.toggle('hidden');
    });

    // ポップアップ内のクリックは閉じないように
    popup.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // ポップアップ以外のクリックで閉じる
    document.addEventListener('click', () => {
        popup.classList.add('hidden');
    });
});

