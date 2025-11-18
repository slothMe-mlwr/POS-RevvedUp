<?php

/*define("db_host", "localhost");
define("db_user", "root");
define("db_pass", "hnyjnmrl0207.MYSQL");
define("db_name", "tryrevvedup");*/

define("db_host", "localhost");
define("db_user", "u185723031_revvedup2");
define("db_pass", "u185723031_revvedup2@A");
define("db_name", "u185723031_revvedup2");

class db_connect
{
    public $host = db_host;
    public $user = db_user;
    public $pass = db_pass;
    public $name = db_name;
    public $conn;
    public $error;
    public $mysqli;


    public function connect()
    {
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

            if (!$this->conn) {
                $this->error = "Fatal Error: Can't connect to database" . $this->conn->connect_error;
                return false;
            }
        } catch (\Throwable $th) {
            header("Location:setup.php");
        }
    }
}