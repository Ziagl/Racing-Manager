<?php
	$tea_id = $_GET['id'];
	$teaminfo = $db->getTeam($tea_id);
	
	//drivers
	$teaminfo['driver'] = '';
	$drivers = $db->getDriversOfTeam($teaminfo['id']);
	if($drivers != null)
	{
		foreach($drivers as $d)
		{
			$teaminfo['driver'].= '<a href="?site=driverinfo&id='.$d['id'].'">'.$d['firstname'] . " " . $d['lastname'] . "</a>, ";
		}
		$teaminfo['driver'] = substr($teaminfo['driver'], 0, -2);
	}
	//ai drivers
	if($teaminfo['driver'] == '')
	{
		$drivers = $db->getAIDriversOfTeam($teaminfo['id']);
		if($drivers != null)
		{
			foreach($drivers as $d)
			{
				$teaminfo['driver'].= '<a href="?site=driverinfo&id='.$d['id'].'">'.$d['firstname'] . " " . $d['lastname'] . "</a>, ";
			}
			$teaminfo['driver'] = substr($teaminfo['driver'], 0, -2);
		}
	}
	//tires
	$teaminfo['tires'] = '';
	if($teaminfo['tir_id'] != null)
	{
		$teaminfoire = $db->getTire($teaminfo['tir_id']);
		$teaminfo['tires'] = $teaminfoire['name'];
	}
	//sponsor
	$teaminfo['sponsor'] = '';
	if($teaminfo['spo_id'] != null)
	{
		$teaminfoire = $db->getSponsor($teaminfo['spo_id']);
		$teaminfo['sponsor'] = $teaminfoire['name'];
	}
	
	$teaminfo['value'] = number_format_Tablerow($teaminfo['value']);
	
	$ownTeam = false;
	if($tea_id == $user['tea_id'])
		$ownTeam = true;
	
	//country
	$country = $db->getCountry($teaminfo['cou_id']);
	$teaminfo['country_picture'] = $country['picture'];
    $teaminfo['country_name'] = $country['name'];
    
    //season goal
    $teaminfo['goal'] = compute_season_goal($teaminfo['league'], $teaminfo['class']);
	
	//charts
	$team_history = $db->getTeamHistory($tea_id);
	$statistic_points = statistic_values_to_chart_string($team_history, 'points');
	$statistic_points_count = (substr_count($statistic_points,',')+1)/2;
	if($statistic_points_count > 5) $statistic_points_count = 5;
	$statistic_ranking = statistic_values_to_chart_string($team_history, 'ranking');
	$statistic_ranking_count = (substr_count($statistic_ranking,',')+1)/2;
	if($statistic_ranking_count > 5) $statistic_ranking_count = 5;
	$statistic_budget = statistic_values_to_chart_string($team_history, 'value');
	$statistic_budget_count = (substr_count($statistic_budget,',')+1)/2;
	if($statistic_budget_count > 5) $statistic_budget_count = 5;
	
	//user
	$_user = $db->getUserByTeam($tea_id);
	if($_user)
		$teaminfo['manager'] = $_user['name'];
	
	$smarty->assign('statistic_points', $statistic_points);
	$smarty->assign('statistic_points_count', $statistic_points_count);
	$smarty->assign('statistic_ranking', $statistic_ranking);
	$smarty->assign('statistic_ranking_count', $statistic_ranking_count);
	$smarty->assign('statistic_budget', $statistic_budget);
	$smarty->assign('statistic_budget_count', $statistic_budget_count);
	$smarty->assign('ownteam', $ownTeam);
	$smarty->assign('teaminfo', $teaminfo);
	$smarty->assign('content', 'teaminfo.tpl');
