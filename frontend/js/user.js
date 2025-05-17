window.onload = function () {
  addEditButtonFeature();

  addLogoutEventHandler();
  addUpdateAccountEventHandler();
};

function addLogoutEventHandler() {
  document.querySelector("#logout-btn").addEventListener("click", (event) => {
    event.preventDefault();

    fetch("/backend/api/UserAPI.php?action=logout")
      .then((respond) => {
        return respond.json();
      })
      .then((data) => {
        alert(data.message);
        localStorage.removeItem("nuochoas");
        window.location.href = "index.php";
      })
      .catch((error) => {
        console.log(error);
      });
  });
}

function addUpdateAccountEventHandler() {
  document
    .querySelector("#acoount-form")
    .addEventListener("submit", (event) => {
      event.preventDefault();

      // 1. Lấy input data
      const username = document.querySelector("#input_username").value;

      const hoten = cleanWhitespace(
        document.querySelector("#input_hoten").value
      );
      const email = cleanWhitespace(
        document.querySelector("#input_email").value
      );
      const currentPassword = document
        .querySelector("#input_currentpass")
        .value.trim();
      const newPassword = document
        .querySelector("#input-password")
        .value.trim();
      const confirmPassword = document
        .querySelector("#cf-password")
        .value.trim();

      // 2. Kiểm tra và bắt lỗi các dữ liệu không hợp lệ
      if (
        !validateInput(
          hoten,
          email,
          currentPassword,
          newPassword,
          confirmPassword
        )
      ) {
        return;
      }

      // console.log(hoten, email, currentPassword, newPassword, confirmPassword)

      // 3. Fetch API
      fetch("/backend/api/UserAPI.php?action=updateUserFromClient", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username,
          hoten,
          email,
          currentPassword,
          newPassword,
        }),
      })
        .then((respond) => {
          return respond.json();
        })
        .then((data) => {
          alert(data.message);

          // If success then refresh page
          if (data.success) {
            document.querySelector("#acoount-form").submit();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    });
}

function addHuyDonHandler(btn_huydon) {
  // 1. Confirm user muốn  xóa đơn hàng
  if (!confirm("Bạn có chắc chắn muốn hủy đơn hàng này?")) {
    return;
  }

  // 2. Lấy mã hóa đơn và gọi API
  const maHoaDon = btn_huydon.getAttribute("data-maHoaDon");

  fetch("/backend/api/HoaDonAPI.php?action=huydon", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      maHoaDon,
    }),
  })
    .then((respond) => {
      return respond.json();
    })
    .then((data) => {
      alert(data.message);
      window.location.href = window.location.href;
    })
    .catch((error) => {
      console.log(error);
    });
}

function validateInput(
  hoten,
  email,
  currentPassword,
  newPassword,
  confirmPassword
) {
  // Kiểm tra 1 trong 3 trường password có giá trị ?
  const isChangingPassword = currentPassword || newPassword || confirmPassword;

  if (isChangingPassword) {
    // Yêu cầu nhập đầy đủ 3 trường
    if (!currentPassword || !newPassword || !confirmPassword) {
      alert("Vui lòng nhập đầy đủ 3 trường nếu muốn đổi mật khẩu.");
      return false;
    } else {
      if (newPassword !== confirmPassword) {
        alert("Mật khẩu xác nhận không khớp.");
        return false;
      }
      if (/\s/.test(newPassword)) {
        alert("Mật khẩu không được chứa khoảng trắng.");
        return false;
      }
      if (newPassword.length > 50) {
        alert("Password không được vượt quá 50 ký tự.");
        return false;
      }
    }
  }

  if (hoten.length > 255) {
    alert("Họ tên không được vượt quá 255 kí tự");
    return false;
  }

  const emailRegex =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (!emailRegex.test(email)) {
    alert("Email không hợp lệ, vui lòng kiểm tra lại!");
    return false;
  }
  if (email.length > 255) {
    alert("Email không được vượt quá 255 kí tự");
    return false;
  }

  // Kết quả
  return true;
}

function cleanWhitespace(str) {
  return str.trim().replace(/\s+/g, " ");
}

function enableEdit(input, originalValue) {
  input.disabled = false;
  input.focus();

  input.addEventListener("focusout", function () {
    // If user change data
    if (input.value.trim() !== originalValue) {
      input.classList.add("changed");
    } else {
      ``;
      input.value = input.value.trim();
      input.classList.remove("changed");
    }

    input.disabled = true;
  });
}

function addEditButtonFeature() {
  const editBtn_hoten = document.querySelector("#editBtn-hoten");
  const inputField_hoten = document.querySelector("#input_hoten");
  const originalHoTenValue = inputField_hoten.value;

  const editBtn_email = document.querySelector("#editBtn-email");
  const inputField_email = document.querySelector("#input_email");
  const originalEmailValue = inputField_email.value;

  editBtn_hoten.addEventListener("click", () => {
    enableEdit(inputField_hoten, originalHoTenValue);
  });

  editBtn_email.addEventListener("click", () => {
    enableEdit(inputField_email, originalEmailValue);
  });
}
