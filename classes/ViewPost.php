<?php class ViewPost{

    public function display_post_page($post_title, $creation_date, $text, $author_id, $author_nickname, $modify_post_button, $delete_post_button, $post_id, $show, $like_status, $comment_field_error,$comments,$display_more, $display_less, $order){
        $check= ($like_status === 'like') ? '☐' : '☑';
            return "
            <!DOCTYPE html>
            <html lang='fr'>
                <head>
                    <title>Blackboard</title>
                    <meta charset='UTF-8'>
                    <meta http-equiv='Content-type' content='text/html;charset=UTF-8'>
                    <link rel='stylesheet' href='css/post.css'>
                </head>    
                <body>
                    
                
                  
                    <h1 id='homeh'><a id='homebutton' href='timeline.php?show=1&order=likes'>Blackboard</a></h1>
                 

                    
                    <p id='createdby'>Créé par <a id='authornick' href='profile.php?action=show&userid=$author_id&show=1'>$author_nickname</a></p>
                    <p id='date'>$creation_date</p>
                    <h2 id='title'>$post_title</h2>
                    
                    <div id='text-block'>
                        <p id='text'>$text</p>
                    </div>
                    <div id='privilege'>
                    $modify_post_button
                    $delete_post_button
                    </div>
                    <form action='post.php?action=show&postid=$post_id&show=$show' method='post'>
                        <input type='submit' name='$like_status' value='$check'><br>
                        <textarea id='postcomment' name='commenttext' rows='3' cols='60' placeholder='Commentaire...'></textarea>
                        <input type='submit' name='commentaire' value='Poster'><br>
                        $comment_field_error
                    </form>
                    <div id='commentaires'>
                        $comments
                    </div>
                    <div id='optionscommentaires'>
                    <a id='affplus' href='post.php?action=show&postid=$post_id&show=$display_more'>↓</a>
                    <a id='affmoins' href='post.php?action=show&postid=$post_id&show=$display_less'>↑</a>
                    </div>
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
                    <link rel='stylesheet' href='css/postcreate.css'>
                </head>
                <body>
                    <h1 id='homeh'><a id='homebutton' href='timeline.php?show=1&order=likes'>Blackboard</a></h1>
                    <h2>Ajouter votre publication</h2>
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
                    <link rel='stylesheet' href='css/postmod.css'>
                </head>
                <body>
                  
                    <h1 id='homeh'><a id='homebutton' href='timeline.php?show=1&order=likes'>Blackboard</a></h1>
                    <h2>Modifier Votre publication</h2>
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
              <a class='author' href='profile.php?action=show&userid=$author_id&show=1'>by $author_nickname</a><br>
              <span class='thumbnail'>
                <a id='posttitle' href='post.php?action=show&postid=$post_id&show=5'><p>$post_title</p></a>
              
                <p id='postinfo'>Likes : $num_likes Commentaires : $num_comments le :$creation_date</p>
               
              </span>
            </div>
            ";
        }
} ?>
