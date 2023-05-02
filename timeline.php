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
require_once("classes/Permission.php");
require_once("classes/SeriesOfPosts.php");
require_once("classes/ViewSeriesOfPosts.php");
require_once("classes/ControlSeriesOfPosts.php");
$DB= new DataBase();
$SER= new SeriesOfPosts();
$PERM = new Permission();
$VIEWSER = new ViewSeriesOfPosts();
$CONTROLSER = new ControlSeriesOfPosts();
$connection = $DB->connect();
if(!isset($_SESSION['id'])) echo $PERM->forbidden_page();
else echo $CONTROLSER->control_series_of_posts($connection, $_GET, $_SESSION, 'follower_id');
?>