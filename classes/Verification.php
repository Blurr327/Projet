<?php

class Verification{

    public function update_field_error_variables(&$data, &$required, &$error_msgs){
        $req_errors=array();
        $error_msgs=array();
        foreach($required as $req){
            $error_msgs[$req]="";
        }
        $this->verify_required($data,$req_errors, $required);
        $this->error_msgs_post_fields($error_msgs, $req_errors);
        foreach($error_msgs as $key => $error_msg){
            $error_msgs[$key]=$this->prepare_error_msg($error_msgs,$key);
        }
        return !$req_errors;
    }

    public function error_msgs_post_fields(&$error_msgs ,&$req_errors){
        foreach($req_errors as $error){
            $error_msgs[$error]="Ce champ ne peut pas être vide";
        }
        return $error_msgs;
    }
    
    public function prepare_error_msg($error_msgs,$type){ // prépare le message d'erreur pour l'affichage
         if(isset($error_msgs[$type])){
            return "<p style='color :#990000;font-size:small;opacity:0.75;'>".$error_msgs[$type]."</p>";
         }
         return "";
    }
    
    public function prepare_data(&$data){ // prépare les données pour le traitement
        foreach($data as $key => $value){
            $data[$key] = htmlspecialchars(trim($value));
        }
    }

   public function verify_required(&$data, &$required_errors, $required){ // vérification des champs requis
      
        foreach($required as $value){
            if(empty($data[$value])){
                $ok=false;
                $required_errors[]=$value;
            }
        }
     
    }

    public function unique_nickname($result_of_fetch){ // vérification de l'unicité du pseudo
            if(!$result_of_fetch){
                echo "Requête invalide";
                return false;
            }
            return mysqli_num_rows($result_of_fetch) === 0;
    }
        
    public function verify_password_format($password){ 
        $uppercase = preg_match('/[A-Z]/', $password); // vérifie la présence d'un caractère majuscule
        $lowercase = preg_match('/[a-z]/', $password); // vérifie la présence d'un caractère miniscule
        $number= preg_match('/[0-9]/', $password); // vérifie la présence d'un nombre
        $specialchars = preg_match('/[^\w]/', $password); // vérifie la présence d'un caractère spécial
        return strlen($password) <8 || !$uppercase || !$lowercase || !$number || !$specialchars; 
    }

    public function verify_name_format($name){ 
        return !preg_match("/^[a-zA-Z\s]+$/", $name); // le nom ne contient que des lettre et éventuellement des espaces
    }

    public function verify_nickname_format($nickname){
        return !preg_match("/^[a-zA-Z0-9\s]+$/", $nickname); // le pseudo ne contient que des lettres, des espaces et des nombres
    }
    
    public function verify_password_validity($password,$result_of_fetch){ // vérifie la validité du mot de passe 
        while($line=mysqli_fetch_assoc($result_of_fetch)){
            if($line['password'] === md5($password)) return true;
        }
        return false;
    }
    
    public function verify_pwd_and_nickname(&$data,&$errors,$connection){ // vérifie l'existence de l'utilisateur et la validité du mot de passe
        $DB= new DataBase();
        $USER= new User();
        $ok=false;
        $result = $USER->fetch_user($connection,$data['pseudo']);
        if($result){
            if(!$this->unique_nickname($result)){
                $ok = $this->verify_password_validity($data['password'],$result);
                $errors[]=($ok) ? "":"password";
             }
            else {
                $errors[]="pseudo";
            }
        }
        return $ok;
    }
    
    public function verify_format(&$data,&$format_errors,$connection){  // vérifie la validité des données
    
        $VER = new Verification();
        $DB=new DataBase();
        $USER= new User();
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
                if(!$VER->unique_nickname($USER->fetch_user($connection,$given_value))){
                    $ok=false;
                    $format_errors[]="pseudo1";
                }
            }
        }
    
    }

    
}

?>