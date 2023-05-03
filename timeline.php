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
require_once("classes/ViewPermission.php");
require_once("classes/SeriesOfPosts.php");
require_once("classes/ViewSeriesOfPosts.php");
require_once("classes/ControlSeriesOfPosts.php");
require_once("classes/Sub.php");
require_once("classes/ControlSub.php");
require_once("classes/ViewSub.php");

$DB= new DataBase();
$SER= new SeriesOfPosts();
$VIEWPERM = new ViewPermission();
$VIEWSER = new ViewSeriesOfPosts();
$CONTROLSER = new ControlSeriesOfPosts();
$connection = $DB->connect();
if(!isset($_SESSION['id'])) echo $VIEWPERM->forbidden_page();
else echo $CONTROLSER->control_series_of_posts($connection, $_GET, $_SESSION, 'follower_id', 'timeline.php', $_SERVER, $_POST);
?>