<?php
    $teams_old = $db->getTeams($user['ins_id'], 'points desc');
    $league = $team['league'];
    
    $teams = array();
    foreach($teams_old as $t)
    {
    	//tires
    	$t['tires'] = '';
    	if($t['tir_id'] != null)
    	{
    		$tire = $db->getTire($t['tir_id']);
			$t['tires'] = $tire['name'];
	    }
	    //drivers
	    $t['driver'] = '';
	    $drivers = $db->getDriversOfTeam($t['id']);
	    if($drivers != null)
	    {
		    foreach($drivers as $d)
		    {
			    $t['driver'].= '<a href="?site=driverinfo&id='.$d['id'].'">'.$d['firstname'] . " " . $d['lastname'] . "</a>, ";
		    }
		    $t['driver'] = substr($t['driver'], 0, -2);
	    }
	    //ai drivers
	    if($t['driver'] == '')
	    {
		    $drivers = $db->getAIDriversOfTeam($t['id']);
		    if($drivers != null)
		    {
			    foreach($drivers as $d)
			    {
				    $t['driver'].= '<a href="?site=driverinfo&id='.$d['id'].'">'.$d['firstname'] . " " . $d['lastname'] . "</a>, ";
			    }
			    $t['driver'] = substr($t['driver'], 0, -2);
		    }
	    }
	    //sponsor
	    $t['sponsor'] = '';
	    if($t['spo_id'] != null)
    	{
    		$tire = $db->getSponsor($t['spo_id']);
			$t['sponsor'] = $tire['name'];
	    }
	    
	    $teams[] = $t;
    }
    
    $count_league = array(0, 0, 0);
    
    $array_size = count($teams);
    for($i = 0; $i < $array_size; ++$i)
    {
    	$_user = $db->getUserByTeam($teams[$i]['id']);
    	$teams[$i]['manager_human'] = false;
    	if($_user)
    	{
	    	$teams[$i]['manager'] = $_user['name'];
	    	$teams[$i]['manager_human'] = true;
	    	$teams[$i]['manager_userid'] = $_user['id'];
	    }
	    	
	    switch($teams[$i]['league'])
	    {
		    case 1: $count_league[0]++; break;
		    case 2: $count_league[1]++; break;
		    case 3: $count_league[2]++; break;
	    }
    }
    
    if(isset($_POST['league']))
    {
	    $league = $_POST['league'];
    }

    $smarty->assign('teams', $teams);
    $smarty->assign('teams_count', $count_league);
    $smarty->assign('team_id', $team['id']);
    $smarty->assign('league', $league);
    $smarty->assign('content', 'statistic_teaminfo.tpl');