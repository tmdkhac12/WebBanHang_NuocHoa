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

    let username = document.querySelector("#login-form #username").value.trim();
    let password = document.querySelector("#login-form #password").value.trim();

    // Fetch gửi yêu cầu đăng nhập
    fetch("/backend/api/UserAPI.php?action=login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      credentials: "include", // 🔥 thêm dòng này để session hoạt động
      body: JSON.stringify({
        username: username,
        password: password,
      }),
    })
      .then((respond) => {
        return respond.json();
      })
      .then((data) => {
        // If login success
        if (data.success) {
          alert(data.message);
          window.location.href = "index.php";
        } else {
          flashErrorMessage(
            document.querySelector("#login-form #error-message"),
            data.message
          );
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
  console.log("test");
  document
    .querySelector("#register-form")
    .addEventListener("submit", (event) => {
      event.preventDefault();

      const error_box = document.querySelector("#register-form #error-message");

      // If password and confirm password are not the same
      if (!isEqualsPasswordAndCfPassword()) {
        flashErrorMessage(
          error_box,
          "Mật khẩu và nhập lại mật khẩu chưa trùng khớp."
        );
        return;
      }

      // Get user input
      let hoten = null;
      let email = null;
      let username = document
        .querySelector("#register-form #username")
        .value.trim();
      let password = document
        .querySelector("#register-form #password")
        .value.trim();
      let status = 1;
      let quyenhan = "user";

      // Validate user input
      const validateRegisterObject = validateRegisterInput(username, password);
      let error_message = "";
      if (validateRegisterObject.isValid === false) {
        for (const error of validateRegisterObject.errors) {
          error_message += error + " ";
        }

        alert(error_message);
        return;
      }

      // If user input is valid then fetch register API
      fetch("/backend/api/UserAPI.php?action=addUser", {
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
          quyenhan: quyenhan,
        }),
      })
        .then((respond) => {
          return respond.json();
        })
        .then((data) => {
          // If register not success
          if (!data.success) {
            flashErrorMessage(error_box, data.message);
          } else {
            alert(data.message);
            document.querySelector("#register-form").submit();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    });
}

function validateRegisterInput(username, password) {
  const errors = [];

  // Kiểm tra username
  if (username.length > 50) {
    errors.push("Username không được vượt quá 50 ký tự.");
  }
  if (/\s/.test(username)) {
    errors.push("Username không được chứa khoảng trắng.");
  }
  if (!/^[a-zA-Z0-9]+$/.test(username)) {
    errors.push(
      "Username chỉ được chứa chữ và số (không dấu, không ký tự đặc biệt)."
    );
  }

  // Kiểm tra password
  if (password.length > 50) {
    errors.push("Password không được vượt quá 50 ký tự.");
  }
  if (/\s/.test(password)) {
    errors.push("Password không được chứa khoảng trắng.");
  }

  // Kết quả
  return {
    isValid: errors.length === 0,
    errors,
  };
}

function flashErrorMessage(errorBox, message) {
  errorBox.style.opacity = 0;
  setTimeout(() => {
    errorBox.innerHTML = message;
    errorBox.style.opacity = 1;
  }, 50);
}
