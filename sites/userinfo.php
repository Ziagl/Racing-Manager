<?php
	$usr_id = $_GET['id'];
	$userinfo = $db->getUser($usr_id);
	$teaminfo = $db->getTeam($userinfo['tea_id']);
	
	//picture
	$userinfo['picture'] = "/driver/default.jpg";
	$file = './content/img/manager/'.$userinfo['id'].'.svg';
	if(file_exists($file))
	{
		$userinfo['picture'] = "/manager/".$userinfo['id'].'.svg';
	}
	
	//charts
	$user_history = $db->getUserHistory($usr_id);
	$statistic_points = statistic_values_to_chart_string($user_history, 'points');
	$statistic_points_count = (substr_count($statistic_points,',')+1)/2;
	if($statistic_points_count > 5) $statistic_points_count = 5;
	$statistic_ranking = statistic_values_to_chart_string($user_history, 'ranking');
	$statistic_ranking_count = (substr_count($statistic_ranking,',')+1)/2;
	if($statistic_ranking_count > 5) $statistic_ranking_count = 5;
	
	$smarty->assign('statistic_points', $statistic_points);
	$smarty->assign('statistic_points_count', $statistic_points_count);
	$smarty->assign('statistic_ranking', $statistic_ranking);
	$smarty->assign('statistic_ranking_count', $statistic_ranking_count);
	$smarty->assign('teaminfo', $teaminfo);
	$smarty->assign('userinfo', $userinfo);
	$smarty->assign('content', 'userinfo.tpl');
