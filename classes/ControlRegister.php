<?php class ControlRegister{


public function control_register_page(&$data){  // affichage de la page quand la méthode de requête est post
    $VER = new Verification();
    $DB = new DataBase();
    $USER= new User();
    $REG= new Register();
    $required=array("pseudo","password","prenom","nom");
    $error_msgs=array();
    $req_errors=array();
    $VIEWREG = new ViewRegister();
    $format_errors=array();
    $connection=$DB->connect();
    $VER->prepare_data($data);
    $VER->verify_required($data,$req_errors,$required);
    if(empty($req_errors)) $VER->verify_format($data,$format_errors,$connection);
    $REG->error_msgs_register($error_msgs,$req_errors,$format_errors);
    $password_error=$VER->prepare_error_msg($error_msgs,'password');
    $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo');
    if(empty($nickname_error)) $nickname_error=$VER->prepare_error_msg($error_msgs,'pseudo1'); // ça c'est pour l'erreur "utilisateur existe déjà"
    $firstname_error=$VER->prepare_error_msg($error_msgs,'prenom');
    $lastname_error=$VER->prepare_error_msg($error_msgs,'nom');
    if(empty($error_msgs)){
        $USER->insert_user($connection,$data['prenom'],$data['nom'],$data['pseudo'],$data['password']);
        return false;
    }
    return $VIEWREG->simple_reg_display($firstname_error,$lastname_error,$nickname_error,$password_error);
}



} ?>
