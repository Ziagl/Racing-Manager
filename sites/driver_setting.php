<?php
    $drivers_old = $db->getDriversOfTeam($user['tea_id']);

	if(isset($_POST['sell_driver_id']))
	{
		$driver = $db->getDriver($_POST['sell_driver_id']);
		if($driver['tea_id'] == $user['tea_id'])
		{
			$sell_price = calculate_sell_price($driver,0);
			
			//sell driver
			if($sell_price > 0)
			{
				$db->sellDriver($driver['id'], $driver['tea_id'], $driver['ins_id'], $sell_price);
			}
			//or delete him
			else
			{
				$db->deleteDriver($driver['id']);
			}
		}
		unset($_POST['sell_driver_id']);
		header("Location: ?site=driver_setting");
		die();
	}

    $drivers = array();
    $driver_images = array();
    foreach($drivers_old as $driver)
    {
        $country = $db->getCountry($driver['cou_id']);
        $history_old = $db->getDriverHistory($driver['id'], 'date DESC', 10);
        $history = array();
        foreach($history_old as $h)
        {
	        $h['speed_css'] = get_css_color_class($h['speed']);
		    $h['persistence_css'] = get_css_color_class($h['persistence']);
		    $h['experience_css'] = get_css_color_class($h['experience']);
		    $h['stamina_css'] = get_css_color_class($h['stamina']);
		    $h['freshness_css'] = get_css_color_class($h['freshness']);
		    $h['morale_css'] = get_css_color_class($h['morale']);
	        $history[] = $h;
        }
        $history_first = $db->getDriverHistory($driver['id'], 'date ASC', 1);
        
	if(!array_key_exists('speed', $history_first[0])) $history_first[0]['speed'] = $driver['speed'];
		if(!array_key_exists('persistence', $history_first[0])) $history_first[0]['persistence'] = $driver['persistence'];
		if(!array_key_exists('experience', $history_first[0])) $history_first[0]['experience'] = $driver['experience'];
		if(!array_key_exists('stamina', $history_first[0])) $history_first[0]['stamina'] = $driver['stamina'];
		if(!array_key_exists('freshness', $history_first[0])) $history_first[0]['freshness'] = $driver['freshness'];
		if(!array_key_exists('morale', $history_first[0])) $history_first[0]['morale'] = $driver['morale'];
	
	$history_first[0]['speed_css'] = get_css_color_class($history_first[0]['speed']);
		$history_first[0]['persistence_css'] = get_css_color_class($history_first[0]['persistence']);
		$history_first[0]['experience_css'] = get_css_color_class($history_first[0]['experience']);
		$history_first[0]['stamina_css'] = get_css_color_class($history_first[0]['stamina']);
		$history_first[0]['freshness_css'] = get_css_color_class($history_first[0]['freshness']);
		$history_first[0]['morale_css'] = get_css_color_class($history_first[0]['morale']);
		
        $driver['country_picture'] = $country['picture'];
        $driver['country_name'] = $country['name'];
        $driver['history'] = $history;
        $driver['history_first'] = $history_first[0];
        $driver = add_color_class_driver($driver);	//adds CSS color class for driver values
        $driver = default_image($driver);       
        
        //calculate sell price
        $driver['sell_price'] = calculate_sell_price($driver,1);
        
        $driver['wage'] = number_format($driver['wage'], 0, ",", ".");
        $driver['bonus'] = number_format($driver['bonus'], 0, ",", ".");
        $drivers[] = $driver;
    }

    $smarty->assign('drivers', $drivers);
    $smarty->assign('content', 'driver_setting.tpl');
