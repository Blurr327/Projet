<?php class ViewPost{

    public function display_post_page($post_title, $creation_date, $text, $author_id, $author_nickname, $modify_post_button, $delete_post_button, $post_id, $show, $like_status, $comment_field_error,$comments,$display_more, $display_less, $order){
            return "
            <!DOCTYPE html>
            <html lang='fr'>
                <head>
                    <title>Blackboard</title>
                    <meta charset='UTF-8'>
                    <meta http-equiv='Content-type' content='text/html;charset=UTF-8'>
                </head>    
                <body>
                    <nav>
                    <a href='timeline.php?show=1&order=$order'><pre><< Revenir au fil d'actualité</pre></a>
                    </nav>
                
                    <header>$post_title</header>
                    <p id='date'>$creation_date</p>
                    <div id='text'>
                        <p>$text</p><br>
                    </div>
                    <p id='createdby'>Crée par <a href='profile.php?action=show&userid=$author_id&show=1'>$author_nickname</a></p>
                    $modify_post_button
                    $delete_post_button
                    <form action='post.php?action=show&postid=$post_id&show=$show' method='post'>
                        <input type='submit' name='$like_status' value='$like_status'><br>
                        <textarea id='postcomment' name='commenttext' rows='3' cols='60' placeholder='Commentaire...'></textarea>
                        <input type='submit' name='commentaire' value='Poster'><br>
                        $comment_field_error
                    </form>
                    <div id='commentaires'>
                        $comments
                    </div>
                    <span id='optionscommentaires'>
                    <a href='post.php?action=show&postid=$post_id&show=$display_more'>Afficher plus...</a>
                    <a href='post.php?action=show&postid=$post_id&show=$display_less'>Afficher moins...</a>
                    </span>
                </body>
            </html>
            ";
        }

        public function display_post_creation($title_error, $post_error){
            return "
            <!DOCTYPE html>
            <html lang='fr'>  
                <head>
                    <title>Blackboard</title>
                    <meta charset='UTF-8'>
                </head>
                <body>
                    <nav>
                        <a href='timeline.php?show=1&order=recent'><pre>Revenir au fil d'actualité</pre></a>
                    </nav>
                    <h3>Ajouter votre publication</h3>
                    <form action='post.php?action=createpost' method='post'>
                        <textarea id='titlecreate' name='titlecreate' rows='2' cols='60' placeholder='Votre titre...'></textarea><br>
                        $title_error<br>
                        <textarea id='textcreate' name='postcreate' rows='6' cols='60' placeholder='Votre post...'></textarea><br>
                        $post_error<br>
                        <input type='submit' name='Create' value='Publier'>
                    </form>
                </body>
            </html>
            ";
        }

        public function display_post_mod($post_id, $old_post_title, $title_error, $old_post, $post_error){
            return "
            <!DOCTYPE html>
            <html lang='fr'>  
                <head>
                    <title>Blackboard</title>
                    <meta charset='UTF-8'>
                </head>
                <body>
                    <nav>
                      <a href='timeline.php?show=1&order=recent'><pre>Revenir au fil d'actualité</pre></a>
                    </nav>
                    <h3>Modifier Votre publication</h3>
                    <form action='post.php?action=modpost&postid=$post_id' method='post'>
                        <textarea id='titlemod' name='titlemod' rows='2' cols='60'>$old_post_title</textarea><br>
                        $title_error<br>
                        <textarea id='textmod' name='postmod' rows='6' cols='60'>$old_post</textarea><br>
                        $post_error<br>
                        <input type='submit' name='modify' value='Modifier'>
                    </form>
                </body>
            </html>
            ";
        }

        public function display_post_on_timeline($post_title,$post_id, $author_nickname,$author_id,$num_likes, $num_comments, $creation_date){ // affiche un post (son apparence sur le timeline)
            return "
             <div class='post'>
              <a class='author' href='profile.php?action=show&userid=$author_id&show=1'>$author_nickname</a><br>
              <span class='thumbnail'>
              <h3><a id='posttitle' href='post.php?action=show&postid=$post_id&show=5'>$post_title</a></h3>
                <p id='numlikes'>Likes : $num_likes</p>
                <p id='numcomments'>Commentaires : $num_comments</p>
                <p id='creationdate'>Créé le : $creation_date</p>
              </span>
            </div>
            ";
        }
} ?>
