<?php class ControlPost{


public function control_post_page($connection, $get, $session, $data,$server){ // affichage de la page quand la méthode de requête n'est pas post
    $COMMENT = new Comment(); // initialisation des variables
    $LIKE = new Like();
    $USER = new User();
    $POST = new Post();
    $VIEWPOST = new ViewPost();
    $modify_post_button="";
    $delete_post_button="";
    $like_status='like';
    $privileges=false;
    $comment_field_error='';

    if($server['REQUEST_METHOD']==='POST'){ // mise à jour de l'erreur
        $comment_field_error= $POST->update_post_page($connection, $get, $session, $data);
    }

    $show=abs(intval($get['show']))  ; // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive
    $post_id=(abs(intval($get['postid'])) === 0) ? 1 : abs(intval($get['postid']));// valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive

    $comments = $COMMENT->display_comments_for_post($connection, $post_id, $show); // pour l'affichage des commentaireqs

    if($LIKE->does_like($connection, $session['id'], $post_id)) $like_status='unlike'; // mise à jour du bouton like/unlike 


    $post_title=$POST->fetch_post_accessories($connection, $post_id, 'post_title'); // accéder aux informations nécessaires pour la page
    $author_id=$POST->fetch_post_accessories($connection,$post_id, 'author_id');
    $creation_date= $POST->fetch_post_accessories($connection, $post_id,'creation_date');
    $author_nickname=$POST->fetch_author_nickname($connection,$post_id);
    $text = $POST->fetch_post_accessories($connection,$post_id, 'post');
    $num_comments= $COMMENT->get_num_comments($connection, $post_id);

    $display_more=($show+5 > $num_comments) ? $num_comments : $show+5; // un paramètre de get controle combien de commentaires on peut voir
    $display_less=($show-5 >= 0) ? $show-5 : 0;
    
    $order=(isset($session['order'])) ? $session['order'] : 'likes';

    $privileges= $USER->privileges($connection, $session,$author_id); //  mise à jour des droits de l'utilisateur courant

    if($privileges){ // l'ajout des boutons de modification et de suppression pour les utilisateurs qui ont le droit à ça
        $modify_post_button="<a class='buttons' href='post.php?action=modpost&postid=$post_id'>Modifier</a>";
        $delete_post_button="<a class='buttons' href='post.php?action=deletepost&postid=$post_id'>Supprimer</a>";
    }

    return $VIEWPOST->display_post_page($post_title, $creation_date, $text, $author_id, $author_nickname, $modify_post_button, $delete_post_button, $post_id, $show, $like_status, $comment_field_error,$comments,$display_more, $display_less, $order);
   
}


    public function control_delete_post($connection, $post_id){
        $POST = new Post();
        $USER= new User();
        $POST->delete_post($connection, $post_id);
        return 'redirect'; // on va faire la redirection dans le controlleur frontal
    }

    public function control_post_creation($connection, $data, $session , $server){
        $POST= new Post();
        $VIEWPOST= new ViewPost();
        $errors=array("","");
        if($server['REQUEST_METHOD'] === 'POST'){
            $errors=$POST->update_post_creation($connection, $data, $session);
        }
        return $VIEWPOST->display_post_creation($errors[0],$errors[1]); // 0, title error et 1 post error
    }

    public function control_timeline_or_user_posts($connection, $session, $get, $order, $timeline_or_user){
        $POST= new Post();
        $VIEWPOST=new ViewPost();
        $posts_display="";
        $show=(abs(intval($get['show'])) === 0) ? 1:abs(intval($get['show']));
        $user_id_profile=(isset($get['userid'])) ? abs(intval($get['userid'])) : 1;
        $starting_point=($show-1)*14; // page 1 (avec show=1) affiche les premiers 14 postes, page 2(avec show=2)affiche les postes numéro 15 justqu'à 28... ainsi de suite
        $num_shown=($starting_point+14> $POST->get_number_of_posts($connection,$session, $timeline_or_user, $user_id_profile)) ?$POST->get_number_of_posts($connection,$session, $timeline_or_user, $user_id_profile):$starting_point+14;
        $posts_array= $POST->get_posts($connection, $session['id'], $order, $timeline_or_user,$user_id_profile);
        for($i=$starting_point;$i<$num_shown;$i++){
            $posts_display .= $VIEWPOST->display_post_on_timeline($posts_array[$i]['post_title'], $posts_array[$i]['posts_post_id'],$posts_array[$i]['nickname'], $posts_array[$i]['posts_author_id'], $posts_array[$i]['num_likes'],$posts_array[$i]['num_comments'],$posts_array[$i]['posts_creation_date']);
        }
        
        return $posts_display;
    }

    public function control_post_mod($connection,$get,$session, $data,$server){ // pour la page de modification du poste
        $POST = new Post();
        $USER= new User();

        $VIEWPOST=new ViewPost();
        $errors=array("","");
        $post_id=(abs(intval($get['postid'])) === 0) ? 1 : abs(intval($get['postid'])) ;

        $old_post= $POST->fetch_post_accessories($connection, $post_id ,'post'); // accéder aux informations nécessaires à l'affichage de la page
        $old_post_title= $POST->fetch_post_accessories($connection, $post_id,'post_title');
        if($server['REQUEST_METHOD'] === 'POST'){
            $errors=$POST->update_post_modification_page($connection, $data, $get, $session);
            if(!$errors) return 'redirect';
        }

        return $VIEWPOST->display_post_mod($post_id, $old_post_title, $errors[0], $old_post, $errors[1]);
    }
 /// when you finish here go back to series of posts and modify the names of the fucntions and what ever elese you need to modify 
 // modify post.php as well
} ?>
