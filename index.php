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
        max-width: 1200px;
        min-height: 600px;
        display: flex;
        margin: auto;
        color: white;
        font-family: myFont;
        font-size: 16px;
    }

    #left_panel {
        min-height: 700px;
        background-color: #27344b;
        flex: 1;
        text-align: center;
    }

    #profile_image {
        width: 50%;
        border: solid thin white;
        border-radius: 50%;
        margin: 10px;
    }

    #left_panel label {
        width: 100%;
        height: 20px;
        display: block;
        background-color: #404b56;
        border-bottom: solid thin #ffffff55;
        cursor: pointer;
        padding: 2px;
        transition: all 1s ease;
    }

    #left_panel label:hover {
        background-color: #778593;
    }

    #left_panel label img{
        float: right;
        width: 25px;
    }

    #right_panel {
        min-height: 700px;
        flex: 4;
        text-align: center;
    }

    #header {
        background-color: #485b6c;
        height: 80px;
        font-size: 45px;
        text-align: center;
        font-family: headFont;
        position: relative;
    }

    #inner_left_panel {
        background-color: #383e48;
        flex: 1;
        min-height: 700px;
    }

    #inner_right_panel {
        background-color: #f2f7f8;
        flex: 2;
        min-height: 700px;
        transition: all 2s ease;
    }

    #radio_contacts:checked ~ #inner_right_panel {
        flex: 0;
    }

    #radio_settings:checked ~ #inner_right_panel {
        flex: 0;
    }

    #contact {
        width: 150px;
        height: 150px;
        margin: 10px;
        display: inline-block;
        vertical-align: top;
        /* overflow: hidden; */
    }

    #contact img {
        width: 100%;
    }

    .loader_on {
        position: absolute;
        width: 30%;
    }

    .loader_off {
        display: none;
    }
</style>

<body>
    <div id="wrapper">
        <div id="left_panel">
            <div id="user_info" style="padding: 10px;">
                <img id="profile_image" src="ui/images/user_male.jpg">
                <br>
                <span id="username">Username</span>
                <br>
                <span id="email" style="font-size: 15px; opacity: 0.5;">email@gmail.com</span>
                
                <br>
                <br>
                <br>

                <div>
                    <label id="label_chat" for="radio_chat">Chat <img src="ui/icons/chat.png"></label>
                    <label id="label_contacts" for="radio_contacts">Contacts <img src="ui/icons/contacts.png"></label>
                    <label id="label_settings" for="radio_settings">Settings <img src="ui/icons/settings.png"></label>
                    <label id="logout" for="radio_logout">Logout <img src="ui/icons/logout-icon.png"></label>
                </div>
            </div>
        </div>
        <div id="right_panel">
            <div id="header">
                <div id="loader_holder" class="loader_on"> <img style="width: 70px;" src="ui/icons/giphy.gif"> </div>
                My Chat
            </div>
            <div id="container" style="display: flex;">
                <div id="inner_left_panel">
                    
                </div>

                <input type="radio" id="radio_chat" name="myradio"  style="display: none;">
                <input type="radio" id="radio_contacts" name="myradio" style="display: none;">
                <input type="radio" id="radio_settings" name="myradio" style="display: none;">

                <div id="inner_right_panel">

                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    function _(element) {
        return document.getElementById(element);
    }

    var label_contacts = _("label_contacts");
    label_contacts.addEventListener("click",get_contacts);

    var label_chat = _("label_chat");
    label_chat.addEventListener("click",get_chats);

    var label_settings = _("label_settings");
    label_settings.addEventListener("click",get_settings);

    var logout = _("logout");
    logout.addEventListener("click", logout_user);

    function get_data(find, type) {
        var xml = new XMLHttpRequest();
        var loader_holder = _("loader_holder");
        loader_holder.className = "loader_on";
        xml.onload = function() {
            if (xml.readyState == 4 || xml.status == 200) {
                loader_holder.className = "loader_off";
                handle_result(xml.responseText, type);
            }
        }
        var data = {};
        data.find = find;
        data.data_type = type;
        data = JSON.stringify(data);

        xml.open("POST", "api.php", true);
        xml.send(data);
    }

    function handle_result(result, type) {
        if (result.trim() != "") {
            var obj = JSON.parse(result);
            if (typeof(obj.logged_in) != "undefined" && !obj.logged_in) {
                window.location = "login.php";
            } else {
                switch(obj.data_type) {
                    case "user_info":
                        var username = _("username");
                        var email = _("email");
                        var profile_image = _("profile_image");

                        username.innerHTML = obj.username;
                        email.innerHTML = obj.email;
                        profile_image.src = obj.image;
                        break;
                    case "contacts":
                        var inner_left_panel = _("inner_left_panel");
                        inner_left_panel.innerHTML = obj.message;
                        break;
                    case "chats":
                        var inner_left_panel = _("inner_left_panel");
                        inner_left_panel.innerHTML = obj.message;
                        break;
                    case "settings":
                        var inner_left_panel = _("inner_left_panel");
                        inner_left_panel.innerHTML = obj.message;
                        break;
                    case "save_settings":
                        alert(obj.message);
                        get_data({},"user_info");
                        get_settings(true);
                        break;
                }
            }
        }
    }

    function logout_user() {
        var answer = confirm("Are you sure you want to logout");
        if (answer) {
            get_data({}, "logout");
        }
    }

    get_data({},"user_info");

    function get_contacts(e) {
        get_data({}, "contacts");
    }

    function get_chats(e) {
        get_data({}, "chats");
    }

    function get_settings(e) {
        get_data({}, "settings");
    }

</script>

<script>

    function collect_data() {
        var save_settings_button = _("save_settings_button");
        save_settings_button.disabled = true;
        save_settings_button.value = "Loading...Please wait...";

        var myform = _("myform");
        var inputs = myform.getElementsByTagName("input");
        var data = {};

        for(var i = inputs.length - 1; i >= 0; i--) {
            var key = inputs[i].name;

            switch(key) {
                case "username":
                    data.username = inputs[i].value;
                    break;
                case "email":
                    data.email = inputs[i].value;
                    break;
                case "gender":
                    if (inputs[i].checked) {
                        data.gender = inputs[i].value;
                    }
                    break;
                case "password":
                    data.password = inputs[i].value;
                    break;
                case "password2":
                    data.password2 = inputs[i].value;
                    break;
            }
        }
        send_data(data, "save_settings");

    }

    function send_data(data, type) {
        var xml = new XMLHttpRequest();
        xml.onload = function() {
            if(xml.readyState == 4 || xml.status == 200) {
                handle_result(xml.responseText);
                var save_settings_button = _("save_settings_button");
                save_settings_button.disabled = false;
                save_settings_button.value = "Signup";
            }
        }
        data.data_type = type;
        var data_string = JSON.stringify(data);

        xml.open("POST", "api.php", true);
        xml.send(data_string);
    }


</script>