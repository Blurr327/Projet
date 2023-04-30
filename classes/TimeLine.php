<?php

class TimeLine{
    
    public function get_num_pages_for_timeline($connection, $session){
        $POST= new Post();
        $num_posts = $POST->get_number_of_posts($connection, $session);
        $tmp=1;
        while($tmp*14<$num_posts){
            $tmp++;
        }
        return $tmp;
    }

    public function display_drop_down_for_pages($connection, $session){
        $pages_drop_down_display="<select name='show' size='1'>";
        $num_pages= $this->get_num_pages_for_timeline($connection, $session);
        for($i=1;$i<=$num_pages;$i++){
            $pages_drop_down_display .= "<option value='$i'>$i</option>";
        }
        $pages_drop_down_display .= "</select>";
        return $pages_drop_down_display;
    }

    public function simple_display_timeline($connection, $get, $session){
        $POST = new Post();
        $order=(htmlspecialchars($get['order']) === 'like') ? 'likes' : 'posts_creation_date';
        $checked_order_like=($order==='likes') ? 'checked' : '';
        $checked_order_recent=($order==='posts_creation_date') ? 'checked': '';
        $show=(abs(intval($get['show'])) === 0) ? 1 :abs(intval($get['show'])) ; // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive
        $posts=$POST->simple_display_timeline_posts($connection, $session, $get, $order);
        $pages_drop_down_display= $this->display_drop_down_for_pages($connection, $session);
        $current_user_id=$session['id'];
        return "
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>Blackboard</title>
            </head>
            <body>
                <nav>
                    <a href='profile.php?action=show&userid=$current_user_id&show=1'>Mon Profile</a>
                    <a href='profile.php?action=search&show=1'>Recherche</a>
                </nav>
                <header>
                    <h1>Blackboard</h1>
                </header>
                <p id='pagenum'>Page : $show </p>
                <form action='timeline.php' method='get'>
                    $pages_drop_down_display
                    <label for='like'>Ordre par likes : </label>
                    <input type='radio' id='like' name='order' value='like' $checked_order_like>
                    <label for='recent'>Ordre par plus récent : </label>
                    <input type='radio' id='recent' name='order' value='recent' $checked_order_recent><br>
                    <input type='submit' name='dropdown' value='Appliquer'>
                </form>
                <a href='post.php?action=createpost'>Create Post</a><br>
                <div id='posts'>
                    $posts
                </div>
            </body>
            </html>
        ";
    }
    
}

?>