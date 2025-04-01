document.addEventListener('DOMContentLoaded', function () {
    const tagSelect = document.getElementById('technology-tag');
    const products = document.querySelectorAll('.product');

    tagSelect.addEventListener('change', function () {
        const selectedTag = this.value;

        products.forEach(product => {
            const tags = product.getAttribute('data-tag').split(',');

            if (selectedTag === '' || tags.includes(selectedTag)) {
                product.classList.remove('hidden');
            } else {
                product.classList.add('hidden');
            }
        });
    });
});

