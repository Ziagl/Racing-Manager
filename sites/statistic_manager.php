<?php
    $teams = $db->getTeams($user['ins_id'], 'points desc');
    $drivers_old = $db->getDrivers($user['ins_id'], 'and tea_id is not null','points desc');
    $users_old = $db->getUsers($user['ins_id'], 'points desc, placement asc');

    //get team name for each driver
    $drivers = array();
    foreach($drivers_old as $driver)
    {
        $t = $db->getTeam($driver['tea_id']);
        $driver['team'] = $t['name'];
        $drivers[] = $driver;
    }

    //get team name for each user
    $users = array();
    $user_images = array();
    foreach($users_old as $usr)
    {
        $t = $db->getTeam($usr['tea_id']);
        $usr['team'] = $t['name'];
        $usr['color1'] = $t['color1'];
        $usr['picture'] = "/driver/default.jpg";
        $file = './content/img/manager/'.$usr['id'].'.svg';
		if(file_exists($file))
		{
			$usr['picture'] = "/manager/".$usr['id'].'.svg';
		}
        $users[] = $usr;
    }
    
    //get last 2 dates
    $user_ranking_array = array();
    foreach($users as $u)
    {
    	$history = $db->getUserHistoryForUser($u['id']);
		$rank = -1;
		$rank_last = -1;
		if(count($history) > 0)
		{
			$rank = $history[0]['ranking'];
			$rank_last = (count($history) > 1)?$history[1]['ranking']:$history[0]['ranking'];
		}

		$use_id = $u['id'];
		
		if(array_key_exists($use_id, $user_ranking_array))
			$user_ranking_array[$use_id]['pos1'] = $rank;
		else
			$user_ranking_array[$use_id] = array('pos1' => $rank);
			
		if(array_key_exists($use_id, $user_ranking_array))
			$user_ranking_array[$use_id]['pos2'] = $rank_last;
		else
			$user_ranking_array[$use_id] = array('pos2' => $rank_last);
    }
    
    //for each date get positions of team and compute difference
    $array_size = count($users);
    for($i = 0; $i < $array_size; ++$i)
    {
    	$diff = 0;
    	if(array_key_exists($users[$i]['id'], $user_ranking_array))
    	{
    		$pos1 = 0;
    		$pos2 = 0;
    		if(array_key_exists('pos1',$user_ranking_array[$users[$i]['id']]))
    			$pos1 = $user_ranking_array[$users[$i]['id']]['pos1'];
    		if(array_key_exists('pos2',$user_ranking_array[$users[$i]['id']]))
    			$pos2 = $user_ranking_array[$users[$i]['id']]['pos2'];
    		$diff = $pos1 - $pos2;
    	}
    	$users[$i]['change'] = "";
    	if($diff < 0)
    		$users[$i]['change'] = "<span style='color: green'>&#9650; +".abs($diff)."</span>";//▲
    	if($diff > 0)
    		$users[$i]['change'] = "<span style='color: red'>&#9660; -".abs($diff)."</span>";//▼
    }//foreach

    $smarty->assign('users', $users);
    $smarty->assign('user_id', $user['id']);
    $smarty->assign('content', 'statistic_manager.tpl');