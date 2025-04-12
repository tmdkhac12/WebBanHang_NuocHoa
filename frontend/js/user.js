window.onload = function () {

    addLogoutEventHandler();
}

function addLogoutEventHandler() {
    document.querySelector("#logout-btn").addEventListener("click", (event) => {
        event.preventDefault();

        fetch("/backend/api/UserAPI.php?action=logout")
            .then((respond) => {
                return respond.json()
            })
            .then((data) => {
                alert(data.message)
                window.location.href = "index.php"
            })
            .catch((error) => {
                console.log(error)
            })
    })
}