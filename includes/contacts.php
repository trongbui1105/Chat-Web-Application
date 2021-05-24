<?php
    // sleep(2);
    $myid = $_SESSION['userid'];
    $sql = "select * from users where userid != '$myid' limit 10";
    $myusers = $DB->read($sql, []);
    $mydata = ' 
                <style>
                    @keyframes appear {
                        0%{opacity: 0; transform: translateY(50px)}
                        100%{opacity: 1; transform: translateY(0px)}
                    }

                    #contact {
                        cursor: pointer;
                        transition: all .5s cubic-bezier(0.68, -2, 0.265, 1.55);
                        // width:  200px;
                        max-height: 100%;
                        max-width: 100%;   
                        margin: 20px;
                        object-fit: contain;
                    }

                    #contact:hover {
                        transform: scale(1.2);
                    }
                </style>
                <div style="text-align: center; animation: appear 1s ease;">
                ';

    if (is_array($myusers)) {
        // check for new messages
        $msgs = array();
        $me = $_SESSION['userid'];
        $query = "select * from messages where receiver = '$me' && received = 0";
        $mymgs = $DB->read($query,[]);
        

        if (is_array($mymgs)){
            foreach ($mymgs as $row2) {
                $sender = $row2->sender;
                if(isset($msgs[$sender])){
                    $msgs[$sender]++;
                } else{
                    $msgs[$sender] = 1;
                }
            }
        }

        

        foreach ($myusers as $row) {
            $image = ($row->gender == "Male") ? "ui/images/user_male.jpg" : "ui/images/user_female.jpg";
            if (file_exists($row->image)) {
                $image = $row->image;
            }

            $mydata .= "<div id='contact' style='position: relative;' userid='$row->userid' onclick='start_chat(event)'>
                                <img src='$image'>
                                <br>$row->username";
           
            if (count($msgs) > 0 && isset($msgs[$row->userid])) {
                $mydata .= "<div style='width: 25px; height: 25px; border-radius: 50%;
                            background-color: orange; color: white; position: absolute; left: 0px; top: 0px;'>
                                ".$msgs[$row->userid]."
                            </div>";
            }

            $mydata .= "</div>";
        }
    }
    $mydata .= '</div>';

    // $result = $result[0];
    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);

    die;

    $info->message = "No contacts were found";
    $info->data_type = "error";
    echo json_encode($info);
?>
    