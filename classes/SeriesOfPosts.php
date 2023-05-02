<?php

class SeriesOfPosts{
    
    public function get_num_pages_for_timeline($connection, $session){
        $POST= new Post();
        $num_posts = $POST->get_number_of_posts($connection, $session);
        $tmp=1;
        while($tmp*14<$num_posts){ 
            $tmp++;
        }
        return $tmp;
    }

  
    
}

?>