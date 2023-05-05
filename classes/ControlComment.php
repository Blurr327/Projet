<?php class ControlComment{

    public function control_comment_page($connection, $get, $session){
        $USER= new User();
        $COM= new Comment();
        $VIEWCOM = new ViewComment();
        $comment_id= (abs(intval($get['commentid'])) ===0) ? 1 :abs(intval($get['commentid'])); // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive
        $modify_comment="";
        $delete_comment="";
        
        $author_info= $COM->fetch_comment_author_info($connection, $comment_id);
        $author_id=$author_info['id'];
        $author_nickname=$author_info['nickname'];
        $authors_comment=$author_info['comment'];
        $post_id=$author_info['post_id'];
        $privileges= $USER->privileges($connection, $session,$author_id); //  mise à jour des droits de l'utilisateur courant

        if($privileges){
            $modify_comment="<a class='buttons' href='comment.php?action=modcomment&commentid=$comment_id'>Modifier</a>";
            $delete_comment="<a class='buttons' href='comment.php?action=deletecomment&commentid=$comment_id' >Supprimer</a>";
        }
        return $VIEWCOM->display_comment_page($post_id, $author_id, $author_nickname, $authors_comment, $modify_comment, $delete_comment);
        
    }

    public function control_mod_page($connection, $get, $session, $server, $data){
        $USER = new User();
        $PERM = new ViewPermission();
        $VIEWCOM = new ViewComment();
        $COM = new Comment();
        $field_error="";
        if($server['REQUEST_METHOD'] === 'POST'){
            $field_error=$COM->update_mod_comment_page($connection, $get, $session, $data);
            if(!$field_error) return 'redirect';
        }
        $comment_id= (abs(intval($get['commentid'])) === 0) ? 1 : abs(intval($get['commentid']));
        $author_info= $COM->fetch_comment_author_info($connection, $comment_id);
        $post_id= $author_info['post_id'];
        if(!$USER->privileges($connection, $session, $author_info['author_id'])){
            return $PERM->forbidden_page();
        }   
        $old_comment=$author_info['comment'];
        return $VIEWCOM->display_mod_com_page($post_id, $comment_id, $old_comment, $field_error);
    }
} ?>
