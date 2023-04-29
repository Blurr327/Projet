<?php

class Register{
    
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

    public function simple_reg_display($firstname_error,$lastname_error,$nickname_error,$password_error){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
            <head>
                <title>Blackboard : Register Page</title>
                <meta charset='utf8'>
                <link rel='stylesheet' href='css/register.css'>
            </head>
            <body>
                  <header>
                  <a href='?action=default'><h1 >Blackboard</h1></a>
                  </header>
                  
                  <h3>Inscrivez-vous : </h3>
                  <form action='index.php?action=register' method='post'>
                  <span class='field'>
                  <label for='prenom'>Prénom : </label>
                  <input type='text' name='prenom' placeholder='prenom' id='prenom'><br>
                  </span>
                       $firstname_error
                    <span class='field'>
                  <label for='nom'>Nom : </label>
                  <input type='text' name='nom' placeholder='nom' id='nom'><br>
                       $lastname_error
                       </span>
                       <span class='field'>
                  <label for='pseudo'>Pseudo : </label>
                  <input type='text' name='pseudo' placeholder='pseudo' id='pseudo'><br>
                  </span>
                       $nickname_error 
                       <span class='field'>
                  <label for='password'>Password : </label>
                  <input type='password' name='password' placeholder='password' id='password'><br>
                  </span>
                       $password_error
                       <span class='actions'>
                  <input type='submit' name='submitreg' value='Envoyer'>
                  <input type='reset' name='resetreg' value='Effacer'>
                  </span>
                  </form>
            </body>
        </html>
        ";
    }

    public function display_register_page(&$data){  // affichage de la page quand la méthode de requête est post
        $VER = new Verification();
        $DB = new DataBase();
        $USER= new User();
        $required=array("pseudo","password","prenom","nom");
        $error_msgs=array();
        $req_errors=array();
        $format_errors=array();
        $connection=$DB->connect();
        $VER->prepare_data($data);
        $VER->verify_required($data,$req_errors,$required);
        if(empty($req_errors)) $VER->verify_format($data,$format_errors,$connection);
        $this->error_msgs_register($error_msgs,$req_errors,$format_errors);
        $password_error=$VER->prepare_error_msg($error_msgs,'password');
        $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo');
        if(empty($nickname_error)) $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo1'); // ça c'est pour l'erreur "utilisateur existe déjà"
        $firstname_error=$VER->prepare_error_msg($error_msgs,'prenom');
        $lastname_error=$VER->prepare_error_msg($error_msgs,'nom');
        if(empty($error_msgs)){
            $USER->insert_user($connection,$data['prenom'],$data['nom'],$data['pseudo'],$data['password']);
            return false;
        }
        return $this->simple_reg_display($firstname_error,$lastname_error,$nickname_error,$password_error);
    }
}
?>

