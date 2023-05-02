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


    
}
?>

