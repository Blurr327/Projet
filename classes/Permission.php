<?php

class Permission{

    public function forbidden_page(){
        return"
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Forbidden</title>
        </head>
        <body>
            <header>
            <h1>Vous n'avez pas le droit de continuer</h1>
            </header>
        </body>
        </html>
    ";
    }
}

?>