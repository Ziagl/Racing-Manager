<?php
    $show_result = false;       //show only result --> no settings possible (if qualification is computed)

    //no computed qualification available!
    if(count($db->isQualificationOrRace($user['ins_id'], 1)) != 0)
        $show_result = true;

    include('config/global_race.php');

    //drive some rounds
    if(isset($_POST['car']))
    {
        $car_number = $_POST['car'];
        if($car_number == 1)
        {
            $driver = $driver1;
            $car = $car1;
            $max = $params['training_max_rounds'] - count($db->getSetupOfTypeAndCarAll($user['ins_id'], $user['tea_id'], $driver1['id'], 0, "id ASC"));
        }
        if($car_number == 2)
        {
            $driver = $driver2;
            $car = $car2;
            $max = $params['training_max_rounds'] - count($db->getSetupOfTypeAndCarAll($user['ins_id'], $user['tea_id'], $driver2['id'], 0, "id ASC"));
        }
        if($car_number == 3)
        {
        	$driver = $driver3;
            $car = $car3;
            $max = $params['training_max_rounds'] - count($db->getSetupOfTypeAndCarAll($user['ins_id'], $user['tea_id'], $driver3['id'], 0, "id ASC"));
        }
        $_team = $db->getTeam($user['tea_id']);
        $mechanic = array('setup' => $setup, 'tires' => $tires);
        $rounds = min($_POST['rounds_value'], $max);
        $tire_id = $_POST['tire_id'];
        $settings = array(
            'front_wing' => intval(trim($_POST['front_wing_value'])),
            'rear_wing' => intval(trim($_POST['rear_wing_value'])),
            'front_suspension' => intval(trim($_POST['front_suspension_value'])),
            'rear_suspension' => intval(trim($_POST['rear_suspension_value'])),
            'tire_pressure' => intval(trim($_POST['tire_pressure_value'])),
            'brake_balance' => intval(trim($_POST['brake_balance_value'])),
            'gear_ratio' => intval(trim($_POST['gear_ratio_value']))
        );
        $_SESSION['settings'] = $settings;
        if($car_number == 1)
        {
        	$_SESSION['setting_tire_id_1'] = $tire_id;
        }
        if($car_number == 2)
        {
        	$_SESSION['setting_tire_id_2'] = $tire_id;
        }
        if($car_number == 3)
        {
        	$_SESSION['setting_tire_id_3'] = $tire_id;
        }
        $_SESSION['rounds'] = $rounds;
        $_SESSION['last_car'] = $car_number;
        $track = $db->getTrack($user['ins_id']);

        //tires
        $tire = $db->getRaceTire($tire_id);
        $tire_type = $tire['tire_type'];
        
        //driver need to drive some round to make a comment
        //chance 1:5 for each round
        $rnd = 0;
        for($i=0; $i < $rounds; ++$i)
        	$rnd+= rand(1, 5);
        $comment_type = 0;
        $comment_value = 0;
        if($rnd > 10)
        {
        	//find worst setting
        	$comment_value = abs($settings['front_wing'] - $user['front_wing']);
        	$comment_type = 1;
        	if(abs($settings['rear_wing'] - $user['rear_wing']) > $comment_value)
        	{
        		$comment_value = abs($settings['rear_wing'] - $user['rear_wing']);
        		$comment_type = 2;
        	}
        	if(abs($settings['front_suspension'] - $user['front_suspension']) > $comment_value)
        	{
        		$comment_value = abs($settings['front_suspension'] - $user['front_suspension']);
        		$comment_type = 3;
        	}
        	if(abs($settings['rear_suspension'] - $user['rear_suspension']) > $comment_value)
        	{
        		$comment_value = abs($settings['rear_suspension'] - $user['rear_suspension']);
        		$comment_type = 4;
        	}
        	if(abs($settings['tire_pressure'] - $user['tire_pressure']) > $comment_value)
        	{
        		$comment_value = abs($settings['tire_pressure'] - $user['tire_pressure']);
        		$comment_type = 5;
        	}
        	if(abs($settings['brake_balance'] - $user['brake_balance']) > $comment_value)
        	{
        		$comment_value = abs($settings['brake_balance'] - $user['brake_balance']);
        		$comment_type = 6;
        	}
        	if(abs($settings['gear_ratio'] - $user['gear_ratio']) > $comment_value)
        	{
        		$comment_value = abs($settings['gear_ratio'] - $user['gear_ratio']);
        		$comment_type = 7;
        	}
        }
        
        //compute lap times
        $round_data = array();
        for( $i = 0; $i < $rounds; ++$i )
        {
            $round_data[] = compute_training($user, $settings, $driver, $car, $tire, $mechanic, $track, $i+1, $params, $i);
        }//for
        //save new distance for tire (and active flag)
        $db->setRaceTireDistance($tire['id'], $tire['distance']);
        
        //store to db
        $db->insertTrainingSetup($car_number, $user['tea_id'], $team['driver'.$car_number], $user['ins_id'], $_team['league'], $settings, $tire_type, $round_data, 0, $comment_type, $comment_value);

        unset($_POST['car']);
        header('Location: ?site=race_training');
    }//if
    
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
	
	$tire_type = 2;
	if(isset($_POST['tire_type']))
	{
		$tire_type = $_POST['tire_type'];
	}

    //get rounds and display
    if($tire_type > 1 || $league == 4)
    {
    	$laps_all_old = $db->getSetupOfType($user['ins_id'],null,0);	//hard and soft
    }
    else
    {
    	$laps_all_old = $db->getSetupOfTypeTrainingTires($user['ins_id'],0,$tire_type);//hard or soft
    }
    
	$laps_to_go_driver1 = $params['training_max_rounds'];
	$laps_to_go_driver2 = $params['training_max_rounds'];
	$laps_to_go_driver3 = $params['training_max_rounds'];
    $laps_all = array();
    $best_fastest_lap = -1;
    foreach($laps_all_old as $lap)
    {
        $_team = $db->getTeam($lap['tea_id']);
        $_user = $db->getUserByTeam($lap['tea_id']);
        if($_user)
        	$lap['manager_name'] = $_user['name'];
        else
        	$lap['manager_name'] = $_team['manager'];
        
        //only teams of the same league
        if($_team['league'] == $league)
        {
			if($best_fastest_lap == -1)
				$best_fastest_lap = $lap['round_time'];
			
			$lap['team_name'] = $_team['name'];
			$lap['color'] = $_team['color1'];
			$lap['team_id'] = $_team['id'];
			$driver = $db->getDriver($lap['dri_id']);
			$lap['driver_firstname'] = $driver['firstname'];
			$lap['driver_lastname'] = $driver['lastname'];
			$lap['driver_shortname'] = $driver['shortname'];
			if($team['id'] == $_team['id'])
			{
				if($lap['dri_id'] == $_team['driver1'])
					$laps_to_go_driver1 = $params['training_max_rounds'] - $lap['rounds'];
				if($lap['dri_id'] == $_team['driver2'])
					$laps_to_go_driver2 = $params['training_max_rounds'] - $lap['rounds'];
				if($lap['dri_id'] == $_team['driver3'])
					$laps_to_go_driver3 = $params['training_max_rounds'] - $lap['rounds'];
			}
			if($best_fastest_lap == $lap['round_time'])
				$lap['diff'] = '';
			else
				$lap['diff'] = "+ ".time_to_string($lap['round_time'] - $best_fastest_lap);
			$laps_all[] = $lap;
        }
        else
        {
			//youth league
			if($league == 4)
			{
				if($_team['driver3'] == $lap['dri_id'])
				{
					if($best_fastest_lap == -1)
						$best_fastest_lap = $lap['round_time'];
					
					$lap['team_name'] = $_team['name'];
					$lap['color'] = $_team['color1'];
					$lap['team_id'] = $_team['id'];
					$driver = $db->getDriver($lap['dri_id']);
					$lap['driver_firstname'] = $driver['firstname'];
					$lap['driver_lastname'] = $driver['lastname'];
					$lap['driver_shortname'] = $driver['shortname'];
					if($team['id'] == $_team['id'])
					{
						if($lap['dri_id'] == $_team['driver1'])
							$laps_to_go_driver1 = $params['training_max_rounds'] - $lap['rounds'];
						if($lap['dri_id'] == $_team['driver2'])
							$laps_to_go_driver2 = $params['training_max_rounds'] - $lap['rounds'];
						if($lap['dri_id'] == $_team['driver3'])
							$laps_to_go_driver3 = $params['training_max_rounds'] - $lap['rounds'];
					}
					if($best_fastest_lap == $lap['round_time'])
						$lap['diff'] = '';
					else
						$lap['diff'] = "+ ".time_to_string($lap['round_time'] - $best_fastest_lap);
					$laps_all[] = $lap;
				}
			}
        }
    }//foreach
    //get last lap and get best lap
    $car1_last_lap = $db->getSetupOfTypeAndCar($user['ins_id'], $user['tea_id'], $driver1['id'], 0);
    $car1_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver1['id'], 0, 1, 'round_time ASC');
    $car1_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver1['id'], 0, 0, 'round_time ASC');
    $car1_laps = $db->getSetupOfTypeAndCarAll($user['ins_id'], $user['tea_id'], $driver1['id'], 0, "id DESC");
    $car2_last_lap = $db->getSetupOfTypeAndCar($user['ins_id'], $user['tea_id'], $driver2['id'], 0);
    $car2_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver2['id'], 0, 1, 'round_time ASC');
    $car2_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver2['id'], 0, 0, 'round_time ASC');
    $car2_laps = $db->getSetupOfTypeAndCarAll($user['ins_id'], $user['tea_id'], $driver2['id'], 0, "id DESC");
    $car3_last_lap = $db->getSetupOfTypeAndCar($user['ins_id'], $user['tea_id'], $driver3['id'], 0);
    $car3_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver3['id'], 0, 1, 'round_time ASC');
    $car3_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver3['id'], 0, 0, 'round_time ASC');
    $car3_laps = $db->getSetupOfTypeAndCarAll($user['ins_id'], $user['tea_id'], $driver3['id'], 0, "id DESC");
    
    //get driver comments
    //driver 1
    $last_type = -1;
    $last_value = -1;
    $car1_comments = array();
    if($car1_laps)
    {
    	$i = count($car1_laps);
		foreach($car1_laps as $lap)
		{
			if($last_type != $lap['comment_type'] && 
			   $last_value != $lap['comment_value'] &&
			   $lap['comment_type'] != 0)
			{
				$car1_comments[] = Translator::_translate('Lap')." ".$i.": ".generate_driver_comment($lap);
			}
			$last_type = $lap['comment_type'];
			$last_value = $lap['comment_value'];
			$i--;
		}
    }
    
    //driver 2
    $last_type = -1;
    $last_value = -1;
    $car2_comments = array();
    if($car2_laps)
    {
    	$i = count($car2_laps);
		foreach($car2_laps as $lap)
		{
			if($last_type != $lap['comment_type'] && 
			   $last_value != $lap['comment_value'] &&
			   $lap['comment_type'] != 0)
			{
				$car2_comments[] = Translator::_translate('Lap')." ".$i.": ".generate_driver_comment($lap);
			}
			$last_type = $lap['comment_type'];
			$last_value = $lap['comment_value'];
			$i--;
		}
    }
    
    //driver 3
    $last_type = -1;
    $last_value = -1;
    $car3_comments = array();
    if($car3_laps)
    {
    	$i = count($car3_laps);
		foreach($car3_laps as $lap)
		{
			if($last_type != $lap['comment_type'] && 
			   $last_value != $lap['comment_value'] &&
			   $lap['comment_type'] != 0)
			{
				$car3_comments[] = Translator::_translate('Lap')." ".$i.": ".generate_driver_comment($lap);
			}
			$last_type = $lap['comment_type'];
			$last_value = $lap['comment_value'];
			$i--;
		}
    }
    

    $smarty->assign('car1_comments', $car1_comments);
    $smarty->assign('car2_comments', $car2_comments);
    $smarty->assign('car3_comments', $car3_comments);
    $smarty->assign('tire_type', $tire_type);
	$smarty->assign('league', /*$_SESSION['league']*/$league);
    $smarty->assign('show_result', $show_result);
    $smarty->assign('laps_all', $laps_all);
    $smarty->assign('car1_last_lap', $car1_last_lap);
    $smarty->assign('car1_best_lap_soft', $car1_best_lap_soft);
    $smarty->assign('car1_best_lap_hard', $car1_best_lap_hard);
    $smarty->assign('car2_last_lap', $car2_last_lap);
    $smarty->assign('car2_best_lap_soft', $car2_best_lap_soft);
    $smarty->assign('car2_best_lap_hard', $car2_best_lap_hard);
    $smarty->assign('car3_last_lap', $car3_last_lap);
    $smarty->assign('car3_best_lap_soft', $car3_best_lap_soft);
    $smarty->assign('car3_best_lap_hard', $car3_best_lap_hard);
    $smarty->assign('car1_laps', $car1_laps);
    $smarty->assign('car2_laps', $car2_laps);
    $smarty->assign('car3_laps', $car3_laps);
    $smarty->assign('max_rounds', $params['training_max_rounds']);
    $smarty->assign('laps_to_go_driver1', $laps_to_go_driver1);
    $smarty->assign('laps_to_go_driver2', $laps_to_go_driver2);
    $smarty->assign('laps_to_go_driver3', $laps_to_go_driver3);
    $smarty->assign('settings', isset($_SESSION['settings'])?$_SESSION['settings']:null);
    $smarty->assign('setting_tire_type',isset($_SESSION['setting_tire_type'])?$_SESSION['setting_tire_type']:0);
    if(count($car1_tires) > 0)
    	$smarty->assign('setting_tire_id_1',isset($_SESSION['setting_tire_id_1'])?$_SESSION['setting_tire_id_1']:$car1_tires[0]['id']);
    if(count($car2_tires) > 0)
    	$smarty->assign('setting_tire_id_2',isset($_SESSION['setting_tire_id_2'])?$_SESSION['setting_tire_id_2']:$car2_tires[0]['id']);
    if(count($car3_tires) > 0)
    	$smarty->assign('setting_tire_id_3',isset($_SESSION['setting_tire_id_3'])?$_SESSION['setting_tire_id_3']:$car3_tires[0]['id']);
    $smarty->assign('rounds', isset($_SESSION['rounds'])?$_SESSION['rounds']:null);
    $smarty->assign('last_car', isset($_SESSION['last_car'])?$_SESSION['last_car']:1);
    
	if($tire_error != null)
	{
		$error = $tire_error;
	}
    if($car1_error != null && $car2_error != null)
    {
        $error = Translator::_translate('tr_race_no_items_car_training');
    }//if
    if($driver1 == null && $driver2 == null)
    {
        $error = Translator::_translate('tr_race_no_driver_car_training');
    }//if

    $smarty->assign('error', $error);
    $smarty->assign('team_id', $team['id']);
    $smarty->assign('team_league', $team['league']);
    $smarty->assign('car1_error', $car1_error);
    $smarty->assign('car2_error', $car2_error);
    $smarty->assign('car3_error', $car3_error);
    $smarty->assign('content', 'race_training.tpl');