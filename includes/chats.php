<?php

    $arr['userid'] = "null";
    if (isset($DATA_OBJ->find->userid)) {
        $arr['userid'] = $DATA_OBJ->find->userid;
    } 
    
    $sql = "select * from users where userid = :userid limit 1";
    $result = $DB->read($sql, $arr);

    if (is_array($result)) {
        $row = $result[0];
        $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
        if (file_exists($row->image)) {
            $image = $row->image;
        }
        $mydata =   "Now Chatting with: <br>
                    <div id='active_contact'>
                                <img src='$image'>
                                <br>$row->username
                        </div>";

        $messages =    "
                        <div id='message_left'>
                            <div></div>
                            <img src='$image'>
                            <b>$row->username</b> <br>
                            This is a test message <br> <br>
                            <span style='font-size: 13px; color: #878281;'>12 May 2021 21:30 pm</span>
                        </div>
                        <div id='message_right'>
                            <div></div>
                            <img src='$image' style='float:right'>
                            <b>$row->username</b> <br>
                            This is a test message <br> <br>
                            <span style='font-size: 13px; color: #878281;'>12 May 2021 21:30 pm</span>
                        </div>
                        ";
        $info->user = $mydata;
        $info->messages = $messages;
        $info->data_type = "chats";
        echo json_encode($info);
    } else {
        $info->message = "That contacts was not found";
        $info->data_type = "chats";
        echo json_encode($info);
    }

    
?>
    