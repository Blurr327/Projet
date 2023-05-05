<?php

class ViewProfile{

    public function display_profile_info_block($nickname, $firstname, $lastname){
        return "
            <div id='profileinfo'>
                <h2>$nickname's Blackboard</h2><br>
                <p>$firstname $lastname</p><br>
            </div>
        ";
    }

    public function display_no_posts_msg_profile(){
        return "
        
        <h3>Cet utilisateur n'a aucun poste</h3>
        ";
    }

    public function display_nav($order){
        return "";
    }
}
?>