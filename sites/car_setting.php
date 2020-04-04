<?php
    //$team = $db->getTeam($user['tea_id']);
    $drivers = array();
    $car1 = array();
    $car2 = array();
    $car3 = array();
    
    if($team['car_design'] == null)
    {
    	create_missing_cars($db, $team);    	
    }
    //only needed to initially create alle country driver helmets
    //create_driver_cars($db, $team);
    
    //item tuneup
    if(isset($_POST['item_tune']))
    {
        $db->changeItemTuneup($_POST['item_id'], $_POST['item_tune']);

        unset($_POST['item_tune']);
        die();
    }

	if(!isset($_SESSION['tab']))
		$_SESSION['tab'] = 0;
	
    if(isset($_POST['driver1']))
    {
        $db->setTeamDriver($user['tea_id'], $_POST['driver1'], 1);
        $_SESSION['tab'] = 0;
        header('Location: ?site=car_setting');
    }
    elseif(isset($_POST['driver2']))
    {
        $db->setTeamDriver($user['tea_id'], $_POST['driver2'], 2);
        $_SESSION['tab'] = 1;
        header('Location: ?site=car_setting');
    }
    elseif(isset($_POST['driver3']))
    {
        $db->setTeamDriver($user['tea_id'], $_POST['driver3'], 3);
        $_SESSION['tab'] = 2;
        header('Location: ?site=car_setting');
    }
    else
    {
        $drivers = $db->getDriversOfTeam($user['tea_id']);
        $car1_old = $db->getItemsFromCar($user['tea_id'], 1);
        $car1 = car_items($car1_old);
        $car2_old = $db->getItemsFromCar($user['tea_id'], 2);
        $car2 = car_items($car2_old);
        $car3_old = $db->getItemsFromCar($user['tea_id'], 3);
        $car3 = car_items($car3_old);
        foreach($car3 as $_item)
        {
        	if(array_key_exists('id', $_item))
        	{
        		if($_item['tuneup'] < 100)
        			$db->changeitemtuneup($_item['id'], 100);
        	}
        }
        
        $smarty->assign('driver1', 0);
        $smarty->assign('driver2', 0);
        $smarty->assign('driver3', 0);
        $dri = $db->getDriver($team['driver1']);
        $smarty->assign('driver_cou1', $dri['cou_id']);
        $dri = $db->getDriver($team['driver2']);
        $smarty->assign('driver_cou2', $dri['cou_id']);
        $dri = $db->getDriver($team['driver3']);
        $smarty->assign('driver_cou3', $dri['cou_id']);
        $smarty->assign('driver1', $team['driver1']);
        $smarty->assign('driver2', $team['driver2']);
        $smarty->assign('driver3', $team['driver3']);
    }
    
    //drivers and risk are only editable before qualification
    $not_editable = false;
    //if(count($db->isQualificationOrRace($user['ins_id'], 1)) != 0)
    //    $not_editable = true;

    $smarty->assign('rand', rand(0,9999999));
    $smarty->assign('not_editable', $not_editable);
	$smarty->assign('tab', $_SESSION['tab']);
    $smarty->assign('drivers', $drivers);
    $smarty->assign('car1', $car1);
    $smarty->assign('car2', $car2);
    $smarty->assign('car3', $car3);
    $smarty->assign('ins_id', $user['ins_id']);
    $smarty->assign('tea_id', $team['id']);
    $smarty->assign('content', 'car_setting.tpl');