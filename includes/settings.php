<?php
    // sleep(2);

    $sql = "select * from users where userid = :userid limit 1";
    $id = $_SESSION['userid'];
    $data = $DB->read($sql, ['userid'=>$id]);

    
    $image = ($row->gender == "Male") ? "ui/images/user_male.jpeg" : "ui/images/user_female.jpeg";
    if (file_exists($row->image)) {
        $image = $row->image;
    }

    $mydata = "";
    if (is_array($data)) {
        $data = $data[0];

        $mydata = '
            <style type="text/css">
                form {
                    text-align: left;
                    margin: auto;
                    padding: 100px;
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

                #error {
                    text-align: center;
                    padding: 0.5em; 
                    background-color: #ecaf91; 
                    color: white; 
                    display: none;
                }

                #change_image_button {
                    background-color: #9b9a80;
                    width: 200px;
                    margin-left: 80px;
                }
            </style>

            <div id="error" style="">Error</div>
            <div style="display: flex;">
                <div>
                    <img src="ui/images/user_male.jpg" style="width: 200px; height: 200px; margin-left: 70px; margin-top: 70px;" />
                    <input type="button" value="Change Image" id="change_image_button">
                </div>
                <form id="myform">
                    <input type="text" name="username" placeholder="Username" value="'.$data->username.'"><br>
                    <input type="text" name="email" placeholder="Email" value="'.$data->email.'"><br>
                    <div style="padding: 10px;">
                        <br>Gender:<br>
                        <input type="radio" value="Male" name="gender_male">Male<br>
                        <input type="radio" value="Female" name="gender_female">Female<br>
                    </div>
                    <input type="text" name="password" placeholder="Password" value="'.$data->password.'"><br>
                    <input type="text" name="password2" placeholder="Retype Password" value="'.$data->password.'"><br>
                    <input type="button" value="Save Settings" id="signup_button"><br>
                </form>

            </div>

            <script>
                function _(element) {
                    return document.getElementById(element);
                }

                var signup_button = _("signup_button");
                signup_button.addEventListener("click", collect_data);

                function collect_data() {
                    signup_button.disabled = true;
                    signup_button.value = "Loading...Please wait...";

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
                            case "gender_male":
                            case "gender_female":
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
                    send_data(data, "signup");

                }

                function send_data(data, type) {
                    var xml = new XMLHttpRequest();
                    xml.onload = function() {
                        if(xml.readyState == 4 || xml.status == 200) {
                            handle_result(xml.responseText);
                            signup_button.disabled = false;
                            signup_button.value = "Signup";
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
            ';
    }

    // $result = $result[0];
    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found";
    $info->data_type = "error";
    echo json_encode($info);
?>
    