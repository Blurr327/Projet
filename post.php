<?php
session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);
require_once("classes/DataBase.php");
require_once("classes/Like.php");
require_once("classes/Comment.php");
require_once("classes/Post.php");
require_once("classes/ControlPost.php");
require_once("classes/ViewPost.php");
require_once("classes/Verification.php");
require_once("classes/User.php");
require_once("classes/ViewComment.php");
require_once("classes/ControlPermission.php");
require_once("classes/ViewPermission.php");
$DB = new DataBase();
$POST= new Post();
$PERM= new ControlPermission();
$VIEWPERM= new ViewPermission();
$COMMENT= new Comment();
$LIKE = new Like();
$CONTROLPOST= new ControlPost();
$USER = new User();
$connection= $DB->connect();
if(!isset($_SESSION['id'])){
    echo $VIEWPERM->forbidden_page();
    exit;
}
$action = (isset($_GET['action'])) ? $_GET['action'] :'show';
switch($action){
    case 'modpost':
            $post_id=(abs(intval($_GET['postid'])) === 0) ? 1 : abs(intval($_GET['postid']));
            $forbidden=$PERM->control_perm_post($connection, $post_id, $_SESSION);
            if($forbidden) {
                echo $forbidden;exit;
            }
            $result=$CONTROLPOST->control_post_mod($connection, $_GET, $_SESSION, $_POST,$_SERVER);
            if($result==='redirect') header("Location: post.php?show=5&action=show&postid=$post_id");
            echo $result;
        break;
    case 'createpost':
        echo $CONTROLPOST->control_post_creation($connection, $_POST, $_SESSION, $_SERVER);
        break;
    case 'show' :
        echo $CONTROLPOST->control_post_page($connection, $_GET, $_SESSION, $_POST, $_SERVER);
        break;
    case 'deletepost':
        $post_id=(abs(intval($_GET['postid'])) === 0) ? 1 : abs(intval($_GET['postid']));
        $forbidden=$PERM->control_perm_post($connection, $post_id, $_SESSION);
        if($forbidden) {
            echo $forbidden;exit;
        }
        $result=$CONTROLPOST->control_delete_post($connection, $post_id);
        if($result==='redirect') header("Location: timeline.php?show=1&order=recent");
        break;
}
?>