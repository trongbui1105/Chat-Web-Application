<?php

    $info = (Object)[];
    $data = false;

    // validate info
    $data['email'] = $DATA_OBJ->email;

    if (empty($DATA_OBJ->email)) {
        $Error = "Please enter a valid email";
    }

    if (empty($DATA_OBJ->password)) {
        $Error = "Please enter a valid password";
    }

    if ($Error == "") {
        $query = "select * from users where email = :email limit 1";
        
        $result = $DB->read($query, $data);
        
    
        if (is_array($result)) {
            $result = $result[0];
            if ($result->password == $DATA_OBJ->password) {
                $_SESSION['user_id'] = $result->userid;
                $info->message = "You logged in succesfully";
                $info->data_type = "info";
                echo json_encode($info);
            } else {
                $info->message = "Wrong password";
                $info->data_type = "error";
                echo json_encode($info);
            }
        } else {
            $info->message = "Wrong email";
            $info->data_type = "error";
            echo json_encode($info);
        }
    } else {
        $info->message = $Error;
        $info->data_type = "error";
        echo json_encode($info);
    }