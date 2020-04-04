<?php
    $qualification_laps = $db->isQualificationOrRace($user['ins_id'], 1);
    
    $params = $db->getParams($user['ins_id']);
    
    $league = $team['league'];//show own league
    if(isset($_SESSION['league']))	
    	$league = $_SESSION['league'];
        
    if(isset($_POST['league']))//or selected league
    {
	    $league = $_POST['league'];
	    $_SESSION['league'] = $league;
    }
        
    $result = $db->getInstanceQualification($user['ins_id']);
    $result = unserialize($result['last_qualification']);
    //$result = $result[$team['league']-1];
    $result = $result[$league-1];
    
    //replace place holder with line highlighter for own drivers
    $array_size = count($result);
    for($i = 0; $i < $array_size; ++$i)
    {
    	$array_size1 = count($result[$i]);
    	for($j = 0; $j < $array_size1; ++$j)
    	{
        	$result[$i][$j] = str_replace("line-".$user['tea_id'], "line_highlight", $result[$i][$j]);
        }
    }
    
    $array = array();
    
    //first 10 (q3)
    $grid_array = $result[2];
    $grid = $grid_array[count($grid_array) - 1];
    $grid = str_replace(" class='mobile_invisible_low'","", $grid);
    $grid = str_replace(" class='mobile_invisible_high'","", $grid);
    $grid = str_replace(" align='right'","", $grid);
    $grid = str_replace("<span class='nowrapping'>","",$grid);
    $grid = str_replace("</span>","",$grid);
    $grid = str_replace("<td>","§", $grid);
    $grid = strip_tags($grid);
    $grid = explode("§",$grid);

    //1..position
    //2..name
    //3..team
    //5..fastest lap
    $counter = 0;
    $i = 0;
    $array_size = count($grid);
    while($i < $array_size)
    {
    	switch($counter)
    	{
    		case 0: $line = array(); $line['ins_id'] = $user['ins_id']; break;
    		case 1: $line['position'] = $grid[$i]; break;
    		case 3: $line['name'] = $grid[$i]; break;
    		case 4: $line['team'] = $grid[$i];
    				$_team = $db->getTeamByName($grid[$i], $user['ins_id']);
    				$line['color'] = $_team['color1'];
    				$line['highlight'] = 0;
	    				if($_team['id'] == $user['tea_id'])
	    					$line['highlight'] = 1;
    				$_drivers = $db->getDriversOfTeam($_team['id']);
    				if(count($_drivers) == 0)
    					$_drivers = $db->getAIDriversOfTeam($_team['id']);
    				foreach($_drivers as $_driver)
    				{
						if($_driver['firstname']." ".$_driver['lastname'] == $line['name'])
						{
							$line['picture'] = $_driver['picture'];
							break;
						}
    				}
    				break;
    		case 8: $line['laptime'] = $grid[$i]; break;
    		case 9: $line['diff'] = $grid[$i]; $array[] = $line; $counter = 0; break;
		}
    	++$counter;
    	++$i;
    }
    
    //next (from q2 and q1)
    for($j = 1; $j >= 0; $j--)
    {
	    $max = count($array);
	    
	    $grid_array = $result[$j];
	    $grid = $grid_array[count($grid_array) - 1];
	    $grid = str_replace(" class='mobile_invisible_low'","", $grid);
	    $grid = str_replace(" class='mobile_invisible_high'","", $grid);
	    $grid = str_replace(" align='right'","", $grid);
	    $grid = str_replace("<span class='nowrapping'>","",$grid);
	    $grid = str_replace("</span>","",$grid);
	    $grid = str_replace("<td>","§", $grid);
	    
	    //translations
		$grid = str_replace('Disqualification', Translator::_translate('Disqualification'), $grid);
		$grid = str_replace('tr_race_training_setup_hard', Translator::_translate('tr_race_training_setup_hard'), $grid);
		$grid = str_replace('tr_race_training_setup_soft', Translator::_translate('tr_race_training_setup_soft'), $grid);
	    
	    $grid = strip_tags($grid);
	    $grid = explode("§",$grid);
	    
	    //1..position
	    //2..name
	    //3..team
	    //5..fastest lap
	    $counter = 0;
	    $i = 0;
	    $k = 0;
	    $array_size = count($grid);
	    while($i < $array_size)
	    {
	    	switch($counter)
	    	{
	    		case 0: $line = array(); $line['ins_id'] = $user['ins_id']; break;
	    		case 1: $line['position'] = $grid[$i]; break;
	    		case 3: $line['name'] = $grid[$i]; break;
	    		case 4: $line['team'] = $grid[$i]; 
	    				$_team = $db->getTeamByName($grid[$i], $user['ins_id']);
	    				$line['color'] = $_team['color1'];
	    				$line['highlight'] = 0;
	    				if($_team['id'] == $user['tea_id'])
	    					$line['highlight'] = 1;
						$_drivers = $db->getDriversOfTeam($_team['id']);
						if(count($_drivers) == 0)
							$_drivers = $db->getAIDriversOfTeam($_team['id']);
						foreach($_drivers as $_driver)
						{
							if($_driver['firstname']." ".$_driver['lastname'] == $line['name'])
							{
								$line['picture'] = $_driver['picture'];
								break;
							}
						}
    					break;
	    		case 8: $line['laptime'] = $grid[$i]; break;
	    		case 9: $line['diff'] = $grid[$i]; if($k >= $max) $array[] = $line; $counter = 0; $k++; break;
			}
	    	++$counter;
	    	++$i;
	    }
    }

	$smarty->assign('league', $_SESSION['league']==null?1:$_SESSION['league']);
    $smarty->assign('grid', $array);
    $smarty->assign('content', 'race_qualification_grid.tpl');