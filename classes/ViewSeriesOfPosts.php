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

    public function display_profile_info_block($nickname, $firstname, $lastname){
        return "
            <div id='profileinfo'>
                <h2>$nickname's Blackboard</h2><br>
                <p>Nom : $lastname</p><br>
                <p>Prénom : $firstname</p>
            </div>
        ";
    }

    public function display_series_of_posts($nav, $show,$pages_drop_down_display, $checked_order_like, $checked_order_recent, $no_posts, $posts, $url, $follow_block, $profile_info_block){
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
                <h1>Blackboard</h1>
            </header>
            $profile_info_block
            $follow_block
            
            
            <form action='$url' method='get'>
                <p>Page : </p>
                <div id='dropdown'>
                $pages_drop_down_display
                </div>
                <div id='order'>
                <label for='like'>Ordre par likes : </label>
                <input type='radio' id='likes' name='order' value='likes' $checked_order_like>
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



} ?>
