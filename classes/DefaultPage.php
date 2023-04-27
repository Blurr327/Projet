<?php
class DefaultPage{
    public function display_default_page(){
        return "
        <!DOCTYPE html>
        <html lang='fr'>
            <head>
                <title>Blackboard : Welcome !</title>
                <meta charset='utf8'>
                <link rel='stylesheet' href='css/default.css'>
            </head>
            <body>
                <header>
                    <h1>Blackboard<h1>
                </header>
                <blockquote id='moto'>The essence of math is not to make simple things complicated, but to make complicated things simple.
                </blockquote>
                <cite>— Stan Gudder</cite>
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