console.log('discord_idは');
console.log(discordId);

document.getElementById('discord').addEventListener('click', function () {
    console.log("✅ ディスコードボタンがクリックされました");

    // サーバーにリクエストを送る
    fetch('/api/send-discord-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            discord_id: discordId,  // 送る相手の Discord ID
            message: "APIからのmessageです！" // 送るメッセージ
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ サーバーからのレスポンス:", data);
        alert(data.message);
    })
    .catch(error => console.error("❌ エラー:", error));
});

document.getElementById('discord').addEventListener('click', function () {
    console.log("");

    // サーバーにリクエストを送る
    fetch('/api/send-discord-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            discord_id: discordId,  // 送る相手の Discord ID
            message: "APIからのmessageです！" // 送るメッセージ
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ サーバーからのレスポンス:", data);
        alert(data.message);
    })
    .catch(error => console.error("❌ エラー:", error));
});

//改良版
// document.getElementById('discord2').addEventListener('click', function () {
//     console.log("✅ ディスコードボタンがクリックされました");

//     // サーバーにリクエストを送る
//     fetch('/api/send-discord-message', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             discord_id: "ikei105",  // 送る相手の Discord ID
//             message: "こんにちは、ikei105さん！" // 送るメッセージ
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         console.log("✅ サーバーからのレスポンス:", data);
//         alert(data.message);
//     })
//     .catch(error => console.error("❌ エラー:", error));
// });