<?php
class Login{    

    public function error_msgs_login(&$error_messages,&$required_errors,&$format_errors){
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
            foreach($format_errors as $value){
                if($value === "password"){
                    $error_messages["password"]= "mot de passe incorrect";
                }
                else if($value==="pseudo"){
                    $error_messages["pseudo"]="cet utilisateur n'existe pas";
                }
            }
        }
    }
    
    public function display_login_page($error_msgs){
        $VER = new Verification();
        $password_error=$VER->prepare_error_msg($error_msgs,'password');
        $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo');
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
                  <form action='?action=login' method='post'>
                    <label for='pseudo'>Pseudo : </label>
                    <input type='text' name='pseudo' placeholder='pseudo' id='pseudo'><br>
                         $nickname_error 
                    <label for='password'>Password : </label>
                    <input type='password' name='password' placeholder='password' id='password'><br>
                         $password_error
                  </form>
            </body>
        </html>
        ";
    }
}

?>
