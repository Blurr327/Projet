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

    public function get_number_of_posts($connection, $session, $timeline_or_user, $user_id_profile){
        $DB = new DataBase();
        $user_id= $session['id'];
        $req_user= "SELECT * FROM posts WHERE author_id=$user_id_profile";
        $req_timeline="SELECT * FROM posts, follower_and_followed WHERE follower_id=$user_id AND followed_id=author_id";
        $req = ($timeline_or_user ==='follower_id') ? $req_timeline : $req_user;
        $result = $DB->query($connection, $req);
        return mysqli_num_rows($result);
    }

    public function delete_post($connection, $post_id){ // supprimer un post
        $DB=new DataBase();
        $USER= new user();
        $COMMENT = new Comment();
        $LIKE = new Like();
        $LIKE->undo_likes_of($connection, $post_id);
        $COMMENT->delete_all_comments_of($connection, $post_id);
        $req="DELETE FROM posts WHERE post_id=$post_id";
        return $DB->query($connection,$req);
    }

    public function modify_post($connection, $new_text, $new_title, $post_id){ // modifier un poste
        $DB = new DataBase();
        $req="UPDATE posts SET post='".mysqli_real_escape_string($connection,$new_text)."', post_title='".mysqli_real_escape_string($connection, $new_title). "' WHERE post_id=$post_id";
        return $DB->query($connection,$req);
    }

    public function get_posts($connection,$user_id,$order, $timeline_or_user, $user_id_profile){ 
        
        $list_of_posts=array();
        $COMMENT = new Comment();
        $LIKE = new Like();
        $DB=new DataBase();
        $req_user="SELECT posts.post_id AS posts_post_id, author_id AS posts_author_id, posts.creation_date AS posts_creation_date, post_title, nickname FROM posts, users WHERE posts.author_id=$user_id_profile AND posts.author_id=id ORDER BY posts.creation_date DESC";

        $req_timeline="SELECT posts.post_id AS posts_post_id, followed_id AS posts_author_id,posts.creation_date AS posts_creation_date,post_title, nickname FROM follower_and_followed, posts, users WHERE follower_id=$user_id AND followed_id=author_id AND followed_id=id ORDER BY posts.creation_date DESC"; 

        $req =($timeline_or_user === 'follower_id') ? $req_timeline : $req_user;
        $result=$DB->query($connection,$req);
        $rows= $result->fetch_all(MYSQLI_ASSOC);
        foreach($rows as $key =>$post_array){
            $post_array['num_likes']=$LIKE->get_num_likes($connection, $post_array['posts_post_id']);
            $post_array['num_comments']=$COMMENT->get_num_comments($connection, $post_array['posts_post_id']);
            $rows[$key]=$post_array;
        }
        if($order==='likes'){
            array_multisort(array_column($rows, 'num_likes'), SORT_DESC, $rows);
        }
        return $rows;
    }

   


    public function fetch_post_accessories($connection, $post_id, $accessories){ // renvoie le titre, l'id de l'auteur,  la date de création...
        $DB=new DataBase();
        $req="SELECT $accessories FROM posts WHERE post_id=$post_id;"; 
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

    

    public function update_post_modification_page($connection,$data, $get, $session){
        $VER = new Verification(); // initialisation des variables
        $USER= new User();
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

        return array($title_error, $post_error); 
    }




    public function update_post_creation($connection,$data, $session){ // renvoie le tableau d'erreurs et ajoute le post si tout est bien
        $VER = new Verification(); // initialisation des variables
        $VIEWPOST = new ViewPost();
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
        }
        return array($title_error,$post_error);
    }

    

    public function update_post_page($connection, $get, $session, $data){  // renvoie l'erreur du champ du commentaire et ajoute le commentaire si tout est bien 
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

        $VER->prepare_data($data);

        $VER->update_field_error_variables($data, $required, $error_msgs);
        $comment_field_error = $error_msgs['commenttext'];
        
        if(!empty($data['like'])){
            $LIKE->like_post($connection, $session['id'], $post_id); // l'ajout du like à la base de donnée
        }
        if(!empty($data['unlike'])){
            $LIKE->unlike_post($connection, $session['id'], $post_id); // la suppression du like de la base de donnée
        }
        if(!empty($data['commentaire'])){

            $VER->prepare_data($data);

            $VER->update_field_error_variables($data, $required, $error_msgs);
            $comment_field_error = $error_msgs['commenttext'];

            if(!empty($comment_field_error)){
             $COMMENT->insert_comment($connection,$data['commenttext'],$post_id, $session['id']); // l'ajout du commentair à la base de donnée
            }
            return $comment_field_error;
        }

    }



}

?>
