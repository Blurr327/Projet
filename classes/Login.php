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
      

}

?>
