<?php
session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);
require_once("classes/DataBase.php");
require_once("classes/Like.php");
require_once("classes/Comment.php");
require_once("classes/Post.php");
require_once("classes/Verification.php");
require_once("classes/User.php");
require_once("classes/Sub.php");
require_once("classes/Permission.php");
require_once("classes/SeriesOfPosts.php");
$DB= new DataBase();
$connection = $DB->connect();
$USER = new User();
$PERM = new Permission();
if(!isset($_SESSION['id'])){
echo $PERM->forbidden_page();
exit;
}
$action=$_GET['action'];
switch($action){
    case 'deleteuser':
        $user_id=$_GET['userid'];
        $current_user_id= $_SESSION['id'];
        $hasright = $USER->delete_user($connection, $_SESSION, $user_id);
        if(!$hasright) echo $PERM->forbidden_page();
        if($user_id === $current_user_id) header("Location: index.php?action=default");
        else header("Location: timeline.php?show=1&order=recent");  
    case 'moduser':

}
?>