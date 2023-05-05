<?php class ControlPermission{

    public function control_perm_post($connection, $post_id, $session){
        $POST= new Post();
        $USER= new User();
        $VIEWPERM= new ViewPermission();
        $author_id=$POST->fetch_post_accessories($connection, $post_id, 'author_id');
        $privileges=$USER->privileges($connection, $session, $author_id);
        if(!$privileges) return $VIEWPERM->forbidden_page();
        return false; // => l'utilisateur a le droit d'accéder
    }

    public function control_perm_comment($connection, $comment_id, $session){
        $COMMENT = new Comment();
        $USER= new User();
        $VIEWPERM= new ViewPermission();
        $author_info= $COMMENT->fetch_comment_author_info($connection, $comment_id);
        $author_id= $author_info['author_id'];
        $privileges=$USER->privileges($connection, $session, $author_id);
        if(!$privileges) return $VIEWPERM->forbidden_page();
        return false; // => l'utilisateur a le droit d'accéder
    }

} ?>
