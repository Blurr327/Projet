<?php class ViewUser{

    public function display_user_on_list($nickname, $user_id){
        return "
            <div class='user'>
                <a class='userlink' href='profile.php?action=show&userid=$user_id&show=1'><h2 class='usernick'>$nickname</h2></a>
            </div>
        ";
    }
   
    public function display_user_list($user_list,$display_more, $display_less ){
        return "
            <!DOCTYPE html>
            <html lang='fr'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Blackboard</title>
                    <link rel='stylesheet'  href='css/recherche.css'>
                </head>
                <body>
                    <header>
                        <h1 id='homeh'><a id='homebutton' href='timeline.php?show=1&order=likes'>Blackboard</a></h1>
                        
                    </header>
                    <h2>Recherche</h2>
                    <form action='profile.php?action=search&show=5' method='post'>
                    <textarea rows='1' name='searchfield' placeholder='Chercher'></textarea>
                    <input type='submit' name='search' value='🔍'>
                    </form>
                    <div id='users'>
                    $user_list
                    </div>
                    <div id='options'>
                        <a id ='affplus' href='profile.php?action=search&show=$display_more'>↓</a>
                        <a id='affmoins' href='profile.php?action=search&show=$display_less'>↑</a>
                    </div>
                </body>
            </html>
        ";
    }
} ?>
