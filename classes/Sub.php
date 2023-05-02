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

    public function follow_user($connection, $follower_id, $followed_id){
        $DB=new DataBase();
        $req="INSERT INTO follower_and_followed(follower_id, followed_id) VALUES ($follower_id, $followed_id)";
        return $DB->query($connection, $req);  
    }

    public function unfollow_user($connection, $follower_id, $followed_id){
        $DB=new DataBase();
        $req="DELETE FROM follower_and_followed WHERE follower_id=$follower_id AND followed_id=$followed_id";
        return $DB->query($connection, $req);
    }

    public function simple_follower_and_followed_display($connection, $get, $session){
        $user_id_profile = (abs(intval($get['userid'])) === 0) ? 1 :abs(intval($get['userid']));
        $current_user_id=$session['id'];

        if($current_user_id !== $user_id_profile){ // un utilisateur ne peut pas s'abonner à lui même
            $follow_status='S\'abonner';
            if($this->does_follow($connection, $current_user_id,$user_id_profile)) $follow_status='Se désabonner'; //  mise à jour du status de l'abonnement
            $follow_button="
                <form action='profile.php?action=show&order=recent&userid=$user_id_profile' method='post'>
                    <input type='submit' name='$follow_status' value=\"$follow_status\">
                </form>
            ";
        }

        $num_followers= $this->get_number_of_followers($connection, $user_id); // accès au nombre d'abonnées...
        $num_followed= $this->get_number_of_followed($connection, $user_id);

        return "
            <div id='followblock'>
                $follow_button
                <p id='numfollowers'>$num_followers</p>
                <p id='numfollowed'>$num_followed</p>
            </div>
        ";
    }

    public function display_follower_and_followed($connection, $get, $session, $data){
        $profile_page_user_id=(abs(intval($get['userid'])) === 0 ) ? 1 :abs(intval($get['userid']));
        $current_user_id=$session['id'];
        if(!empty($data['S\'abonner'])){
            $this->follow_user($connection, $current_user_id, $profile_page_user_id);
        }
        if(!empty($data['Se désabonner'])){
            $this->unfollow_user($connection, $current_user_id, $profile_page_user_id);
        }
        return simple_follower_and_followed_display($connection, $get, $session);
    }


    public function undo_followers_and_followed_of($connection, $user_id){
        $DB= new DataBase();
        $req = "DELETE FROM follower_and_followed WHERE followed_id=$user_id OR follower_id=$user_id";
        return $DB->query($connection, $req);
    }


}
?>
