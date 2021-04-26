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
    }


</style>

<body>
    <div id="wrapper">
        <div id="left_panel">
            <div style="padding: 10px;">
                <img id="profile_image" src="ui/images/user3.jpg">
                <br>
                Kelly Hartmann
                <br>
                <span style="font-size: 15px; opacity: 0.5;">kellyhartmann@gmail.com</span>
                
                <br>
                <br>
                <br>

                <div>
                    <label for="box">Chat <img src="ui/icons/chat.png"></label>
                    <label>Contacts <img src="ui/icons/contacts.png"></label>
                    <label>Settings <img src="ui/icons/settings.png"></label>
                </div>
            </div>
        </div>
        <div id="right_panel">
            <div id="header">
                My Chat
            </div>
            <div id="container" style="display: flex;">
                <div id="inner_left_panel">
                    <input type="checkbox" id="box" name="">
                </div>
                <div id="inner_right_panel"></div>
            </div>
        </div>
    </div>
</body>
</html>