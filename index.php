<?php
    session_start();
    require_once("classes/Register.php");
    require_once("classes/DataBase.php");
    require_once("classes/Login.php");
    require_once("classes/Verification.php");
    require_once("classes/DefaultPage.php");
    require_once("classes/User.php");
    $action=(isset($_GET['action'])) ? $_GET['action'] : "default";
    $DB= new DataBase();
    $VER= new Verification();
    $LOG= new Login();
    $REG= new Register();
    $DEF= new DefaultPage();
    if(isset($action)){
        switch($action){
            case 'login':
                if($_SERVER['REQUEST_METHOD']==='POST'){
                  $problem=$LOG->display_login_page($_POST,$_SESSION);
                  if(!$problem) header("Location: timeline.php?show=1");
                  echo $problem;
               }
                else {
                   echo $LOG->simple_log_display("","");
            }
            break;
            case 'register': 
                if($_SERVER['REQUEST_METHOD']==='POST'){
                    $problem=$REG->display_register_page($_POST);
                   if(!$problem){ 
                        echo"<p style='color: green;font-size:large'>Enregistrement Réussi</p><br>";
                        header("refresh:3;url=index.php?action=login");
                    }
                   echo $problem;
                }
                else {
                    echo $REG->simple_reg_display("","","","");
                }
                break;
            case 'default': echo $DEF->display_default_page();break;
            default: echo $DEF->display_default_page();break;
        }
    }
?>