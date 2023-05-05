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
require_once("classes/ControlUser.php");
require_once("classes/ViewUser.php");
require_once("classes/Sub.php");
require_once("classes/ViewProfile.php");
require_once("classes/ViewTimeline.php");
require_once("classes/ViewPermission.php");
require_once("classes/SeriesOfPosts.php");
require_once("classes/ViewSeriesOfPosts.php");
require_once("classes/ControlSeriesOfPosts.php");
require_once("classes/Sub.php");
require_once("classes/ControlSub.php");
require_once("classes/ViewSub.php");
$DB= new DataBase();
$connection = $DB->connect();
$USER = new User();

$DB= new DataBase();
$SER= new SeriesOfPosts();
$VIEWPERM = new ViewPermission();
$VIEWSER = new ViewSeriesOfPosts();
$CONTROLSER = new ControlSeriesOfPosts();
$CONTROLUSER= new ControlUser();
$connection = $DB->connect();
$action=(isset($_GET['action'])) ? $_GET['action'] :'show';
if(!isset($_SESSION['id'])) echo $VIEWPERM->forbidden_page();
else{ 
    switch($action){
        case 'show':
            echo $CONTROLSER->control_series_of_posts($connection, $_GET, $_SESSION, 'profile', $_SERVER, $_POST);
            break;
        case 'search':
            echo $CONTROLUSER->control_search_page($connection, $_GET, $_POST, $_SERVER);
            break;
    }
}
?>