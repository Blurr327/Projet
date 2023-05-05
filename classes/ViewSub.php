<?php class ViewSub{

    public function display_follow_and_follower($follow_button, $num_followers, $num_followed){
        return "
        <div id='followblock'>
            <h3 id='followers'>followers : $num_followers</h3>
            <h3 id='followed'>Suivi(e)s : $num_followed</h3>
            $follow_button
        </div>
    ";
    }

    public function display_follow_button($user_id_profile,$follow_status, $order){
        return "
        <form action='profile.php?action=show&order=$order&userid=$user_id_profile&show=1' method='post'>
            <input id='followbutton' type='submit' name='$follow_status' value='$follow_status'>
        </form>
    ";
    }

} ?>
