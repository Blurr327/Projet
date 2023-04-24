<?php

class Register{

    public function verify_format(&$data,&$format_errors,$connexion){  // vérifie la validité des données
        $ok=true;
        $VER = new Verification();
        foreach($data as $field => $given_value){
            if($field === "password"){
                if($VER->verify_password_format($given_value)) {
                    $ok=false;
                    $format_errors[]=$field;
                }
            }
            else if($field ==="nom"|| $field ==="prenom"){
                if($VER->verify_name_format($given_value)) {
                    $ok=false;
                    $format_errors[]=$field;
                }
            }
            else if($field ==="pseudo"){
                if($VER->verify_nickname_format($given_value)) {
                    $ok=false;
                    $format_errors[]=$field;
                }
                else if(!$VER->unique_nickname($given_value,$connexion)){
                    $ok=false;
                    $format_errors[]="pseudo1";
                }
            }
        }
        return $ok;
    }

    public function error_msgs_register(&$error_messages,&$required_errors,&$format_errors){ // remplie le tableau des messages d'erreurs
        if(!empty($required_errors)){
            foreach($required_errors as $error){
                if($error === "password"){
                    $error_messages["password"]= " le mot de passe est obligatoire";
                }
                else if($error ==="nom"){
                    $error_messages["nom"]=" le nom est obligatoire";
                }
                else if($error ==="prenom"){
                    $error_messages["prenom"]=" le prenom est obligatoire";
                }
                else if($error=== "pseudo"){
                    $error_messages["pseudo"]="le pseudo est obligatoire";
                }
            }
        }
        else {
            foreach($format_errors as $error){
                if($error === "password"){
                    $error_messages["password"]= "le mot de passe doit contenir au moins une lettre miniscule, une lettre majuscule, un caractère spécial et un chiffre.";
                }
                else if($error ==="nom"){
                    $error_messages["nom"]="le nom ne contient que des lettres.";
                }
                else if($error ==="prenom"){
                    $error_messages["prenom"]="le prenom ne contient que des lettres.";
                }
                else if($error==="pseudo"){
                    $error_messages["pseudo"]="le pseudo ne contient que des lettres et des nombres.";
                }
                else if($error==="pseudo1"){
                $error_messages["pseudo1"]="cet utilisateur existe déjà";
                }
            }
        }
    }
    public function display_register_page($error_msgs){
        $VER = new Verification();
        $password_error=$VER->prepare_error_msg($error_msgs,'password');
        $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo');
        $firstname_error=$VER->prepare_error_msg($error_msgs,'prenom');
        $lastname_error=$VER->prepare_error_msg($error_msgs,'nom');
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
                  <form action='?action=register' method='post'>
                    <label for='prenom'>Prénom : </label>
                    <input type='text' name='prenom' placeholder='prenom' id='prenom'><br>
                         $firstname_error
                    <label for='nom'>Nom : </label>
                    <input type='text' name='nom' placeholder='nom' id='nom'><br>
                         $lastname_error
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

