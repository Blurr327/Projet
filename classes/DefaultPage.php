<?php
class DefaultPage{
    public function display_default_page(){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
            <head>
                <title>Blackboard : Welcome !</title>
                <meta charset='utf8'>
            </head>
            <body>
                <header>
                    <h1>Blackboard<h1>
                </header>
                <h2>Share your passion for mathematics and help others !</h2>
                <div id='buttons'>
                    <section id='signup'>
                        <h3><a href='?action=register'>Inscription</a></h3>
                    </section>
                    <section id='login'>
                        <h3><a href='?action=login'>Connexion</a></h3>
                    </section>
                </div>  
                <footer id='about'>
                   <p>This project has been collaborated on by Mohamed BEN EL MOSTAPHA and Marius Lecomte, Group 27.</p>
                </footer>
            </body>
        </html>
        ";
    }
}
?>