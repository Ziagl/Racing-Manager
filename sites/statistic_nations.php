<?php
	function cmp($a, $b)
	{
		return $a['points'] < $b['points'];
	}

	$countries = $db->getCountries();
	$drivers = $db->getDrivers($user['ins_id'], "", " id asc");
	
	for($i = 0; $i < count($countries); ++$i)
	{
		$countries[$i]['points'] = 0;
		$countries[$i]['wins'] = 0;	
		$countries[$i]['podium'] = 0;
		$countries[$i]['pole'] = 0;
		$countries[$i]['out'] = 0;
		
		for($j = 0; $j < count($drivers); ++$j)
		{
			if($drivers[$j]['cou_id'] == $countries[$i]['id'])
			{
				$countries[$i]['points'] = $countries[$i]['points'] + $drivers[$j]['points'];
				$countries[$i]['wins'] = $countries[$i]['wins'] + $drivers[$j]['f1_wins'] + $drivers[$j]['f2_wins'] + $drivers[$j]['f3_wins'];
				$countries[$i]['podium'] = $countries[$i]['podium'] + $drivers[$j]['f1_podium'] + $drivers[$j]['f2_podium'] + $drivers[$j]['f3_podium'];
				$countries[$i]['pole'] = $countries[$i]['pole'] + $drivers[$j]['f1_pole'] + $drivers[$j]['f2_pole'] + $drivers[$j]['f3_pole'];
				$countries[$i]['out'] = $countries[$i]['out'] + $drivers[$j]['f1_out'] + $drivers[$j]['f2_out'] + $drivers[$j]['f3_out'];
			}
		}
	}
	
	usort($countries, "cmp");
	
	$smarty->assign('countries', $countries);
	$smarty->assign('content', 'statistic_nations.tpl');
