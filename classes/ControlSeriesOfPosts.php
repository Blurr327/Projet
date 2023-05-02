<?php class ControlSeriesOfPosts{


    public function control_drop_down_for_pages($connection, $session){
        $SERPOST= new SeriesOfPosts();
        $VIEWSER = new ViewSeriesOfPosts();
        $num_pages= $SERPOST->get_num_pages_for_timeline($connection, $session);
        return $VIEWSER->display_drop_down_for_pages($num_pages);
    }

    public function control_series_of_posts($connection, $get, $session, $timeline_or_user){ // $timeline_or_user peut contenir soit : author_id soit : follower_id 
        $POST = new Post();
        $CONTROLPOST = new ControlPost();
        $VIEWSER = new ViewSeriesOfPosts();
        $SERPOST= new SeriesOfPosts();
        $order=(htmlspecialchars($get['order']) === 'like') ? 'likes' : 'posts_creation_date';

        $no_posts_msg=($timeline_or_user === 'follower_id') ? "<h3>Aucun poste... <a href='profile.php?action=search&show=1'>Suivez quelqu'un</a></h3>" : "<h3>Cet utilisateur n'a aucun poste</h3>"; // préparation du message affiché quand il y a aucun poste
        $no_posts= ($POST->get_number_of_posts($connection, $session) === 0) ? $no_posts_msg : '';

        $checked_order_like=($order==='likes') ? 'checked' : ''; // mise à jour du statut de l'ordre
        $checked_order_recent=($order==='posts_creation_date') ? 'checked': '';

        $show=(abs(intval($get['show'])) === 0) ? 1 :abs(intval($get['show'])) ; // valeur du paramétre est modifiable depuis le navigateur, donc il faut se rassurer du fait que c'est un nombre strictement postitive

        $posts=$CONTROLPOST->control_timeline_or_user_posts($connection, $session, $get, $order, $timeline_or_user); // accès aux postes

        $pages_drop_down_display= $this->control_drop_down_for_pages($connection, $session); // pour l'affichage de la liste déroulante

        $current_user_id=$session['id']; // préparation de la partie navigation
        $nav= ($timeline_or_user === 'follower_id') ? "<a href='profile.php?action=show&userid=$current_user_id&show=1&order=recent'>Mon Profile</a>
        <a href='profile.php?action=search&show=1'>Recherche</a>" : "<a href='timeline.php?show=1&order=recent'><pre><<Revenir au fil d'actualité</pre></a>";

        return $VIEWSER->display_series_of_posts($nav, $show,$pages_drop_down_display ,$checked_order_like, $checked_order_recent, $no_posts, $posts);
    }
} ?>
