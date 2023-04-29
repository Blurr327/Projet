<?php

class User{

    public function fetch_user($connection,$nickname){ // renvoie les lignes de l'utilisateur concerné
        $DB= new DataBase();
        $req= 'SELECT * FROM users WHERE nickname=\'' . mysqli_real_escape_string($connection,$nickname) . '\'';
        return $DB->query($connection,$req);
    }

    public function insert_user($connection,$firstname,$lastname,$nickname,$password){ // ajoute l'utilisateur à la base de donnée
        $DB= new DataBase();
        $req='INSERT INTO users(firstname, lastname, nickname, password, signup_date) VALUES (\''. mysqli_real_escape_string($connection,$firstname) . '\',\''. mysqli_real_escape_string($connection,$lastname)  . '\',\'' . mysqli_real_escape_string($connection,$nickname) . '\',\''. md5(mysqli_real_escape_string($connection,$password)) .'\',\''. date("Y-m-d h:i:s") .'\')';
        return $DB->query($connection,$req);
    }
    
    public function get_user_id($connection,$pseudo){ // renvoie le id d'un utilisateur en utilisant son pseudo
        $DB= new DataBase();
        $req="SELECT id FROM users WHERE nickname='$pseudo'";
        $result = $DB->query($connection,$req);
        if(mysqli_num_rows($result) === 0) return "utilisateur inexistant";
        $line=mysqli_fetch_assoc($result);
        return $line['id'];
    }

    public function is_admin(&$session,$connection){ // vérifie si l'utilisateur courant est admin
        $DB= new DataBase();
        $result = $this->fetch_user($connection,$session['pseudo']);
        if($result){
            $line=mysqli_fetch_assoc($result);
            return $line['admin'] == 1;
        }
        return false;
    }

    public function get_users_posts($connection,$user_id,$starting_point,$order){ // renvoie un tableau d'indices qui contient des tableaux associatifs contenant les postes (la date de création + l'id des postes + le titre) du site crées par l'utilisateur courant (classé par $ordre )

        // $order est soit : posts.creation_date, soit : COUNT(liked_id)
        $list_of_posts=array();
        $DB=new DataBase();
        $req="SELECT posts.post_id, posts.creation_date, post_title, COUNT(liked_id), COUNT(comments.post_id) FROM posts, likes, comments WHERE author_id=$user_id AND liked_id=posts.post_id AND comments.post_id=posts.post_id AND author_id=id GROUP BY COUNT(liked_id) ORDER BY $order LIMIT $starting_point, 14"; // on ne veut afficher que 14 postes sur le timeline (pour afficher les autres on va avoir une liste déroulante qui affiche le reste en fonction de $starting_point)
        $result=$DB->query($connection,$req);
        $rows= $result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public function privileges($connection, $session, $associated_user_id){ // renvoie vrai si l'utilisateur courant a le droit de supprimer et modifier un contenu/profile/commentaire crée par l'utilisateur de l'id $associated_user_id
        return $this->is_admin($session,$connection) || $associated_user_id=$session['id'];
    }

}


?>