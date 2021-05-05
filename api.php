<?php

    session_start();

    $DATA_RAW = file_get_contents("php://input");
    $DATA_OBJ = json_decode($DATA_RAW);
    //check if logged in
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
    

    $Error = "";

    // process the data
    if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup") {
        include("includes/signup.php");
    } 
    else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login") {
        include("includes/login.php");
    }
    else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "logout") {
        include("includes/logout.php");
    }
    else if (isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "user_info") {
        include("includes/user_info.php");
    }

