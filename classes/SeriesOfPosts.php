<?php

class SeriesOfPosts{
    
    public function get_num_pages($posts_array){
        $POST= new Post();
        $num_posts = $POST->get_number_of_posts($posts_array);
        $tmp=1;
        while($tmp*14<$num_posts){ 
            $tmp++;
        }
        return $tmp;
    }

    
    public function update_session_order(&$session, $get){
        if(!isset($session['order']) || isset($get['dropdown'])){ // pour garder l'ordre préféré pendant la session
            $session['order']=htmlspecialchars($get['order']);
            $order=htmlspecialchars($get['order']);
        }
    }

    public function get_num_shown($posts_array, $starting_point){ // renvoie le nombre de postes affiché
        return (count($posts_array) < $starting_point+14) ? count($posts_array) : $starting_point+14;
    }

    public function get_posts_array($connection,$get, $session,$page,$order){
        $POST= new Post();
        switch($page){
            case 'profile':
                $user_id_profile=$get['userid'];
                return $POST->get_posts_for_profile($connection, $order, $user_id_profile);
            case 'timeline':
                $user_id=$session['id'];
                return $POST->get_posts_for_timeline($connection, $user_id, $order);
        }
    }
    
}

?>