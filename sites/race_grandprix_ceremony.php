<?php
	$get_track = null;
    
    if(isset($_GET['track']))
    {
    	$get_track = $_GET['track'];
    }
    
    $league = $team['league'];//show own league
	if(isset($_SESSION['league']))	
		$league = $_SESSION['league'];
		
	if(isset($_POST['league']))//or selected league
	{
		$league = $_POST['league'];
		$_SESSION['league'] = $league;
	}

    if($get_track != null)
    {
    	$track = $db->getTrackById($get_track);
    	$result = unserialize($track['last_race']);
    }
    else
    {
		$result = $db->getInstanceRace($user['ins_id']);
		$result = unserialize($result['last_race']);
    }
    $result = $result[$league-1];
    
    $points = $db->getPoints($user['ins_id']);
    
    //replace place holder with line highlighter for own drivers
    $last = count($result) - 1;
    $result = $result[$last];
    
    $result = str_replace("</tr>", "<td>###</td></tr>", $result);
    $result = str_replace("&#9650;", "", $result);
    $result = str_replace("&#9660;", "", $result);
    
    $new_result = "";
    
    $winner_old = array();
    
    $splits = explode("</tr>", $result);
    $j = 1;
    foreach($splits as $split)
    {	
    	if(strlen($split) > 1)
    	{
    		$cols = explode("</td>", $split);
			$team_name = strip_tags($cols[4]);
			$driver_name = strip_tags($cols[3]);
			$_team = $db->getTeamByName($team_name, $user['ins_id']);

			$_drivers = $db->getDriversOfTeam($_team['id']);
			if($_drivers == null)
				$_drivers = $db->getAIDriversOfTeam($_team['id']);
			
			foreach($_drivers as $d)
			{
				if($d['firstname'].' '.$d['lastname'] == $driver_name)
				{
					$winner_old[] = array(
						'tea_id' => $_team['id'],
						'car_number' => ($_team['driver1'] == $d['id'])?1:2,
						'ins_id' => $_team['ins_id'],
						'color1' => $_team['color1'],
					);
					break;
				}
			}
    		
    		if(strpos($split, "class='line-".$user['tea_id']."'") != 0)
				$new_result.= "<tr class='line_highlight' style='color:#".$_team['color1'].";font-weight:bold'>";
			else
				$new_result.= "<tr style='color:#".$_team['color1'].";font-weight:bold'>";

			$i = 0;
			$pos = -1;
			$colspan_set = false;
			foreach($cols as $col)
			{	
				$colspan = 0;
				$strpos = strpos($col, 'colspan');
				if($strpos !== FALSE)
				{
					$colspan = substr($col, $strpos + 9, 1);
					$colspan_set = true;
				}
				if($i == 11 && $colspan_set)
					continue;
				//we do not need last lap and relative difference columns
				if($i == 9 || $i == 10 ||$i == 14)
				{
					$i++;
					continue;
				}
				
				if(strpos($col, "class='fastest_time_marker") != 0)
					if($i == 4 || $i == 5 || $i == 8 || $i == 9 || $i == 11)
						$new_result.= "<td class='fastest_time_marker mobile_invisible_low'>";
				 	else
				 		if($i == 6 || $i == 10)
				 			$new_result.= "<td class='fastest_time_marker mobile_invisible_high'>";
				 		else
							$new_result.= "<td class='fastest_time_marker'>";
				else
					if($i == 4 || $i == 5 || $i == 8 || $i == 9 || $i == 11)
						$new_result.= "<td class='mobile_invisible_low'>";
				 	else
				 		if($i == 6 || $i == 10)
				 			$new_result.= "<td class='mobile_invisible_high'>";
				 		else
				 		{
							if($strpos !== FALSE)
							{
								$new_result.= "<td colspan='".$colspan."'>";
							}
							else
							{
								$new_result.= "<td>";
							}
						}
				
				if($i == 2)
				  $val = str_replace("<td>","",$col);
				else
				  $val = strip_tags($col);
				  
				if($i == 0)
					$pos = $val = $j;
				if($i == 13)
					if($pos > count($points))
						$val = '';
					else
						$val = $points[$pos - 1]['points'];
				
				$new_result.= $val;
				
				$new_result.= "</td>";
				++$i;
				$i+=$colspan;
			}
			if($colspan_set)
			{
				$new_result.= "<td class='mobile_invisible_low'>".strip_tags($cols[10])."</td><td class='mobile_invisible_low'></td>";
			}
			$new_result.= "</tr>";
			
			//translate
        	$new_result = str_replace('Lap', Translator::_translate('Lap'), $new_result);
        	$new_result = str_replace('Broken vehicle body', Translator::_translate('Broken vehicle body'), $new_result);
        	$new_result = str_replace('Brake failure', Translator::_translate('Brake failure'), $new_result);
        	$new_result = str_replace('Engine failure', Translator::_translate('Engine failure'), $new_result);
        	$new_result = str_replace('Aerodynamics failure', Translator::_translate('Aerodynamics failure'), $new_result);
        	$new_result = str_replace('Electrical failure', Translator::_translate('Electrical failure'), $new_result);
        	$new_result = str_replace('Broken suspension', Translator::_translate('Broken suspension'), $new_result);
        	$new_result = str_replace('Transmission damage', Translator::_translate('Transmission damage'), $new_result);
        	$new_result = str_replace('Hydraulic failure', Translator::_translate('Hydraulic failure'), $new_result);
        	$new_result = str_replace('Kers suspension', Translator::_translate('Kers suspension'), $new_result);
        	$new_result = str_replace('DRS damage', Translator::_translate('DRS damage'), $new_result);
        	$new_result = str_replace('Driver failure', Translator::_translate('Driver failure'), $new_result);
        	$new_result = str_replace('Disqualification', Translator::_translate('Disqualification'), $new_result);
        	$new_result = str_replace('Crash', Translator::_translate('Crash'), $new_result);
        	$new_result = str_replace('No fuel', Translator::_translate('No fuel'), $new_result);
        	$new_result = str_replace('Puncture', Translator::_translate('Puncture'), $new_result);
        	$new_result = str_replace('tr_race_training_setup_hard', Translator::_translate('tr_race_training_setup_hard'), $new_result);
        	$new_result = str_replace('tr_race_training_setup_soft', Translator::_translate('tr_race_training_setup_soft'), $new_result);
			
			$j++;
	    }
    }
    
    $winner = array();
    foreach($winner_old as $w)
    {
    	$_team = $db->getTeam($w['tea_id']);
    	$_driver = $db->getDriver($w['car_number']==1?$_team['driver1']:$_team['driver2']);
    	$w['team_name'] = $_team['name'];
    	$w['driver_name'] = $_driver['firstname']." ".$_driver['lastname'];
    	$w['team_picture'] = $_team['picture'];
    	$w['team_id'] = $_team['id'];
    	$w['driver_picture'] = $_driver['picture'];
    	$_country = $db->getCountry($_team['cou_id']);
    	$w['team_anthem'] = $_country['anthem'];
    	$w['team_flag'] = $_country['picture'];
    	$_country = $db->getCountry($_driver['cou_id']);
    	$w['driver_anthem'] = $_country['anthem'];
    	$w['driver_flag'] = $_country['picture'];
	    $winner[] = $w;
    }
    
    $smarty->assign('trackinfo', $get_track==null?'':"&track=".$get_track);
    $smarty->assign('league', $league);
	$smarty->assign('winner', $winner);
	$smarty->assign('result', $new_result);
	$smarty->assign('content', 'race_grandprix_ceremony.tpl');