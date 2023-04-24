<?php
class DataBase{
    private static $host="localhost";
    private static $username="root";
    private static $password="";
    private static $database="BaseBlackboard";

    public function connect(){ // connexion à la base de donnée
        $connection= mysqli_connect($this->host,$this->username,$this->password,$this->databse);
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

    public function fetch_user($connection,$nickname){ // renvoie le les lignes de l'utilisateur concerné
        $req= 'SELECT * FROM users WHERE nickname=\'' . mysqli_real_escape_string($connection,$nickname) . '\'';
        return $this->query($connection,$req);
    }

    public function insert_user($connection,$firstname,$lastname,$nickname,$password){ // ajoute l'utilisateur à la base de donnée
        $req='INSERT INTO users(firstname, lastname, nickname, password) VALUES (\''. mysqli_real_escape_string($connexion,$firstname) . '\',\''. mysqli_real_escape_string($connexion,$lastname)  . '\',\'' . mysqli_real_escape_string($connexion,$nickname) . '\',\''. md5(mysqli_real_escape_string($connexion,$password)) .'\')';
        return $this->query($connection,$req);
    }
    
    
}
?>