// console.log('ログインユーザーidは');
// console.log(loggedInUserId); // ログイン中のユーザーIDを取得

// console.log('記事投稿者は');
// console.log(followTargetUserId);

// console.log('isfollowは');
// console.log(isFollow);


document.addEventListener("DOMContentLoaded", function () {
    const followButton = document.getElementById("follow");
    const unfollowButton = document.getElementById("unfollow");

    if (!followButton) return;

    followButton.addEventListener("click", function () {

        if (!loggedInUserId) {
            console.error("ログインユーザーIDが取得できません");
            return;
        }

        console.log("ログイン中の人↓", loggedInUserId);
        console.log("記事の投稿者(フォローされる人)↓", followTargetUserId);

        fetch(`/api/follow/${loggedInUserId}/${followTargetUserId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            credentials: "include"
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("API Response:", data);
            if (data.success) {
                followButton.classList.add("hidden");  // フォローボタンを非表示
                unfollowButton.classList.remove("hidden"); // フォロー解除ボタンを表示
            } else {
                alert("エラーが発生しました");
            }
        })
        
        .catch(error => console.error("Error:", error));

    });



    if (!unfollowButton) return;

    unfollowButton.addEventListener("click", function () {

        if (!loggedInUserId) {
            console.error("ログインユーザーIDが取得できません");
            return;
        }

        console.log("ログイン中の人↓", loggedInUserId);
        console.log("記事の投稿者(フォロー解除される人)↓", followTargetUserId);

        fetch(`/api/unfollow/${loggedInUserId}/${followTargetUserId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            credentials: "include"
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("API Response:", data);
            if (data.success) {
                unfollowButton.classList.add("hidden");  // フォローボタンを非表示
                followButton.classList.remove("hidden"); // フォロー解除ボタンを表示
            } else {
                alert("エラーが発生しました");
            }
        })
        
        .catch(error => console.error("Error:", error));
    });
});
