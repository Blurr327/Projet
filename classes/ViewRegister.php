<?php class ViewRegister{

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

} ?>
