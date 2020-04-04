<?php
    $race_laps = $db->isQualificationOrRace($user['ins_id'], 2);
    $track = $db->getTrack($user['ins_id']);
    $params = $db->getParams($user['ins_id']);			//###performance issue should only be done once per login!
    
    //detect if driver already has a q3 setting
    $q3 = array();
    $q3[0] = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 2);
    $q3[1] = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 2);
    $quali3_1 = false;
    $quali3_2 = false;
    if($q3[0])
    	$quali3_1 = true;
    if($q3[1])
    	$quali3_2 = true;
    
    $rounds = $track['rounds'];
    $steps = intval($rounds/6);
    $step_array = array(
    		"1-".$steps, 
    		($steps+1)."-".(2*$steps), 
    		(2*$steps+1)."-".(3*$steps),
    		(3*$steps+1)."-".(4*$steps),
    		(4*$steps+1)."-".(5*$steps),
    		(5*$steps+1)."-".$rounds
    );
    
    //no computed race available!
    if(count($race_laps) == 0)
    {
        include('config/global_race.php');

        //if there are new settings
        if(isset($_POST['car']))
        {
            //type: 0...start, 1...1. pitstop, 2...pitstop
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
            $rounds = $_POST['rounds_value'];
            if($rounds == null || $rounds == 0 ||$rounds == "")
            {
            	$_SESSION['last_car'] = $car_number;
            	header('Location: ?site=race_grandprix');
            	die();
            }
            //$tire_type = $_POST['optionsRadios'];
            $tire_id = $_POST['tire_id'];
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
            if($params['qualification_race_tires'] == 1 && $type == 0)
            {
            	$s = $q3[$car_number-1];//$db->getSetupSetting($car_number, $user['tea_id'], $user['ins_id'], 1, 2);
	        	//if there is already a setting for race
	        	if($s != null)
	        	{
		        	$tire_type = $s['tire_type'];
		        	$tire_id = $s['race_tire_id'];
	        	}
            }
            
            $settings = array(
				'front_wing' => $q3[$car_number-1]['front_wing'],
				'rear_wing' => $q3[$car_number-1]['rear_wing'],
				'front_suspension' => $q3[$car_number-1]['front_suspension'],
				'rear_suspension' => $q3[$car_number-1]['rear_suspension'],
				'tire_pressure' => $q3[$car_number-1]['tire_pressure'],
				'brake_balance' => $q3[$car_number-1]['brake_balance'],
				'gear_ratio' => $q3[$car_number-1]['gear_ratio'],
				'power1' => intval(trim($_POST['power1_value'])),
				'power2' => intval(trim($_POST['power2_value'])),
				'power3' => intval(trim($_POST['power3_value'])),
				'power4' => intval(trim($_POST['power4_value'])),
				'power5' => intval(trim($_POST['power5_value'])),
				'power6' => intval(trim($_POST['power6_value']))
			);
			
            $_SESSION['settings'] = $settings;
            $_SESSION['rounds'] = $rounds;
            $_SESSION['last_car'] = $car_number;
            
            $settings = recomputePowerValues($settings);

            //store to db
            $db->insertSetupSetting($car_number, $team['id'], $team['league'], $user['ins_id'], $settings, $tire_type, $tire_id, $rounds, 2, $type);

            //log
            //$message = "Setting for car ".$car_number." type: ".$type." round: ".$rounds." tire: ".$tire_id." settings: ".$settings['front_wing'].", ".$settings['rear_wing'].", ".$settings['front_suspension'].", ".$settings['rear_suspension'].", ".$settings['tire_pressure'].", ".$settings['brake_balance'].", ".$settings['gear_ratio'];
		    //$db->log($user['id'], 2, $message);
            
            unset($_POST['car']);
            header('Location: ?site=race_grandprix');
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
	        $error = Translator::_translate('tr_race_no_driver_car_race');
	    }
	    
	    //depend on param - check for different tire types
	    if($params['race_diff_tires'] == 1)
	    {
	    	$tire_error1 = null;
	    	$tire_error2 = null;
	    	$tire_error_message = Translator::_translate('tr_race_grandprix_tire_error');
	    	
	    	//car 1
		    $hard = 0;
		    $soft = 0;
		    
		    $setups = $db->getSetupSettingAll(1, $user['tea_id'], $user['ins_id'], 2);

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
		    
		    $setups = $db->getSetupSettingAll(2, $user['tea_id'], $user['ins_id'], 2);
		    
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

        //get qualification settings from db
        $r1_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 0));
        $r2_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 1));
        $r3_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 2));
        $r4_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 3));
        $r5_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 4));
        $r6_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 5));
        $r7_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 6));
        $r8_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 7));
        $r9_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 8));
        $r10_1 = power_to_image($db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 2, 9));
        $r1_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 0));
        $r2_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 1));
        $r3_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 2));
        $r4_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 3));
        $r5_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 4));
        $r6_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 5));
        $r7_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 6));
        $r8_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 7));
        $r9_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 8));
        $r10_2 = power_to_image($db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 2, 9));
        
        //training
		$car1_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver1['id'], 0, 1, 'round_time ASC');
		$car1_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver1['id'], 0, 0, 'round_time ASC');
		$car2_best_lap_soft = $db->getBestSetupOfTypeTrainingTires($user['ins_id'],$driver2['id'], 0, 1, 'round_time ASC');
		$car2_best_lap_hard = $db->getBestSetupOfTypeTrainingTires($user['ins_id'], $driver2['id'], 0, 0, 'round_time ASC');
		$smarty->assign('car1_best_lap_soft', $car1_best_lap_soft);
		$smarty->assign('car1_best_lap_hard', $car1_best_lap_hard);
		$smarty->assign('car2_best_lap_soft', $car2_best_lap_soft);
		$smarty->assign('car2_best_lap_hard', $car2_best_lap_hard);
        
        $quali_over = false;
		if(count($db->isQualificationOrRace($user['ins_id'], 1)) != 0)
		{
			//qualification
			$q1_1 = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 0);
			$q2_1 = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 1);
			$q3_1 = $db->getSetupSetting(1, $user['tea_id'], $user['ins_id'], 1, 2);
			$q1_2 = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 0);
			$q2_2 = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 1);
			$q3_2 = $db->getSetupSetting(2, $user['tea_id'], $user['ins_id'], 1, 2);
			$smarty->assign('q1_1', $q1_1);
			$smarty->assign('q2_1', $q2_1);
			$smarty->assign('q3_1', $q3_1);
			$smarty->assign('q1_2', $q1_2);
			$smarty->assign('q2_2', $q2_2);
			$smarty->assign('q3_2', $q3_2);
        
			$quali_over = true;
		}
		
		//setup error
		$setup_error_message = Translator::_translate('tr_race_grandprix_setup_error');
		$setup_error1 = null;
		$setup_error2 = null;
		
		$rounds_to_drive = 0;
		if($r1_1['rounds']) $rounds_to_drive+= $r1_1['rounds'];
		if($r2_1['rounds']) $rounds_to_drive+= $r2_1['rounds'];
		if($r3_1['rounds']) $rounds_to_drive+= $r3_1['rounds'];
		if($r4_1['rounds']) $rounds_to_drive+= $r4_1['rounds'];
		if($r5_1['rounds']) $rounds_to_drive+= $r5_1['rounds'];
		if($r6_1['rounds']) $rounds_to_drive+= $r6_1['rounds'];
		if($r7_1['rounds']) $rounds_to_drive+= $r7_1['rounds'];
		if($r8_1['rounds']) $rounds_to_drive+= $r8_1['rounds'];
		if($r9_1['rounds']) $rounds_to_drive+= $r9_1['rounds'];
		if($r10_1['rounds']) $rounds_to_drive+= $r10_1['rounds'];
		if($rounds_to_drive <= $track['rounds'])
			$setup_error1 = $setup_error_message;
		
		$rounds_to_drive = 0;
		if($r1_2['rounds']) $rounds_to_drive+= $r1_2['rounds'];
		if($r2_2['rounds']) $rounds_to_drive+= $r2_2['rounds'];
		if($r3_2['rounds']) $rounds_to_drive+= $r3_2['rounds'];
		if($r4_2['rounds']) $rounds_to_drive+= $r4_2['rounds'];
		if($r5_2['rounds']) $rounds_to_drive+= $r5_2['rounds'];
		if($r6_2['rounds']) $rounds_to_drive+= $r6_2['rounds'];
		if($r7_2['rounds']) $rounds_to_drive+= $r7_2['rounds'];
		if($r8_2['rounds']) $rounds_to_drive+= $r8_2['rounds'];
		if($r9_2['rounds']) $rounds_to_drive+= $r9_2['rounds'];
		if($r10_2['rounds']) $rounds_to_drive+= $r10_2['rounds'];
		if($rounds_to_drive <= $track['rounds'])
			$setup_error2 = $setup_error_message;
		
		$smarty->assign('setup_error1', $setup_error1);
		$smarty->assign('setup_error2', $setup_error2);
		
		$smarty->assign('quali_over', $quali_over);
        $smarty->assign('show_result', false);
        $smarty->assign('r1_1', $r1_1);
        $smarty->assign('r2_1', $r2_1);
        $smarty->assign('r3_1', $r3_1);
        $smarty->assign('r4_1', $r4_1);
        $smarty->assign('r5_1', $r5_1);
        $smarty->assign('r6_1', $r6_1);
        $smarty->assign('r7_1', $r7_1);
        $smarty->assign('r8_1', $r8_1);
        $smarty->assign('r9_1', $r9_1);
        $smarty->assign('r10_1', $r10_1);
        $smarty->assign('r1_2', $r1_2);
        $smarty->assign('r2_2', $r2_2);
        $smarty->assign('r3_2', $r3_2);
        $smarty->assign('r4_2', $r4_2);
        $smarty->assign('r5_2', $r5_2);
        $smarty->assign('r6_2', $r6_2);
        $smarty->assign('r7_2', $r7_2);
        $smarty->assign('r8_2', $r8_2);
        $smarty->assign('r9_2', $r9_2);
        $smarty->assign('r10_2', $r10_2);

        $smarty->assign('setting_tire_type',isset($_SESSION['setting_tire_type'])?$_SESSION['setting_tire_type']:0);
        if(count($car1_tires) > 0)
        	$smarty->assign('setting_tire_id_1',isset($_SESSION['setting_tire_id_1'])?$_SESSION['setting_tire_id_1']:$car1_tires[0]['id']);
        if(count($car2_tires) > 0)
        	$smarty->assign('setting_tire_id_2',isset($_SESSION['setting_tire_id_2'])?$_SESSION['setting_tire_id_2']:$car2_tires[0]['id']);
        $smarty->assign('settings', isset($_SESSION['settings'])?$_SESSION['settings']:null);
        $smarty->assign('rounds', isset($_SESSION['rounds'])?$_SESSION['rounds']:null);
        $smarty->assign('track', $track);
        $smarty->assign('last_car', isset($_SESSION['last_car'])?$_SESSION['last_car']:1);
    }
    //show result of grand prix
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
    	
        $result = $db->getInstanceRace($user['ins_id']);
        $result = unserialize($result['last_race']);
        $result = $result[$league-1];
        
        //replace place holder with line highlighter for own drivers
        $array_size = count($result);
        for($i = 0; $i < $array_size; ++$i)
        {
        	//translate
        	$result[$i] = str_replace('Lap', Translator::_translate('Lap'), $result[$i]);
        	$result[$i] = str_replace('Broken vehicle body', Translator::_translate('Broken vehicle body'), $result[$i]);
        	$result[$i] = str_replace('Brake failure', Translator::_translate('Brake failure'), $result[$i]);
        	$result[$i] = str_replace('Engine failure', Translator::_translate('Engine failure'), $result[$i]);
        	$result[$i] = str_replace('Aerodynamics failure', Translator::_translate('Aerodynamics failure'), $result[$i]);
        	$result[$i] = str_replace('Electrical failure', Translator::_translate('Electrical failure'), $result[$i]);
        	$result[$i] = str_replace('Broken suspension', Translator::_translate('Broken suspension'), $result[$i]);
        	$result[$i] = str_replace('Transmission damage', Translator::_translate('Transmission damage'), $result[$i]);
        	$result[$i] = str_replace('Hydraulic failure', Translator::_translate('Hydraulic failure'), $result[$i]);
        	$result[$i] = str_replace('Kers suspension', Translator::_translate('Kers suspension'), $result[$i]);
        	$result[$i] = str_replace('DRS damage', Translator::_translate('DRS damage'), $result[$i]);
        	$result[$i] = str_replace('Driver failure', Translator::_translate('Driver failure'), $result[$i]);
        	$result[$i] = str_replace('Disqualification', Translator::_translate('Disqualification'), $result[$i]);
        	$result[$i] = str_replace('Crash', Translator::_translate('Crash'), $result[$i]);
        	$result[$i] = str_replace('No fuel', Translator::_translate('No fuel'), $result[$i]);
        	$result[$i] = str_replace('Puncture', Translator::_translate('Puncture'), $result[$i]);
        	$result[$i] = str_replace('tr_race_training_setup_hard', Translator::_translate('tr_race_training_setup_hard'), $result[$i]);
        	$result[$i] = str_replace('tr_race_training_setup_soft', Translator::_translate('tr_race_training_setup_soft'), $result[$i]);
        	
		$result[$i] = str_replace('/.png', '/0.png', $result[$i]);
		
	        $result[$i] = str_replace("line-".$user['tea_id'], "line_highlight", $result[$i]);
        }

        $smarty->assign('race_translate', Translator::_translate('Lap'));
		$smarty->assign('league', $_SESSION['league']);
        $smarty->assign('rounds', $track['rounds']);
        $smarty->assign('result_js', '"'.implode('","', $result).'"');
        $smarty->assign('result', $result);
        $smarty->assign('show_result', true);
    }

    //no power after quali settings bug fix
    if(isset($_SESSION['settings']))
    {
    	$settings = $_SESSION['settings'];
    	if(!array_key_exists('power1', $settings))
    	{
    		$settings['power1'] = 0;
    		$settings['power2'] = 0;
    		$settings['power3'] = 0;
    		$settings['power4'] = 0;
    		$settings['power5'] = 0;
    		$settings['power6'] = 0;
    		$_SESSION['settings'] = $settings;
    		$smarty->assign('settings', $_SESSION['settings']);
    	}
    }
    $smarty->assign('steps',$step_array);
    $smarty->assign('quali3_1',$quali3_1);
    $smarty->assign('quali3_2',$quali3_2);
    $smarty->assign('refreshtime', $user['refreshtime']);
    $smarty->assign('content', 'race_grandprix.tpl');
