<?php
class Login{    

    public function error_msgs_login(&$error_messages,&$required_errors,&$other_errors){
        if(!empty($required_errors)){
         foreach($required_errors as $value){
             if($value === "password"){
                    $error_messages["password"]= "Entrer le mot de passe svp";
                }
                else if($value=== "pseudo"){
                    $error_messages["pseudo"]="Entrer le pseudo svp";
                }
         }
        }
        else {
            foreach($other_errors as $value){
                if($value === "password"){
                    $error_messages["password"]= "mot de passe incorrect";
                }
                else if($value==="pseudo"){
                    $error_messages["pseudo"]="cet utilisateur n'existe pas";
                }
            }
        }
    }
    
    public function simple_log_display($nickname_error,$password_error){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
            <head>
                <title>Blackboard : Login Page<title>
                <meta charset='utf8'>
            </head>
            <body>
                  <nav>
                    <a href='?action=default'><h3>Blackboard</h3></a>
                  </nav>
                  <form action='index.php?action=login' method='post'>
                    <label for='pseudo'>Pseudo : </label>
                    <input type='text' name='pseudo' placeholder='pseudo' id='pseudo'><br>
                         $nickname_error 
                    <label for='password'>Password : </label>
                    <input type='password' name='password' placeholder='password' id='password'><br>
                         $password_error
                    <input type='submit' name='submitlog' value='Connexion'>
                    <input type='reset' name='resetlog ' value='Effacer'>
                  </form>
            </body>
        </html>
        ";
    }
    public function display_login_page(&$data){
        $VER = new Verification();
        $DB = new DataBase();
        $required= array("pseudo","password");
        $error_msgs=array();
        $other_errors=array(); // erreurs pour : mot de passe incorrect ou utilisateur inexistant
        $req_errors=array();
        $VER->prepare_data($data);
        $connection = $DB->connect();
        $VER->verify_required($data,$req_errors,$required);
        if(empty($req_errors)) $VER->verify_pwd_and_nickname($data,$other_errors,$connection);
        $this->error_msgs_login($error_msgs,$req_errors,$other_errors);
        $password_error=$VER->prepare_error_msg($error_msgs,'password');
        $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo');
        if(empty($error_msgs)) return true;
        return $this->simple_log_display($nickname_error,$password_error);
    }
}

?>
