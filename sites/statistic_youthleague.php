<?php
	//driver
	$drivers_old = $db->getDrivers($user['ins_id'], 'AND (tea_id IS NOT NULL OR ai_tea_id IS NOT NULL) AND youth_points > 0','youth_points desc');
	
	$drivers = array();
    foreach($drivers_old as $driver)
    {
    	$t = $db->getTeam($driver['tea_id']);
	    if(!isset($t))
	    	$t = $db->getTeam($driver['ai_tea_id']);
	    
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

	//team
    $teams_old = $db->getTeams($user['ins_id'], 'youth_points desc, placement asc');
    
    $teams = array();
    $array_size = count($teams_old);
    for($i = 0; $i < $array_size; ++$i)
    {
    	if($teams_old[$i]['youth_points'] > 0)
    	{
    		$_team = $teams_old[$i];
    		$_user = $db->getUserByTeam($_team['id']);
			$_team['manager_human'] = false;
			if($_user)
			{
				$_team['manager'] = $_user['name'];
				$_team['manager_human'] = true;
				$_team['manager_userid'] = $_user['id'];
			}
    		$teams[] = $_team;
    	}
    }
    
    $smarty->assign('drivers', $drivers);
    $smarty->assign('teams', $teams);
    $smarty->assign('team_id', $team['id']);
    $smarty->assign('content', 'statistic_youthleague.tpl');
