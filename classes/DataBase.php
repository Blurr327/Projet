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

    public function fetch_user($connection,$nickname){ // renvoie les lignes de l'utilisateur concerné
        $req= 'SELECT * FROM users WHERE nickname=\'' . mysqli_real_escape_string($connection,$nickname) . '\'';
        return $this->query($connection,$req);
    }

    public function insert_user($connection,$firstname,$lastname,$nickname,$password){ // ajoute l'utilisateur à la base de donnée
        $req='INSERT INTO users(firstname, lastname, nickname, password, signup_date) VALUES (\''. mysqli_real_escape_string($connection,$firstname) . '\',\''. mysqli_real_escape_string($connection,$lastname)  . '\',\'' . mysqli_real_escape_string($connection,$nickname) . '\',\''. md5(mysqli_real_escape_string($connection,$password)) .'\',\''. date("Y-m-d h:i:s") .'\')';
        return $this->query($connection,$req);
    }
    
    
}
?>