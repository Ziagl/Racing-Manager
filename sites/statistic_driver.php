<?php
    $drivers_old = $db->getDrivers($user['ins_id'], 'AND (tea_id IS NOT NULL OR ai_tea_id IS NOT NULL)','points desc, placement asc');
	$league = $team['league'];
    
    if(isset($_POST['league']))
    {
	    $league = $_POST['league'];
    }

    //get team name for each driver
    $drivers = array();
    foreach($drivers_old as $driver)
    {
    	$t = $db->getTeam($driver['tea_id']);
	    if(!isset($t))
	    	$t = $db->getTeam($driver['ai_tea_id']);
	    
    	if($t['league'] == $league)
    	{
	        $_user = $db->getUserByTeam($driver['tea_id']);
	    	$driver['manager_human'] = false;
			if($_user)
			{
				$driver['manager'] = $_user['name'];
				$driver['manager_human'] = true;
				$driver['manager_userid'] = $_user['id'];
			}
			else
				$driver['manager'] = $t['manager'];
	        $driver['team'] = $t['name'];
	        $driver['team_id'] = $t['id'];
	        $driver['color1'] = $t['color1'];
	        if($driver['tea_id'] == $team['id'])
	        	$driver['ok'] = 1;
	        else
	        	$driver['ok'] = 0;
	        $driver = default_image($driver);
	        $drivers[] = $driver;
        }
    }
    
    //get last 2 dates
    $driver_ranking_array = array();
    for($l = 1; $l < 4; ++$l)
    {
    	$drivers_of_league = $db->getDriversOfLeague($user['ins_id'], $l, "", "id ASC");
    	foreach($drivers_of_league as $driver_of_league)
    	{
    		$history = $db->getDriverHistoryForDriver($driver_of_league['id']);
			$rank = -1;
			$rank_last = -1;
			if(count($history) > 0)
			{
				$rank = $history[0]['ranking'];
				$rank_last = (count($history) > 1)?$history[1]['ranking']:$history[0]['ranking'];
			}

			$dri_id = $driver_of_league['id'];
			
			if(array_key_exists($dri_id, $driver_ranking_array))
				$driver_ranking_array[$dri_id]['pos1'] = $rank;
			else
				$driver_ranking_array[$dri_id] = array('pos1' => $rank);
				
			if(array_key_exists($dri_id, $driver_ranking_array))
				$driver_ranking_array[$dri_id]['pos2'] = $rank_last;
			else
				$driver_ranking_array[$dri_id] = array('pos2' => $rank_last);
    	}
    }//for
    
    //for each date get positions of team and compute difference
    $array_size = count($drivers);
	for($i = 0; $i < $array_size; ++$i)
	{
		$diff = 0;
		if(array_key_exists($drivers[$i]['id'], $driver_ranking_array))
		{
			$pos1 = 0;
			$pos2 = 0;
			if(array_key_exists('pos1',$driver_ranking_array[$drivers[$i]['id']]))
				$pos1 = $driver_ranking_array[$drivers[$i]['id']]['pos1'];
			if(array_key_exists('pos2',$driver_ranking_array[$drivers[$i]['id']]))
				$pos2 = $driver_ranking_array[$drivers[$i]['id']]['pos2'];
			$diff = $pos1 - $pos2;
		}
		$drivers[$i]['change'] = "";
		if($diff < 0)
			$drivers[$i]['change'] = "<span style='color: green'>&#9650; +".abs($diff)."</span>";//▲
		if($diff > 0)
			$drivers[$i]['change'] = "<span style='color: red'>&#9660; -".abs($diff)."</span>";//▼
	}//foreach

    $smarty->assign('drivers', $drivers);
    $smarty->assign('league', $league);
    $smarty->assign('content', 'statistic_driver.tpl');