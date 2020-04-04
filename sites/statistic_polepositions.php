<?php
	$league = $team['league'];//show own league
    if(isset($_SESSION['league']))	
    	$league = $_SESSION['league'];
	else
    	$_SESSION['league'] = $league;
        
    if(isset($_POST['league']))//or selected league
	{
    	$league = $_POST['league'];
    	if($league < 4)
    		$_SESSION['league'] = $league;
	}
	
	//driver
	$drivers_old = $db->getDrivers($user['ins_id'], 'AND (f1_pole > 0 OR f2_pole > 0 OR f3_pole > 0)','f1_pole desc, f2_pole desc, f3_pole desc');

	$drivers = array();
    foreach($drivers_old as $driver)
    {
    	$t = $db->getTeam($driver['tea_id']);
	    if(!isset($t))
	    	$t = $db->getTeam($driver['ai_tea_id']);
	    if($league != 0)
			if($t['league'] != $league)
				continue;
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
    $teams_old = $db->getTeams($user['ins_id'], 'f1_pole desc, f2_pole desc, f3_pole desc');
    
    $teams = array();
    $array_size = count($teams_old);
    for($i = 0; $i < $array_size; ++$i)
    {
    	if($league != 0)
			if($teams_old[$i]['league'] != $league)
				continue;
    	if($teams_old[$i]['f1_pole'] > 0 || 
    	   $teams_old[$i]['f2_pole'] > 0 || 
    	   $teams_old[$i]['f3_pole'] > 0)
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
    
    $smarty->assign('league', $league);
    $smarty->assign('drivers', $drivers);
    $smarty->assign('teams', $teams);
    $smarty->assign('team_id', $team['id']);
	$smarty->assign('content', 'statistic_polepositions.tpl');
