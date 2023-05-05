<?php class ControlSeriesOfPosts{


    public function control_drop_down_for_pages($connection, $posts_array, $show){
        $SERPOST= new SeriesOfPosts();
        $VIEWSER = new ViewSeriesOfPosts();
        $num_pages= $SERPOST->get_num_pages($posts_array);
        return $VIEWSER->display_drop_down_for_pages($num_pages, $show);
    }

    public function control_profile_info_block($connection , $user_id_profile){
        $VIEWSER = new ViewSeriesOfPosts();
        $VIEWPROFILE= new ViewProfile();
        $USER=new User();
        $user_info=$USER->fetch_user_byid($connection, $user_id_profile);
        $line = mysqli_fetch_assoc($user_info);
        return $VIEWPROFILE->display_profile_info_block($line['nickname'], $line['firstname'], $line['lastname']); 
    }

    public function control_no_posts_msg($page, $posts_array){
        $VIEWPROFILE= new ViewProfile();
        $VIEWTL= new ViewTimeline();
        if(count($posts_array) != 0) return '';
        switch($page){
            case 'profile':
                return $VIEWPROFILE->display_no_posts_msg_profile(); 
                break;
            case 'timeline':
                return $VIEWTL->display_no_posts_msg_timeline(); 
                break;
        }
    }  

    public function control_check($order, $which_check){
        $checked="";
        switch($which_check){
            case 'like':
                if($order === 'likes') $checked='checked';
                break;
            case 'recent':
                if($order === 'posts_creation_date') $checked='checked';
                break;
        }
        return $checked;
    }

    public function control_additional_block($connection,$page, $get, $session, $server, $data){
        $CONTROLSUB = new ControlSub();
        switch($page){
            case 'profile':
                $user_id_profile=(isset($get['userid'])) ? abs(intval($get['userid'])) : 1;
                $profile_info_block=$this->control_profile_info_block($connection, $user_id_profile);
                $follow_block = $CONTROLSUB->control_follower_and_followed($connection, $get, $session, $server, $data, $user_id_profile);
                return $profile_info_block . $follow_block;
            case 'timeline':
                return "<h2 id='home'>Home</h2>";
        }
    }

    public function control_nav($page, $order, $session){
        $VIEWPROFILE= new ViewProfile();
        $VIEWTL = new ViewTimeline();
        switch($page){
            case 'profile':
                return $VIEWPROFILE->display_nav($order);
            case 'timeline':
                $current_user_id=$session['id'];
                return $VIEWTL->display_nav($order, $current_user_id);
            
        }
    }

    public function control_hidden_data($page, $order, $show, $get){
        switch($page){
            case 'profile':
                $user_id_profile=$get['userid'];
                return array("userid" => $user_id_profile);
            case 'timeline':
                return array();
        }
    }

    public function control_hidden_block($hidden){
        $hidden_block='';
        foreach($hidden as $key => $data){
            $hidden_block .= "<input type=hidden name='$key' value='$data'>";
        }
        return $hidden_block;
    }

    public function control_series_of_posts($connection, $get, &$session, $page, $server, $data){
        $POST = new Post();
        $CONTROLPOST = new ControlPost();
        $VIEWSER = new ViewSeriesOfPosts();
        $SERPOST= new SeriesOfPosts();
        $CONTROLSUB = new ControlSub();
        $VIEWSUB = new ViewSub();

        $SERPOST->update_session_order($session, $get);

        $order=(isset($session['order'])) ? $session['order'] : htmlspecialchars($get['order']);
        $show=(abs(intval($get['show'])) === 0) ? 1 :abs(intval($get['show']));

        

        $checked_order_like= $this->control_check($order, 'like');
        $checked_order_recent= $this->control_check($order, 'recent');

        $additional_block= $this->control_additional_block($connection, $page, $get, $session, $server, $data);

        $nav= $this->control_nav($page, $order, $session);
        $hidden=$this->control_hidden_data($page, $order, $show, $get);
        $hidden_block= $this->control_hidden_block($hidden);

        $posts_array = $SERPOST->get_posts_array($connection, $get, $session, $page, $order);

        $posts= $CONTROLPOST->control_posts($posts_array, $order, $show, $get);

        
        $no_posts_msg= $this->control_no_posts_msg($page, $posts_array);
        
        $pages_drop_down_display=$this->control_drop_down_for_pages($connection, $posts_array, $show);

        return $VIEWSER->display_series_of_posts($nav,$show,$pages_drop_down_display ,$checked_order_like, $checked_order_recent, $no_posts_msg, $posts, $hidden_block, $additional_block, $page);
    }

} ?>
