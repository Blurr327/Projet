<?php class ViewLogin{
    
        public function simple_log_display($nickname_error,$password_error){
            return "
            <!DOCTYPE html>
            <html lang='fr'>
                <head>
                    <title>Blackboard : Login Page</title>
                    <meta charset='utf8'>
                    <link rel='stylesheet' href='css/login.css'>
                </head>
                <body>
                <header>
                <a href='?action=default'><h1 id='webname'>Blackboard</h1></a>
                </header>
                      <h3>Connectez-vous : </h3>
                      <form action='index.php?action=login' method='post'>
                      <label for='pseudo'>Pseudo : </label>
                      <input type='text' name='pseudo' placeholder='pseudo' id='pseudo'><br>
                           $nickname_error 
                      <label for='password'>Password : </label>
                      <input type='password' name='password' placeholder='password' id='password'><br>
                           $password_error                     
                      <span class='actions'>
                      <input type='submit' name='submitlog' value='Connexion'>
                      <input type='reset' name='resetlog ' value='Effacer'>
                      </span>
                    </form>
              </body>
          </html>
          ";
      }
  
  

} 

?>
