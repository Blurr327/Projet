<?php

class Post{

    public function order_by_likes(&$array_containing_posts, &$next_array){ // classe les postes au fur et à mesur
        $num_likes= $next_array['num_likes'];
        if(empty($array_containing_posts)){
            $array_containing_posts[0]= $next_array;
            return;
         }
        if($array_containing_posts[count($array_containing_posts)-1]['num_likes']<$num_likes){
            $tmp_array= $array_containing_posts[count($array_containing_posts)-1];
            $array_containing_posts[count($array_containing_posts)-1]=$next_array;
            $array_containing_posts[count($array_containing_posts)]=$tmp_array;
            return;
        }
        $array_containing_posts[count($array_containing_posts)]= $next_array;
        return;
    }

    public function insert_post($connection,$text,$author_id,$title){ // insère un post à la base de donnée 
        $DB=new DataBase();
        $req="INSERT INTO posts(post, creation_date, author_id, post_title) VALUES ('" . mysqli_real_escape_string($connection,$text) . "','" .date('Y-m-d h:i:s'). "', $author_id,'".mysqli_real_escape_string($connection,$title)."')";
        return $DB->query($connection,$req);
    }

    public function get_number_of_posts($connection, $session){
        $DB = new DataBase();
        $user_id= $session['id'];
        $req="SELECT * FROM posts, follower_and_followed WHERE follower_id=$user_id AND followed_id=author_id";
        $result = $DB->query($connection, $req);
        return mysqli_num_rows($result);
    }

    public function delete_post($connection, $post_id, $session){ // supprimer un post
        $DB=new DataBase();
        $USER= new user();
        $PERM= new Permission();
        $COMMENT = new Comment();
        $LIKE = new Like();
        $author_id=$this->fetch_post_accessories($connection, $post_id, 'author_id');
        $privileges=$USER->privileges($connection, $session, $author_id);
        if(!$privileges) return false;
        $LIKE->undo_likes_of($connection, $post_id);
        $COMMENT->delete_all_comments_of($connection, $post_id);
        $req="DELETE FROM posts WHERE post_id=$post_id";
        $DB->query($connection,$req);
        return true;
    }

    public function modify_post($connection, $new_text, $new_title, $post_id){ // modifier un poste
        $DB = new DataBase();
        $req="UPDATE posts SET post='".mysqli_real_escape_string($connection,$new_text)."', post_title='".mysqli_real_escape_string($connection, $new_title). "' WHERE post_id=$post_id";
        return $DB->query($connection,$req);
    }

    public function get_posts($connection,$user_id,$starting_point,$order,$timeline_or_user){ // renvoie un tableau d'indices qui contient des tableaux associatifs contenant les postes (la date de création et l'auteur + l'id des postes et de l'auteur + le titre) du site crées par des utilisateurs suivi par l'utilisateur courant (classé par $ordre)
        
        // l'option $timeline_or_user peut être soit : author_id (pour la page profile) soit : follower_id (pour le timeline)
        // $order est soit : likes soit : n'importe quoi (dans ce cas l'ordre est par le plus récent)
        $list_of_posts=array();
        $COMMENT = new Comment();
        $LIKE = new Like();
        $DB=new DataBase();
        $req="SELECT posts.post_id AS posts_post_id, followed_id AS posts_author_id,posts.creation_date AS posts_creation_date,post_title, nickname FROM follower_and_followed, posts, users WHERE $timeline_or_user=$user_id AND followed_id=author_id AND followed_id=id ORDER BY posts.creation_date DESC LIMIT $starting_point, 14"; // on ne veut afficher que 14 postes sur la page (pour afficher les autres on va avoir une liste déroulante qui affiche le reste en fonction de $starting_point)
        $result=$DB->query($connection,$req);
        $rows= $result->fetch_all(MYSQLI_ASSOC);
        $rows_ordered_by_likes=array();
        foreach($rows as $key =>$post_array){
            $post_array['num_likes']=$LIKE->get_num_likes($connection, $post_array['posts_post_id']);
            $post_array['num_comments']=$COMMENT->get_num_comments($connection, $post_array['posts_post_id']);
            $rows[$key]=$post_array;
            $this->order_by_likes($rows_ordered_by_likes,$post_array);
        }
        return ($order=== 'likes') ? $rows_ordered_by_likes : $rows;
    }

    public function display_post_on_timeline($post_title,$post_id, $author_nickname,$author_id,$num_likes, $num_comments, $creation_date){ // affiche un post (son apparence sur le timeline)
        return "
         <div class='post'>
          <a class='author' href='profile.php?action=show&userid=$author_id&show=1'>$author_nickname</a>
          <span class='thumbnail'>
            <a href='post.php?action=show&postid=$post_id&show=5'><h3>$post_title</h3></a>
            <p id='numlikes'>Likes : $num_likes</p>
            <p id='numcomments'>Commentaires : $num_comments</p>
            <p id='creationdate'>Crée le : $creation_date</p>
          </span>
        </div>
        ";
    }


    public function fetch_post_accessories($connection, $post_id, $accessories){ // renvoie le titre, l'id de l'auteur,  la date de création...
        $DB=new DataBase();
        $req="SELECT $accessories FROM posts WHERE posts.post_id=$post_id"; 
        $result = $DB->query($connection,$req);
        $line = mysqli_fetch_assoc($result);
        return $line[$accessories];
    }

    public function fetch_author_nickname($connection,$post_id){ // renvoie le pseudo de l'auteur
        $DB= new DataBase();

        $author_id=$this->fetch_post_accessories($connection,$post_id,'author_id');
        $req="SELECT nickname FROM users WHERE id=$author_id";
        $result=$DB->query($connection,$req);
        $line = mysqli_fetch_assoc($result);
        return $line['nickname'];
    }

    public function simple_display_post_mod($connection,$get,$session,$title_error, $post_error){

        $USER= new User();
        $PERM = new Permission();

        $post_id=(abs(intval($get['postid'])) === 0) ? 1 : abs(intval($get['postid'])) ;

        $old_post= $this->fetch_post_accessories($connection, $post_id ,'post'); // accéder aux informations nécessaires à l'affichage de la page
        $old_post_title= $this->fetch_post_accessories($connection, $post_id,'post_title');
        $author_id= $this->fetch_post_accessories($connection, $post_id, 'author_id');

        if(!$USER->privileges($connection, $session, $author_id)){ // pour ceux qui essaient d'accéder à la page sans permission
            return $PERM->forbidden_page();
        }
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

    public function display_post_modification_page($connection,$data, $get, $session){
        $VER = new Verification(); // initialisation des variables
        $USER= new User();
        $PERM = new Permission();
        $required=array("titlemod", "postmod");
        $post_id=intval($get['postid']);
        $req_errors=array();
        $error_msgs=array();
        $title_error="";
        $post_error="";


        $VER->prepare_data($data); // préparation des données

        $allgood=$VER->update_field_error_variables($data,$required, $error_msgs);
        $title_error=$error_msgs['titlemod'];
        $post_error=$error_msgs['postmod'];
        if($allgood){ // pas d'erreurs => modification du poste
            $this->modify_post($connection, $data['postmod'], $data['titlemod'], $post_id); 
            return false;
        }

        return $this->simple_display_post_mod($connection ,$get, $session,$title_error,$post_error); // réaffichage du poste avec les erreurs
    }

    public function simple_display_post_creation($title_error, $post_error){
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
                    <textarea id='titlecreate' name='titlecreate' rows='2' cols='60'>Votre titre...</textarea><br>
                    $title_error<br>
                    <textarea id='textcreate' name='postcreate' rows='6' cols='60'>Votre post...</textarea><br>
                    $post_error<br>
                    <input type='submit' name='Create' value='Publier'>
                </form>
            </body>
        </html>
        ";
    }


    public function display_post_creation($connection,$data, $session){
        $VER = new Verification(); // initialisation des variables
        $required=array("titlecreate", "postcreate");
        $req_errors=array();
        $error_msgs=array();
        $title_error="";
        $post_error="";

        $VER->prepare_data($data); // préparation des données

        $allgood=$VER->update_field_error_variables($data,$required, $error_msgs); // préparer les erreurs
        $title_error=$error_msgs['titlecreate'];
        $post_error=$error_msgs['postcreate'];

        if($allgood){ // pas d'erreurs => création du poste
            $this->insert_post($connection,$data['postcreate'] ,$session['id'],$data['titlecreate']);
            return false;
        }
        return $this->simple_display_post_creation($title_error,$post_error); // réaffichage de la page avec les erreurs
    }

    public function simple_display_post_page($connection, $get, $session, $comment_field_error){ // affichage de la page quand la méthode de requête n'est pas post
        $COMMENT = new Comment(); // initialisation des variables
        $LIKE = new Like();
        $USER = new User();
        $modify_post_button="";
        $delete_post_button="";
        $like_status='like';
        $privileges=false;
        
        $show=abs(intval($get['show']))  ; // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive
        $post_id=(abs(intval($get['postid'])) === 0) ? 1 : abs(intval($get['postid']));// valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive

        $comments = $COMMENT->display_comments_for_post($connection, $post_id, $show); // pour l'affichage des commentaireqs

        if($LIKE->does_like($connection, $session['id'], $post_id)) $like_status='unlike'; // mise à jour du bouton like/unlike 


        $post_title=$this->fetch_post_accessories($connection, $post_id, 'post_title'); // accéder aux informations nécessaires pour la page
        $author_id=$this->fetch_post_accessories($connection,$post_id, 'author_id');
        $creation_date= $this->fetch_post_accessories($connection, $post_id,'creation_date');
        $author_nickname=$this->fetch_author_nickname($connection,$post_id);
        $text = $this->fetch_post_accessories($connection,$post_id, 'post');
        $num_comments= $COMMENT->get_num_comments($connection, $post_id);

        $display_more=($show+5 > $num_comments) ? $num_comments : $show+5; // un paramètre de get controle combien de commentaires on peut voir
        $display_less=($show-5 >= 0) ? $show-5 : 0;
        
        $privileges= $USER->privileges($connection, $session,$author_id); //  mise à jour des droits de l'utilisateur courant

        if($privileges){ // l'ajout des boutons de modification et de suppression pour les utilisateurs qui ont le droit à ça
            $modify_post_button="<a class='buttons' href='post.php?action=modpost&postid=$post_id'>Modifier</a>";
            $delete_post_button="<a class='buttons' href='comment.php?action=deletepost&postid=$post_id'>Supprimer</a>";
        }

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
                <a href='timeline.php?show=1&order=recent'><pre><< Revenir au fil d'actualité</pre></a>
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
                    <textarea id='postcomment' name='commenttext' rows='3' cols='60'>
                    Commentaire...
                    </textarea>
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

    public function display_post_page($connection, $get, $session, $data){ 
        $DB = new DataBase();
        $VER = new Verification();
        $USER= new User();
        $LIKE= new Like(); 
        $COMMENT= new Comment();
        $comments=array();
        $req_errors=array();
        $error_msgs=array();
        $required=array("commenttext");

        $post_id=(abs(intval($get['postid'])) === 0) ? 1 : abs(intval($get['postid']));// valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive

        $connection = $DB->connect();

        $VER->prepare_data($data);

        $VER->update_field_error_variables($data, $required, $error_msgs);
        $comment_field_error = $error_msgs['commenttext'];
        if(!empty($req_errors))
        if(!empty($data['like'])){
            $LIKE->like_post($connection, $session['id'], $post_id); // l'ajout du like à la base de donnée
        }
        if(!empty($data['unlike'])){
            $LIKE->unlike_post($connection, $session['id'], $post_id); // la suppression du like de la base de donnée
        }
        if(!empty($data['commentaire'])){
            $COMMENT->insert_comment($connection,$data['commenttext'],$post_id, $session['id']); // l'ajout du commentair à la base de donnée
        }

        return $this->simple_display_post_page($connection,$get, $session, $comment_field_error);
    }

    public function simple_display_timeline_posts($connection, $session, $get, $order, $timeline_or_user){
        $posts_display="";
        $show=(abs(intval($get['show'])) === 0) ? 1:abs(intval($get['show']));
        $starting_point=($show-1)*14; // page 1 (avec show=1) affiche les premiers 14 postes, page 2(avec show=2)affiche les postes numéro 15 justqu'à 28... ainsi de suite
        
        $posts_array= $this->get_posts($connection, $session['id'],$starting_point, $order, $timeline_or_user);
        for($i=0;$i<count($posts_array);$i++){
            $posts_display .= $this->display_post_on_timeline($posts_array[$i]['post_title'], $posts_array[$i]['posts_post_id'],$posts_array[$i]['nickname'], $posts_array[$i]['posts_author_id'], $posts_array[$i]['num_likes'],$posts_array[$i]['num_comments'],$posts_array[$i]['posts_creation_date']);
        }
        
        return $posts_display;
    }

}

?>
