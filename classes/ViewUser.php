<?php class ViewUser{

    public function display_user_on_list($nickname, $user_id){
        return "
            <div id='user'>
                <a href='profile.php?action=show&userid=$user_id&show=1'<h2>$nickname</h2></a>
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
                </head>
                <body>
                    <nav>
                        <a href='timeline.php?show=1&order=likes'><pre><< Revenir au fil d'actualité</pre></a>
                    </nav>
                    <header>
                        <h1>Recherche</h1>
                    </header>
                    <form action='profile.php?action=search&show=5' method='post'>
                    <textarea name='searchfield' placeholder='Chercher'></textarea>
                    <input type='submit' name='search' value='Chercher'>
                    </form>
                    $user_list
                    <div id='options'>
                        <a href='profile.php?action=search&show=$display_more'>Afficher plus...</a>
                        <a href='profile.php?action=search&show=$display_less'>Afficher moins...</a>
                    </div>
                </body>
            </html>
        ";
    }
} ?>
