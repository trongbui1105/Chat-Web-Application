<?php

    $arr['userid'] = $DATA_OBJ->find->userid;
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
        $info->message = $mydata;
        $info->data_type = "chats";
        echo json_encode($info);
    } else {
        $info->message = "That contacts was not found";
        $info->data_type = "error";
        echo json_encode($info);
    }

    
?>
    