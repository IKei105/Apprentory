

// document.getElementById('discord').addEventListener('click', function () {

//     // サーバーにリクエストを送る
//     fetch('/api/send-discord-message', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             discord_id: discordId,  // 送る相手の Discord ID
//             message: "APIからのmessageです！" // 送るメッセージ
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         console.log("✅ サーバーからのレスポンス:", data);
//         alert(data.message);
//     })
//     .catch(error => console.error("❌ エラー:", error));
// });

// document.getElementById('discord').addEventListener('click', function () {
//     console.log("");

//     // サーバーにリクエストを送る
//     fetch('/api/send-discord-message', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             discord_id: discordId,  // 送る相手の Discord ID
//             message: "APIからのmessageです！" // 送るメッセージ
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         console.log("✅ サーバーからのレスポンス:", data);
//         alert(data.message);
//     })
//     .catch(error => console.error("❌ エラー:", error));
// });
