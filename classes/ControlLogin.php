<?php class ControlLogin{
  
    public function control_login_page(&$data,&$session, $server){
        $VER = new Verification();
        $DB = new DataBase();
        $USER= new User();
        $VIEWLOG = new ViewLogin();
        $LOGIN= new Login();
        $nickname_error="";
        $password_error="";
        if($server['REQUEST_METHOD'] === 'POST'){
            $required= array("pseudo","password");
            $error_msgs=array();
            $other_errors=array(); // erreurs pour : mot de passe incorrect ou utilisateur inexistant
            $req_errors=array();
            $VER->prepare_data($data);
            $connection = $DB->connect();
            $VER->verify_required($data,$req_errors,$required);
            if(empty($req_errors)) $VER->verify_pwd_and_nickname($data,$other_errors,$connection);
            $LOGIN->error_msgs_login($error_msgs,$req_errors,$other_errors);
            $password_error=$VER->prepare_error_msg($error_msgs,'password');
            $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo');
            if(empty($error_msgs)){ 
                $session['id']=$USER->get_user_id($connection,$data['pseudo']);
                $session['pseudo']=$data['pseudo'];
                if($USER->is_admin($session,$connection)) $session['admin']=1;
                return false;
            }
        }
        return $VIEWLOG->simple_log_display($nickname_error,$password_error);
    }
} ?>
