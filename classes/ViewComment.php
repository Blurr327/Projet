<?php class ViewComment{
    public function display_comment_page($post_id, $author_id, $author_nickname, $authors_comment, $modify_comment, $delete_comment){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
            <head>
                <title>Blackboard</title>
                <meta charset='utf8'>
                <link rel='stylesheet' href='css/comment.css'>
            </head>
            <body>
                 <h1 id='homeh'><a id='homebutton' href='timeline.php?show=1&order=likes'>Blackboard</a></h1>
                 <div class='comment'>
                <a id='commentauthor' href='profile.php?action=show&userid=$author_id&show=1'>$author_nickname</a>
                
                    <p id='commenttext'>$authors_comment</p>
                </div><br>
                $modify_comment
                $delete_comment
            </body>
        </html>
    ";

    }

    public function display_mod_com_page($post_id, $comment_id, $old_comment, $field_error){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Blackboard</title>
            <link rel='stylesheet' href='css/modcomment.css'>
        </head>
        <body>
        <h1 id='homeh'><a id='homebutton' href='timeline.php?show=1&order=likes'>Blackboard</a></h1>
        <h2>Modifiez votre commentaire</h2>
            <form action='comment.php?action=modcomment&commentid=$comment_id' method='post'>
                <textarea name='newcomment' class='comment' cols='40' rows='5'>
                $old_comment
                </textarea><br>
                $field_error
                <input type='submit' name='modcomment' value='Modifier'>
            </form>
        </body>
        </html>
        ";
   

        
}

public function display_comment_under_post($author_id, $creation_date,$comment, $nickname, $comment_id){ // affiche une commentaire
    return "
    <div class='comment'>
        <a id='comment_author' href='profile.php?action=show&userid=$author_id&show=1'>$nickname: </a>
        <a id='commenttext' href='comment.php?action=show&commentid=$comment_id'><p>$comment</p></a>
        <p id='commentdate'>$creation_date</p>
    </div><br>
    ";
}

public function display_comments_for_post($connection, $post_id, $num_shown){
    $COMMENT= new Comment();
    $comments_display="";
    $comments= $COMMENT->get_comments($connection, $post_id, $num_shown);
    foreach($comments as $comment_array){
        $comments_display .= $this->display_comment_under_post($comment_array['author_id'],$comment_array['creation_date'],$comment_array['comment'], $comment_array['nickname'], $comment_array['comment_id']);
    }
    return $comments_display;
}


} ?>
