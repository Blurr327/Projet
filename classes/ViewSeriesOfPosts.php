<?php class ViewSeriesOfPosts{



    public function display_drop_down_for_pages($num_pages){ // pour afficher la liste déroulante
        $pages_drop_down_display="<select name='show' size='1'>";
        for($i=1;$i<=$num_pages;$i++){
            $pages_drop_down_display .= "<option value='$i'>$i</option>";
        }
        $pages_drop_down_display .= "</select>";
        return $pages_drop_down_display;
    }

    public function display_series_of_posts($nav, $show, $pages_drop_down_display, $checked_order_like, $checked_order_recent, $no_posts, $posts){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Blackboard</title>
        </head>
        <body>
            <nav>
                $nav
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
                $no_posts
                $posts
            </div>
        </body>
        </html>
    ";
    }



} ?>
