<?php

    $arr['userid'] = "null";
    if (isset($DATA_OBJ->find->userid)) {
        $arr['userid'] = $DATA_OBJ->find->userid;
    } 
    
    $sql = "select * from users where userid = :userid limit 1";
    $result = $DB->read($sql, $arr);

    if (is_array($result)) {
        $arr['message'] = $DATA_OBJ->find->message;
        $arr['date'] = date("Y-m-d H:i:s");
        $arr['sender'] = $_SESSION['userid'];
        $arr['msgid'] = get_random_string_max(60);

        $arr2['sender'] = $_SESSION['userid'];
        $arr2['receiver'] = $arr['userid'];

        $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) limit 1";        $result2 = $DB->read($sql, $arr2);

        if (is_array($result2)) {
            $arr['msgid'] = $result2[0]->msgid;
        }

        $query = "insert into messages (sender, receiver, message, date, msgid) values (:sender, :userid, :message, :date, :msgid)";
        $DB->write($query, $arr);

        //user found
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

        // read from db
        $a['msgid']= $arr['msgid'];

        $sql = "select * from messages where msgid = :msgid limit 10";
        $result2 = $DB->read($sql, $a);

        if (is_array($result2)) {
            foreach ($result2 as $data) {
                $messages .= message_right($data, $row);
            }
        }

        $messages .= "
                        </div>
                            <div style='display: flex; width: 100%; height: 60px;'>
                                <label for='file'><img src='ui/icons/clip.png' style='opacity: 0.8; width: 50px; margin-top: 5px; cursor:pointer'></label>
                                <input type='file' id='message_file' name='file' style='display: none'/>
                                <input id='message_text' style='flex:6; border: solid thin #ccc; border_bottom: none; font-size: 15px; padding: 6px;' type='text' placeholder='Type your message' />
                                <input style='flex:1; cursor: pointer;' type='button' value='Send' onclick='send_message(event)'/>
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

    function get_random_string_max($length) {

        $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $text = "";
    
        $length = rand(4,$length);
    
        for($i=0;$i<$length;$i++) {
    
            $random = rand(0,61);
            
            $text .= $array[$random];
    
        }
    
        return $text;
    }

    
?>
    