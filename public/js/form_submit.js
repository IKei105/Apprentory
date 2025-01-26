document.addEventListener("DOMContentLoaded", () => {
    console.log("form_submit.jsファイルが正常に読み込まれました！");

    const form = document.querySelector("productform");
    console.log("取得したフォーム要素:", form); // フォーム要素が正しく取得できているか確認
    // デバッグ: form が見つかったか確認
    if (!form) {
        console.error("フォームが見つかりません。セレクタを確認してください。");
        console.log("現在の DOM:", document.body.innerHTML); // DOM 全体を出力
        return;
    }

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        // デバッグ: フォーム送信イベントが発火したか確認
        console.log("フォーム送信イベントが発火しました。");

        // デバッグ: 現在選択されているファイルを表示
        console.log("送信されるファイル (window.selectedFiles):", window.selectedFiles);

        const formData = new FormData();

        // 画像ファイルを FormData に追加
        window.selectedFiles.forEach((file) => formData.append("images[]", file));

        // 他のフォームデータを追加
        formData.append("title", document.getElementById("title").value);
        formData.append("subtitle", document.getElementById("subtitle").value);
        formData.append("product_detail", document.getElementById("detail").value);
        formData.append("product_url", document.getElementById("product_url").value);
        formData.append("github_url", document.getElementById("github_url").value);
        formData.append("element", document.querySelector('input[name="element"]:checked').value);

        // **デバッグ: FormData の中身を確認**
        console.log("FormData の中身:");
        for (let [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        fetch("/products", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("サーバーエラーが発生しました。");
                }
                return response.json();
            })
            .then((data) => {
                // デバッグ: サーバーからの成功レスポンスを確認
                console.log("送信成功:", data);
                window.location.href = `/products/${data.id}`;
            })
            .catch((error) => {
                // デバッグ: エラーの詳細を表示
                console.error("送信エラー:", error);
                alert("送信中にエラーが発生しました。");
            });
    });
});
