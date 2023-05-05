<?php
session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);
require_once("classes/DataBase.php");
require_once("classes/Like.php");
require_once("classes/Comment.php");
require_once("classes/ViewComment.php");
require_once("classes/ControlComment.php");
require_once("classes/Post.php");
require_once("classes/Verification.php");
require_once("classes/User.php");
require_once("classes/ViewPermission.php");
require_once("classes/ControlPermission.php");
require_once("classes/ViewPermission.php");
$DB = new DataBase();
$POST= new Post();
$COMMENT= new Comment();
$CONTROLCOM= new ControlComment();
$VIEWCOM= new ViewComment();
$PERM= new ViewPermission();
$CONTROLPERM= new ControlPermission();
$connection= $DB->connect();
if(!isset($_SESSION['id'])){
    echo $PERM->forbidden_page();
    exit;
}
$action = (isset($_GET['action'])) ? $_GET['action'] :'show';
switch($action){
    case 'deletecomment':
        $comment_id=(abs(intval($_GET['commentid'])) ===0) ? 1 :abs(intval($_GET['commentid']));
        $author_info = $COMMENT->fetch_comment_author_info($connection, $comment_id);
        $post_id= $author_info['post_id'];
        $forbidden= $CONTROLPERM->control_perm_comment($connection, $comment_id, $_SESSION);
        if($forbidden){
            echo $forbidden;exit;
        }
        $result= $COMMENT->delete_comment($connection, $comment_id);
        if($result==='redirect') header("Location: post.php?action=show&postid=$post_id&show=5");;
        break;
    case 'modcomment':
        $comment_id=(abs(intval($_GET['commentid'])) ===0) ? 1 :abs(intval($_GET['commentid']));
        $forbidden= $CONTROLPERM->control_perm_comment($connection, $comment_id, $_SESSION);
        if($forbidden){
            echo $forbidden;exit;
        }
        $result= $CONTROLCOM->control_mod_page($connection, $_GET, $_SESSION, $_SERVER, $_POST);
        if($result==='redirect') header("Location: comment.php?action=show&commentid=$comment_id");
        echo $result;
        break;
    default :
        echo $CONTROLCOM->control_comment_page($connection, $_GET, $_SESSION);
        break;
}

?>