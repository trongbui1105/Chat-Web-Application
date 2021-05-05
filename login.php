<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
</head>

<style type="text/css">
    @font-face {
        font-family: headFont;
        src: url(ui/fonts/Summer-Vibes-OTF.otf);
    }

    @font-face {
        font-family: myFont;
        src: url(ui/fonts/OpenSans-Regular.ttf);
    }

    #wrapper {
        max-width: 900px;
        min-height: 500px;
        margin: auto;
        color: gray;
        font-family: myFont;
        font-size: 16px;
    }

    form {
        margin: auto;
        padding: 10px;
        width: 100%;
        max-width: 400px;
    }

    input[type=text], input[type=password], input[type=button] {
        padding: 10px;
        margin: 10px;
        width: 98%;
        border-radius: 5px;
        border: solid 1px grey;
    }

    input[type=button] {
        width: 103%;
        cursor: pointer;
        background-color: #2b5488;
        color: white;
    }

    input[type=radio] {
        transform: scale(1.2);
        cursor: pointer;
    }

    #header {
        background-color: #485b6c;
        font-size: 45px;
        text-align: center;
        font-family: headFont;
        width: 100%;
        color: white;
    }

    #error {
        text-align: center;
        padding: 0.5em; 
        background-color: #ecaf91; 
        color: white; 
        display: none;
    }

</style>

<body>
    <div id="wrapper">
        <div id="header">
            My Chat
            <div style="font-size: 25px; font-family: myFont;">Login</div>
        </div>
        <div id="error">Some text</div>
        <form id="myform">
            <input type="text" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="button" value="Login" id="login_button"><br>
        </form>
    </div>
</body>
</html>

<script>
    function _(element) {
        return document.getElementById(element);
    }

    var login_button = _("login_button");
    login_button.addEventListener("click", collect_data);

    function collect_data() {
        login_button.disabled = true;
        login_button.value = "Loading...Please wait...";

        var myform = _("myform");
        var inputs = myform.getElementsByTagName("input");
        var data = {};

        for(var i = inputs.length - 1; i >= 0; i--) {
            var key = inputs[i].name;

            switch(key) {
                case "email":
                    data.email = inputs[i].value;
                    break;
                case "password":
                    data.password = inputs[i].value;
                    break;
            }
        }
        send_data(data, "login");

    }

    function send_data(data, type) {
        var xml = new XMLHttpRequest();
        xml.onload = function() {
            if(xml.readyState == 4 || xml.status == 200) {
                handle_result(xml.responseText);
                login_button.disabled = false;
                login_button.value = "Login";
            }
        }
        data.data_type = type;
		var data_string = JSON.stringify(data);

		xml.open("POST", "api.php", true);
		xml.send(data_string);
    }

    function handle_result(result) {
        var data = JSON.parse(result);
        if (data.data_type == "info") {
            window.location = "index.php";
        } else {
            var error = _("error");
            error.innerHTML = data.message;
            error.style.display = "block";
        }
    }

</script>