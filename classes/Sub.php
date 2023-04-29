<?php
class Sub {

    public function fetch_list_of_followed($connection,$user_id){ // renvoie un tableau (d'indices) des identifiants des utilisateurs suivi par l'utilisateur en question
        $DB=new DataBase();
        $list_of_followed=array();
        $req="SELECT followed_id FROM follower_and_followed WHERE follower_id=$user_id" ;
        $result=$DB->query($connection,$req);
        while($line = mysqli_fetch_assoc($result)){
            $list_of_followed[]=$line['followed_id'];
        }
        return $list_of_followed;
    }
    
    public function fetch_list_of_followers($connection,$user_id){ // renvoie un tableau (d'indices) des identifiants des utilisateurs qui suivent l'utilisateur en question
        $DB=new DataBase();
        $list_of_followers=array();
        $req="SELECT follower_id FROM follower_and_followed WHERE followed_id=$user_id" ;
        $result=$DB->query($connection,$req);
        while($line = mysqli_fetch_assoc($result)){
            $list_of_followers[]=$line['followed_id'];
        }
        return $list_of_followers;
    }

    public function get_number_of_followers($connection, $user_id){
        return count(fetch_list_of_followers($connection,$user_id));
    }

    public function get_number_of_followed($connection, $user_id){
        return count(fetch_list_of_followed($connection,$user_id));
    }

    public function does_follow($connection, $potential_follower_id, $potential_followed_id){
        foreach(fetch_list_of_followers($potential_followed_id) as $follower_id){
            if($follower_id === $potential_follower_id) return true;
        }
        return false;
    }

}
?>