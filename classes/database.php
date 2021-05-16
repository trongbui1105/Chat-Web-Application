<?php

Class Database {
    private $con;

	//construct
	function __construct(){
		$this->con = $this->connect();
	}

	//connect to db
	private function connect() {
        require 'config.php';
        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8mb4";
		try {
			$connection = new PDO($dsn, $user, $password);
            if (!$connection) {
                echo "Connected to the $db database fail!\n";
            }
			return $connection;
		} catch(PDOException $e) {
			echo $e->getMessage();
			die;
		}

		return false;
	}

    //write to db
    public function write($query, $data_array = []) {
        $con = $this->connect();
        try {
            $statement = $con->prepare($query);
            $check = $statement->execute($data_array);
            
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage() . "<br>";
            return $error;
            die();
        }

        if ($check) {
            return true;
        } else {
            return false;
        }
        
    }

    //read to db
    public function read($query, $data_array = []) {
        $con = $this->connect();
        try {
            $statement = $con->prepare($query);
            $check = $statement->execute($data_array);
            
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage() . "<br>";
            return $error;
            die();
        }

        if ($check) {
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result) > 0) {
                return $result;
            }
            return false;
        } else {
            return false;
        }
        
    }
    public function get_user($userid) {
        $con = $this->connect();
        try {
            $arr['userid'] = $userid;
            $query = "select * from users where userid = :userid limit 1";
            $statement = $con->prepare($query);
            $check = $statement->execute($arr);
            
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage() . "<br>";
            return $error;
            die();
        }

        if($check) {
			$result = $statement->fetchAll(PDO::FETCH_OBJ);
			if(is_array($result) && count($result) > 0) {
				return $result[0];
			}
			return false;
		}
		return false;
        
    }

    

    public function generate_id($max) {
		$rand = "";
		$rand_count = rand(4,$max);
		for ($i = 0; $i < $rand_count; $i++) { 
			# code...
			$r = rand(0,9);
			$rand .= $r;
		}

		return $rand;
	}

    
}
