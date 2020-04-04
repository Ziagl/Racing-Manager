<?php
	$tracks = $db->getTracksOfCalendar($user['ins_id']);
	$team = $db->getTeam($user['tea_id']);
	
	$array_size = count($tracks);
	for($i = 0; $i < $array_size; ++$i)
	{
		//f1
		$dri_id = $tracks[$i]['f1_last_winner'];
		$tracks[$i]['f1_last_winner_info'] = '';
		if($dri_id)
		{
			$driver = $db->getDriver($dri_id);
			$tracks[$i]['f1_last_winner_info'] = '<a href="?site=driverinfo&id='.$dri_id.'">'.$driver['firstname'].' '.$driver['lastname'].'</a>';
		}
		//f2
		$dri_id = $tracks[$i]['f2_last_winner'];
		$tracks[$i]['f2_last_winner_info'] = '';
		if($dri_id)
		{
			$driver = $db->getDriver($dri_id);
			$tracks[$i]['f2_last_winner_info'] = '<a href="?site=driverinfo&id='.$dri_id.'">'.$driver['firstname'].' '.$driver['lastname'].'</a>';
		}
		//f3
		$dri_id = $tracks[$i]['f3_last_winner'];
		$tracks[$i]['f3_last_winner_info'] = '';
		if($dri_id)
		{
			$driver = $db->getDriver($dri_id);
			$tracks[$i]['f3_last_winner_info'] = '<a href="?site=driverinfo&id='.$dri_id.'">'.$driver['firstname'].' '.$driver['lastname'].'</a>';
		}
		$country = $db->getCountry($tracks[$i]['cou_id']);
		$tracks[$i]['country'] = $country['name'];
		$tracks[$i]['country_picture'] = $country['picture'];
		$tracks[$i]['date'] = date('d.m.Y', strtotime($tracks[$i]['race_date']));
	}
	
	$smarty->assign('league', $team['league']);
	$smarty->assign('tracks', $tracks);
	$smarty->assign('content', 'statistic_track.tpl');
