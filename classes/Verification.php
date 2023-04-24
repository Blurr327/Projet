<?php

class Verification{
    
    public function prepare_error_msg($error_msgs,$type){
         if(isset($error_msgs[$type])){
            return "<p style='color :#990000'>".$error_msgs[$type]."</p>";
         }
         return "";
    }
    
    public function prepare_data(&$data){ // prépare les données pour le traitement
        foreach($data as $key => $value){
            $data[$key] = htmlspecialchars(trim($value));
        }
    }

   public function verify_required(&$data, &$required_errors, $required){ // vérification des champs requis
        $ok=true;
        foreach($required as $value){
            if(empty($data[$value])){
                $ok=false;
                $required_errors[]=$value;
            }
        }
        return $ok;
    }

    public function unique_nickname($nickname,$result_of_fetch){ // vérification de l'unicité du pseudo
            if(!$result_of_fetch){
                echo "Requête invalide";
                return false;
            }
            return mysqli_num_rows($result) === 0;
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

    public function verify_pwd_and_nickname(&$data,&$errors,$connection){
        $ok=false;
        $result = fetch_user($connection,$data['pseudo']);
        if($result){
            if(!unique_nickname($data["pseudo"],$result)){
                $ok = verify_password_validity($data['password'],$result);
                $errors[]=($ok) ? "":"password";
             }
            else {
                $errors[]="pseudo";
            }
        }
        return $ok;
    }

    public function is_admin(&$data,$connection){
        $result = fetch_user($connection,$data['pseudo']);
        if($result){
            $line=mysqli_fetch_assoc($result);
            return $line['admin'] == 1;
        }
        return false;
    }
    
}

?>