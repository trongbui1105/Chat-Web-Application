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
        min-height: 500px;
        display: flex;
        margin: auto;
        color: white;
        font-family: myFont;
        font-size: 16px;
    }

    #left_panel {
        min-height: 500px;
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
        min-height: 500px;
        flex: 4;
        text-align: center;
    }

    #header {
        background-color: #485b6c;
        height: 80px;
        font-size: 45px;
        text-align: center;
        font-family: headFont;
    }

    #inner_left_panel {
        background-color: #383e48;
        flex: 1;
        min-height: 430px;
    }

    #inner_right_panel {
        background-color: #f2f7f8;
        flex: 2;
        min-height: 430px;
        transition: all 2s ease;
    }
/* 
    #radio_chat:checked ~ #inner_right_panel {
        flex: 2;
    } */

    #radio_contacts:checked ~ #inner_right_panel {
        flex: 0;
    }

    #radio_settings:checked ~ #inner_right_panel {
        flex: 0;
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
                </div>
            </div>
        </div>
        <div id="right_panel">
            <div id="header">My Chat</div>
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

    function get_data(find, type) {
        var xml = new XMLHttpRequest();
        xml.onload = function() {
            if (xml.readyState == 4 || xml.status == 200) {
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
            if (!obj.logged_in) {
                window.location = "login.php";
            } else {
                alert(result);
            }
        }
    }

    get_data({},"user_info");
    // get_data({}, "signup");

</script>