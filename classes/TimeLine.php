<?php

class TimeLine{
    
    public function simple_display_timeline($connection, $get, $session, $order){
        $POST = new Post();
        $show = $show=(abs(abs($get['show'])) === 0) ? 1 :abs(intval($get['show'])) ; // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive
        $posts=$POST->simple_display_timeline_posts($connection, $session, $get, $order);
    }
    
}

?>