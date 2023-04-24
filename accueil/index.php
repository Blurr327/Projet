<?php

// require_once("classes/Register.php")
// require_once("classes/Login.php")
// check if the user is already logged in, in which case redirect to the Main page

$required= array(   "nom",
  	                "prenom",
  	                "password",
  	                "pseudo",
  ); // pass this array to the function verify required
$connexion = mysqli_connect("localhost","root","","BaseBlackboard");
// check connexion and make sure to show a message when it's not successful
$ok1=false;
$ok2 =false;
if(!empty($_POST)){
$error_messages= array();
$required_errors= array();
$format_errors= array();
pretraiter($_POST);
$ok1 = verify_required($_POST,$required_errors,$required); 	
 	if($ok1){
 		$ok2 = verify_format($_POST, $format_errors,$connexion);
 	}
 	message_erreurs($error_messages,$required_errors,$format_errors);
}
 
if($ok1 && $ok2){
    global $connexion;
    if(!$connexion){
        echo "Pas de connexion au serveur... "; exit;
    }
    mysqli_set_charset($connexion, "utf8");
    $req='INSERT INTO users(firstname, lastname, nickname, password) VALUES (\''. mysqli_real_escape_string($connexion,$_POST["prenom"]) . '\',\''. mysqli_real_escape_string($connexion,$_POST["nom"])  . '\',\'' . mysqli_real_escape_string($connexion,$_POST["pseudo"]) . '\',\''. md5(mysqli_real_escape_string($connexion,$_POST["password"])) .'\')';
    $resultat = mysqli_query($connexion,$req);
    if(!$resultat){
    	echo "requête incorrecte";
    	echo mysqli_error($connexion);
    }

 }
  
  // when you paste the code for register change erreurs message to error_msgs
?>
<html lang="fr">
<head>
	<title>BlackBoard</title>
	<meta charset="utf-8">
	<style>
     .errors {
     	font-size : smaller;
     	color : red;
     }
	</style>
</head>
<body>
	<form action='register.php' method='post'>
		<label for="nom">Nom : </label>
		<input type='text' name='nom' id="nom">	
        <?php
          if(isset($error_messages["nom"])) echo '<p class="errors">' . $error_messages["nom"] . '</p>';
        ?>
		<br>
        <label for="prenom">Prenom : </label>
        <input type="text" name="prenom" id="prenom">
        <?php
          if(isset($error_messages["prenom"]))  echo '<p class="errors">' . $error_messages["prenom"] . '</p>';
        ?>
        <br>
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="pseudo" id="pseudo">
        <?php
          if(isset($error_messages["pseudo"])) echo '<p class="errors">' . $error_messages["pseudo"] . '</p>';
          else if(isset($error_messages["pseudo1"])) echo '<p class="errors">' . $error_messages["pseudo1"] . '</p>';
        ?>
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <?php
          if(isset($error_messages["password"])) echo '<p class="errors">' . $error_messages["password"] . '</p>';
        ?>
        <br>
        <input type="submit" name="submit" value="S'inscrire">
        <input type="reset" name="reset" value="Effacer">
	</form>
</body>
</html>