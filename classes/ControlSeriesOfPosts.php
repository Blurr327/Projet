<?php class ControlSeriesOfPosts{


    public function control_drop_down_for_pages($connection, $session, $timeline_or_user, $user_id_profile, $show){
        $SERPOST= new SeriesOfPosts();
        $VIEWSER = new ViewSeriesOfPosts();
        $num_pages= $SERPOST->get_num_pages_for_timeline($connection, $session, $timeline_or_user, $user_id_profile);
        return $VIEWSER->display_drop_down_for_pages($num_pages, $show);
    }

    public function control_profile_info_block($connection , $user_id_profile){
        $VIEWSER = new ViewSeriesOfPosts();
        $USER=new User();
        $user_info=$USER->fetch_user_byid($connection, $user_id_profile);
        $line = mysqli_fetch_assoc($user_info);
        return $VIEWSER->display_profile_info_block($line['nickname'], $line['firstname'], $line['lastname']);
    }

    public function control_series_of_posts($connection, $get, &$session, $timeline_or_user, $url, $server, $data){ // $timeline_or_user peut contenir soit : author_id soit : follower_id 
        $POST = new Post();
        $CONTROLPOST = new ControlPost();
        $VIEWSER = new ViewSeriesOfPosts();
        $SERPOST= new SeriesOfPosts();
        $CONTROLSUB = new ControlSub();
        $VIEWSUB = new ViewSub();
        $user_id_profile=(isset($get['userid'])) ? abs(intval($get['userid'])) : 1;
        $order=(isset($session['order'])) ? $session['order'] : htmlspecialchars($get['order']);

        if(!isset($session['order']) || isset($get['dropdown'])){ // pour garder l'ordre préféré pendant la session
            $session['order']=htmlspecialchars($get['order']);
            $order=htmlspecialchars($get['order']);
        }

        $no_posts_msg=($timeline_or_user === 'follower_id') ? "<h3>Aucun poste... <a href='profile.php?action=search&show=10'>Suivez quelqu'un</a></h3>" : "<h3>Cet utilisateur n'a aucun poste</h3>"; // préparation du message affiché quand il y a aucun poste
        $no_posts= ($POST->get_number_of_posts($connection, $session, $timeline_or_user, $user_id_profile) === 0) ? $no_posts_msg : '';

        $checked_order_like=($order==='likes') ? 'checked' : ''; // mise à jour du statut de l'ordre
        $checked_order_recent=($order==='posts_creation_date') ? 'checked': '';

        $show=(abs(intval($get['show'])) === 0) ? 1 :abs(intval($get['show'])) ; // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive

        $posts=$CONTROLPOST->control_timeline_or_user_posts($connection, $session, $get, $order, $timeline_or_user); // accès aux postes

        $pages_drop_down_display= $this->control_drop_down_for_pages($connection, $session, $timeline_or_user, $user_id_profile, $show); // pour l'affichage de la liste déroulante


        switch($timeline_or_user){
            case 'author_id':
                $nav="<a href='timeline.php?show=1&order=$order'>Revenir au fil d'actualité</a>";
                $follow_block= $CONTROLSUB->control_follower_and_followed($connection, $get, $session, $server, $data, $user_id_profile);
                $url="profile.php?action=show&userid=$user_id_profile&show=1&order=$order";
               
                $profile_info_block= $this->control_profile_info_block($connection, $user_id_profile);
                break;
            default:
                $current_user_id=$session['id']; // préparation de la partie navigation
                $nav="<a id='myprofile' href='profile.php?action=show&userid=$current_user_id&show=1&order=$order'>Mon Profile</a>
                <a id='search' href='profile.php?action=search&show=10'>Recherche</a> <a id='postcreate' href='post.php?action=createpost'>Publier</a>";
                $follow_block= '';
                $profile_info_block='';
                break;
        }
          

        return $VIEWSER->display_series_of_posts($nav,$show,$pages_drop_down_display ,$checked_order_like, $checked_order_recent, $no_posts, $posts, $url, $follow_block, $profile_info_block);
    }
} ?>
