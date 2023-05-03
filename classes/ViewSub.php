<?php class ViewSub{

    public function display_follow_and_follower($follow_button, $num_followers, $num_followed){
        return "
        <div id='followblock'>
            $follow_button
            <h3>followers : </h3><p id='numfollowers'>$num_followers</p>
            <h3>Suivi(e)s : </h3><p id='numfollowed'>$num_followed</p>
        </div>
    ";
    }

    public function display_follow_button($user_id_profile,$follow_status, $order){
        return "
        <form action='profile.php?action=show&order=$order&userid=$user_id_profile&show=1' method='post'>
            <input type='submit' name='$follow_status' value='$follow_status'>
        </form>
    ";
    }

} ?>
