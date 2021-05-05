<?php

    $mydata = '<div style="text-align: center;">
                    <div id="contact">
                        <img src="ui/images/cr7.jpeg">
                        <br>Username
                    </div>

                    <div id="contact">
                        <img src="ui/images/m10.jpeg">
                        <br>Username
                    </div>

                    <div id="contact">
                        <img src="ui/images/h10.jpeg">
                        <br>Username
                    </div>
                </div>';

    // $result = $result[0];
    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found";
    $info->data_type = "error";
    echo json_encode($info);
?>
    