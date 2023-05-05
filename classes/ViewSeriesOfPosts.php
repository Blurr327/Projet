<?php class ViewSeriesOfPosts{


  
    public function display_drop_down_for_pages($num_pages, $show){ // pour afficher la liste déroulante
        $pages_drop_down_display="<select name='show' size='1'>";
        for($i=1;$i<=$num_pages;$i++){
            if($i === $show) $pages_drop_down_display .= "<option value='$i' selected>$i</option>";
            else $pages_drop_down_display .= "<option value='$i'>$i</option>";
        }
        $pages_drop_down_display .= "</select>";
        return $pages_drop_down_display;
    }

    public function display_no_posts_msg_profile(){
        return "
        <h3>Aucun poste... <a href='profile.php?action=search&show=10'>Suivez quelqu'un</a></h3>
        ";
    }

    public function display_no_posts_msg_timeline(){
        return "
            <h3>Cet utilisateur n'a aucun poste</h3>
        ";
    }

    public function display_profile_info_block($nickname, $firstname, $lastname){
        return "
            <div id='profileinfo'>
                <h2>$nickname's Blackboard</h2><br>
                <p>Nom : $lastname</p><br>
                <p>Prénom : $firstname</p>
            </div>
        ";
    }

    public function display_series_of_posts($nav, $show,$pages_drop_down_display, $checked_order_like, $checked_order_recent, $no_posts, $posts, $hidden_block, $additional_block, $page){
    
        return "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Blackboard</title>
            <link rel='stylesheet' href='css/timelineanduser.css'>
        </head>
        <body>
            <nav>
                $nav
            </nav>
            <header>
                <a id='homebutton' href='timeline.php?show=1&order=likes'><h1>Blackboard</h1></a>
            </header>
            $additional_block   
            <form action='$page.php' method='get'>
                <p id='page'>Page : </p>
                <div id='dropdown'>
                $pages_drop_down_display
                </div>
                <div id='order'>
                <label for='like'>Ordre par likes : </label>
                <input type='radio' id='likes' name='order' value='likes' $checked_order_like>
                $hidden_block
                <label for='recent'>Ordre par plus récent : </label>
                <input type='radio' id='posts_creation_date' name='order' value='posts_creation_date' $checked_order_recent><br>
                </div>
                <div id='appliquer'>
                <input type='submit' name='dropdown' value='Appliquer'>
                </div>
            </form>
            <br>
            <div id='posts'>
                $no_posts
                $posts
            </div>
        </body>
        </html>
    ";
    }

    public function display_series($posts_array, $num_shown, $starting_point){
        $VIEWPOST= new ViewPost();
        $posts_display='';
        for($i=$starting_point;$i<$num_shown;$i++){
            $posts_display .= $VIEWPOST->display_post_on_timeline($posts_array[$i]['post_title'], $posts_array[$i]['posts_post_id'],$posts_array[$i]['nickname'], $posts_array[$i]['posts_author_id'], $posts_array[$i]['num_likes'],$posts_array[$i]['num_comments'],$posts_array[$i]['posts_creation_date']);
        }
        return $posts_display;
    }



} ?>
