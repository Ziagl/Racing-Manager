<?php
    if(!$user['admin'])
    {
        header('Location: ?site=dashboard');
        die();
    }
    
    $params = $db->getParams($user['ins_id']);
    $users = $db->getUsers($user['ins_id']);
    $tracks = $db->getAllTracks($user['ins_id']);
    $races = $db->getTrackCalendar($user['ins_id']);
    
    //$training_users = $db->getTrainingUsers();
    //$notraining_users = $db->getNoTrainingUsers();
    //$qualification_users = $db->getQualificationUsers();
    //$noqualification_users = $db->getNoQualificationUsers();
    //$grandprix_users = $db->getGrandprixUsers();
    //$nograndprix_users = $db->getNoGrandprixUsers();
    
    //race calendar save
    if(isset($_POST['save_race']))
    {
    	$races = array();
    	$i = 1;
    	foreach($_POST as $key=>$value)
		{
			if(strpos($key, "race_") === 0)
			{
				$id = str_replace("race_","",$key);
				$races[$id]['tra_id'] = $value;
				$races[$id]['rank'] = $i;
				$i++;	
			}
		}
    	$db->saveTrackCalendar($user['ins_id'], $races);
    
	    header('Location: ?site=administration');
	    die();
    }
    
    //race calendar add
    if(isset($_POST['add_race']))
    {
    	$db->addRace($user['ins_id'], $tracks[0]['id']);
    
	    header('Location: ?site=administration');
        die();
    }
    
    //race calendar delete
    if(isset($_POST['del_race']))
    {
	    $db->delLastRace($user['ins_id']);
	    
	    header('Location: ?site=administration');
        die();
    }
    
    //acknowledge driver bid
    if(isset($_POST['bid_id']))
    {
	    change_driver_cloth($_POST['bid_id'], $db);
	    $db->buyDriverFromBid($_POST['bid_id']);
	    
	    header('Location: ?site=administration');
        die();
    }

    if(isset($_POST['training_max_rounds']))
    {
        $db->changeParams($user['ins_id'],
                       $_POST['training_max_rounds'],
                       $_POST['qualification_max_rounds'],
                       $_POST['qualification_cut1'],
                       $_POST['qualification_cut2'],
                       $_POST['drop_out'],
                       $_POST['random'],
                       0,//$_POST['time_change'],
                       0,//$_POST['straight'],
                       0,//$_POST['curve'],
                       $_POST['item_value'],
                       $_POST['setup_value'],
                       $_POST['driver_value'],
                       $_POST['tire_value'],
                       $_POST['speed'],
                       $_POST['driver_bid_type'],
                       $_POST['driver_bid_visible'],
                       $_POST['qualification_race_tires'],
                       $_POST['race_diff_tires'],
                       $_POST['qualification_diff_tires'],
                       $_POST['ai_strength1'],
                       $_POST['ai_strength2'],
                       $_POST['ai_strength3'],
                       $_POST['round_factor'],
                       0,//$_POST['overtake'],
                       $_POST['hard_tires_per_weekend'],
                       $_POST['soft_tires_per_weekend'],
                       $_POST['meter_to_round'],
                       $_POST['tire_condition'],
                       $_POST['engine_power']);
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['repairAiItem']))
    {
    	$db->repairAiIteams();
    	
    	header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['deleteAiItems']))
    {
    	$db->deleteAiItems();
    	
    	header('Location: ?site=administration');
        die();
    }
    
    //compute drivers for ai teams
    //and do some training rounds
    if(isset($_POST['training']))
    {
    	cron_compute_training($db);

	    header('Location: ?site=administration');
        die();
    }

    if(isset($_POST['user']))
    {
        //change current user
        $user = $db->getUser($_POST['user']);
        unset($_SESSION['settings']);
        unset($_SESSION['rounds']);
        $_SESSION['user'] = $user;

        header('Location: ?site=administration');
        die();
    }

    if(isset($_POST['reset']))
    {
        $db->reset();
        generate_new_tire_set($db);
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['trackreset']))
    {
        randomize_track($db);
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['driverreset']))
    {
        randomize_drivers($db);
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['carreset']))
    {
    	set_time_limit(300);
    	$db->deleteAllCarDesigns();
   		create_missing_cars($db);
    	header('Location: ?site=administration');
        die();
    }

    if(isset($_POST['reset_tqr']))
    {
        $db->resetTQR();
        generate_new_tire_set($db);
        $db->updateInstanceCurrentDay($user['ins_id'], 0);
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['reset_qr']))
    {
        $db->resetQR();
        $db->updateInstanceCurrentDay($user['ins_id'], 1);
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['reset_r']))
    {
        $db->resetR();
        $db->updateInstanceCurrentDay($user['ins_id'], 2);
        header('Location: ?site=administration');
        die();
    }

    if(isset($_POST['quali']))
    {
    	cron_compute_qualification($db);
    	
        header('Location: ?site=administration');
        die();
    }

    if(isset($_POST['race']))
    {
    	$filename_flag = __DIR__."/../log/race.flag";
    	
    	if(!file_exists($filename_flag))
    	{
			$handle = fopen($filename_flag, 'a');
			fclose($handle);
			
			cron_compute_race($db);
			
			unlink($filename_flag);
			header('Location: ?site=administration');
        }
        else
        {
        	echo "Es wird bereits ein Rennen berechnet!";
        }
        die();
    }
    
    if(isset($_POST['next_race']))
    {
	    cron_compute_next_race($db);
        
        header('Location: ?site=administration');
        die();
    }
    
    if(isset($_POST['next_saison']))
    {
    	generate_track_calendar($db);
    	header('Location: ?site=administration');
    	die();
    }
    
    //driver bids
    $bids_array = array();
    if($params['driver_bid_type'] == 1)
    {
	    $bids = $db->getDriverBids($user['ins_id']);
	    $array_size = count($bids);
	    for($i = 0; $i < $array_size; ++$i)
	    {
	    	$b = $bids[$i];
	    	$driver = $db->getDriver($b['dri_id']);
	    	$driver_bids = $db->getCountDriverBidsDriver($user['ins_id'], $b['dri_id']);
	    	$_team = $db->getTeam($b['tea_id']);
	    	$b['class'] = "";
	    	//get time diff
	    	$date1 = new DateTime(date('Y-m-d H:i:s'));
	    	$date2 = new DateTime($b['created']);
	    	$interval = $date1->diff($date2);
	    	if($interval->format('%a') > 0)
	    	{
		    	$b['class'] = "line_highlight";
	    	}
	    	$b['picture'] = $driver['picture'];
	    	$b['firstname'] = $driver['firstname'];
	    	$b['lastname'] = $driver['lastname'];
	    	$b['team'] = $_team['name'];
	    	$date = new DateTime($b['created']);
	    	$b['created'] = $date->format('d.m.Y H:i');
	    	$date = new DateTime($b['last_update']);
	    	$b['last_update'] = $date->format('d.m.Y H:i');
	    	$b['other_bids'] = $driver_bids - 1;
	    	//calculate chance
	    	if($driver_bids == 1)
	    	{
		    	$best = $driver['wage'] + ($driver['bonus'] * 100);
		    	$current = $b['wage'] + ($b['bonus'] * 100);
		    	
		    	if($current > $best)
		    		$b['chance'] = 100;
		    	else
		    	{
		    		if(($current * 100 / $best) < 70)
		    			$b['chance'] = 0;
		    		else
		    			$b['chance'] = number_format(($current - ($best * 0.7)) * 100 / ($best * 0.3), 2);
		    	}
	    	}
	    	else
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
		    	
		    	if($current > $best)
					$b['chance'] = 100;
				else
					$b['chance'] = number_format(($current * 100 / $best) / count($driver_bids), 2);
	    	}
		    $bids_array[] = $b;
	    }
    }

    $smarty->assign('freeTeams', $db->freeTeams());
    //$smarty->assign('training_users', $training_users);
    //$smarty->assign('no_training_users', $notraining_users);
    //$smarty->assign('qualification_users', $qualification_users);
    //$smarty->assign('no_qualification_users', $noqualification_users);
    //$smarty->assign('grandprix_users', $grandprix_users);
    //$smarty->assign('no_grandprix_users', $nograndprix_users);
	$smarty->assign('bids', $bids_array);
	$smarty->assign('tracks', $tracks);
	$smarty->assign('races', $races);
    $smarty->assign('params', $params);
    $smarty->assign('users', $users);
    $smarty->assign('content', 'administration.tpl');
