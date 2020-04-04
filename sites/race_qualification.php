<?php
    $qualification_laps = $db->isQualificationOrRace($user['ins_id'], 1);
    $params = $db->getParams($user['ins_id']);			//###performance issue should only be done once per login!

    //no computed qualification available!
    if(count($qualification_laps) == 0)
    {
        include('config/global_race.php');

        //drive some rounds
        if(isset($_POST['car']))
        {
            //type: 0...Q1, 1...Q2, 2...Q3
            $type = $_POST['type'];
            $car_number = $_POST['car'];
            if($car_number == 1)
            {
                $driver = $driver1;
                $car = $car1;
            }else{
                $driver = $driver2;
                $car = $car2;
            }
            //$tire_type = $_POST['optionsRadios'];
            $tire_id = $_POST['tire_id'];
            $rounds = $_POST['rounds_value'];
            if($rounds < 3)
            	$rounds = 3;
            if($car_number == 1)
			{
				$_SESSION['setting_tire_id_1'] = $tire_id;
			}
			else
			{
				$_SESSION['setting_tire_id_2'] = $tire_id;
			}
            $tire = $db->getRaceTire($tire_id);
            $tire_type = $tire['tire_type'];
            $_SESSION['setting_tire_type'] = $tire_id;//$tire_type;
            
            //for q3 check if there is already a race start setting --> use same tire
            if($params['qualification_race_tires'] == 1 && $type == 2) //insert param for this#####
            {
            	$s = $db->getSetupSetting($car_number, $user['tea_id'], $user['ins_id'], $type, 0);
	        	//if there is already a setting for race
	        	if($s != null)
	        	{
		        	/*
		        	$settings = array(
		                'front_wing' => intval(trim($s['front_wing'])),
		                'rear_wing' => intval(trim($s['rear_wing'])),
		                'front_suspension' => intval(trim($s['front_suspension'])),
		                'rear_suspension' => intval(trim($s['rear_suspension'])),
		                'tire_pressure' => intval(trim($s['tire_pressure'])),
		                'brake_balance' => intval(trim($s['brake_balance'])),
		                'gear_ratio' => intval(trim($s['gear_ratio']))
		            );
		        	$db->insertSetupSetting($car_number, $user['tea_id'], $team['league'], $user['ins_id'], $settings, $tire_type, $tire_id, $s['rounds'], $s['type'], $s['subtype']);
		        	*/
		        	$tire = $db->getRaceTire($s['tire_number']);
					$tire_type = $tire['tire_type'];
					$_SESSION['setting_tire_type'] = $tire_id;//$tire_type;
		        }
		    }

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
			$_SESSION['rounds'] = $rounds;
			$_SESSION['last_car'] = $car_number;

			//store to db
			$db->insertSetupSetting($car_number, $team['id'], $team['league'], $user['ins_id'], $settings, $tire_type, $tire_id, $rounds, 1, $type);

            //log
            //$message = "Setting for car ".$car_number." type: ".$type." round: ".$rounds." tire: ".$tire_id." settings: ".$settings['front_wing'].", ".$settings['rear_wing'].", ".$settings['front_suspension'].", ".$settings['rear_suspension'].", ".$settings['tire_pressure'].", ".$settings['brake_balance'].", ".$settings['gear_ratio'];
		    //$db->log($user['id'], 1, $message);
            
            unset($_POST['car']);
            header('Location: ?site=race_qualification');
        }

		if($tire_error != null)
		{
			$error = $tire_error;
		}
		if($car1_error != null && $car2_error != null)
	    {
	        $error =  Translator::_translate('tr_race_no_items_car_training');
	    }
	    if($driver1 == null && $driver2 == null)
	    {
	        $error = Translator::_translate('tr_race_no_driver_car_qualification');
	    }
	    
	    //depend on param - check for different tire types
	    if($params['qualification_diff_tires'] == 1)
	    {
	    	$tire_error1 = null;
	    	$tire_error2 = null;
	    	$tire_error_message = Translator::_translate('tr_race_qualification_tire_error');
	    	
	    	//car 1
		    $hard = 0;
		    $soft = 0;
		    
		    $setups = $db->getSetupSettingAll(1, $user['tea_id'], $user['ins_id'], 1);
		    
		    if(isset($setups))
			    foreach($setups as $setup)
			    {
				    if($setup['tire_type'] == 0)
				    	$hard++;
				    if($setup['tire_type'] == 1)
				    	$soft++;
			    }
		    if($hard == 0 || $soft == 0)
		    	$tire_error1 = $tire_error_message;
		    	
		    //car 2
		    $hard = 0;
		    $soft = 0;
		    
		    $setups = $db->getSetupSettingAll(2, $user['tea_id'], $user['ins_id'], 1);
		    if(isset($setups))
			    foreach($setups as $setup)
			    {
				    if($setup['tire_type'] == 0)
				    	$hard++;
				    if($setup['tire_type'] == 1)
				    	$soft++;
			    }
		    if($hard == 0 || $soft == 0)
		    	$tire_error2 = $tire_error_message;
		    	
		    $smarty->assign('tire_error1', $tire_error1);
		    $smarty->assign('tire_error2', $tire_error2);
	    }
	
	    $smarty->assign('error', $error);
	    $smarty->assign('car1_error', $car1_error);
	    $smarty->assign('car2_error', $car2_error);
	    
	    //training
		$car1_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver1['id'], 0, 1, 'round_time ASC');
		$car1_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver1['id'], 0, 0, 'round_time ASC');
		$car2_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver2['id'], 0, 1, 'round_time ASC');
		$car2_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver2['id'], 0, 0, 'round_time ASC');
		$smarty->assign('car1_best_lap_soft', $car1_best_lap_soft);
		$smarty->assign('car1_best_lap_hard', $car1_best_lap_hard);
		$smarty->assign('car2_best_lap_soft', $car2_best_lap_soft);
		$smarty->assign('car2_best_lap_hard', $car2_best_lap_hard);

        //get qualification settings from db
        $q1_1 = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 0);
        $q2_1 = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 1);
        $q3_1 = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 2);
        $q1_2 = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 0);
        $q2_2 = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 1);
        $q3_2 = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 2);

        $smarty->assign('show_result', false);
        $smarty->assign('q1_1', $q1_1);
        $smarty->assign('q2_1', $q2_1);
        $smarty->assign('q3_1', $q3_1);
        $smarty->assign('q1_2', $q1_2);
        $smarty->assign('q2_2', $q2_2);
        $smarty->assign('q3_2', $q3_2);

        $smarty->assign('setting_tire_type',isset($_SESSION['setting_tire_type'])?$_SESSION['setting_tire_type']:0);
        if(count($car1_tires) > 0)
        	$smarty->assign('setting_tire_id_1',isset($_SESSION['setting_tire_id_1'])?$_SESSION['setting_tire_id_1']:$car1_tires[0]['id']);
        if(count($car2_tires) > 0)
        	$smarty->assign('setting_tire_id_2',isset($_SESSION['setting_tire_id_2'])?$_SESSION['setting_tire_id_2']:$car2_tires[0]['id']);
        $smarty->assign('settings', isset($_SESSION['settings'])?$_SESSION['settings']:null);
        $smarty->assign('rounds', isset($_SESSION['rounds'])?$_SESSION['rounds']:null);
        $smarty->assign('last_car', isset($_SESSION['last_car'])?($_SESSION['last_car']==3?1:$_SESSION['last_car']):1);
    }
    //show result of qualification
    else
    {
    	$league = $team['league'];//show own league
    	if(isset($_SESSION['league']))	
    		$league = $_SESSION['league'];
    	else
    		$_SESSION['league'] = $league;
        
        if(isset($_POST['league']))//or selected league
    	{
	    	$league = $_POST['league'];
	    	$_SESSION['league'] = $league;
    	}
    	
        $result = $db->getInstanceQualification($user['ins_id']);
        $result = unserialize($result['last_qualification']);
		$result = $result[$league-1];
        
        //replace place holder with line highlighter for own drivers
        $array_size = count($result);
        for($i = 0; $i < $array_size; ++$i)
        {
        	$array_size1 = count($result[$i]);
        	for($j = 0; $j < $array_size1; ++$j)
        	{
        		//translations
        		$result[$i] = str_replace('Disqualification', Translator::_translate('Disqualification'), $result[$i]);
				$result[$i] = str_replace('tr_race_training_setup_hard', Translator::_translate('tr_race_training_setup_hard'), $result[$i]);
				$result[$i] = str_replace('tr_race_training_setup_soft', Translator::_translate('tr_race_training_setup_soft'), $result[$i]);
        	
			$result[$i] = str_replace('/.png', '/0.png', $result[$i]);
		
	        	$result[$i][$j] = str_replace("line-".$user['tea_id'], "line_highlight", $result[$i][$j]);
	        }
        }

		$smarty->assign('league', $_SESSION['league']);
        $smarty->assign('rounds', 3);
        if(count($result) > 0)
        	$smarty->assign('q1', '"'.implode('","', $result[0]).'"');
        if(count($result) > 1)
        	$smarty->assign('q2', '"'.implode('","', $result[1]).'"');
        if(count($result) > 2)
        	$smarty->assign('q3', '"'.implode('","', $result[2]).'"');
        $smarty->assign('result', $result);
        $smarty->assign('show_result', true);
    }
    
    $smarty->assign('max_rounds', $params['qualification_max_rounds']);
    $smarty->assign('refreshtime', $user['refreshtime']);

    $smarty->assign('content', 'race_qualification.tpl');
