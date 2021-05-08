<?php

include_once("model/account.php");

class Model {

    private $server;
    private $dbname;
    private $username;
    private $password;
    private $pdo;
	# define the constructor which has four arguments for $server, $dbname, $username, $password. 
	# The $pdo field should be assigned as null
    public function __construct($server, $dbname, $username, $password) {
        $this -> server = $server;
        $this -> dbname = $dbname;
        $this -> username = $username;
        $this -> password = $password;
        $this -> pdo = null;
    }





    #Define a Connect() function to create the $pdo as a PDO object based on the four fields $server, $dbname, $username, $password. 
	#Using the try/catch structure to handle the database connection error
    public function Connect() {
        try {
            $this-> pdo = new PDO("mysql:dbname=" . $this->dbname . ";host=" . $this->server, $this->username, $this->password);
        } catch (Exception $e) {
            echo 'Caught exception ', $e -> getMessage(), '\n';
        }
    }
  
  

    #method to get an account by id, returns an account object
	#it querys database and create an object account if the id exists in database; 
	#return null otherwise
    public function getAccountById($id) {
        $rows = ($this -> pdo) -> query("SELECT * FROM savings WHERE id='" . $id . "';");
        foreach ($rows as $row) {
            return new Account($row["id"], $row["balance"]);
        }
        return null;
	}

	#method to withdraw money from account
	#returns the new balance after withdraw amount from account; return null if failure
	#it update balance of user id in the database
	#should check whether amount is less than or equal to current balance
    public function withdraw($id, $amount) {
        try {

            $rows = ($this->pdo)->query("SELECT * FROM savings WHERE id='" . $id . "';");
            foreach ($rows as $row) {
                if ($row["balance"] >= $amount) {
                    $newBalance = $row["balance"] - $amount;
                    ($this->pdo)->exec("UPDATE savings SET balance = " . $newBalance . " WHERE id = '" . $id . "';");
                    return $newBalance;
                } else {
                    return null;
                }
            }
            return null;
        } catch (PDOException $ex) {
            echo $ex -> getMessage();
                return null;
        }
    }
	
	
	#method to deposit amount to account id
	#returns the new balance after depositing amount to account; return null if failure
	#it update balance of user id in the database
    public function deposit($id, $amount) {
        try {
            $rows = ($this->pdo)->query("SELECT * FROM savings WHERE id='" . $id . "';");
            foreach ($rows as $row) {
                $newBalance = $row["balance"] + $amount;
                ($this->pdo)->exec("UPDATE savings SET balance = " . $newBalance . " WHERE id = '" . $id . "';");
                return $newBalance;
            }
            return null;
        } catch (PDOException $ex) {
            return null;
        }
	}
}
?>