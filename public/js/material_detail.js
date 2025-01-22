{
    const form = document.querySelector('#delete-form');
    form.addEventListener('submit', (e) => {
        e.preventDefault(); //formのbuttonは押すとactionで指定したページに飛んでしまうのでとりあえず防ぐ

        if (confirm('投稿記事を削除していいでしょうか？') === false) {
            return;
        }

        form.submit();
    });

}