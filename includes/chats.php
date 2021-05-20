<?php

    $arr['userid'] = "null";
    if (isset($DATA_OBJ->find->userid)) {
        $arr['userid'] = $DATA_OBJ->find->userid;
    } 
    
    $refresh = false;
    if ($DATA_OBJ->data_type == "chats_refresh"){
		$refresh = true;
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
        $mydata = "";
        if (!$refresh) {
            $mydata =   "Now Chatting with: <br>
                        <div id='active_contact'>
                            <img src='$image'>
                            <br>$row->username
                        </div>";
        }

        $messages = "";
        if (!$refresh) {
            $messages =    "<div id='messages_holder_parent' style='height: 698px;'>
                            <div id='messages_holder' style='height: 640px; overflow-y:scroll;'>";
        }

        // read from db
        $a['sender'] = $_SESSION['userid'];
 		$a['receiver'] = $arr['userid'];


        $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) order by id desc limit 10";
        $result2 = $DB->read($sql, $a);

        if (is_array($result2)) {
            $result2 = array_reverse($result2);
            foreach ($result2 as $data) {
                $myuser = $DB->get_user($data->sender);
                if ($_SESSION['userid'] == $data->sender){
                    $messages .= message_right($data,$myuser);
                }else {
                    $messages .= message_left($data,$myuser);
                }
            }
        }

        if (!$refresh) {
            $messages .= message_controls();
        }  

        $info->user = $mydata;
        $info->messages = $messages;
        $info->data_type = "chats";
		if($refresh){
			$info->data_type = "chats_refresh";
		}
		echo json_encode($info);
    } else {

        // read from db
        $a['userid'] = $_SESSION['userid'];
 
        $sql = "select * from messages where (sender = :userid || receiver = :userid) group by msgid order by id desc limit 10";
		$result2 = $DB->read($sql,$a);

		$mydata = "Previews Chats:<br>";
        if (is_array($result2)) {
            $result2 = array_reverse($result2);
            foreach ($result2 as $data) {
                $other_user = $data->sender;
                if ($data->sender == $_SESSION['userid']) {
                    $other_user = $data->receiver;
                }

                $myuser = $DB->get_user($other_user);

                $image = ($myuser->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
                if (file_exists($myuser->image)) {
                    $image = $myuser->image;
                }

                $mydata .=   "
                            <div id='active_contact' userid='$myuser->userid' onclick='start_chat(event)' style='cursor: pointer;'>
                                <img src='$image'>
                                $myuser->username <br>
                                <span style='font-size: 15px;'>$data->message</span>
                            </div>";
            }
        }

        $info->user = $mydata;
		$info->messages = "";
 		$info->data_type = "chats";
 
		echo json_encode($info);
    }

    
?>
    