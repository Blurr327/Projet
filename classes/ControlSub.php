<?php class ControlSub{


    public function control_follower_and_followed($connection, $get, $session, $server, $data, $user_id_profile ){ // pour les pages de profil
        $VIEWSUB= new ViewSub();
        $SUB = new Sub();

        $current_user_id=$session['id'];
        $follow_button='';
        $order= (isset($session['order'])) ? $session['order'] : 'likes';

        if($server['REQUEST_METHOD']==='POST'){
            $SUB->update_follower_and_followed($connection, $get, $session, $data);
        }

        if($current_user_id != $user_id_profile){ // un utilisateur ne peut pas s'abonner à lui même
            $follow_status="follow";
            if($SUB->does_follow($connection, $current_user_id,$user_id_profile)) $follow_status='Se désabonner'; //  mise à jour du status de l'abonnement
            $follow_button=$VIEWSUB->display_follow_button($user_id_profile,$follow_status, $order);
        }

        $num_followers= $SUB->get_number_of_followers($connection, $user_id_profile); // accès au nombre d'abonnées...
        $num_followed= $SUB->get_number_of_followed($connection, $user_id_profile);

        return $VIEWSUB->display_follow_and_follower($follow_button, $num_followers, $num_followed);
    }



} ?>
