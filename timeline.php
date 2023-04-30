<?php
session_start();
require_once("classes/DataBase.php");
require_once("classes/Like.php");
require_once("classes/Comment.php");
require_once("classes/Post.php");
require_once("classes/Verification.php");
require_once("classes/User.php");
require_once("classes/Permission.php");
require_once("classes/TimeLine.php");
$DB= new DataBase();
$TL= new TimeLine();
$connection = $DB->connect();
echo $TL->simple_display_timeline($connection, $_GET, $_SESSION);
?>