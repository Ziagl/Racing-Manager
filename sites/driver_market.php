<?php
    $message = null;
    $count_driver = 0;
    $params = $db->getParams($user['ins_id']);			//###performance issue should only be done once per login!

	//delete bid
	if(isset($_POST['delete_bid_id']))
	{
		$db->deleteDriverBid($_POST['delete_bid_id'], $user['tea_id']);
		
		unset($_POST['delete_bid_id']);
		header("Location: ?site=driver_market");
		die();
	}

	//change a bid
	if(isset($_POST['bid_id']))
	{
		$_wage = 0;
		$_bonus = 0;
		foreach($_POST as $key=>$value)
		{
			if(strpos($key, "bid_wage_new_") === 0)
			{
				preg_match_all('!\d+!', $value, $wage);
				$_wage = $wage[0][0];
			}
			if(strpos($key, "bid_bonus_new_") === 0)
			{
				preg_match_all('!\d+!', $value, $bonus);
				$_bonus = $bonus[0][0];
			}
		}
		
		preg_match_all('!\d+!', $_wage, $wage);
		preg_match_all('!\d+!', $_bonus, $bonus);
		
		if($wage[0][0] < $team['value'])
			$db->changeDriverBid($_POST['bid_id'], $wage[0][0], $bonus[0][0]);
		
		unset($_POST['bid_id']);
		header("Location: ?site=driver_market");
		die();
	}

	//make a new bid
	if(isset($_POST['driver_bid_id']))
	{
		$driver = $db->getDriver($_POST['driver_bid_id']);

		//form action
		$db->makeDriverBid($user['ins_id'], $driver['id'], $user['tea_id'], $driver['wage'], $driver['bonus']);
		
		unset($_POST['driver_bid_id']);
		header("Location: ?site=driver_market");
		die();
	}

    if(isset($_POST['driver_id']) || isset($_POST['youth_driver']))
    {
    	
    	//buy driver
    	if(isset($_POST['driver_id']))
    	{
	        //form action
	        $ret = $db->buyDriver($_POST['driver_id'], $user['tea_id']);
	        if($ret != 0)
	        {
	            $message = Translator::_translate('tr_driver_market_success');
	        }
	        else
	        {
	            $message = Translator::_translate('tr_driver_market_error');
	        }
	
	        unset($_POST['driver_id']);
        }
        //buy youth driver
        if(isset($_POST['youth_driver']))
        {
        	//form action
        	//birthday
        	$datestart = strtotime((date("Y") - 22).'-01-01');//you can change it to your timestamp;
			$dateend = strtotime((date("Y") - 16).'-12-31');//you can change it to your timestamp;
			$daystep = 86400;
			$datebetween = abs(($dateend - $datestart) / $daystep);
			$randomday = rand(0, $datebetween);
			//echo "\$randomday: $randomday<br>";
			$birthday = date("Y-m-d", $datestart + ($randomday * $daystep));
        	
        	//driver values
        	$values = array();
        	for($i = 0; $i < 4; $i++)
        	{
	        	$values[] = rand(1,50);
        	}
        	
        	$countries = $db->getCountries();
			$maxCountries = 0;
	
			foreach($countries as $c)
			{
				$maxCountries+= $c['relevance'];
			}
			//driver country
			$country_relevance = rand(1,$maxCountries);
			$country = null;
			foreach($countries as $c)
			{
				$country_relevance-= $c['relevance'];
				if($country_relevance <= 0)
				{
					$country = $c;
					break;
				}
			}
			$image_folder = "1/";
			if($country['language'] == 1)
				$image_folder = "3/";
			if($country['language'] == 3 || $country['language'] == 4 || $country['language'] == 5 || $country['language'] == 22 || $country['language'] == 27 || 
			   $country['language'] == 31 || $country['language'] == 32 || $country['language'] == 34 || $country['language'] == 40 || $country['language'] == 41 ||
			   $country['language'] == 54 || $country['language'] == 55 || $country['language'] == 57)
				$image_folder = "2/";
        	
        	$gender = rand(0,9);
        	if($gender == 0)
        	{
        		$picture = "default.jpg";
        		try{
        			$firstnames = $db->getFirstnames($country['language'], $gender);
        			$files_count = new FilesystemIterator("./content/img/driver/female/".$image_folder, FilesystemIterator::SKIP_DOTS);
        			$number = iterator_count($files_count);
        			$dirname = "./content/img/driver/".$user['ins_id'];
					if(!is_dir($dirname))
						mkdir($dirname);
					$i = 1;
					do
					{
						$picture = $user['ins_id']."/".$user['tea_id']."-".$i.".svg";
						++$i;
					}while(file_exists("./content/img/driver/".$picture));
					copy("./content/img/driver/female/".$image_folder.str_pad(rand(1,$number), 3, '0', STR_PAD_LEFT).".svg", "./content/img/driver/".$picture);
        		}catch(Exception $e) {}
        		$gender = 1;	//female
        	}
        	else
        	{
        		$picture = "default.jpg";
        		try{
					$firstnames = $db->getFirstnames($country['language'], $gender);
					$files_count = new FilesystemIterator("./content/img/driver/male/".$image_folder, FilesystemIterator::SKIP_DOTS);
					$number = iterator_count($files_count);
					$dirname = "./content/img/driver/".$user['ins_id'];
					if(!is_dir($dirname))
						mkdir($dirname);
					$i = 1;
					do
					{
						$picture = $user['ins_id']."/".$user['tea_id']."-".$i.".svg";
						++$i;
					}while(file_exists("./content/img/driver/".$picture));
					copy("./content/img/driver/male/".$image_folder.str_pad(rand(1,$number), 3, '0', STR_PAD_LEFT).".svg", "./content/img/driver/".$picture);
        		}catch(Exception $e) {}
        		$gender = 0;	//male
        	}
            $lastnames = $db->getLastnames($country['language']);
        	$firstname = $firstnames[rand(0, count($firstnames) - 1)]['name'];
            $lastname = $lastnames[rand(0, count($lastnames) - 1)]['name'];
        	$shortname = strtoupper(substr(uml_replace($lastname), 0, 2) . substr(uml_replace($firstname), 0, 1));
	        $ret = $db->buyYouthDriver($gender, $picture, $birthday, $values, $country['id'], $firstname, $lastname, $shortname, $user['tea_id'], $user['ins_id']);
	        if($ret != 0)
	        {
	        	change_youth_driver_cloth($user['tea_id'], $ret, $db);
	            $message = Translator::_translate('tr_driver_market_success');
	        }
	        else
	        {
	            $message = Translator::_translate('tr_driver_market_error');
	        }
	     	
	     	unset($_POST['youth_driver']);   
        }
    }
    else
    {
        $count_driver = $db->getCountDriversOfTeam($user['tea_id']);
        $drivers_old = $db->getFreeDrivers($user['ins_id'], $team['value'], 'lastname asc');

        $drivers = array();
        foreach($drivers_old as $driver)
        {
            $driver['age'] = date('Y') - date('Y', strtotime($driver['birthday']));
            $driver = number_format_Tablerow($driver);
            $driver = add_color_class_driver($driver);	//adds CSS color class for driver values
            $driver = default_image($driver);
            $country = $db->getCountry($driver['cou_id']);
            $driver['country_name'] = $country['name'];
		    $driver['country_picture'] = $country['picture'];
            $driver['not_buyable'] = false;
            if(intval($driver['wage']) > intval($team['value']))
            	$driver['not_buyable'] = true;
            $drivers[] = $driver;
        }
        $smarty->assign('drivers', $drivers);
    }
    
    //if option for driver bids is set --> count previous bids
    $bids_array = array();
    if($params['driver_bid_type'] == 1)
    {
    	$time = time();
	    $count_bids = $db->getCountDriverBidsTeam($user['ins_id'], $user['tea_id']);
	    $bids = $db->getDriverBids($user['ins_id']);
	    $array_size = count($bids);
	    for($i = 0; $i < $array_size; ++$i)
	    {
		    if($bids[$i]['tea_id'] == $user['tea_id'])
		    {
		    	$b = $bids[$i];
		    	$driver = $db->getDriver($b['dri_id']);
		    	$driver_bids = $db->getCountDriverBidsDriver($user['ins_id'], $b['dri_id']);
		    	$b['picture'] = $driver['picture'];
		    	$country = $db->getCountry($driver['cou_id']);
		    	$b['country_name'] = $country['name'];
		    	$b['country_picture'] = $country['picture'];
		    	$b['firstname'] = $driver['firstname'];
		    	$b['lastname'] = $driver['lastname'];
		    	$b['other_bids'] = $driver_bids - 1;
		    	//we need to calculate time till driver make his dicision
		    	//get the first bid for this driver to calculate time
		    	$first_driver_bid = $db->getDriverBidsFirstDriver($user['ins_id'], $b['dri_id']);
		    	$bid_time = strtotime($first_driver_bid['created']);
		    	$bid_time = strtotime("+".$params['bid_time']." hours", $bid_time);
		    	$bid_time = roundToNextHour(date('Y-m-d H:i:s', $bid_time));
		    	$b['time_to_bid'] = strtotime($bid_time) - $time;
		    	
		    	//calculate chance
		    	if($driver_bids == 1)
		    	{
			    	$best = $driver['wage'] + ($driver['bonus'] * 100);
			    	$current = $b['wage'] + ($b['bonus'] * 100);
			    	
			    	//if bet is above driver market value
			    	if($current >= $best)
			    		$b['chance'] = 100;
			    	//or if it is below this mark
			    	else
			    	{
			    		$b['chance'] = 0;
			    		/*
			    		this code lets you also set bets lower than market value till 70 percent
			    		if(($current * 100 / $best) < 70)
			    			$b['chance'] = 0;
			    		else
			    			$b['chance'] = number_format(($current - ($best * 0.7)) * 100 / ($best * 0.3), 2);
			    		*/
			    	}
		    	}
		    	else
		    	{
		    		//if user is able to see chance if other player also made an offer for that driver
		    		if($params['driver_bid_visible'] == 1)
		    		{
			    		$driver_bids = $db->getDriverBidsDriver($b['ins_id'], $b['dri_id']);
				    	$best = 0;
				    	//calculate max
				    	foreach($driver_bids as $d_b)
				    	{
					    	$value = $d_b['wage'] + ($d_b['bonus'] * 100);
					    	if($value > $best)
					    		$best = $value;
				    	}
				    	$current = $b['wage'] + ($b['bonus'] * 100);
				    	
				    	if($current >= $best)
				    		$b['chance'] = 100;
				    	else
				    		$b['chance'] = number_format(($current * 100 / $best) / count($driver_bids), 2);
			    	}
			    	else
			    		$b['chance'] = '?';
		    	}
			    $bids_array[] = $b;
		    }
	    }
    }

	$smarty->assign('driver_bid_type', $params['driver_bid_type']);
	$smarty->assign('bids', $bids_array);
	$smarty->assign('count_bids', $count_bids);
    $smarty->assign('count_driver', $count_driver);
    $smarty->assign('message', $message);
    $smarty->assign('instance', $instance);
    $smarty->assign('max_youth_driver', $params['max_youth_driver']);
    $smarty->assign('content', 'driver_market.tpl');