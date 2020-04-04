<?php
    $error = null;
    $car1_error = null;
    $car2_error = null;
    $car3_error = null;
    $tire_error = null;

    $driver1 = $driver2 = $driver3= null;
    $car1 = $car2 = $car3 = null;

    $data = array();
    //track
    $track = $db->getTrack($user['ins_id']);
    $country = $db->getCountry($track['cou_id']);
    //simple weather only sun or rain
    $weather = "sun";
    if($track['weather'] < 31)
    {
    	$weather = "rain";
    }
    /*if($track['weather'] < 31)
    {
	    $weather = "rain";
    }
    if($track['weather'] > 30 && $track['weather'] < 71)
    {
	    $weather = "cloudy";
    }*/
    
    //car1
    if($team['driver1'] != null)
    {
        $driver1 = $db->getDriver($team['driver1']);
        $driver1['driver_value'] = number_format(($driver1['speed'] + $driver1['persistence'] + $driver1['experience'] + $driver1['stamina'] + $driver1['freshness'] + $driver1['morale']) / 6, 0);
        $driver1 = default_image($driver1);
        $car1_old = $db->getItemsFromCar($user['tea_id'],1);
        $car1 = array();
        $car_value = 0;
        foreach($car1_old as $car)
        {
            $item = $db->getItem($car['ite_id']);
            $car['name'] = $item['name'];
            $car['value'] = $item['skill'] + (($item['skill_max'] - $item['skill']) * ($car['tuneup'] * 0.01));
            //car part value changes by condition
	        $car['value'] *= $car['condition'] * 0.01;
            $car1[] = $car;
            $car_value+= $car['value'];
        }
        if(count($car1) != 10)
        {
            $car1_error = Translator::_translate('tr_race_no_items');
        }
        $car1['car_value'] = number_format($car_value / 10, 0);
    }

    //car2
    if($team['driver2'] != null)
    {
        $driver2 = $db->getDriver($team['driver2']);
        $driver2['driver_value'] = number_format(($driver2['speed'] + $driver2['persistence'] + $driver2['experience'] + $driver2['stamina'] + $driver2['freshness'] + $driver2['morale']) / 6, 0);
        $driver2 = default_image($driver2);
        $car2_old = $db->getItemsFromCar($user['tea_id'],2);
        $car2 = array();
        $car_value = 0;
        foreach($car2_old as $car)
        {
            $item = $db->getItem($car['ite_id']);
            $car['name'] = $item['name'];
            $car['value'] = $item['skill'] + (($item['skill_max'] - $item['skill']) * ($car['tuneup'] * 0.01));
            //car part value changes by condition
	        $car['value'] *= $car['condition'] * 0.01;
            $car2[] = $car;
			$car_value+= $car['value'];
        }
        if(count($car2) != 10)
        {
            $car2_error = Translator::_translate('tr_race_no_items');
        }
        $car2['car_value'] = number_format($car_value / 10, 0);
    }
    
    //car3
    if($team['driver3'] != null)
    {
        $driver3 = $db->getDriver($team['driver3']);
        $driver3['driver_value'] = number_format(($driver3['speed'] + $driver3['persistence'] + $driver3['experience'] + $driver3['stamina'] + $driver3['freshness'] + $driver3['morale']) / 6, 0);
        $driver3 = default_image($driver3);
        $car3_old = $db->getItemsFromCar($user['tea_id'],3);
        $car3 = array();
        $car_value = 0;
        foreach($car3_old as $car)
        {
            $item = $db->getItem($car['ite_id']);
            $car['name'] = $item['name'];
            $car['value'] = $item['skill'] + (($item['skill_max'] - $item['skill']) * ($car['tuneup'] * 0.01));
            //car part value changes by condition
	        $car['value'] *= $car['condition'] * 0.01;
            $car3[] = $car;
			$car_value+= $car['value'];
        }
        if(count($car3) != 10)
        {
            $car3_error = Translator::_translate('tr_race_no_items');
        }
        $car3['car_value'] = number_format($car_value / 10, 0);
    }
    
    if($team['tir_id'] == null)
    	$tire_error = Translator::_translate('tr_race_no_tire_sponsor');

    //mechanics
    $mechanics_old = $db->getMechanicsOfTeam($user['tea_id']);
    $return = get_mechanic_values($mechanics_old);
    $setup = $return[2];
    $tires = $return[3];
    $setup = number_format_Tablerow(compute_setup_bonus($setup),1);
    $tires = number_format_Tablerow(compute_tire_bonus($tires),1);
    
    //get tires
    //driver 1
    $car1_tires = compute_race_tire_array($team['id'], 1, $db, $params, $weather);
    //driver2
    $car2_tires = compute_race_tire_array($team['id'], 2, $db, $params, $weather);
    //driver3
    $car3_tires = compute_race_tire_array($team['id'], 3, $db, $params, $weather);

    $smarty->assign('car1_tires', $car1_tires);
    $smarty->assign('car2_tires', $car2_tires);
    $smarty->assign('car3_tires', $car3_tires);

    $smarty->assign('driver1', $driver1);
    $smarty->assign('car1', $car1);
    $smarty->assign('driver2', $driver2);
    $smarty->assign('car2', $car2);
    $smarty->assign('driver3', $driver3);
    $smarty->assign('car3', $car3);
    $smarty->assign('setup', $setup);
    $smarty->assign('tires', $tires);
    $smarty->assign('track', $track);
    $smarty->assign('country', $country);
    $smarty->assign('weather', $weather);