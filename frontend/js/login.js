window.onload = function () {
  // Them hieu ung khi chuyen tab dang nhap/dang ky
  addAnimation();

  // Xu ly su kien dang nhap/ dang ky.
  addLoginEventHandler();
  addRegisterEventHandler();
};

function addAnimation() {
  let login_page = document.querySelector(".login-page");
  let signup_page = document.querySelector(".signup-page");

  let create_acc_button = document.querySelector("#signup");
  create_acc_button.addEventListener("click", function () {
    login_page.style.display = "none";
    signup_page.style.display = "block";
  });

  let login_button = document.querySelector("#login");
  login_button.addEventListener("click", function () {
    signup_page.style.display = "none";
    login_page.style.display = "block";
  });
}

function addLoginEventHandler() {
  document.querySelector("#login-form").addEventListener("submit", (event) => {
    event.preventDefault();

    let username = document.querySelector("#login-form #username").value;
    let password = document.querySelector("#login-form #password").value;

    // Fetch gửi yêu cầu kiểm tra username + password có chính xác
    fetch("../../backend/api/UserAPI.php?action=login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: username,
        password: password,
      }),
    })
      .then((respond) => {
        return respond.json();
      })
      .then((data) => {
        let isExist = data.isExist;

        if (isExist === "true") {
          alert("Đăng nhập thành công!");
          window.location.href = "index.php";
        } else {
          document.querySelector("#login-form #error-message").innerHTML =
            "Username hoặc password không chính xác";
        }
      })
      .catch((error) => {
        console.log(error);
      });
  });
}

function isEqualsPasswordAndCfPassword() {
  let password = document.querySelector("#register-form #password").value;
  let confirmPassword = document.querySelector(
    "#register-form #confirmPassword"
  ).value;

  return password === confirmPassword;
}

function addRegisterEventHandler() {
  document
    .querySelector("#register-form")
    .addEventListener("submit", (event) => {
      event.preventDefault();

      if (isEqualsPasswordAndCfPassword()) {
        let hoten = null;
        let email = null;
        let username = document.querySelector("#register-form #username").value;
        let password = document.querySelector("#register-form #password").value;
        let status = 1;

        fetch("../../backend/api/UserAPI.php?action=addUser", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            hoten: hoten,
            email: email,
            username: username,
            password: password,
            status: status,
          }),
        })
          .then((respond) => {
            return respond.json();
          })
          .then((data) => {
            console.log(data);

            if (!data.success) {
              document.querySelector(
                "#register-form #error-message"
              ).innerHTML = data.message;
            } else {
              alert("Đăng ký tài khoản thành công!");
              document.querySelector("#register-form").submit();
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        document.querySelector("#register-form #error-message").innerHTML =
          "Nhập lại mật khẩu và mật khẩu phải trùng nhau";
      }
    });
}
