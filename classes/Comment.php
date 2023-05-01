<?php

class Comment{

    public function insert_comment($connection,$text,$post_id,$author_id){ // ajoute une commentaire
        $DB=new DataBase();
        $req="INSERT INTO comments(comment,author_id, post_id,creation_date) VALUES ('". mysqli_real_escape_string($connection,$text) . "',$author_id, $post_id, '" . date("Y-m-d h:i:s") . "')";
        return $DB->query($connection,$req);
    }

    public function delete_all_comments_of($connection, $post_id){
        $comments_array= $this->get_comments($connection, $post_id,'all');
        foreach($comments_array as $comment_array){
            $this->delete_comment($connection, $comment_array['comment_id'], 'deletepost');
        }
        return;
    }

    

    public function get_num_comments($connection, $post_id){
        $DB= new DataBase();
        $req="SELECT * FROM comments WHERE post_id=$post_id";
        $result=$DB->query($connection, $req);
        return mysqli_num_rows($result);
    }

    public function delete_comment($connection,$comment_id, $session){ // supprime le commentaire
        $DB=new DataBase();
        $USER= new user();
        $PERM= new Permission();
        $author_info=$this->fetch_comment_author_info($connection, $comment_id);
        if($session != 'deletepost'){ // si on supprime un post, on supprime tous les commentaires
            $privileges=$USER->privileges($connection, $session, $author_info['author_id']);
            if(!$privileges){
                return false;
            }
        }
        $req="DELETE FROM comments WHERE comment_id=$comment_id";
        $DB->query($connection,$req);
        return true;
    }

    public function modify_comment($connection,$comment_id,$new_text){ // modifie le commentaire
        $DB= new DataBase();
        $req="UPDATE comments SET comment='$new_text' WHERE comment_id=$comment_id";
        return $DB->query($connection,$req);
    }

    public function get_comments($connection,$post_id,$num_shown){ // renvoie un tableau de tableau associatifs constitué de la commentaire/l'auteur/ladate et l'id du commentaire
        $DB = new DataBase();
        $USER= new User();
        $limitornot=($num_shown=== 'all') ? "" : "LIMIT 0,$num_shown";
        $req="SELECT comment, author_id, comment_id, creation_date, nickname FROM comments, users WHERE comments.post_id=$post_id AND id=author_id ORDER BY creation_date $limitornot"; // numshown = le nombre de commentaire affiché
        $result=$DB->query($connection,$req);
        $rows=$result->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public function display_comment_under_post($author_id, $creation_date,$comment, $nickname, $comment_id){ // affiche une commentaire
        return "
        <div class='comment'>
            <a class='comment_author' href='profile.php?action=show&userid=$author_id&show=1'>$nickname</a>
            <a href='comment.php?action=show&commentid=$comment_id'><p class='commentcontent'>$comment</p></a>
            <p class='date'>$creation_date</p>
        </div><br>
        ";
    }

    public function display_comments_for_post($connection, $post_id, $num_shown){
        $comments_display="";
        $comments= $this->get_comments($connection, $post_id, $num_shown);
        foreach($comments as $comment_array){
            $comments_display .= $this->display_comment_under_post($comment_array['author_id'],$comment_array['creation_date'],$comment_array['comment'], $comment_array['nickname'], $comment_array['comment_id']);
        }
        return $comments_display;
    }

    public function fetch_comment_author_info($connection, $comment_id){
        $DB= new DataBase();
        $comment_id= intval($comment_id);
        $req="SELECT nickname, id, comment, post_id, author_id FROM comments, users WHERE comment_id=$comment_id AND author_id=id";
        $result = $DB->query($connection, $req);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        return $rows[0];
    }

    public function simple_display_comment_page($connection, $get, $session){
        $USER= new User();
        $comment_id= (abs(intval($get['commentid'])) ===0) ? 1 :abs(intval($get['commentid'])); // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive
        $modify_comment="";
        $delete_comment="";

        $author_info= $this->fetch_comment_author_info($connection, $comment_id);
        $author_id=$author_info['id'];
        $author_nickname=$author_info['nickname'];
        $authors_comment=$author_info['comment'];
        $post_id=$author_info['post_id'];
        $privileges= $USER->privileges($connection, $session,$author_id); //  mise à jour des droits de l'utilisateur courant

        if($privileges){
            $modify_comment="<a class='buttons' href='comment.php?action=modcomment&commentid=$comment_id'>Modifier</a>";
            $delete_comment="<a class='buttons' href='comment.php?action=deletecomment&commentid=$comment_id' >Supprimer</a>";
        }
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
    
    

    public function simple_display_mod_page($connection ,$field_error, $get, $session){
        $USER = new User();
        $PERM = new Permission();
        $comment_id= (abs(intval($get['commentid'])) === 0) ? 1 : abs(intval($get['commentid']));
        $author_info= $this->fetch_comment_author_info($connection, $comment_id);
        $post_id= $author_info['post_id'];
        if(!$USER->privileges($connection, $session, $author_info['author_id'])){
            return $PERM->forbidden_page();
        }   
        $old_comment=$author_info['comment'];
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

    public function display_mod_comment_page($connection, $get, $session, $data){
        $VER = new Verification();
        $req_errors= array();
        $error_msgs=array();
        $required=array("newcomment");
        $comment_id= (abs(intval($_GET['commentid'])) === 0) ? 1 :$_GET['commentid'];
        $VER->prepare_data($data);
        $all_good=$VER->update_field_error_variables($data,$required, $error_msgs);
        $field_error=$error_msgs['newcomment'];
        if($all_good){
            $this->modify_comment($connection, $comment_id, $data['newcomment']);
            return false;
        }
        return $this->simple_display_mod_page($connection,$field_error, $get, $session);
    }


} 
?>
