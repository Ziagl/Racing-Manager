<?php
    $drivers = array();
    $trainings = array();

    if(isset($_POST['monday']) && isset($_POST['driver']))
    {
    	if($_POST['monday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['monday'], 0);
        else
        	$db->deleteDriTra($_POST['driver'], 0);
        if($_POST['tuesday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['tuesday'], 1);
        else
        	$db->deleteDriTra($_POST['driver'], 1);
        if($_POST['wednesday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['wednesday'], 2);
        else
        	$db->deleteDriTra($_POST['driver'], 2);
        if($_POST['thursday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['thursday'], 3);
        else
        	$db->deleteDriTra($_POST['driver'], 3);
        if($_POST['friday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['friday'], 4);
        else
        	$db->deleteDriTra($_POST['driver'], 4);
        if($_POST['saturday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['saturday'], 5);
        else
        	$db->deleteDriTra($_POST['driver'], 5);
        if($_POST['sunday'] != '')
        	$db->insertDriTra($_POST['driver'], $_POST['sunday'], 6);
        else
        	$db->deleteDriTra($_POST['driver'], 6);

		$drivers = $db->getDriversOfTeam($user['tea_id']);
		$array_size = count($drivers);
		for($i = 0; $i < $array_size; ++$i)
		{
			if($drivers[$i]['id'] == $_POST['driver'])
			{
				$_SESSION['last_car'] = $i;
				break;
			}
		}
		
        unset($_POST['monday']);
        unset($_POST['tuesday']);
        unset($_POST['wednesday']);
        unset($_POST['thursday']);
        unset($_POST['friday']);
        unset($_POST['saturday']);
        unset($_POST['sunday']);

        header('Location: ?site=driver_training');
    }
    else
    {
        $drivers_old = $db->getDriversOfTeam($user['tea_id']);
        foreach($drivers_old as $driver)
        {
            $days_old = $db->getDriTra($driver['id']);
            $days = array(0, 0, 0, 0, 0, 0, 0);
            $array_size = count($days_old);
            for($i = 0; $i < $array_size; $i++)
            	$days[$days_old[$i]['day']] = $days_old[$i]['tra_id'];
            $count = count($days);
            $driver['monday'] = $days[0];
            $driver['monday_text'] = training_to_text($days[0], 1, $db);
            $driver['tuesday'] = $days[1];
            $driver['tuesday_text'] = training_to_text($days[1], 1, $db);
            $driver['wednesday'] = $days[2];
            $driver['wednesday_text'] = training_to_text($days[2], 1, $db);
            $driver['thursday'] = $days[3];
            $driver['thursday_text'] = training_to_text($days[3], 1, $db);
            $driver['friday'] = $days[4];
            $driver['friday_text'] = training_to_text($days[4], 1, $db);
            $driver['saturday'] = $days[5];
            $driver['saturday_text'] = training_to_text($days[5], 2, $db);
            $driver['sunday'] = $days[6];
            $driver['sunday_text'] = training_to_text($days[6], 2, $db);
            $drivers[] = $driver;
        }
        $trainings = $db->getTrainings();
    }

	$smarty->assign('last_car', isset($_SESSION['last_car'])?$_SESSION['last_car']:1);
    $smarty->assign('trainings', $trainings);
    $smarty->assign('drivers', $drivers);
    $smarty->assign('content', 'driver_training.tpl');