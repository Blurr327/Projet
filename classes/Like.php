<?php

class Like{

    public function get_num_likes($connection, $post_id){
        $DB= new DataBase();
        $req ="SELECT * FROM likes WHERE liked_id=$post_id";
        $result= $DB->query($connection, $req);
        return mysqli_num_rows($result);
    }

    public function like_post($connection, $liker_id, $liked_id){ // ajouter un like à la base de donnée
        $DB=new DataBase();
        $req="INSERT INTO likes(liker_id, liked_id) VALUES ($liker_id, $liked_id)";
        return $DB->query($connection,$req);
    }

    public function unlike_post($connection, $liker_id, $liked_id){ // supprimer un like de la base de donnée
        $DB=new DataBase();
        $req="DELETE FROM likes WHERE liker_id=$liker_id AND liked_id=$liked_id";
        return $DB->query($connection,$req);
    }

    public function does_like($connection, $liker_id, $liked_id){ // vérifie si l'utilisateur de l'id : $liker_id a aimé le post de l'id: $liked_id
        $DB= new DataBase();
        $req="SELECT * FROM likes WHERE liker_id=$liker_id AND liked_id=$liked_id";
        $result = $DB->query($connection, $req);
        return mysqli_num_rows($result) > 0;
    }

    public function undo_likes_of($connection, $post_id){
        $DB= new DataBase();
        $req="DELETE FROM likes WHERE liked_id=$post_id";
        return $DB->query($connection, $req);
    }

    public function undo_likes_of_user($connection, $user_id){
        $DB= new DataBase();
        $req="DELETE FROM likes WHERE liker_id=$user_id";
        return $DB->query($connection, $req);
    }

    public function update_like_on_posts($connection, $data){
        if(!empty($data['like'])){
            $LIKE->like_post($connection, $session['id'], $post_id); // l'ajout du like à la base de donnée
        }
        if(!empty($data['unlike'])){
            $LIKE->unlike_post($connection, $session['id'], $post_id); // la suppression du like de la base de donnée
        }
    }
}
?>