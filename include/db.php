<?php
class Database {
private $host = "http://www.tonrukfarm.com/phpmyadmin/";
private $username = "tonrukfa_sathit1";
private $password = "sathit1234";
private $dbname = "tonrukfa_sathit";

public $conn;
public function getConnection(){
    try{
        $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,
                              $this->username,$this->password);
        $this->conn->exec("set names utf8");
    }catch(PDOException $e){
        echo"Connection Error! : ".$e->getMessage();
    }
   return $this->conn;
 }
}
?>
