<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p id="Demo"></p>

    <script>
        fetch("./api/UserAPI.php?action=getAllUsrs")
            .then((respond) => {
                console.log(respond, "Type of Respond: " + typeof respond)
                return respond.json();  //  <=> JSON.parse(respond.text())
            })
            .then((data) => {
                document.querySelector("#Demo").innerHTML = data
                console.log(data, "Type of data: " + typeof data)
            })
            .catch((error) => {
                console.log(error)
            })

    </script>
</body>
</html>