<?php class ViewPermission{

    public function forbidden_page(){
        return"
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Forbidden</title>
            <link rel='stylesheet' href='css/forbidden.css'>
        </head>
        <body>
            <header>
            <h1>Vous n'avez pas le droit de continuer.</h1>
            </header>
        </body>
        </html>
    ";
    }
} 
?>
