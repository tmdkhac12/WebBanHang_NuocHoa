
window.onload = function () {
    // Them hieu ung khi chuyen tab dang nhap/dang ky
    addAnimation();
}

function addAnimation() {
    let login_page = document.querySelector(".login-page");
    let signup_page = document.querySelector(".signup-page");

    let create_acc_button = document.querySelector("#signup");
    create_acc_button.addEventListener("click", function () {
        login_page.style.display = "none";
        signup_page.style.display = "block";
    })

    let login_button = document.querySelector("#login");
    login_button.addEventListener("click", function () {
        signup_page.style.display = "none";
        login_page.style.display = "block";
    })
}

