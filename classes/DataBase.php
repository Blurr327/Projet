<?php
class DataBase{
    private $host="localhost";
    private $username="root";
    private $password="";
    private $database="BaseBlackboard";

    public function connect(){ // connexion à la base de donnée
        $connection= mysqli_connect($this->host,$this->username,$this->password,$this->database);
        if(!$connection){
            return "Pas de connexion au serveur";
        }
        mysqli_set_charset($connection,'utf8');
        return $connection;
    }

    public function query($connection,$request){ // passer une requête 
        $result=mysqli_query($connection,$request);
        if(!$result){
            return mysqli_error($connection);
        }
        return $result;
    }

    
}
?>