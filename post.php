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
$PERM= new Permission();
$COMMENT= new Comment();
$LIKE = new Like();
$connection= $DB->connect();
$action = (isset($_GET['action'])) ? $_GET['action'] :'show';
switch($action){
    case 'modpost':
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $post_id=(abs(intval($_GET['postid'])) === 0) ? 1 : abs(intval($_GET['postid']));
            $problem= $POST->display_post_modification_page($connection, $_POST, $_GET, $_SESSION);
            if(!$problem) header("Location: post.php?action=show&postid=$post_id&show=5");
            echo $problem;
        }
        else {
            echo $POST->simple_display_post_mod($connection,$_GET, $_SESSION,"","");
        }
        break;
    case 'createpost':
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $problem= $POST->display_post_creation($connection, $_POST, $_SESSION);
            if(!$problem) header("Location: timeline.php?show=1&order=recent");
            echo $problem;
        }
        else {
            echo $POST->simple_display_post_creation("","");
        }
        break;
    case 'show' :
        if($_SERVER['REQUEST_METHOD']==='POST'){
           
            echo $POST->display_post_page($connection, $_GET, $_SESSION, $_POST);
          
        }
        else {
            echo $POST->simple_display_post_page($connection, $_GET, $_SESSION);
        }
        break;
    case 'deletepost':
        $post_id=(abs(intval($_GET['postid'])) === 0) ? 1 : abs(intval($_GET['postid']));

        $hasright=$POST->delete_post($connection, $post_id, $_SESSION);
        if(!$hasright){
            echo $PERM->forbidden_page();
            break;
        }
        header("Location: timeline.php?show=1&order=recent");
        break;
}
?>