<?php
    $default = array('ranking' => '-', 'points' => 0);
    
    //display random event?
    $last_login = $user['last_login'];
    $now = date('d', time());
    $last = date('d', strtotime($last_login));
    $randomevent_message = null;
    if($now != $last && array_key_exists('randomevent', $_SESSION) != true)	//one day in seconds
    {
    	if(rand(0,1) != 0)
    	{
    		$drivers = $db->getDriversOfTeam($team['id']);
			$max_drivers = count($drivers);
    		$max = 22;
    		if($max_drivers > 0)
    			$max = 32;
    		$type = rand(0, $max);
    		if($type >= 0 && $type <= 22)
    		{
    			$randomevent_message = Translator::_translate('eventmessage0-'.$type);
    		}
    		if($type > 22 && $type <= 32)
    		{
    			$randomevent_message = Translator::_translate('eventmessage0-'.$type); 
    			$driver = $drivers[rand(0, $max_drivers - 1)];
				$randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
    		}
    	}
    	else
    	{
			$driver_values = array(Translator::_translate('tr_driver_setting_speed'), Translator::_translate('tr_driver_setting_persistence'), Translator::_translate('tr_driver_setting_experience'), Translator::_translate('tr_driver_setting_stamina'));
			$driver_values_index = array('speed', 'persistence', 'experience', 'stamina');
			$max_driver_values = count($driver_values);
			$mechanic_values = array(Translator::_translate('tr_mechanic_setting_repair'), Translator::_translate('tr_mechanic_setting_setup'), Translator::_translate('tr_mechanic_setting_tires'), Translator::_translate('tr_mechanic_setting_pitstop')/*, Translator::_translate('tr_mechanic_setting_development')*/);
			$mechanic_values_index = array('repair', 'setup', 'tires', 'pit_stop'/*, 'development'*/);
			$max_mechanic_values = count($mechanic_values);
			$drivers = $db->getDriversOfTeam($team['id']);
			$max_drivers = count($drivers);
			$mechanics = $db->getMechanicsOfTeam($team['id']);
			$max_mechanics = count($mechanics);
			$max = 14;
			if($max_drivers > 0)
				$max = 27;
			if($max_mechanics > 0)
			$max = 31;
			$type = rand(0, $max);
			switch($type)
			{
				case 0: $randomevent_message = Translator::_translate('eventmessage1');
						$value = rand(0, 30000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message); 
						break;
				case 1: $randomevent_message = Translator::_translate('eventmessage2');
						$value = rand(10000, 25000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 2: $randomevent_message = Translator::_translate('eventmessage3');
						$value = rand(1000, 50000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 3: $randomevent_message = Translator::_translate('eventmessage4');
						$value = rand(0, 1000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 4: $randomevent_message = Translator::_translate('eventmessage5');
						$value = rand(1000, 100000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 5: $randomevent_message = Translator::_translate('eventmessage6');
						$value = rand(0, 10000);
						while($value % 5 != 0)
						{
							$value++;
						}
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 6: $randomevent_message = Translator::_translate('eventmessage7');
						$value = rand(1000, 10000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 7: $randomevent_message = Translator::_translate('eventmessage8');
						$value = rand(100, 50000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 8: $randomevent_message = Translator::_translate('eventmessage9');
						$value = rand(10000, 25000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$tir_id = $team['tir_id'];
						$tire = $db->getTire($tir_id);
						if($tire)
							$randomevent_message = str_replace("#Y#", $tire['name'], $randomevent_message);
						else
							$randomevent_message = str_replace("#Y#", '', $randomevent_message);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 9: $randomevent_message = Translator::_translate('eventmessage10');
						$value = rand(100, 50000);
						$db->changeTeamValue($team['id'], $value);	//add money to team
						$db->randomeventIn($team['id'], $value);
						$randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						break;
				case 10: $randomevent_message = Translator::_translate('eventmessage11');
						 $value = rand(10000, 500000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 break;
				case 11: $randomevent_message = Translator::_translate('eventmessage12');
						 $value = rand(1000, 10000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 break;
				case 12: $randomevent_message = Translator::_translate('eventmessage13');
						 $value = rand(1, 5000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 break;
				case 13: $randomevent_message = Translator::_translate('eventmessage14');
						 $value = rand(1, 10000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 break;
				case 14: $randomevent_message = Translator::_translate('eventmessage15');
						 $value = rand(500, 1000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 break;
				//driver
				case 15: $randomevent_message = Translator::_translate('eventmessage16');
						 $value = rand(1000, 5000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 break;
				case 16: $randomevent_message = Translator::_translate('eventmessage17');
						 $value = rand(1000, 10000);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 break;
				case 17: $randomevent_message = Translator::_translate('eventmessage18');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $value = rand(0, $max_driver_values);
						 $randomevent_message = str_replace("#X#", $driver_values[$value], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver[$driver_values_index[$value]] = $driver[$driver_values_index[$value]] + $points;
						 if($driver[$driver_values_index[$value]] > 100) $driver[$driver_values_index[$value]] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 18: $randomevent_message = Translator::_translate('eventmessage19');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $value = rand(0, $max_driver_values);
						 $randomevent_message = str_replace("#X#", $driver_values[$value], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver[$driver_values_index[$value]] = $driver[$driver_values_index[$value]] + $points;
						 if($driver[$driver_values_index[$value]] > 100) $driver[$driver_values_index[$value]] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 19: $randomevent_message = Translator::_translate('eventmessage20');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['morale'] = $driver['morale'] + $points;
						 if($driver['morale'] > 100) $driver['morale'] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 20: $randomevent_message = Translator::_translate('eventmessage21');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['morale'] = $driver['morale'] + $points;
						 if($driver['morale'] > 100) $driver['morale'] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 21: $randomevent_message = Translator::_translate('eventmessage22');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['freshness'] = $driver['freshness'] + $points;
						 if($driver['freshness'] > 100) $driver['freshness'] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 22: $randomevent_message = Translator::_translate('eventmessage23');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['freshness'] = $driver['freshness'] + $points;
						 if($driver['freshness'] > 100) $driver['freshness'] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 23: $randomevent_message = Translator::_translate('eventmessage24');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 4);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['speed'] = $driver['speed'] + $points;
						 if($driver['speed'] > 100) $driver['speed'] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 24: $randomevent_message = Translator::_translate('eventmessage25');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['experience'] = $driver['experience'] + $points;
						 if($driver['experience'] > 100) $driver['experience'] = 100;
						 $db->updateDriverSkills($driver);
						 break;
				case 25: $randomevent_message = Translator::_translate('eventmessage26');
						 $points = rand(2, 3);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 foreach($drivers as $driver)
						 {
							 $driver['morale'] = $driver['morale'] + $points;
							 if($driver['morale'] > 100) $driver['morale'] = 100;
							 $db->updateDriverSkills($driver);
						 }
						 break;
				case 26: $randomevent_message = Translator::_translate('eventmessage27');
						 $driver = $drivers[rand(0, $max_drivers - 1)];
						 $randomevent_message = str_replace("#Y#", $driver['firstname']." ".$driver['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $driver['morale'] = $driver['morale'] + $points;
						 if($driver['morale'] > 100) $driver['morale'] = 100;
						 $db->updateDriverSkills($driver);
						 $value = rand(10000, 25000);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 $db->changeTeamValue($team['id'], -$value);	//add money to team
						 $db->randomeventOut($team['id'], $value);
						 break;
				case 27: $randomevent_message = Translator::_translate('eventmessage28');
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 foreach($drivers as $driver)
						 {
							 $driver['morale'] = $driver['morale'] - $points;
							 if($driver['morale'] < 0) $driver['morale'] = 0;
							 $db->updateDriverSkills($driver);
						 }
						 $value = rand(1000, 10000);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 $db->changeTeamValue($team['id'], $value);	//add money to team
						 $db->randomeventIn($team['id'], $value);
						 break;
				//mechanics
				case 28: $randomevent_message = Translator::_translate('eventmessage29');
						 $points = rand(2, 5);
					 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 foreach($meachanics as $mechanic)
						 {
							 $mechanic['morale'] = $mechanic['morale'] + $points;
							 if($mechanic['morale'] > 100) $mechanic['morale'] = 100;
							 $db->updateMechanicSkills($mechanic);
						 }
						 break;
				case 29: $randomevent_message = Translator::_translate('eventmessage30');
						 $mechanic = $mechanics[rand(0, $max_mechanics - 1)];
						 $randomevent_message = str_replace("#Y#", $mechanic['firstname']." ".$mechanic['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $value = rand(0, $max_mechanic_values);
						 $randomevent_message = str_replace("#X#", $mechanic_values[$value], $randomevent_message);
						 $mechanic[$mechanic_values_index[$value]] = $mechanic[$mechanic_values_index[$value]] + $points;
						 if($mechanic[$mechanic_values_index[$value]] > 100) $mechanic[$mechanic_values_index[$value]] = 100;
						 $db->updateMechanicSkills($mechanic);
						 break;
				case 30: $randomevent_message = Translator::_translate('eventmessage31');
						 $mechanic = $mechanics[rand(0, $max_mechanics - 1)];
						 $randomevent_message = str_replace("#Y#", $mechanic['firstname']." ".$mechanic['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $value = rand(0, $max_mechanic_values);
						 $randomevent_message = str_replace("#X#", $mechanic_values[$value], $randomevent_message);
						 $mechanic[$mechanic_values_index[$value]] = $mechanic[$mechanic_values_index[$value]] + $points;
						 if($mechanic[$mechanic_values_index[$value]] > 100) $mechanic[$mechanic_values_index[$value]] = 100;
						 $db->updateMechanicSkills($mechanic);
						 break;
				case 31: $randomevent_message = Translator::_translate('eventmessage32');
						 $mechanic = $mechanics[rand(0, $max_mechanics - 1)];
						 $randomevent_message = str_replace("#Y#", $mechanic['firstname']." ".$mechanic['lastname'], $randomevent_message);
						 $points = rand(2, 5);
						 $randomevent_message = str_replace("#Z#", $points, $randomevent_message);
						 $value = rand(1000, 50000);
						 $randomevent_message = str_replace("#X#", number_format($value, 0, ',', '.'), $randomevent_message);
						 $mechanic['morale'] = $mechanic['morale'] + $points;
						 if($mechanic['morale'] > 100) $mechanic['morale'] = 100;
						 $db->changeTeamValue($team['id'], -$value);	//add money to team
						 $db->randomeventOut($team['id'], $value);
						 break;
			}
    	}
    	$_SESSION['randomevent'] = 1;
    }
    
    //get team ranking and points
    $league = $team['league'];
	$team_ranking = $db->getTeamHistoryForLeagueAndTeam($league, $user['tea_id']);
	$team['rank']= $default;
	$team['rank_last'] = $default;
	if(count($team_ranking) > 0)
	{
		$team['rank']= $team_ranking[0];
		$team['rank_last'] = (count($team_ranking) > 1)?$team_ranking[1]:$team_ranking[0];
	}
	$team['goal'] = compute_season_goal($team['league'], $team['class']);
	
	//get driver ranking and points
	$drivers = $db->getDriversOfTeam($user['tea_id'], 'points DESC');
	$driver_ranking = array();
	foreach($drivers as $driver)
	{
		$history = $db->getDriverHistoryForDriver($driver['id']);
		$driver['rank'] = $default;
		$driver['rank_last'] = $default;
		if(count($history) > 0)
		{
			$driver['rank'] = $history[0];
			$driver['rank_last'] = (count($history) > 1)?$history[1]:$history[0];
		}
		$driver_ranking[] = $driver;
	}
	
	//get manager ranking and points
	$history = $db->getUserHistoryForUser($user['id']);
	$user['rank'] = $default;
	$user['rank_last'] = $default;
	if(count($history) > 0)
	{
		$user['rank'] = $history[0];
		$user['rank_last'] = (count($history) > 1)?$history[1]:$history[0];
	}
	$user['picture'] = null;
	$file = './content/img/manager/'.$user['id'].'.svg';
	if(file_exists($file))
	{
		$user['picture'] = "/manager/".$user['id'].'.svg';
	}
	
	//timer
	$instance = $db->getInstance($user['ins_id']);
	$current_race = $instance['current_race'];
	$current_day = $instance['current_day'];
	$races = $db->getTrackCalendar($instance['id']);
	$track = $db->getTrack($instance['id']);
	$calendar = $races[$current_race-1];
	
	$date_qualification = strtotime($calendar['qualification_date']);
	$date_race = strtotime($calendar['race_date']);
	$date_training_next = -1;
	$next_track = -1;
	$array_size = count($races);
	if($current_race < $array_size)
	{
		$calendar_next = $races[$current_race];
		$date_training_next = strtotime($calendar_next['training_date']);
		$next_track = $db->getTrackById($calendar_next['tra_id']);
	}
	$time = time();
	
	$smarty->assign('randomevent_message', $randomevent_message);
	$smarty->assign('params',$params);
	$smarty->assign('date_training_next',$date_training_next - $time);
	$smarty->assign('date_race',$date_race - $time);
	$smarty->assign('date_qualification',$date_qualification - $time);
	$smarty->assign('track',$track);
	$smarty->assign('next_track',$next_track);
	$smarty->assign('user', $user);
	$smarty->assign('driver_ranking', $driver_ranking);
	$smarty->assign('team', $team);
    $smarty->assign('content', 'dashboard.tpl');
