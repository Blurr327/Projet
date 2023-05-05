<?php
class ViewTimeline{

    public function display_no_posts_msg_timeline(){
        return "
            <h3>Aucun poste... <a href='profile.php?action=search&show=10'>Suivez quelqu'un</a></h3>
        ";
    }

    public function display_nav($order, $current_user_id){
        return "
        <a id='myprofile' href='profile.php?action=show&userid=$current_user_id&show=1&order=$order'>Mon Profile</a>
                <a id='search' href='profile.php?action=search&show=5'>Recherche</a> <a id='postcreate' href='post.php?action=createpost'>Publier</a>
                ";
    }
}
?>