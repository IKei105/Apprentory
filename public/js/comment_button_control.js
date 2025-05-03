document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('original-product-comment');
    const button = document.querySelector('.original-product-comment-button');

    if (!input || !button) return;

    button.disabled = input.value.trim() === '';

    input.addEventListener('input', () => {
        button.disabled = input.value.trim() === '';
    });
});
