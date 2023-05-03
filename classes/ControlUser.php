<?php class ControlUser{

    public function control_list_users($connection, $num_shown){
        $USER= new User();
        $VIEWUSER= new ViewUser();
        $list_of_users_display='';

        $users_array=$USER->get_list_of_users($connection, $num_shown);
        foreach($users_array as $user_array){
            $list_of_users_display .= $VIEWUSER->display_user_on_list($user_array['nickname'], $user_array['id']);
        }
        return $list_of_users_display;
    }

    public function control_search_page($connection, $get, $data, $server){
        $USER= new User();
        $VIEWUSER= new ViewUser();
        $show= abs(intval($get['show']));
        $num_users= $USER->get_num_users($connection);
        $display_more=($show+5 > $num_users) ? $num_users : $show+5; // un paramètre de get controle combien d'utilisateurs on peut voir
        $display_less=($show-5 >= 0) ? $show-5 : 0;

        



        if($server['REQUEST_METHOD']==='POST'){
            $result= $USER->update_list_page($connection, $data);
            if(!$result) $list_users= "<p> Cet utilisateur n'existe pas";
            else $list_users=$VIEWUSER->display_user_on_list($data['searchfield'], $result[0]['id']);
        }
        else{
            $list_users= $this->control_list_users($connection, $show);
            
        }
        return $VIEWUSER->display_user_list($list_users, $display_more, $display_less);
    }
} ?>
