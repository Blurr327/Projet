<?php
session_start();
require_once("classes/DataBase.php");
require_once("classes/Like.php");
require_once("classes/Comment.php");
require_once("classes/Post.php");
require_once("classes/Verification.php");
require_once("classes/User.php");
require_once("classes/Permission.php");
$DB = new DataBase();
$POST= new Post();
$COMMENT= new Comment();
$PERM= new Permission();
$connection= $DB->connect();
$action = (isset($_GET['action'])) ? $_GET['action'] :'show';
switch($action){
    case 'deletecomment':
        $comment_id=(abs(intval($_GET['commentid'])) ===0) ? 1 :abs(intval($_GET['commentid']));
        $author_info = $COMMENT->fetch_comment_author_info($connection, $comment_id);
        $post_id= $author_info['post_id'];
        $hasright=$COMMENT->delete_comment($connection, $comment_id, $_SESSION);
        if(!$hasright) echo $PERM->forbidden_page();
        header("Location: post.php?action=show&postid=$post_id&show=5");
        break;
    case 'modcomment':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $comment_id= (abs(intval($_GET['commentid'])) === 0) ? 1 :$_GET['commentid'];
            $author_info = $COMMENT->fetch_comment_author_info($connection, $comment_id);
            $post_id= $author_info['post_id'];
            $problem = $COMMENT->display_mod_comment_page($connection, $_GET, $_SESSION, $_POST);
            if(!$problem) header("Location: post.php?action=show&postid=$post_id&show=5");
            echo $problem;
        }
        else{
            echo $COMMENT->simple_display_mod_page($connection,"", $_GET, $_SESSION);
        }
        break;
    default :
        echo $COMMENT->simple_display_comment_page($connection, $_GET, $_SESSION);
        break;
}

?>