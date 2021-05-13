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
        $row->image = $image;
        $mydata =   "Now Chatting with: <br>
                    <div id='active_contact'>
                                <img src='$image'>
                                <br>$row->username
                        </div>";

        $messages =    "
                        <div id='messages_holder_parent' style='height: 698px;'>
                            <div id='messages_holder' style='height: 640px; overflow-y:scroll;'>";
        $messages .= message_left($row);
        $messages .= "
                            </div>

                            <div style='display: flex; width: 100%; height: 60px;'>
                                <input style='flex:6; border: none; font-size: 15px; padding: 6px;' type='text' placeholder='Type your message' />
                                <input style='flex:1; cursor: pointer;' type='button' value='Send' />
                            </div>
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
    