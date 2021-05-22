<?php

    session_start();

    $info = (object)[];
    if(!isset($_SESSION['userid'])) {
        if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login" && $DATA_OBJ->data_type != "signup") {
            $info->logged_in = false;
            echo json_encode($info);
            die;
        }
    }

    require_once("classes/autoload.php");
    $DB = new Database();

    $data_type = "";
    if (isset($_POST['data_type'])) {
        $data_type = $_POST['data_type'];
    }
    $destination = "";

    if(isset($_FILES['file']) && $_FILES['file']['name'] != ""){
        if($_FILES['file']['error'] == 0){
            $folder = "uploads";
            if(!file_exists($folder)){
                mkdir($folder,0777,true);
            }

            $destination = $folder . '/' . $_FILES['file']['name'];
            
            if (file_exists($destination)) {
                $random = "(" . rand(0, 1000) . ")";
                $destination = str_replace('.', $random . '.', $destination);
            }
           
            move_uploaded_file($_FILES['file']['tmp_name'], $destination);
            $info->message = "Your image was uploaded";
            $info->data_type = $data_type;
            echo json_encode($info);
       }
    }

    if ($data_type == "change_profile_image") {
        if ($destination != "") {
            //save to database
            $id = $_SESSION['userid'];
            $query = "update users set image = '$destination' where userid = '$id' limit 1";
            $DB->write($query, []);
        }
    } else if($data_type == "send_image") {
            $arr['userid'] = "null";
            if(isset($_POST['userid'])){
                $arr['userid'] = addslashes($_POST['userid']);
            }
    
            $arr['message'] = "";
            $arr['date'] = date("Y-m-d H:i:s");
            $arr['sender'] = $_SESSION['userid'];
            $arr['msgid'] = get_random_string_max(60);
            $arr['file'] = $destination;
    
                $arr2['sender'] = $_SESSION['userid'];
                $arr2['receiver'] = $arr['userid'];
    
                $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) limit 1";
                $result2 = $DB->read($sql, $arr2);
    
                if(is_array($result2)) {
                    $arr['msgid'] = $result2[0]->msgid;
                }
    
            $query = "insert into messages (sender,receiver,message,date,msgid,files) values (:sender,:userid,:message,:date,:msgid,:file)";
            $DB->write($query,$arr);
    }
    
    
    function get_random_string_max($length) {
    
        $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $text = "";
    
        $length = rand(4,$length);
        for($i = 0; $i < $length; $i++) {
            $random = rand(0,61);
            $text .= $array[$random];
        }
        return $text;
    }

?>