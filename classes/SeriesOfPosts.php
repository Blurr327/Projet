<?php

class SeriesOfPosts{
    
    public function get_num_pages_for_timeline($connection, $session, $timeline_or_user, $user_id_profile){
        $POST= new Post();
        $num_posts = $POST->get_number_of_posts($connection, $session, $timeline_or_user, $user_id_profile);
        $tmp=1;
        while($tmp*14<$num_posts){ 
            $tmp++;
        }
        return $tmp;
    }

    
  
    
}

?>