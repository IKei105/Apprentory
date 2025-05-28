document.addEventListener('DOMContentLoaded', function () {
    const tagSelect = document.getElementById('technology-tag');
    const products = document.querySelectorAll('.product');

    tagSelect.addEventListener('change', function () {
        const selectedTag = this.value;

        products.forEach(product => {
            const tags = product.getAttribute('data-tag').split(',');

            // "0" ならすべて表示、それ以外はフィルター
            if (selectedTag === '0' || tags.includes(selectedTag)) {
                product.classList.remove('hidden');
            } else {
                product.classList.add('hidden');
            }
        });
    });
});
