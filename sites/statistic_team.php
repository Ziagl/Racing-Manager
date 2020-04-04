<?php
    $teams = $db->getTeams($user['ins_id'], 'points desc, placement asc');
    $league = $team['league'];
    
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
    
    //get last 2 dates
    $team_ranking_array = array();
    for($l = 1; $l < 4; ++$l)
    {
    	$teams_of_league = $db->getTeamsOfLeague($user['ins_id'], $l, "id ASC");
    	foreach($teams_of_league as $team_of_league)
    	{
    		$team_ranking = $db->getTeamHistoryForLeagueAndTeam($l, $team_of_league['id']);
			$rank = -1;
			$rank_last = -1;
			if(count($team_ranking) > 0)
			{
				$rank= $team_ranking[0]['ranking'];
				$rank_last = (count($team_ranking) > 1)?$team_ranking[1]['ranking']:$team_ranking[0]['ranking'];
			}
			
			$tea_id = $team_of_league['id'];
    		
    		if(array_key_exists($tea_id, $team_ranking_array))
				$team_ranking_array[$tea_id]['pos1'] = $rank;
			else
				$team_ranking_array[$tea_id] = array('pos1' => $rank);
				
			if(array_key_exists($tea_id, $team_ranking_array))
				$team_ranking_array[$tea_id]['pos2'] = $rank_last;
			else
				$team_ranking_array[$tea_id] = array('pos2' => $rank_last);
    	}
    }//for
    
    //for each date get positions of team and compute difference
    $array_size = count($teams);
	for($i = 0; $i < $array_size; ++$i)
	{
		$diff = 0;
		if(array_key_exists($teams[$i]['id'], $team_ranking_array))
		{
			$pos1 = 0;
			$pos2 = 0;
			if(array_key_exists('pos1',$team_ranking_array[$teams[$i]['id']]))
				$pos1 = $team_ranking_array[$teams[$i]['id']]['pos1'];
			if(array_key_exists('pos2',$team_ranking_array[$teams[$i]['id']]))
				$pos2 = $team_ranking_array[$teams[$i]['id']]['pos2'];
			$diff = $pos1 - $pos2;
		}
		$teams[$i]['change'] = "";
		if($diff < 0)
			$teams[$i]['change'] = "<span style='color: green'>&#9650; +".abs($diff)."</span>";//▲
		if($diff > 0)
			$teams[$i]['change'] = "<span style='color: red'>&#9660; -".abs($diff)."</span>";//▼
	}//foreach
    
    if(isset($_POST['league']))
    {
	    $league = $_POST['league'];
    }

    $smarty->assign('teams', $teams);
    $smarty->assign('teams_count', $count_league);
    $smarty->assign('team_id', $team['id']);
    $smarty->assign('league', $league);
    $smarty->assign('content', 'statistic_team.tpl');