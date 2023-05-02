<?php
    session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]); // start session AFTER logging in....
    require_once("classes/Register.php");
    require_once("classes/DataBase.php");
    require_once("classes/Login.php");
    require_once("classes/ControlLogin.php");
    require_once("classes/ViewLogin.php");
    require_once("classes/ControlRegister.php");
    require_once("classes/ViewRegister.php");
    require_once("classes/Verification.php");
    require_once("classes/DefaultPage.php");
    require_once("classes/User.php");
    $action=(isset($_GET['action'])) ? $_GET['action'] : "default";
    $DB= new DataBase();
    $VER= new Verification();
    $CONTROLLOG= new ControlLogin();
    $VIEWLOG = new ViewLogin();
    $CONTROLREG= new ControlRegister();
    $VIEWREG = new ViewRegister();
    $REG= new Register();
    $DEF= new DefaultPage();
    if(isset($action)){
        switch($action){
            case 'login':
                  $problem=$CONTROLLOG->control_login_page($_POST,$_SESSION, $_SERVER);
                  if(!$problem) header("Location: timeline.php?show=1&order=recent");
                  echo $problem;
            break;
            case 'register': 
                if($_SERVER['REQUEST_METHOD']==='POST'){
                    $problem=$CONTROLREG->control_register_page($_POST,'',$_GET,$_SESSION);
                   if(!$problem){ 
                        echo"<p style='color: green;font-size:large'>Enregistrement Réussi</p><br>";
                        header("refresh:3;url=index.php?action=login");
                    }
                   echo $problem;
                }
                else {
                    echo $VIEWREG->simple_reg_display("","","","");
                }
                break;
            case 'default': echo $DEF->display_default_page();break;
            default: echo $DEF->display_default_page();break;
        }
    }
?>