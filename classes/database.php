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
            foreach ($data_array as $key => $value) {
                $statement->bindParam(':'.$key, $value);
            }
            $check = $statement->execute();
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage() . "<br/>";
            return $error;
            die();
        }

        if ($check) {
            return true;
        } else {
            return false;
        }
        
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
