<?php
	//default values for own drivers
	$driver1 = array($team['id'], 1);
	$driver2 = array($team['id'], 2);
	
	if(isset($_POST['selected_driver1']))
    {
        $driver1 = explode('#', $_POST['selected_driver1']);
    }
    if(isset($_POST['selected_driver2']))
    {
        $driver2 = explode('#', $_POST['selected_driver2']);
    }
	
	//driverlist of league
	$_teams = $db->getTeamsOfLeague($user['ins_id'], $team['league'], "class asc");
	$_drivers = array();
	foreach($_teams as $_team)
	{
		$driver = $db->getDriver($_team['driver1']);
		if($driver)
		{
			$driver['team_id'] = $_team['id'];
			$driver['team_name'] = $_team['name'];
			$driver['car_number'] = 1;
			$driver['param_id'] = $driver['team_id']."#".$driver['car_number'];
			$_drivers[] = $driver;
		}
		$driver = $db->getDriver($_team['driver2']);
		if($driver)
		{
			$driver['team_id'] = $_team['id'];
			$driver['team_name'] = $_team['name'];
			$driver['car_number'] = 2;
			$driver['param_id'] = $driver['team_id']."#".$driver['car_number'];
			$_drivers[] = $driver;
		}
	}
	
	//data for both cars
	$car1 = $db->getSetupForDriver($user['ins_id'], $team['league'], 2, $driver1[0], $driver1[1]);
	$car2 = $db->getSetupForDriver($user['ins_id'], $team['league'], 2, $driver2[0], $driver2[1]);
	
	//get arrays out of db data
	$car1_array = create_analyze_arrays($car1, $db);
	$car2_array = create_analyze_arrays($car2, $db);
	
	//compute differnces for each row
	$difference = array();
	$array_size = count($car1_array[1]);
	for($i = 0; $i < $array_size; ++$i)
	{
		$diff = array('time' => 0, 'time_readable' => '-');
		if(count($car1_array[1]) > 0 && count($car2_array[1]) > 0)
		{
			$diff['time'] = $car1_array[1][$i]['lap_time'] - $car2_array[1][$i]['lap_time'];
			if($diff['time'] > 0)
				$diff['time_readable'] = "<span style='color: red; white-space: nowrap;'>&#9660; +".time_to_string($diff['time'])."</span>";//▲
			if($diff['time'] < 0)
				$diff['time_readable'] = "<span style='color: green; white-space: nowrap;'>&#9650; ".time_to_string($diff['time'])."</span>";//▼
		}
		$difference[] = $diff;
	}
	$difference_sum = 0;
	if(count($car1_array) > 0 && count($car2_array) > 0)
	{
		if(count($car1_array[1]) > 0 && count($car2_array[1]) > 0)
		{
			//add racetime diff
			$diff = array();
			$diff['time'] = $car1_array[1][count($car1_array[1]) - 1]['round_time'] - $car2_array[1][count($car2_array[1]) - 1]['round_time'];
			if($diff['time'] > 0)
				$diff['time_readable'] = "<span style='color: red; white-space: nowrap;'>&#9660; +".time_to_string($diff['time'])."</span>";//▲
			if($diff['time'] < 0)
				$diff['time_readable'] = "<span style='color: green; white-space: nowrap;'>&#9650; ".time_to_string($diff['time'])."</span>";//▼
			$difference_sum = $diff['time_readable'];
		}
	}
	
	//create raw chart data
	$car1_chart = normalize_chart_values($car1_array[0]);
	$car2_chart = normalize_chart_values($car2_array[0]);
	
	$daten = false;
	if(count($car1) > 0 || count($car2) > 0)
		$daten = true;
	
	$smarty->assign('difference', $difference);
	$smarty->assign('difference_sum', $difference_sum);
	$smarty->assign('driver1_active', $driver1[0]."#".$driver1[1]);
	$smarty->assign('driver2_active', $driver2[0]."#".$driver2[1]);
	$smarty->assign('drivers', $_drivers);
	$smarty->assign('daten', $daten);
	$smarty->assign('laps', count($car1_array[0]));
	$smarty->assign('car1_data', $car1_array[1]);
	$smarty->assign('car2_data', $car2_array[1]);
	$smarty->assign('car1_chart', tire_values_to_chart_string($car1_chart));
	$smarty->assign('car2_chart', tire_values_to_chart_string($car2_chart));
	$smarty->assign('content', 'race_analyze.tpl');
