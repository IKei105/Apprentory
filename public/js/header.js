document.getElementById('search-button').addEventListener('click', () => {
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.classList.toggle('hidden'); // hiddenクラスを付与・除去を切り替え
    }
});
