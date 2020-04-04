<?php
	$dri_id = $_GET['id'];
	
	$driver = $db->getDriver($dri_id);
	
	//country
	$country = $db->getCountry($driver['cou_id']);
	$driver['country_picture'] = $country['picture'];
    $driver['country_name'] = $country['name'];
    
    //age
    $driver['age'] = date('Y') - date('Y', strtotime($driver['birthday']));
    $driver['birthday_formated'] = date('d.m.Y', strtotime($driver['birthday']));
    
    $tea_id = $driver['tea_id'];
    if($tea_id == null)
    	$tea_id = $driver['ai_tea_id'];
    $teaminfo = $db->getTeam($tea_id);
    	
    //charts
	$driver_history = $db->getDriverHistory($dri_id, 'date ASC');
	$statistic_points = statistic_values_to_chart_string($driver_history, 'points');
	$statistic_points_count = (substr_count($statistic_points,',')+1)/2;
	if($statistic_points_count > 5) $statistic_points_count = 5;
	$statistic_ranking = statistic_values_to_chart_string($driver_history, 'ranking');
	$statistic_ranking_count = (substr_count($statistic_ranking,',')+1)/2;
	if($statistic_ranking_count > 5) $statistic_ranking_count = 5;
	$statistic_speed = statistic_values_to_chart_string($driver_history, 'speed');
	$statistic_persistence = statistic_values_to_chart_string($driver_history, 'persistence');
	$statistic_experience = statistic_values_to_chart_string($driver_history, 'experience');
	$statistic_stamina = statistic_values_to_chart_string($driver_history, 'stamina');
	$statistic_freshness = statistic_values_to_chart_string($driver_history, 'freshness');
	$statistic_morale = statistic_values_to_chart_string($driver_history, 'morale');

	$smarty->assign('statistic_points', $statistic_points);
	$smarty->assign('statistic_points_count', $statistic_points_count);
	$smarty->assign('statistic_ranking', $statistic_ranking);
	$smarty->assign('statistic_ranking_count', $statistic_ranking_count);
	$smarty->assign('statistic_speed', $statistic_speed);
	$smarty->assign('statistic_persistence', $statistic_persistence);
	$smarty->assign('statistic_experience', $statistic_experience);
	$smarty->assign('statistic_stamina', $statistic_stamina);
	$smarty->assign('statistic_freshness', $statistic_freshness);
	$smarty->assign('statistic_morale', $statistic_morale);
    $smarty->assign('teaminfo', $teaminfo);
	$smarty->assign('driver', $driver);
	$smarty->assign('content', 'driverinfo.tpl');
