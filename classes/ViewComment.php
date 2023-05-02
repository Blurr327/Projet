<?php class ViewComment{
    public function display_comment_page($post_id, $author_id, $author_nickname, $authors_comment, $modify_comment, $delete_comment){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
            <head>
                <title>Blackboard</title>
                <meta charset='utf8'>
            </head>
            <body>
                <nav>
                    <a href='post.php?action=show&postid=$post_id&show=1'><pre><< Revenir au post</pre></a>
                </nav>
                <a id='commentauthor' href='profile.php?action=show&userid=$author_id&show=1'>$author_nickname</a>
                <div class='comment'>
                    <p>$authors_comment</p>
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
        </head>
        <body>
            <nav>
            <a href='post.php?action=show&postid=$post_id&show=1'><pre><< Revenir au post</pre></a>
            </nav>
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


} ?>
