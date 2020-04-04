<?php
	/*
	 * switches languages of all texts from game
	 * params: language_id for example 0 for german and 1 for english
	 */
	function setLanguage($language_id)
	{
		global $language;
		switch($language_id)
        {
        	case 0: $language = 'de'; Translator::init($language); break;
        	case 1: $language = 'en'; Translator::init($language); break;
        }
	}//setLanguage

	/*
	 * generates a passwort for password forgot function
	 * params: length and strength of generated password
	 * return: password
	 */
    function generatePassword($length=9, $strength=0)
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '123456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }//generatePassword
    
    /*
     * replaces german Umlaute
     */
    function uml_replace($str)
    {    	
    	$str = str_replace('ä', 'ae', $str);
    	$str = str_replace('ö', 'oe', $str);
    	$str = str_replace('ü', 'ue', $str);
    	$str = str_replace('Ä', 'Ae', $str);
    	$str = str_replace('Ö', 'Oe', $str);
    	$str = str_replace('Ü', 'Ue', $str);
    	$str = str_replace('ß', 'ss', $str);
    	
    	return $str;
    }//uml_replace
    
    /*
     * function that gets a time string
     * and change it to the next full hour
     */
    function roundToNextHour($dateString) {
		$date = new DateTime( $dateString );
		$minutes = $date->format('i');
		$seconds = $date->format('s');
		if($minutes > 0){
			$date->modify("+1 hour");
			$date->modify('-'.$minutes.' minutes');
			$date->modify('-'.$seconds.' seconds');
		}
		return $date->format('Y-m-d H:i:s');
	}//roundToNextHour
    
    /*
     * function that translates english finance details into german
     * params: string in english, database object
     * return: german/english translated string
     */
    function translate_finance_detail($str, $db, $language_id)
    {
		//converts textual information to readable
		$ret = "";
		$array = explode(" ", $str);
		
		if($language_id == 0) //german
		{
			$array_size = count($array);
			for($i = 0; $i < $array_size; ++$i)
			{
				if($array[$i] == "randomevent")
				{
					$ret.= "Zufallsereignis";
					$i++;
				}
				if($array[$i] == "team")
				{
					$team = $db->getTeam($array[$i+1]);
					$ret.=$team['name'];
					$i++;
				}
				if($array[$i] == "repairs")
				{
					if($array[$i+1] == "item")
						$ret.=" repariert ";
				}
				if($array[$i] == "buys")
				{
					if($array[$i+1] == "item")
						$ret.=" kauft ";
					else
						$ret.=" verpflichtet ";
				}
				if($array[$i] == "pays")
				{
					$i++;
					if($array[$i] == "training")
					{
						$i++;
						if($array[$i] == "for")
						{
							$i++;
							if($array[$i] == "driver")
							{
								$i++;
								$driver = $db->getDriver($array[$i]);
								$ret.=" zahlt Training für ".$driver['firstname']." ".$driver['lastname'];
							}
						}
					}
				}
				if($array[$i] == "sells")
				{
					$ret.=" verkauft ";
					$i++;
				}
				if($array[$i] == "get")
				{
					$i++;
					if($array[$i] == "money")
					{
						$i++;
						if($array[$i] == "from")
						{
							$i++;
							if($array[$i] == "main")
							{
								$ret.=" erhält Geld vom Hauptsponsor ";
							}
							if($array[$i] == "tire")
							{
								$ret.=" erhält Geld vom Reifensponsor ";
							}
						}
					}
				}
				if($array[$i] == "pays")
				{
					$i++;
					if($array[$i] == "bonus")
					{
						$i++;
						if($array[$i] == "for")
						{
							$i++;
							$ret.=" zahlt Punktprämie für ".$array[$i]." ";
							$i++;
							if($array[$i] == "points")
							{
								$ret.="Punkte";
							}
						}
					}
					if($array[$i] == "mechanic")
					{
						$i++;
						$mechanic = $db->getMechanic($array[$i]);
						$ret.=" zahlt ".$mechanic['firstname']." ".$mechanic['lastname'];
						$i++;
						if($array[$i] == "bonus")
						{
							$i++;
							if($array[$i] == "for")
							{
								$i++;
								$ret.=" zahlt Punktprämie für ".$array[$i]." ";
								$i++;
								if($array[$i] == "points")
								{
									$ret.="Punkte";
								}
							}
						}
					}
					if($array[$i] == "driver")
					{
						$i++;
						$driver = $db->getDriver($array[$i]);
						$ret.=" zahlt ".$driver['firstname']." ".$driver['lastname'];
						$i++;
						if($array[$i] == "bonus")
						{
							$i++;
							if($array[$i] == "for")
							{
								$i++;
								$ret.=" zahlt Punktprämie für ".$array[$i]." ";
								$i++;
								if($array[$i] == "points")
								{
									$ret.="Punkte";
								}
							}
						}
					}
				}
				
				if($array[$i] == "driver")
				{
					$driver = $db->getDriver($array[$i+1]);
					$ret.="den Fahrer ".$driver['firstname']." ".$driver['lastname'];
					$i++;
				}
				if($array[$i] == "mechanic")
				{
					$mechanic = $db->getMechanic($array[$i+1]);
					$ret.="den Mechaniker ".$mechanic['firstname']." ".$mechanic['lastname'];
					$i++;
				}
				if($array[$i] == "item")
				{
					$item = $db->getItem($array[$i+1]);
					$item_name_array = explode(" ", $item['name']);
					$ret.=Translator::_translate($item_name_array[0]);
					$ret.=" ".$item_name_array[1];
					$i++;
				}
				if($array[$i] == "sponsor")
				{
					if($array[$i-1] == "main")
					{
						$sponsor = $db->getSponsor($array[$i+1]);
					}
					if($array[$i-1] == "tire")
					{
						$sponsor = $db->getTire($array[$i+1]);
					}
					$ret.=$sponsor['name'];
					$i++;
				}
				
				if($array[$i] == "bonus")
				{
					$i++;
					if($array[$i] == "for")
					{
						$i++;
						$ret.=" Siegprämie für ";
						$ret.="Platzierung";
					}
				}
				
				if($array[$i] == "youthdriver")
				{
					$ret.="Jugendfahrer";
				}
			}
		}//german
		
		if($language_id == 1) //english
		{
			$array_size = count($array);
			for($i = 0; $i < $array_size; ++$i)
			{
				if($array[$i] == "randomevent")
				{
					$ret.= "Random event";
					$i++;
				}
				if($array[$i] == "team")
				{
					$team = $db->getTeam($array[$i+1]);
					$ret.=$team['name'];
					$i++;
				}
				if($array[$i] == "buys")
				{
					if($array[$i+1] == "item")
						$ret.=" buys ";
					else
						$ret.=" engages ";
				}
				if($array[$i] == "pays")
				{
					$i++;
					if($array[$i] == "training")
					{
						$i++;
						if($array[$i] == "for")
						{
							$i++;
							if($array[$i] == "driver")
							{
								$i++;
								$driver = $db->getDriver($array[$i]);
								$ret.=" pays training for ".$driver['firstname']." ".$driver['lastname'];
							}
						}
					}
				}
				if($array[$i] == "sells")
				{
					$ret.=" sells ";
					$i++;
				}
				if($array[$i] == "get")
				{
					$i++;
					if($array[$i] == "money")
					{
						$i++;
						if($array[$i] == "from")
						{
							$i++;
							if($array[$i] == "main")
							{
								$ret.=" gets money from main sponsor ";
							}
							if($array[$i] == "tire")
							{
								$ret.=" gets money from tire sponsor ";
							}
						}
					}
				}
				if($array[$i] == "pays")
				{
					$i++;
					if($array[$i] == "bonus")
					{
						$i++;
						if($array[$i] == "for")
						{
							$i++;
							$ret.=" pays bonus for ".$array[$i]." ";
							$i++;
							if($array[$i] == "points")
							{
								$ret.="points";
							}
						}
					}
					if($array[$i] == "mechanic")
					{
						$i++;
						$mechanic = $db->getMechanic($array[$i]);
						$ret.=" pays ".$mechanic['firstname']." ".$mechanic['lastname'];
						$i++;
						if($array[$i] == "bonus")
						{
							$i++;
							if($array[$i] == "for")
							{
								$i++;
								$ret.=" pays bonus for ".$array[$i]." ";
								$i++;
								if($array[$i] == "points")
								{
									$ret.="points";
								}
							}
						}
					}
					if($array[$i] == "driver")
					{
						$i++;
						$driver = $db->getDriver($array[$i]);
						$ret.=" pays ".$driver['firstname']." ".$driver['lastname'];
						$i++;
						if($array[$i] == "bonus")
						{
							$i++;
							if($array[$i] == "for")
							{
								$i++;
								$ret.=" pays bonus for ".$array[$i]." ";
								$i++;
								if($array[$i] == "points")
								{
									$ret.="points";
								}
							}
						}
					}
				}
				
				if($array[$i] == "driver")
				{
					$driver = $db->getDriver($array[$i+1]);
					$ret.=" driver ".$driver['firstname']." ".$driver['lastname'];
					$i++;
				}
				if($array[$i] == "mechanic")
				{
					$mechanic = $db->getMechanic($array[$i+1]);
					$ret.=" mechanic ".$mechanic['firstname']." ".$mechanic['lastname'];
					$i++;
				}
				if($array[$i] == "item")
				{
					$item = $db->getItem($array[$i+1]);
					$ret.=$item['name'];
					$i++;
				}
				if($array[$i] == "sponsor")
				{
					if($array[$i-1] == "main")
					{
						$sponsor = $db->getSponsor($array[$i+1]);
					}
					if($array[$i-1] == "tire")
					{
						$sponsor = $db->getTire($array[$i+1]);
					}
					$ret.=$sponsor['name'];
					$i++;
				}
				
				if($array[$i] == "bonus")
				{
					$i++;
					if($array[$i] == "for")
					{
						$i++;
						$ret.=" bonus for ";
						$ret.="position";
					}
				}
				
				if($array[$i] == "youthdriver")
				{
					$ret.="youthdriver";
				}
			}
		}//english
		return $ret;
    }//translate_finance_detail
    
    /*
     * computes current timestamp for race computation time tracking
     * params: no
     * return: current time as float
     */
    function microtime_float()
	{
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}//microtime_float
    
    /*
     * generates a table for training week with detailed information
     * params: training id, factor (week day or weekend), database object
     * return: html string of table data
     */
    function training_to_text($tra_id, $factor, $db)
    {
	    $ret = '';
	    $training = $db->getTraining($tra_id);
	    
	    if($training['speed'] != 0)
	    	$ret.= "<td class='".($training['speed']>0?"value_green":"value_red")."'>".($training['speed']>0?"+":"").($factor*$training['speed'])."%</td>";
	    else
	    	$ret.= "<td class='value_red'>-8%</td>";
	    if($training['persistence'] != 0)
	    	$ret.= "<td class='".($training['persistence']>0?"value_green":"value_red")."'>".($training['persistence']>0?"+":"").($factor*$training['persistence'])."%</td>";
	    else
	    	$ret.= "<td class='value_red'>-8%</td>";
	    if($training['stamina'] != 0)
	    	$ret.= "<td class='".($training['stamina']>0?"value_green":"value_red")."'>".($training['stamina']>0?"+":"").($factor*$training['stamina'])."%</td>";
	    else
	    	$ret.= "<td class='value_red'>-8%</td>";
	    if($training['freshness'] != 0)
	    	$ret.= "<td class='".($training['freshness']>0?"value_green":"value_red")."'>".($training['freshness']>0?"+":"").($factor*$training['freshness'])."%</td>";
	    else
	    	$ret.= "<td class='value_red'>-16%</td>";
	    if($training['morale'] != 0)
	    	$ret.= "<td class='".($training['morale']>0?"value_green":"value_red")."'>".($training['morale']>0?"+":"").($factor * $training['morale'])."%</td>";
	    else
	    	$ret.= "<td class='value_green'>+16%</td>";
	    if($training['cost'] > 0)
	    	$ret.= "<td>".$training['cost']." €</td>";
	    else
	    	$ret.= "<td></td>";
	    	
	    return $ret;
    }//training_to_text
    
    function translate_item($str)
    {
    	$strings = explode(" ", $str);
    	$ret = Translator::_translate($strings[0])." ".$strings[1];
    	
    	return $ret;
    }//translate_item
    
    /*
     * gets a value between 0 and 100 and sets css class to display it colorized
     * params: number (0-100)
     * return: css class as string
     */
    function get_css_color_class($value)
    {
	    if($value < 21) return "value_red";
	    if($value > 20 && $value < 41) return "value_orange";
	    if($value > 40 && $value < 61) return "value_yellow";
	    if($value > 60 && $value < 81) return "value_yellowgreen";
	    if($value > 80) return "value_green";
    }//get_css_color_class
    
    /*
     * generates css color classes for each driver value
     * params: driver array
     * return: extended driver array with css classes for each value
     */
    function add_color_class_driver($driver)
    {
	    $driver['speed_css'] = get_css_color_class($driver['speed']);
	    $driver['persistence_css'] = get_css_color_class($driver['persistence']);
	    $driver['experience_css'] = get_css_color_class($driver['experience']);
	    $driver['stamina_css'] = get_css_color_class($driver['stamina']);
	    $driver['freshness_css'] = get_css_color_class($driver['freshness']);
	    $driver['morale_css'] = get_css_color_class($driver['morale']);
	    return $driver;
    }//add_color_class_driver
    
    /*
     * generates css color classes for each mechanic value
     * params: mechanic array
     * return: extended mechanic array with css classes for each value
     */
    function add_color_class_mechanic($mechanic)
    {
	    $mechanic['pit_stop_css'] = get_css_color_class($mechanic['pit_stop']);
	    $mechanic['development_css'] = get_css_color_class($mechanic['development']);
	    $mechanic['morale_css'] = get_css_color_class($mechanic['morale']);
	    $mechanic['tires_css'] = get_css_color_class($mechanic['tires']);
	    $mechanic['setup_css'] = get_css_color_class($mechanic['setup']);
	    $mechanic['repair_css'] = get_css_color_class($mechanic['repair']);
	    if(isset($mechanic['pit_stop_current']))
	    	$mechanic['pit_stop_current_css'] = get_css_color_class($mechanic['pit_stop_current']);
	    if(isset($mechanic['development_current']))
	    	$mechanic['development_current_css'] = get_css_color_class($mechanic['development_current']);
	    if(isset($mechanic['tires_current']))
	    	$mechanic['tires_current_css'] = get_css_color_class($mechanic['tires_current']);
	    if(isset($mechanic['setup_current']))
	    	$mechanic['setup_current_css'] = get_css_color_class($mechanic['setup_current']);
	    if(isset($mechanic['repair_current']))
	    	$mechanic['repair_current_css'] = get_css_color_class($mechanic['repair_current']);
	    return $mechanic;
    }//add_color_class_mechanic
    
    /*
     * returns default image string (filename) if driver has no picture
     * params: driver array
     * return: driver array
     */
    function default_image($driver)
    {
    	if(array_key_exists('picture', $driver) && $driver['picture'] == '')
	    	$driver['picture'] = 'default.jpg';
	    return $driver;
    }//default_image

	/*
	 * number format functions for all different values
	 * params: an array, number of decimals
	 * return: same array, where certain columns are formatted with number format
	 */
    function number_format_Tablerow($s, $decimals = 0)
    {
        //array
        if(is_array($s))
        {
            if(isset($s['value']))
                $s['value'] = number_format($s['value'], $decimals, ',', '.');
            if(isset($s['wage']))
                $s['wage'] = number_format($s['wage'], $decimals, ',', '.');
            if(isset($s['bonus']))
                $s['bonus'] = number_format($s['bonus'], $decimals, ',', '.');
            if(isset($s['sell_value']))
                $s['sell_value'] = number_format($s['sell_value'], $decimals, ',', '.');
            if(isset($s['repair_value']))
                $s['repair_value'] = number_format($s['repair_value'], $decimals, ',', '.');
            if(isset($s['in_value']))
                $s['in_value'] = number_format($s['in_value'], $decimals, ',', '.');
            if(isset($s['out_value']))
                $s['out_value'] = number_format($s['out_value'], $decimals, ',', '.');
        }
        //no array
        else
        {
            $s =    number_format($s, $decimals, ',', '.');
        }
        return $s;
    }//number_format_Tablerow
    
    /*
     * converts tire values to chart string
     * params: tire value array
     * string: chart format string of values
     */
    function tire_values_to_chart_string($str_array, $meters = 0)
    {
	    $hard = "[";
	    $array_size = count($str_array);
        for($j = 0; $j < $array_size; ++$j)
        {
        	$value = $j+1;
        	if($meters > 0)
        		$value = intval(floor((($j+1) * $meters) / 1000));
        		
        	$hard.="[".($value).", ".$str_array[$j]."]";
	        if($j < $array_size - 1)
	        	$hard.=", "; 
        }
        $hard.= "]";
        
        return $hard;
    }//tire_values_to_chart_string
    
    
    function normalize_chart_values($array)
    {
    	$max = 0;
    	$min = 9999999;
    	foreach($array as $val)
    	{
    		if($max < $val)
    			$max = $val;
    		if($min > $val)
    			$min = $val;
    	}
    	$return = array();
    	foreach($array as $val)
    	{
    		$value = ($val - $min) / ($max - $min);
    		$return[] = $value;
    	}
    	return $return;
    }
    
    function create_analyze_arrays($array, $db)
    {
		$car_array = array();
		$car_data = array();
		$last_round_time = 0;
		$last_box = 0;
		foreach($array as $val)
		{
			$team = $db->getTeam($val['tea_id']);
			$driver = $db->getDriver($team['driver'.$val['car_number']]);
			$val['driver_name'] = $driver['firstname']." ".$driver['lastname'];
			$val['driver_team'] = $team['name'];
			                    
			//pit stop
			$val['box'] = 0;
			if($last_box != $val['pit_stop'])
			{
				$last_box = $val['pit_stop'];
				$val['box'] = 1;
			}
			//round time
			$round_time = $val['round_time'] - $last_round_time;
			$car_array[] = $round_time;
			$val['lap_time'] = $round_time;
			$val['round_time_readable'] = time_to_string($round_time);
			$car_data[] = $val;
			$last_round_time = $val['round_time'];
		}
		
		return array($car_array, $car_data);
    }//create_analyze_arrays
    
    /*
     * converts statistic values to chart string
     * params: statistic value array
     * string: chart format string of values
     */
    function statistic_values_to_chart_string($str_array, $type)
    {
	    $ret = "[";
	    $array_size = count($str_array);
        for($j = 0; $j < $array_size; ++$j)
        {
        	$date = DateTime::createFromFormat('Y-m-d H:i:s', $str_array[$j]['date']);
        	if($date)
        	{
        		$date = $date->format('U') * 1000;
        	}
        	else{
        		$date = DateTime::createFromFormat('Y-m-d', $str_array[$j]['date']);
        		if($date)
        		{
        			$date = $date->format('U') * 1000;
        		}
        		else
        		{
        			$date = "";
        		}
        	}
	        $ret.="["./*($j+1)*/$date.", ".$str_array[$j][$type]."]";
	        if($j < $array_size - 1)
	        	$ret.=", "; 
        }
        $ret.= "]";
        
        return $ret;
    }//statistic_values_to_chart_string

	/*
	 * gets all car parts by type of part
	 * params: car items array
	 * return: converted array with parts per type
	 */
    function car_items($car_items)
    {
        $ret = array();
        $items = array(
        	0 => Translator::_translate('tr_body'),
        	1 => Translator::_translate('tr_brake'),
        	2 => Translator::_translate('tr_engine'),
        	3 => Translator::_translate('tr_aerodynamics'),
        	4 => Translator::_translate('tr_electronics'),
        	5 => Translator::_translate('tr_suspension'),
        	6 => Translator::_translate('tr_gearbox'),
        	7 => Translator::_translate('tr_hydraulics'),
        	8 => Translator::_translate('tr_kers'),
        	9 => Translator::_translate('tr_drs')
        );
        foreach($items as $key => $value)
        {
            $item = array();
            $item['type'] = $key;
            $item['type_name'] = $value;
            $item['part'] = false;
            foreach($car_items as $c)
            {
                if($c['type'] == $key)
                {
                	$item['id'] = $c['id'];
                	$item['skill'] = $c['skill'];
                	$item['skill_max'] = $c['skill_max'];
                    $item['part'] = true;
                    $item['name'] = $c['name'];
                    $item['condition'] = $c['condition'];
                    $item['tuneup'] = $c['tuneup'];
                    break;
                }
            }
            $ret[] = $item;
        }

        return $ret;
    }//car_items
    
    function create_type_array($size)
    {
    	$ret = array();
    	for($i = 0; $i < $size; ++$i)
    		$ret[] = "Type ".$i;
    	return $ret;
    }
    
    function color_palette()
    {
    	return array("#000000","#000033","#000066","#000099","#0000cc","#0000ff","#003300","#003333","#003366","#003399","#0033cc","#0033ff","#006600","#006633","#006666","#006699","#0066cc","#0066ff","#009900","#009933","#009966","#009999","#0099cc","#0099ff","#00cc00","#00cc33","#00cc66","#00cc99","#00cccc","#00ccff","#00ff00","#00ff33","#00ff66","#00ff99","#00ffcc","#00ffff","#33000","#330033","#330066","#330099","#3300cc","#3300ff","#333300","#333333","#333366","#333399","#3333cc","#3333ff","#336600","#336633","#336666","#336699","#3366cc","#3366ff","#339900","#339933","#339966","#339999","#3399cc","#3399ff","#33cc00","#33cc33","#33cc66","#33cc99","#33cccc","#33ccff","#33ff00","#33ff33","#33ff66","#33ff99","#33ffcc","#33ffff","#660000","#660033","#660066","#660099","#6600cc","#6600ff","#663300","#663333","#663366","#663399","#6633cc","#6633ff","#666600","#666633","#666666","#666699","#6666cc","#6666ff","#669900","#669933","#669966","#669999","#6699cc","#6699ff","#66cc00","#66cc33","#66cc66","#66cc99","#66cccc","#66ccff","#66ff00","#66ff33","#66ff66","#66ff99","#66ffcc","#66ffff","#990000","#990033","#990066","#990099","#9900cc","#9900ff","#993300","#993333","#993366","#993399","#9933cc","#9933ff","#996600","#996633","#996666","#996699","#9966cc","#9966ff","#999900","#999933","#999966","#999999","#9999cc","#9999ff","#99cc00","#99cc33","#99cc66","#99cc99","#99cccc","#99ccff","#99ff00","#99ff33","#99ff66","#99ff99","#99ffcc","#99ffff","#cc0000","#cc0033","#cc0066","#cc0099","#cc00cc","#cc00ff","#cc3300","#cc3333","#cc3366","#cc3399","#cc33cc","#cc33ff","#cc6600","#cc6633","#cc6666","#cc6699","#cc66cc","#cc66ff","#cc9900","#cc9933","#cc9966","#cc9999","#cc99cc","#cc99ff","#cccc00","#cccc33","#cccc66","#cccc99","#cccccc","#ccccff","#ccff00","#ccff33","#ccff66","#ccff99","#ccffcc","#ccffff","#ff0000","#ff0033","#ff0066","#ff0099","#ff00cc","#ff00ff","#ff3300","#ff3333","#ff3366","#ff3399","#ff33cc","#ff33ff","#ff6600","#ff6633","#ff6666","#ff6699","#ff66cc","#ff66ff","#ff9900","#ff9933","#ff9966","#ff9999","#ff99cc","#ff99ff","#ffcc00","#ffcc33","#ffcc66","#ffcc99","#ffcccc","#ffccff","#ffff00","#ffff33","#ffff66","#ffff99","#ffffcc","#ffffff");
    }
    
    function generate_helmet($filename, $flag)
	{
		$img = imagecreatefrompng('content/img/driver/helmet.png');
		imagealphablending($img, true);
		imagesavealpha($img, true);
		
		//change color of helbet to Flag
		blend_image($img, $flag);
		
		$result = imagecreatefrompng('content/img/driver/helmet_layer.png');
		imagealphablending($result, true);
		imagesavealpha($result, true);
	
		imagecopyresized($result, $img, 435, 115, 0, 0, 90, 68, 400, 300);
		
		//save image to filesystem
		imagepng($result, $filename, 9, PNG_ALL_FILTERS);
	}
	
	function blend_image(&$img, $flag)
	{
		$img_flag = imagecreatefromgif($flag);
		imagealphablending($img, false);
		for($x = imagesx($img); $x--;)
		{
			for($y = imagesy($img); $y--;)
			{
				$rgb = imagecolorat($img, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
					$g = ($rgb >> 8) & 0xFF;
					$b = $rgb & 0xFF;
				if($r == 255 && $g == 0 && $b == 0)
				{
					try{
						$color = imagecolorat($img_flag, floor($x/5), floor($y/7));
						$rgb = imagecolorsforindex($img_flag, $color);
					}catch(Exception $e)
					{
						$rgb = array('red' => 255, 'green' => 255, 'blue' => 255);
					}
					$color = imagecolorallocatealpha($img, $rgb['red'], $rgb['green'], $rgb['blue'], 0);
					imagesetpixel($img, $x, $y, $color);
				}
			}
		}
		imagealphablending($img, true);
	}
    
    function construct_car($tea_id, $tire_image, $design)
    {
    	$image_width = 1000;
    	$image_height = 320;
    	$filename = 'content/img/car/team/'.$tea_id.'.png';
    	
    	//create empty image
		$img = imagecreatefrompng('content/img/car/top/top4.png');
		imagealphablending($img, true);
		imagesavealpha($img, true);
		
		//add top to image
		$value = $design['top'][0] + 1;
		$image = imagecreatefrompng('content/img/car/top/top'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['top'][1], $design['top'][2]);
	
		//add body to image
		$value = $design['body'][0] + 1;
		$image = imagecreatefrompng('content/img/car/body/body'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['body'][1], $design['body'][2]);
	
		//add front to image
		$value = $design['front'][0] + 1;
		$image = imagecreatefrompng('content/img/car/front/front'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['front'][1], $design['front'][2]);
	
		//add frontwing to image
		$value = $design['frontwing'][0] + 1;
		$image = imagecreatefrompng('content/img/car/frontwing/frontwing'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['frontwing'][1], $design['frontwing'][2]);
	
		//add rearwing to image
		$value = $design['rearwing'][0] + 1;
		$image = imagecreatefrompng('content/img/car/rearwing/rearwing'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['rearwing'][1], $design['rearwing'][2]);
	
		//add frontbox to image
		$value = $design['frontbox'][0] + 1;
		$image = imagecreatefrompng('content/img/car/frontbox/frontbox'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['frontbox'][1], $design['frontbox'][2]);
	
		//add rearbox to image
		$value = $design['rearbox'][0] + 1;
		$image = imagecreatefrompng('content/img/car/rearbox/rearbox'.$value.'.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['rearbox'][1], $design['rearbox'][2]);
	
		//add mirror to image
		$image = imagecreatefrompng('content/img/car/mirror/mirror.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		colorize_image($img, $design['mirror'][1], $design['mirror'][2]);
	
		//save image to filesystem
		imagepng($img, $filename, 9, PNG_ALL_FILTERS);
		
		add_tires($filename, $tire_image);
    }//construct car
    
    function add_tires($filename, $tire_image)
	{
		$image_width = 1000;
		$image_height = 320;
		
		$img = imagecreatefrompng($filename);
		imagealphablending($img, true);
		imagesavealpha($img, true);
	
		//add tire to image
		$image = imagecreatefrompng('content/img/car/tire/tire.png');
		imagecopy($img, $image, 0, 0, 0, 0, $image_width, $image_height);
		
		//add back tire to image
		$image = imagecreatefrompng('content/img/tires/'.$tire_image);
		imagecopy($img, $image, 0, 0, -65, -155, $image_width, $image_height);
		
		//add front tire to image
		$image = imagecreatefrompng('content/img/tires/'.$tire_image);
		imagecopy($img, $image, 0, 0, -670, -155, $image_width, $image_height);
	
		//save image to filesystem
		imagepng($img, $filename, 9, PNG_ALL_FILTERS);
	}//add_tires
	
	function random_design($random_color_list)
	{
		$color_max = count($random_color_list);
		$top_max = 4;
		$body_max = 12;
		$front_max = 8;
		$frontwing_max = 8;
		$rearwing_max = 10;
		$frontbox_max = 9;
		$rearbox_max = 11;
		$mirror_max = 1;
		
		$design = array();
		$design['body'] = array(rand(0, $body_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['front'] = array(rand(0, $front_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['frontbox'] = array(rand(0, $frontbox_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['frontwing'] = array(rand(0, $frontwing_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['mirror'] = array(rand(0, $mirror_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['rearbox'] = array(rand(0, $rearbox_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['rearwing'] = array(rand(0, $rearwing_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		$design['top'] = array(rand(0, $top_max - 1), $random_color_list[rand(1,$color_max) - 1], $random_color_list[rand(1,$color_max) - 1]);
		return $design;
	}
	
	//only needed to initially create alle country driver helmets
	function create_driver_cars($db, $team = null)
	{
		/*if($team == null)
		{
			$drivers = $db->getAIDrivers($team['ins_id']);
		}
		else
		{
			$drivers = $db->getDriversOfTeam($team['id']);
		}
		if(count($drivers) > 0)
		{
			foreach($drivers as $driver)
			{
				if(!file_exists("content/img/driver/helmet/".$driver['id'].".png"))
				{
					$tea_id = $driver['tea_id'];
					if($tea_id == null)
						$tea_id = $driver['ai_tea_id'];
					$country = $db->getCountry($driver['cou_id']);*/
					for($i = 1; $i <= 186; ++$i)
					{
						$country = $db->getCountry($i);
						generate_helmet("content/img/driver/helmet/".$i.".png", "content/img/flags/".$country['picture'].".gif");
					}
				/*}
			}
		}*/
	}
	
	function create_missing_cars($db, $team = null)
	{
		set_time_limit(0);
		if($team == null)
		{
			$teams = $db->getTeamsWithoutCarDesign();
		}
		else
		{
			$teams = array($team);
		}
		if(count($teams) > 0)
		{
			foreach($teams as $team)
			{
				$design = random_design(array("#".$team['color1'], "#".$team['color2']));
				$tir_id = $team['tir_id'];
				$tire_filename = "tire8_dry_hard.png";
				if($tir_id)
				{
					$tire = $db->getTire($team['tir_id']);
					$tire_filename = $tire['picture_dry_hard'];
				}
				construct_car($team['id'], $tire_filename, $design);
				$serialized = serialize($design);
				$db->updateTeamCarDesign($team['id'], $serialized);
			}
		}
	}
	
	function colorize_image(&$img, $rgb1, $rgb2)
	{
		$r1 = hexdec(substr($rgb1, 1, 2));
		$g1 = hexdec(substr($rgb1, 3, 2));
		$b1 = hexdec(substr($rgb1, 5, 2));
		$r2 = hexdec(substr($rgb2, 1, 2));
		$g2 = hexdec(substr($rgb2, 3, 2));
		$b2 = hexdec(substr($rgb2, 5, 2));
		
		if($r1 == 255 && $g1 == 0 && $b1 == 0)
				$r1 = 254;
		if($r1 == 0 && $g1 == 0 && $b1 == 255)
				$b1 = 254;
			
		if($r2 == 255 && $g2 == 0 && $b2 == 0)
				$r2 = 254;
		if($r2 == 0 && $g2 == 0 && $b2 == 255)
				$b2 = 254;
		
		//$img = imagecreatefrompng($filename);
		imagealphablending($img, false);
		for($x = imagesx($img); $x--;)
		{
			for($y = imagesy($img); $y--;)
			{
				$rgb = imagecolorat($img, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				if($r == 255 && $g == 0 && $b == 0)
				{
					$color = imagecolorallocatealpha($img, $r1, $g1, $b1, 0);
					imagesetpixel($img, $x, $y, $color);
				}
				if($r == 0 && $g == 0 && $b == 255)
				{
					$color = imagecolorallocatealpha($img, $r2, $g2, $b2, 0);
					imagesetpixel($img, $x, $y, $color);
				}
			}
		}

		imagealphablending($img, true);
		//imagesavealpha($img, true);
		//imagepng($img, $filename, 9, PNG_ALL_FILTERS);
	}//end colorize_image
	
	function power_to_image($array)
	{
		if($array == null) return $array;
		$array['power1_img'] = 0;
		$array['power2_img'] = 0;
		$array['power3_img'] = 0;
		$array['power4_img'] = 0;
		$array['power5_img'] = 0;
		$array['power6_img'] = 0;
		if(is_numeric($array['power1']))
			$array['power1_img'] = number_format(abs($array['power1'] - 1) / 10, 0);
		if(is_numeric($array['power2']))
			$array['power2_img'] = number_format(abs($array['power2'] - 1) / 10, 0);
		if(is_numeric($array['power3']))
			$array['power3_img'] = number_format(abs($array['power3'] - 1) / 10, 0);
		if(is_numeric($array['power4']))
			$array['power4_img'] = number_format(abs($array['power4'] - 1) / 10, 0);
		if(is_numeric($array['power5']))
			$array['power5_img'] = number_format(abs($array['power5'] - 1) / 10, 0);
		if(is_numeric($array['power6']))
			$array['power6_img'] = number_format(abs($array['power6'] - 1) / 10, 0);
		return $array;
	}

	/*
	 * gets the item value based on its condition
	 * params: item array
	 * return: current value
	 */
	function compute_item_value($item)
	{
	    //value is the half of the value in percent of damage
	    return (($item['condition'] * str_replace(".", "", $item['value'])) * 0.005) * 0.5;
	}//compute_item_value

	/*
	 * gets the repair costs of item
	 * params: item array
	 * return: current repair costs
	 */
	function compute_item_repair_value($item)
	{
	    //value is the half of the value in percent of damage
	    return (100 - $item['condition']) * (str_replace(".", "", $item['value']) * 0.01);
	}//compute_item_repair_value

	/*
	 * computes pitstop time
	 * params: pitstop time by mechanics
	 * return: time in seconds
	 */
	function compute_pitstop_time($pitstop)
	{
	    return 30.0 - ($pitstop * 20); //1 because a team can only have 10 mechanics
	}//compute_pitstop_time

	/*
	 * computes bonus for setup
	 * params: mechanic setup value
	 * return: bonus in percent
	 */
	function compute_setup_bonus($setup)
	{
	    return $setup * 0.07;
	}//compute_setup_bonus

	/*
	 * computes tire bonus
	 * params: tire bonus of mechanics
	 * return: bonus in percent
	 */
	function compute_tire_bonus($tires)
	{
	    return $tires * 0.4;
	}//compute_tire_bonus

	/*
	 * computes repair bonus
	 * params: repair bonus of mechanics
	 * return: bonus in percent
	 */
	function compute_repair_bonus($repair)
	{
	    return $repair * 0.35;
	}//compute_repair_bonus

	/*
	 * computes current sell price of driver
	 * params: driver array, type (display or for computation)
	 * return: formatted sell price
	 */
	function calculate_sell_price($driver, $type)
	{
		$wage = $driver['wage'];
	    $sell_price = $wage * 0.8;								//max. is 80% of wage
	    $sell_price*= ((100 - $driver['morale']) + 100) * 0.005;//max. depends of morale
		if($type == 0)
			return $sell_price;
		else
			return number_format($sell_price, 0, ",", ".");
	}//calculate_sell_price
	
	function calculate_sell_price_mechanic($mechanic, $type)
	{
		$wage = $mechanic['wage'];
	    $sell_price = $wage * 0.8;								//max. is 80% of wage
	    $sell_price*= ((100 - $mechanic['morale']) + 100) * 0.005;//max. depends of morale
		if($type == 0)
			return $sell_price;
		else
			return number_format($sell_price, 0, ",", ".");
	}//calculate_sell_price_mechanic
	
	function recomputePowerValues($settings)
	{
		$power1 = $settings['power1'];
		$power2 = $settings['power2'];
		$power3 = $settings['power3'];
		$power4 = $settings['power4'];
		$power5 = $settings['power5'];
		$power6 = $settings['power6'];
		$sum = $power1 + $power2 + $power3 + $power4 + $power5 + $power6;
		//if sum is 0 there is no setting
		if($sum == 0)
		{
			$power1 = 100;
			$power2 = 100;
			$power3 = 100;
			$power4 = 100;
			$power5 = 100;
			$power6 = 100;
			$sum = $power1 + $power2 + $power3 + $power4 + $power5 + $power6;
		}
		$settings['power1'] = round(($power1 * 100) / $sum);
		$settings['power2'] = round(($power2 * 100) / $sum);
		$settings['power3'] = round(($power3 * 100) / $sum);
		$settings['power4'] = round(($power4 * 100) / $sum);
		$settings['power5'] = round(($power5 * 100) / $sum);
		$settings['power6'] = 100 - $settings['power1'] - $settings['power2'] - $settings['power3'] - $settings['power4'] - $settings['power5'];
		return $settings;
	}

	/*
	 * gets an array of mechanics and computes the global for the team values
	 * params: mechanic array
	 * return: array of mechanic and values for pitstop, tires, setup and repair
	 */
	function get_mechanic_values($mechanics_old)
	{
	    $mechanics = array();
	    $pitstop = 0;
	    $tires = 0;
	    $setup = 0;
	    $repair = 0;
	    foreach($mechanics_old as $mechanic)
	    {
	    	$mechanic['sell_price'] = calculate_sell_price_mechanic($mechanic, 1);
	    	$mechanic['pit_stop_current'] = round(($mechanic['pit_stop'] + $mechanic['morale']) * 0.5);
	    	$mechanic['tires_current'] = round(($mechanic['tires'] + $mechanic['morale']) * 0.5);
	    	$mechanic['setup_current'] = round(($mechanic['setup'] + $mechanic['morale']) * 0.5);
	    	$mechanic['repair_current'] = round(($mechanic['repair'] + $mechanic['morale']) * 0.5);
	    	$mechanic['development_current'] = round(($mechanic['development'] + $mechanic['morale']) * 0.5);
	        $mechanic = number_format_Tablerow($mechanic);
	        //here we generate values for the team value of pitstop, setup,...
	        //formula goes: sum all mechanic values * morale which are working for that job
	        switch($mechanic['job'])
	        {
	            //pitstop
	            case 1: $pitstop += $mechanic['pit_stop_current'] * 0.1; break;
	            //setup
	            case 2: $setup += $mechanic['setup_current'] * 0.1; break;
	            //tires
	            case 3: $tires += $mechanic['tires_current'] * 0.1; break;
	            //repair
	            case 4: $repair += $mechanic['repair_current'] * 0.1; break;
	            //Development
	            case 8: break;
	            default: break;
	        }
	        $mechanic = add_color_class_mechanic($mechanic);	//adds CSS color class for driver values
	        $mechanics[] = $mechanic;
	    }
	    return array($mechanics, $pitstop, $setup, $tires, $repair);
	}//get_mechanic_values

	/*
	 * converts in game time to string
	 * params: time as float
	 * return: time as readable string
	 */
	function time_to_string($time)
	{
		$negative = false;
		if($time < 0)
		{
			$negative = true;
			$time = abs($time);
		}
	    $ret = "";
	    //to minutes
	    $time *= 60;
	    $minutes = intval($time);
	    if($minutes >= 60){
	      $hours = intval($minutes/60);
	
	    $ret .= $hours.":";
	    $minutes -= $hours * 60;
	    $time -= $hours * 60;
	    if($minutes<10){
	        $ret .= "0".$minutes.":";
	    }else{
	        $ret .= $minutes.":";
	    }
	    }else{
	      $ret .= $minutes.":";
	    }
	    $time -= $minutes;
	    $time *= 60;
	    $seconds = intval($time);
	    if($seconds<10){
	      $ret .= "0".$seconds.":";
	    }else{
	      $ret .= $seconds . ":";
	    }
	    $time -= $seconds;
	    $time *= 1000;
	    $milliseconds = intval($time);
	    if($milliseconds<100){
	      if($milliseconds<10){
	          $ret .= "00".$milliseconds;
	      }else{
	          $ret .= "0".$milliseconds;
	      }
	    }else{
	      $ret .= $milliseconds;
	    }
	    if($negative)
	    {
	    	$ret = "-".$ret;
	    }
	    return $ret;
	}//time_to_string

	/*
	 * computes training rounds with given settings and values for driver, car, mechanic...
	 * each round is stored in db
	 * params: settings array, driver array, car array, tire array, mechanic array, track information, round number, global params, 
	 *         round number of tires (for race)
	 * return: array of round number, round time as floar and round time as string
	 */
	function compute_training($user, $settings, $driver, $car, &$tire, $mechanic, $track, $round_number, $params, $tire_round_number)
	{		
		//this function has a seperate debug function for troubleshoot
		$debug = false;
		$factor = $params['round_factor'] * 0.01;
	    //change car values with track values
	    //Karosserie = 0, Bremsen = 1, Motor = 2, Aerodynamik = 3, Elektrik = 4, Aufhängung = 5, Getriebe = 6, Hydraulics = 7, Kers = 8, DRS = 9
	    $car[0]['value'] *= $track['body'] * 0.01;
	    $car[1]['value'] *= $track['brakes'] * 0.01;
	    $car[2]['value'] *= $track['engine'] * 0.01;
	    $car[3]['value'] *= $track['aerodynamics'] * 0.01;
	    $car[4]['value'] *= $track['electronics'] * 0.01;
	    $car[5]['value'] *= $track['suspension'] * 0.01;
	    $car[6]['value'] *= $track['gearbox'] * 0.01;
	    $car[7]['value'] *= $track['hydraulics'] * 0.01;
	    $car[8]['value'] *= $track['kers'] * 0.01;
	    $car[9]['value'] *= $track['drs'] * 0.01;
	    
	    if(!isset($settings['front_wing']))
	    	$settings['front_wing'] = 0;
	    if(!isset($settings['rear_wing']))
	    	$settings['rear_wing'] = 0;
	    if(!isset($settings['front_suspension']))
	    	$settings['front_suspension'] = 0;
	    if(!isset($settings['rear_suspension']))
	    	$settings['rear_suspension'] = 0;
	    if(!isset($settings['tire_pressure']))
	    	$settings['tire_pressure'] = 0;
	    if(!isset($settings['brake_balance']))
	    	$settings['brake_balance'] = 0;
	    if(!isset($settings['gear_ratio']))
	    	$settings['gear_ratio'] = 0;
	    
	    //change setting values with track values
	    if($user == null)
	    {
			$front_wing = 1.0 + (abs($track['front_wing'] - $settings['front_wing']) * 0.01);
			$rear_wing = 1.0 + (abs($track['rear_wing'] - $settings['rear_wing']) * 0.01);
			$front_suspension = 1.0 + (abs($track['front_suspension'] - $settings['front_suspension']) * 0.01);
			$rear_suspension = 1.0 + (abs($track['rear_suspension'] - $settings['rear_suspension']) * 0.01);
			$tire_pressure = 1.0 + (abs($track['tire_pressure'] - $settings['tire_pressure']) * 0.01);
			$brake_balance = 1.0 + (abs($track['brake_balance'] - $settings['brake_balance']) * 0.01);
			$gear_ratio = 1.0 + (abs($track['gear_ratio'] - $settings['gear_ratio']) * 0.01);
	    }
	    else
	    {
	    	$front_wing = 1.0 + (abs($user['front_wing'] - $settings['front_wing']) * 0.01);
			$rear_wing = 1.0 + (abs($user['rear_wing'] - $settings['rear_wing']) * 0.01);
			$front_suspension = 1.0 + (abs($user['front_suspension'] - $settings['front_suspension']) * 0.01);
			$rear_suspension = 1.0 + (abs($user['rear_suspension'] - $settings['rear_suspension']) * 0.01);
			$tire_pressure = 1.0 + (abs($user['tire_pressure'] - $settings['tire_pressure']) * 0.01);
			$brake_balance = 1.0 + (abs($user['brake_balance'] - $settings['brake_balance']) * 0.01);
			$gear_ratio = 1.0 + (abs($user['gear_ratio'] - $settings['gear_ratio']) * 0.01);
	    }

	    //tire
	    switch($tire['tire_type'])
	    {
	    	//hard
	    	case 0: 
	    		//rain
	    		if($track['weather'] < 31)
	    			$tire_values = explode(' ', $tire['hard_rain']);
	    		else
	    			$tire_values = explode(' ', $tire['hard']);
	    		break;
	    	//soft
	    	case 1: 
	    		//rain
	    		if($track['weather'] < 31)
	    			$tire_values = explode(' ', $tire['soft_rain']);
	    		else
	    			$tire_values = explode(' ', $tire['soft']); 
	    		break;
	    }
	    $tire_round_number = intval(floor($tire['distance'] / $params['meter_to_round']));
	    if($tire_round_number < count($tire_values))
	        $tire_value = $tire_values[$tire_round_number];
	    else
	        $tire_value = $tire_values[count($tire_values) - 1];
	    
		//*** compute standard round time
	    //get values from track
	    $distance = $track['distance'] * 0.01;
	    $dsgcurves = $track['dsgcurves'];
	    $dsgstraights = $track['dsgstraights'];
	    //change speed with params
	    $speed_curves = $dsgcurves * $params['speed'];
	    $speed_straights = $dsgstraights * $params['speed'];
	    //compute round time
	    $average_speed = ($speed_curves + $speed_straights) * 0.5;
	    $round_time = $distance / $average_speed;
	    //***
	    if($debug) echo "compute standard: ".$round_time." --> ".time_to_string($round_time)."<br>";
	    //*** compute car parts
	    //change speed with car values
	    $round_time *= 1.0 + ($factor * ($params['item_value'] * (1.0 - ($car[4]['value'] + $car[7]['value'] + $car[1]['value'] + $car[5]['value'] + $car[6]['value']) * 0.002))); //electronics, hydraulics, brakes, suspension, gearbox
	    $round_time *= 1.0 + ($factor * ($params['item_value'] * (1.0 - ($car[3]['value'] + $car[0]['value'] + $car[2]['value'] + $car[9]['value'] + $car[8]['value']) * 0.002))); //aerodynamics, body, engine, drs, kers
		//***
		if($debug) echo "car parts: ".$round_time." --> ".time_to_string($round_time)."<br>";
		//*** compute driver value
	    //change round time with driver values
	    $round_time *= 1.0 + ($factor * ($params['driver_value'] * (1.0 - (($driver['speed'] + $driver['morale'] + $driver['experience'] + $driver['speed'] + $driver['morale'] + $driver['experience'] + $driver['persistence'] + $driver['freshness'] + $driver['stamina']) / 900))));
	    //stamina!
	    $round_time *= 1.0 + ($factor * (0.01 * $round_number * ($params['driver_value'] * (1.0 - (($driver['freshness'] + $driver['stamina']) / 200)))));
		//***
		if($debug) echo "driver: ".$round_time." --> ".time_to_string($round_time)."<br>";
		//*** compute setup
	    //change round time with setting values
	    //mechanic can do better setups
	    $item_setup = ($front_wing + $rear_wing + $front_suspension + $rear_suspension + $tire_pressure + $brake_balance + $gear_ratio) / 7.0;
		$round_time *= 1.0 + ($factor * (($item_setup * $params['setup_value']) * (1.0 - ($mechanic['setup'] * 0.01))));
		//***
		if($debug) echo "setup: ".$round_time." --> ".time_to_string($round_time)."<br>";
		//*** compute tires
	    //change round time with tire
	    if($debug) echo "tire: (1.0 + (".$factor." * (".$params['tire_value']." * ".$tire_value.") * (1.0 - (".($mechanic['tires'] * 0.01).")))<br>";
	    if($debug) echo "value: ".(1.0 + ( $factor * ($params['tire_value'] * $tire_value) * (1.0 - ($mechanic['tires'] * 0.01))))."<br>";
	    $round_time *= 1.0 + ($factor * (($params['tire_value'] * $tire_value) * (1.0 - ($mechanic['tires'] * 0.01))));
		//***
		if($debug) echo "tires: ".$round_time." --> ".time_to_string($round_time)."<br>";
	    //engine value (only for race)
	    if(array_key_exists('power1', $settings))
	    {
	    	$value = $round_time * $params['engine_power']; //5 percent of race time
	    	$engine_value = 0;
	    	$rounds = $track['rounds'];
			$steps = intval($rounds/6);
			if($round_number <= $steps)
				$engine_value = $settings['power1'];
			if($steps < $round_number && $round_number <= (2*$steps))
				$engine_value = $settings['power2'];
			if((2*$steps) < $round_number && $round_number <= (3*$steps))
				$engine_value = $settings['power3'];
			if((3*$steps) < $round_number && $round_number <= (4*$steps))
				$engine_value = $settings['power4'];
			if((4*$steps) < $round_number && $round_number <= (5*$steps))
				$engine_value = $settings['power5'];
			if((5*$steps) < $round_number)
				$engine_value = $settings['power6'];
			$base_value = ($value * $engine_value) / 100;
			//$base_value = $base_value / 100;
			$value = $value / 2;
			$value-= $base_value;
			if($debug)
			{
				if($driver['id'] == 4)
				{
					echo "Rundenzeit: ".$round_time;
				}
			}
			$round_time+= $value;
			if($driver['id'] == 4)
			{
				if($debug) echo " - ".$round_time."<br>";
			}
	    }
		//random
	    $percent_round_time = $round_time * $params['random'];
	    $random = RandomNumberGenerator::get_random_float() * $percent_round_time;
	    if(RandomNumberGenerator::get_random_boolean() == 0)
	    {
	        $random *= -1.0;
	    }
	    $round_time += $random;
		if($debug){echo "random: ".$round_time." --> ".time_to_string($round_time)."<br><br><br>";}
		//add distance to tire
		$tire['distance']+= $track['distance'];
	    return array($round_number, $round_time, time_to_string($round_time));
	}//compute_training
	
	/*
	 * generates a readably comment of driver to trainingrounds
	 * params: type of setting, value of difference
	 * return: comment as string
	 */
	function generate_driver_comment($lap)
	{
		$ret = '';
		switch($lap['comment_type'])
		{
			//front_wing
			case 1: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_front_wing_small'), $lap['comment_value'], $lap['front_wing']." ".Translator::_translate('tr_driver_setting_degree')); break;
			//rear_wing
			case 2: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_rear_wing_small'), $lap['comment_value'], $lap['rear_wing']." ".Translator::_translate('tr_driver_setting_degree')); break;
			//front_suspension
			case 3: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_front_suspension_small'), $lap['comment_value'], $lap['front_suspension']." %"); break;
			//rear_suspension
			case 4: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_rear_suspension_small'), $lap['comment_value'], $lap['rear_suspension']." %"); break;
			//tire_pressure
			case 5: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_tire_pressure_small'), $lap['comment_value'], $lap['tire_pressure']." %"); break;
			//brake_balance
			case 6: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_brake_balance_small'), $lap['comment_value'], $lap['brake_balance']." %"); break;
			//gear_ratio
			case 7: $ret = generate_driver_comment_text(Translator::_translate('tr_race_training_setup_gear_ratio_small'), $lap['comment_value'], $lap['gear_ratio']." %"); break;
		}
		return $ret;
	}//generate_driver_comment
	
	/*
	 * translates setup strings
	 */
	function generate_driver_comment_text($type, $value, $setting_value)
	{
		//perfect setup
		if($value == 0)
		{
			return "<div class='value_green'>".Translator::_translate('tr_race_training_perfect_setup')."</div>";
		}
		if($value < 2)
		{
			return "<div class='value_green'>".Translator::_translate('tr_race_training_your_setup')." ".$type." (".$setting_value.")  ".Translator::_translate('tr_race_training_nearly_perfect_setup')."</div>";
		}
		//setting is nearly perfekt
		else if($value < 5)
		{
			return "<div class='value_yellowgreen'>".Translator::_translate('tr_race_training_your_setup')." ".$type." (".$setting_value.") ".Translator::_translate('tr_race_training_very_good_setup')."</div>";
		}
		//setting is good
		else if($value < 10)
		{
			return "<div class='value_yellow'>".Translator::_translate('tr_race_training_your_setup')." ".$type." (".$setting_value.") ".Translator::_translate('tr_race_training_acceptable_setup')."</div>";
		}
		//setting is bad
		else if($value < 20)
		{
			return "<div class='value_orange'>".Translator::_translate('tr_race_training_your_setup')." ".$type." (".$setting_value.") ".Translator::_translate('tr_race_training_not_good_setup')."</div>";
		}
		//setting is very bad
		else
		{
			return "<div class='value_red'>".Translator::_translate('tr_race_training_your_setup')." ".$type." (".$setting_value.") ".Translator::_translate('tr_race_training_very_bad_setup')."</div>";
		}
	}//generate_driver_comment_text
	
	/*
	 * generates new tires for race weekend for all teams
	 */
	function generate_new_tire_set($ins_id, $db, $tea_id = null)
	{
		//delete old tires
		if($tea_id == null)
			$db->deleteRaceTires();

		$params = $db->getParams($ins_id);
		if($tea_id == null)
			$_teams = $db->getTeams($ins_id, 'id asc');
		else
		{
			$_teams = array();
			$_team_tmp = $db->getTeam($tea_id);
			if($_team_tmp['ins_id'] == $ins_id)
				$_teams[] = $_team_tmp;
		}
		//teams
		foreach($_teams as $_team)
		{
			$tea_id = $_team['id'];
			$tir_id = $_team['tir_id'];
			//for each car
			//for human teams and AI controlled teams
			for($car_number = 1; $car_number < 4; ++$car_number)
			{
				$tire_number = 0;
				//$dri_id = $_driver['id'];
				//tire types
				for($tire_type = 0; $tire_type < 2; $tire_type++)
				{
					switch($tire_type)
					{
						//hard
						case 0:
							for($i = 0; $i < $params['hard_tires_per_weekend']; $i++)
							{
								$tire_number++;
								$db->addRaceTire($tea_id, $car_number, $tire_type, $tir_id, $tire_number);
							}
							break;
						//soft
						case 1: 
							for($i = 0; $i < $params['soft_tires_per_weekend']; $i++)
							{
								$tire_number++;
								$db->addRaceTire($tea_id, $car_number, $tire_type, $tir_id, $tire_number);
							}
							break;
					}
				}//for tire_type
			}//foreach driver
		}//foreach team
	}//generate_new_tire_set
	
	/*
	 * gets all tires for driver and returns readable array for display
	 */
	function compute_race_tire_array($tea_id, $car_number, $db, $params, $weather)
	{
		$ret = array();
		if($tea_id == null)
			return $ret;
		$array = $db->getRaceTiresForDriver($tea_id, $car_number);
		//if driver has no tires yet
		if(count($array) == 0)
		{
			$team = $db->getTeam($tea_id);
			generate_new_tire_set($team['ins_id'], $db, $tea_id);
			$array = $db->getRaceTiresForDriver($tea_id, $car_number);
		}
		foreach($array as $a)
		{
			$element = $a;
			$tire = $db->getTire($element['tir_id']);
			$tire_type = "";
			switch($element['tire_type'])
			{
				//hard
				case 0: $tire_type = Translator::_translate('tr_race_training_setup_hard'); break;
				//soft
				case 1: $tire_type = Translator::_translate('tr_race_training_setup_soft'); break;
			}
			$condition = explode(',', $params['tire_condition']);
			$condition_info = "";
			if($element['distance'] * 0.001 <= $condition[0])
				$condition_info = "<span class='value_green'>".Translator::_translate('tire_new')."</span>";
			if($element['distance'] * 0.001 <= $condition[1] && $element['distance'] * 0.001 > $condition[0])
				$condition_info = "<span class='value_yellow'>".Translator::_translate('tire_approached')."</span>";
			if($element['distance'] * 0.001 <= $condition[2] && $element['distance'] * 0.001 > $condition[1])
				$condition_info = "<span class='value_orange'>".Translator::_translate('tire_critical')."</span>";
			if($element['distance'] * 0.001 > $condition[2])
				$condition_info = "<span class='value_red'>".Translator::_translate('tire_broken')."</span>";
			$element['distance'] = number_format($element['distance'] / 1000, 1, ',', '.');
			//$element['tire_name'] = $tire['name']." (".$element['tire_number'].") ".$tire_type." ".$element['distance']." ".Translator::_translate('km')." ".$condition_info;
			$element['tire_name'] = " ".$tire_type." (".$element['tire_number'].") ".$element['distance']." ".Translator::_translate('km')." ".$condition_info;
			switch($element['tire_type'])
			{
				//hard
				case 0: if($weather == 'rain') $element['tire_picture'] = $tire['picture_wet_hard']; else $element['tire_picture'] = $tire['picture_dry_hard']; break;
				//soft
				case 1: if($weather == 'rain') $element['tire_picture'] = $tire['picture_wet_soft']; else $element['tire_picture'] = $tire['picture_dry_soft']; break;
			}
			$ret[] = $element;
		}
		return $ret;
	}//compute_race_tire_array

	/*
	 * AI Functions
	 */
 

	/*
	 * ai teams get drivers - each ai team gets 2 drivers
	 * params: instance id, db object
	 * return: nothing
	 */
	function ai_update_drivers($ins_id, $db)
	{
		$_debug = false;
		
		//loop through all teams without manager
		$_teams = $db->getFreeTeams($ins_id);
		foreach($_teams as $_team)
		{
			if($_debug) echo $_team['name'];
			//check if team has already two ai drivers
			$_drivers = $db->getAIDriversOfTeam($_team['id']);
			if($_debug) echo " ".count($_drivers)."<br>";
			
			//get new free drivers
			$_free_drivers = $db->getAIFreeDrivers($ins_id, 10000000);
			$_last_index = -1;
			while(count($_drivers) < 2 && count($_free_drivers) > 0)		//AI needs at least two drivers
			{
				$driver_index = rand(0, count($_free_drivers) - 1);
				if($driver_index != $_last_index)
				{
					$db->buyAIDriver($_free_drivers[$driver_index]['id'], $_team['id']);
					change_youth_driver_cloth($_team['id'], $_free_drivers[$driver_index]['id'], $db);
					if($_debug) echo " buys Driver: ".$_free_drivers[$driver_index]['firstname']." ".$_free_drivers[$driver_index]['lastname']."<br>";
					$_drivers = $db->getAIDriversOfTeam($_team['id']);
					$_last_index = $driver_index;
				}
			}
			
			//set drivers
			$_drivers = $db->getAIDriversOfTeam($_team['id']);
			$db->setTeamDriver($_team['id'], $_drivers[0]['id'], 1);
			$db->setTeamDriver($_team['id'], $_drivers[1]['id'], 2);
			
			//set tires
			$_tires = $db->getTires();
			if($_team['tir_id'] == null)
			{
				$db->acceptAITire($_tires[rand(0, count($_tires) - 1)]['id'], $_team['id']);
			}
		}
		//create missing cars for all teams
		create_missing_cars($db);
	}//ai_update_drivers
	
	/*
	 * ai teams get parts - each ai car has all parts but with random class
	 * params: instance id, db object
	 * return: nothing
	 */
	function ai_update_parts($ins_id, $db)
	{
		$_debug = false;
		
		//delete all AI Items
		$db->deleteAiItems($ins_id);
		
		//loop through all teams without manager
		$_teams =  $db->getFreeTeams($ins_id);
		foreach($_teams as $_team)
		{
			//get max item class for team
			$league = $_team['league'];
			$item_min = 1;
			$item_max = 2;
			if($league == 2)
			{
				$item_min = 2;//4
				$item_max = 4;
			}
			if($league == 1)
			{
				$item_min = 3;//7
				$item_max = 8;
			}
				
			//get all items of team
			$tea_ites = $db->getItemsFromStock($_team['id']);
			$count = array();
			for($i = 0; $i < 10; ++$i)
			{
				$count[$i] = 0;
			}
			
			//loop through all types and count items of type
			for($i = 0; $i < 10; ++$i)
			{
				//check if we already have at least 2 of that type
				foreach($tea_ites as $tea_ite)
				{
					$ite = $db->getItem($tea_ite['ite_id']);
					if($ite['type'] == $i)
						$count[$i]++;
				}				
			}
			
			//now buy items till we have 2 for that type
			for($i = 0; $i < 10; ++$i)
			{
				for($j = 0; $j < 2 - $count[$i]; ++$j)
				{
					//buy item with type $i
					$items = $db->getItemsMinMax($item_min, $item_max, 99999999);
					if(count($items) > 0)
					{
						$db->buyAIItem($items[rand(0, count($items) - 1)]['id'], $_team['id'], $ins_id, $j + 1);
					}
				}
			}
			
			//now get all items and loop through all items to set condition and tuneup
			//we must set those values, because AI doesn't repair items!!!
			$tea_ites = $db->getItemsFromStock($_team['id']);
			foreach($tea_ites as $tea_ite)
			{
				if($tea_ite['condition'] < 30)
				{
					//if it is broken repair it
					if($tea_ite['condition'] == 0)
					{
						$db->changeTeaIteCondition($tea_ite['id'], 100);
					}
					//if it is in bad condition rand for a solution
					else
					{
						$rnd = rand(0, 3);
						if($rnd == 0)
						{
							$db->changeTeaIteCondition($tea_ite['id'], 100);
						}
					}
				}
			}
		}//foreach
	}//ai_update_parts
	
	/**/
	function get_ai_strength($_team, $params)
	{
		switch($_team['league'])
		{
			case 1: return $params['ai_strength1']; break;
			case 2: return $params['ai_strength2']; break;
			case 3: return $params['ai_strength3']; break;
		}
	}//get_ai_strength
	
	/* 
	 * ai teams compute training - each driver drives full amount of training rounds with random settings
	 * params: instance id, db object
	 * return: nothing
	 */
	function ai_compute_training($ins_id, $db)
	{
		$params = $db->getParams($ins_id);
		
		//loop through all teams without manager
		$_teams =  $db->getFreeTeams($ins_id);
		foreach($_teams as $_team)
		{
			//for both cars
			for($car_number = 1; $car_number < 3; ++$car_number)
			{
				$driver = $db->getDriver($car_number == 1?$_team['driver1']:$_team['driver2']);
				
				$number_laps = $db->getSetupOfTypeAndCarAll($ins_id, $_team['id'], $driver['id'], 0, "id ASC");
				//do not compute more rounds than are allowed to
				if($number_laps > $params['training_max_rounds'])
					continue;
	
				$driver['speed_value'] = ($driver['speed'] + $driver['experience']) * 0.5;
				$driver['persistence_value'] = ($driver['persistence'] + $driver['experience']) * 0.5;
	        	$driver['strength_value'] = ($driver['freshness'] + $driver['morale'] + $driver['speed_value'] + $driver['persistence_value']) * 0.25;
	       		$driver = default_image($driver);
	        
		        $car_old = $db->getItemsFromCar($_team['id'], $car_number);
		        $car = array();
		        foreach($car_old as $c)
		        {
		            $item = $db->getItem($c['ite_id']);
		            $c['name'] = $item['name'];
		            $c['value'] = $item['skill'] + (($item['skill_max'] - $item['skill']) * ($c['tuneup'] * 0.01));
		            $car[] = $c;
		        }//foreach
			
				$mechanic = array('setup' => 0, 'tires' => 0);

				$_track = $db->getTrack($ins_id);
				$max = get_ai_strength($_team, $params);
				
				//random settings
		        $settings = array(
		            'front_wing' => rand(max(0, $_track['front_wing'] - $max), min(90, $_track['front_wing'] + $max)),
		            'rear_wing' => rand(max(0, $_track['rear_wing'] - $max), min(90, $_track['rear_wing'] + $max)),
		            'front_suspension' => rand(max(0, $_track['front_suspension'] - $max), min(100, $_track['front_suspension'] + $max)),
		            'rear_suspension' => rand(max(0, $_track['rear_suspension'] - $max), min(100, $_track['rear_suspension'] + $max)),
		            'tire_pressure' => rand(max(0, $_track['tire_pressure'] - $max), min(100, $_track['tire_pressure'] + $max)),
		            'brake_balance' => rand(max(0, $_track['brake_balance'] - $max), min(100, $_track['brake_balance'] + $max)),
		            'gear_ratio' => rand(max(0, $_track['gear_ratio'] - $max), min(100, $_track['gear_ratio'] + $max))
		        );
				
				//get instance and track
				$instance = $db->getInstance($ins_id);
				$track = $db->getTrack($ins_id);
				$params = $db->getParams($ins_id);
		
		        //tires
				$tires = $db->getRaceTiresForDriver($driver['ai_tea_id'], $car_number);
				//if driver has no tires yet
				if(count($tires) == 0)
				{
					generate_new_tire_set($ins_id, $db, $driver['ai_tea_id']);
					$tires = $db->getRaceTiresForDriver($driver['ai_tea_id'], $car_number);
				}
				//select tire hard, soft
				$hard_tire = null;
				$soft_tire = null;
				foreach($tires as $t)
				{
					if($hard_tire == null && $t['tire_type'] == 0)
						$hard_tire = $db->getRaceTire($t['id']);
					if($soft_tire == null && $t['tire_type'] == 1)
						$soft_tire = $db->getRaceTire($t['id']);
					if($hard_tire != null && $soft_tire != null)
						break;
				}

				//compute lap times
		        $round_data = array();
		        //drive some rounds with soft
		        for( $i = 0; $i < $params['training_max_rounds'] / 2; ++$i )
		        {
		            $round_data[] = compute_training(null, $settings, $driver, $car, $hard_tire, $mechanic, $track, $i+1, $params, $i);
		        }//for
				$db->setRaceTireDistance($hard_tire['id'], $hard_tire['distance']);
				$db->insertTrainingSetup($car_number, $_team['id'], $driver['id'], $_team['ins_id'], $_team['league'], $settings, $hard_tire['tire_type'], $round_data, 0, 0/*$comment_type*/, 0/*$comment_value*/);
				$round_data = array();
				//drive some rounds with hard
				for( $j = $i; $j < $params['training_max_rounds']; ++$j)
				{
					$round_data[] = compute_training(null, $settings, $driver, $car, $soft_tire, $mechanic, $track, $j+1, $params, $j);
				}
				$db->setRaceTireDistance($soft_tire['id'], $soft_tire['distance']);
		        //store to db
		        $db->insertTrainingSetup($car_number, $_team['id'], $driver['id'], $_team['ins_id'], $_team['league'], $settings, $soft_tire['tire_type'], $round_data, 0, 0/*$comment_type*/, 0/*$comment_value*/);
		        //$db->insertSetup($car_number, $_team['id'], $driver['id'], $_team['ins_id'], null, $settings, $tire_type, $round_data, 0);
	        }
		}//foreach
	}//ai_compute_training

	/*
	 * computes ai qualification - each driver sets a random setup for all 3 sessions
	 * params: instance id, db object
	 * return: nothing
	 */ 
	function ai_compute_qualification($ins_id, $db)
	{
		$params = $db->getParams($ins_id);
		
		//loop through all teams with manager
		//check if this user did qualification settings - if not use bad standard settings
		//so that his drivers take part
		$_teams =  $db->getManagedTeams($ins_id);
		foreach($_teams as $_team)
		{
			//for each qualification session
			for($car_number = 1; $car_number < 3; ++$car_number)
			{
				$driver_id = $car_number == 1?$_team['driver1']:$_team['driver2'];
				if($driver_id)
				{
					for($i = 0; $i < 3; ++$i)
					{
						$type = $i;
						$settings = $db->getSetupSetting($car_number, $_team['id'], $ins_id, 1, $type);
	
						//if this driver has no setting
						if($settings == null || count($settings) == 0)
						{
							$driver = $db->getDriver($car_number == 1?$_team['driver1']:$_team['driver2']);
						
							//get all tires of driver
							//random tire type
							//tires
							$tires = $db->getRaceTiresForDriver($_team['id'], $car_number);
							//if driver has no tires yet
							if(count($tires) == 0)
							{
								generate_new_tire_set($ins_id, $db, $_team['id']);
								$tires = $db->getRaceTiresForDriver($_team['id'], $car_number);
							}
	
							//select tire hard, soft
							$hard_tire = null;
							$soft_tire = null;
							foreach($tires as $t)
							{
								if($hard_tire == null && $t['tire_type'] == 0)
									$hard_tire = $db->getRaceTire($t['id']);
								if($hard_tire != null && $t['tire_type'] == 0 && $t['distance'] <= $hard_tire['distance'])
									$hard_tire = $db->getRaceTire($t['id']);
								if($soft_tire == null && $t['tire_type'] == 1)
									$soft_tire = $db->getRaceTire($t['id']);
								if($soft_tire != null && $t['tire_type'] == 1 && $t['distance'] <= $soft_tire['distance'])
									$soft_tire = $db->getRaceTire($t['id']);
							}

							$_track = $db->getTrack($ins_id);
							$max = get_ai_strength($_team, $params);
							$max = $max * 2;
	
							//random settings
							$settings = array(
								/*'front_wing' => 45,
								'rear_wing' => 45,
								'front_suspension' => 50,
								'rear_suspension' => 50,
								'tire_pressure' => 50,
								'brake_balance' => 50,
								'gear_ratio' => 50*/
								'front_wing' => rand(max(0, $_track['front_wing'] - $max), min(90, $_track['front_wing'] + $max)),
							    'rear_wing' => rand(max(0, $_track['rear_wing'] - $max), min(90, $_track['rear_wing'] + $max)),
							    'front_suspension' => rand(max(0, $_track['front_suspension'] - $max), min(100, $_track['front_suspension'] + $max)),
							    'rear_suspension' => rand(max(0, $_track['rear_suspension'] - $max), min(100, $_track['rear_suspension'] + $max)),
							    'tire_pressure' => rand(max(0, $_track['tire_pressure'] - $max), min(100, $_track['tire_pressure'] + $max)),
							    'brake_balance' => rand(max(0, $_track['brake_balance'] - $max), min(100, $_track['brake_balance'] + $max)),
							    'gear_ratio' => rand(max(0, $_track['gear_ratio'] - $max), min(100, $_track['gear_ratio'] + $max))
							);
				
							//store to db
							if($i < 2)
							{
								switch(rand(0,1))
								{
									//hard
									case 0: $db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], 3, 1, $type); break;
									//soft
									case 1: $db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], 3, 1, $type); break;
								}
							}
							else
							{
								//last setup should be a not used tire (otherwise driver might be disqualified
								$setups = $db->getSetupSettingAll($car_number, $_team['id'], $ins_id, 1);
								//check if all tiretypes are used, otherwise set other tire_type
								$hard = 0;
								$soft = 0;
								if(isset($setups))
									foreach($setups as $setup)
									{
										if($setup['tire_type'] == 0)
											$hard++;
										if($setup['tire_type'] == 1)
											$soft++;
									}
								if($hard == 0)
									$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], 3, 1, $type);
								else
								{
									if($soft == 0)
										$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], 3, 1, $type);
									else
									{
										if(rand(0,1) == 0)
											$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], 3, 1, $type);
										else
											$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], 3, 1, $type);
									}	
								}
							}
						}//if setting
					}//for
				}
			}
		}//for
		
		//loop through all teams without manager
		$_teams =  $db->getFreeTeams($ins_id);
		foreach($_teams as $_team)
		{
			$db->repairRaceTiresForDriver($_team['id']);
			//for each qualification session
			for($i = 0; $i < 3; ++$i)
			{
				for($car_number = 1; $car_number < 3; ++$car_number)
				{
					$type = $i;
					$driver = $db->getDriver($car_number == 1?$_team['driver1']:$_team['driver2']);
		            
					//get all tires of driver
					//random tire type
					//tires
					$tires = $db->getRaceTiresForDriver($driver['ai_tea_id'], $car_number);
					//if driver has no tires yet
					if(count($tires) == 0)
					{
						generate_new_tire_set($ins_id, $db, $driver['ai_tea_id']);
						$tires = $db->getRaceTiresForDriver($driver['ai_tea_id'], $car_number);
					}
					//select tire hard, soft
					$hard_tire = null;
					$soft_tire = null;
					foreach($tires as $t)
					{
						if($hard_tire == null && $t['tire_type'] == 0)
							$hard_tire = $db->getRaceTire($t['id']);
						if($hard_tire != null && $t['tire_type'] == 0 && $t['distance'] <= $hard_tire['distance'])
							$hard_tire = $db->getRaceTire($t['id']);
						if($soft_tire == null && $t['tire_type'] == 1)
							$soft_tire = $db->getRaceTire($t['id']);
						if($soft_tire != null && $t['tire_type'] == 1 && $t['distance'] <= $soft_tire['distance'])
							$soft_tire = $db->getRaceTire($t['id']);
					}
					
					$_track = $db->getTrack($ins_id);
					$max = get_ai_strength($_team, $params);
					
					//random settings
			        $settings = array(
			            'front_wing' => rand(max(0, $_track['front_wing'] - $max), min(90, $_track['front_wing'] + $max)),
			            'rear_wing' => rand(max(0, $_track['rear_wing'] - $max), min(90, $_track['rear_wing'] + $max)),
			            'front_suspension' => rand(max(0, $_track['front_suspension'] - $max), min(100, $_track['front_suspension'] + $max)),
			            'rear_suspension' => rand(max(0, $_track['rear_suspension'] - $max), min(100, $_track['rear_suspension'] + $max)),
			            'tire_pressure' => rand(max(0, $_track['tire_pressure'] - $max), min(100, $_track['tire_pressure'] + $max)),
			            'brake_balance' => rand(max(0, $_track['brake_balance'] - $max), min(100, $_track['brake_balance'] + $max)),
			            'gear_ratio' => rand(max(0, $_track['gear_ratio'] - $max), min(100, $_track['gear_ratio'] + $max))
			        );
		
		            //store to db
		            if($i < 2)
		            {
						switch(rand(0,1))
						{
							//hard
							case 0: $db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $params['qualification_max_rounds'], 1, $type); break;
							//soft
							case 1: $db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $params['qualification_max_rounds'], 1, $type); break;
						}
		            }
		            else
		            {
		            	//last setup should be a not used tire (otherwise driver might be disqualified
		            	$setups = $db->getSetupSettingAll($car_number, $_team['id'], $ins_id, 1);
						//check if all tiretypes are used, otherwise set other tire_type
						$hard = 0;
						$soft = 0;
						if(isset($setups))
							foreach($setups as $setup)
							{
								if($setup['tire_type'] == 0)
									$hard++;
								if($setup['tire_type'] == 1)
									$soft++;
							}
						if($hard == 0)
							$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $params['qualification_max_rounds'], 1, $type);
						else
						{
							if($soft == 0)
								$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $params['qualification_max_rounds'], 1, $type);
							else
							{
								if(rand(0,1) == 0)
									$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $params['qualification_max_rounds'], 1, $type);
								else
									$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $params['qualification_max_rounds'], 1, $type);
							}	
						}
		            }
	            }//for
			}//for
		}//foreach
	}//ai_compute_qualification
	
	/*
	 * computes settings for race of ai driver
	 * params: instance id, db object
	 * return: nothing
	 */
	function ai_compute_race($ins_id, $db)
	{
		$params = $db->getParams($ins_id);
		
		//loop through all teams with manager
		//check if this user did qualification settings - if not use bad standard settings
		//so that his drivers take part
		$_teams =  $db->getManagedTeams($ins_id);
		foreach($_teams as $_team)
		{
			$db->repairRaceTiresForDriver($_team['id']);

			for($car_number = 1; $car_number < 3; ++$car_number)
			{
				$driver_id = $car_number == 1?$_team['driver1']:$_team['driver2'];
				if($driver_id)
				{
					for($type = 0; $type < 10; ++$type)
					{
						$settings = $db->getSetupSetting($car_number, $_team['id'], $ins_id, 2, $type);
	
						//if this driver has no setting
						if($settings == null || count($settings) == 0)
						{
							$driver = $db->getDriver($car_number == 1?$_team['driver1']:$_team['driver2']);
						
							//random values
							if(rand(0,1) == 0)
								$rounds = rand(1, 30);
							else
								$rounds = rand(15, 30);
		
							//tires
							$tires = $db->getRaceTiresForDriver($_team['id'], $car_number);
							//if driver has no tires yet
							if(count($tires) == 0)
							{
								generate_new_tire_set($ins_id, $db, $_team['id']);
								$tires = $db->getRaceTiresForDriver($_team['id'], $car_number);
							}
							//select tire hard, soft
							$hard_tire = null;
							$soft_tire = null;
							foreach($tires as $t)
							{
								if($hard_tire == null && $t['tire_type'] == 0)
									$hard_tire = $db->getRaceTire($t['id']);
								if($hard_tire != null && $t['tire_type'] == 0 && $t['distance'] < $hard_tire['distance'])
									$hard_tire = $db->getRaceTire($t['id']);
								if($soft_tire == null && $t['tire_type'] == 1)
									$soft_tire = $db->getRaceTire($t['id']);
								if($soft_tire != null && $t['tire_type'] == 1 && $t['distance'] < $soft_tire['distance'])
									$soft_tire = $db->getRaceTire($t['id']);
							}
							
							$_track = $db->getTrack($ins_id);
							$max = get_ai_strength($_team, $params);
							
							//random settings
							$settings = array(
								'front_wing' => 45,
								'rear_wing' => 45,
								'front_suspension' => 50,
								'rear_suspension' => 50,
								'tire_pressure' => 50,
								'brake_balance' => 50,
								'gear_ratio' => 50,
								'power1' => 50,
								'power2' => 50,
								'power3' => 50,
								'power4' => 50,
								'power5' => 50,
								'power6' => 50,
							);
							
							$settings = recomputePowerValues($settings);
				
							//store to db
							//$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, $tire_type, $rounds, 2, $type);
							//last setup should be a not used tire (otherwise driver might be disqualified
							$setups = $db->getSetupSettingAll($car_number, $_team['id'], $ins_id, 2);
							//check if all tiretypes are used, otherwise set other tire_type
							$hard = 0;
							$soft = 0;
							if(isset($setups))
								foreach($setups as $setup)
								{
									if($setup['tire_type'] == 0)
										$hard++;
									if($setup['tire_type'] == 1)
										$soft++;
								}
							if($hard == 0)
								$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $rounds, 2, $type);
							else
							{
								if($soft == 0)
									$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $rounds, 2, $type);
								else
								{
									if(rand(0,1) == 0)
										$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $rounds, 2, $type);
									else
										$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $rounds, 2, $type);
								}
							}
						}//if setting
						else
						{
							$type = 10;
						}
					}//for
				}
			}
		}//for
		
		//loop through all teams without manager
		$_teams =  $db->getFreeTeams($ins_id);
		foreach($_teams as $_team)
		{
			$db->repairRaceTiresForDriver($_team['id']);
			for($type = 0; $type < 10; ++$type)
			{
				for($car_number = 1; $car_number < 3; ++$car_number)
				{		        
			        $driver = $db->getDriver($car_number == 1?$_team['driver1']:$_team['driver2']);
			        
			        //random values
			        if(rand(0,1) == 0)
			        	$rounds = rand(1, 30);
			        else
		            	$rounds = rand(15, 30);

					//tires
					$tires = $db->getRaceTiresForDriver($driver['ai_tea_id'], $car_number);
					//if driver has no tires yet
					if(count($tires) == 0)
					{
						generate_new_tire_set($ins_id, $db, $driver['ai_tea_id']);
						$tires = $db->getRaceTiresForDriver($driver['ai_tea_id'], $car_number);
					}
					//select tire hard, soft
					$hard_tire = null;
					$soft_tire = null;
					foreach($tires as $t)
					{
						if($hard_tire == null && $t['tire_type'] == 0)
							$hard_tire = $db->getRaceTire($t['id']);
						if($hard_tire != null && $t['tire_type'] == 0 && $t['distance'] < $hard_tire['distance'])
							$hard_tire = $db->getRaceTire($t['id']);
						if($soft_tire == null && $t['tire_type'] == 1)
							$soft_tire = $db->getRaceTire($t['id']);
						if($soft_tire != null && $t['tire_type'] == 1 && $t['distance'] < $soft_tire['distance'])
							$soft_tire = $db->getRaceTire($t['id']);
					}
					
		            $_track = $db->getTrack($ins_id);
					$max = get_ai_strength($_team, $params);
					
					//random settings
			        $settings = array(
			            'front_wing' => rand(max(0, $_track['front_wing'] - $max), min(90, $_track['front_wing'] + $max)),
			            'rear_wing' => rand(max(0, $_track['rear_wing'] - $max), min(90, $_track['rear_wing'] + $max)),
			            'front_suspension' => rand(max(0, $_track['front_suspension'] - $max), min(100, $_track['front_suspension'] + $max)),
			            'rear_suspension' => rand(max(0, $_track['rear_suspension'] - $max), min(100, $_track['rear_suspension'] + $max)),
			            'tire_pressure' => rand(max(0, $_track['tire_pressure'] - $max), min(100, $_track['tire_pressure'] + $max)),
			            'brake_balance' => rand(max(0, $_track['brake_balance'] - $max), min(100, $_track['brake_balance'] + $max)),
			            'gear_ratio' => rand(max(0, $_track['gear_ratio'] - $max), min(100, $_track['gear_ratio'] + $max)),
			            'power1' => rand(0, 100),
			            'power2' => rand(0, 100),
			            'power3' => rand(0, 100),
			            'power4' => rand(0, 100),
			            'power5' => rand(0, 100),
			            'power6' => rand(0, 100),
			        );
			        
			        $settings = recomputePowerValues($settings);
		
		            //store to db
		            //$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, $tire_type, $rounds, 2, $type);
		            //last setup should be a not used tire (otherwise driver might be disqualified
					$setups = $db->getSetupSettingAll($car_number, $_team['id'], $ins_id, 2);
					//check if all tiretypes are used, otherwise set other tire_type
					$hard = 0;
					$soft = 0;
					if(isset($setups))
						foreach($setups as $setup)
						{
							if($setup['tire_type'] == 0)
								$hard++;
							if($setup['tire_type'] == 1)
								$soft++;
						}
					if($hard == 0)
						$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $rounds, 2, $type);
					else
					{
						if($soft == 0)
							$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $rounds, 2, $type);
						else
						{
							if(rand(0,1) == 0)
								$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 0, $hard_tire['id'], $rounds, 2, $type);
							else
								$db->insertSetupSetting($car_number, $_team['id'], $_team['league'], $_team['ins_id'], $settings, 1, $soft_tire['id'], $rounds, 2, $type);
						}
					}
				}//for
			}//for
		}//for
	}//ai_compute_race
	
	/*
	 * returns league array for compute_season_goal and compute_new_team_class
	 */
	function get_leagues_array()
	{
		return array(array(1,2,3,4), array(4,5,6,7), array(7,8,9,10));
	}
	
	/*
	 * function that returns season goal by leage and class
	 * goal is returned as number between 0 and 3
	 * 0...champion, 1...good midfield, 2...good show, 3...not last place
	 */
	function compute_season_goal($league, $class)
	{
		$leagues_array = get_leagues_array();
		//			League 1		League 2		League 3
		//1-3		1				3				5
		//4-6		2				4				6
		//7-10		3				5				7
		//11-x		4				6				8
		$index = -1;
		$league = $league - 1;
		if($class <= $leagues_array[$league][0])
		{
			$index = 0;
		}
		if($class > $leagues_array[$league][0] && $class <= $leagues_array[$league][1])
		{
			$index = 1;
		}
		if($class > $leagues_array[$league][1] && $class <= $leagues_array[$league][2])
		{
			$index = 2;
		}
		if($class > $leagues_array[$league][2])
		{
			$index = 3;
		}
		return $index;
	}
	
	/*
	 * Function that gets all drivers from database and randomize their
	 * names, genders, nations and birthday years
	 */
	function randomize_drivers($db)
	{
		$countries = $db->getCountries();
		$maxCountries = 0;

		foreach($countries as $c)
		{
			$maxCountries+= $c['relevance'];
		}
		
		//get all instances
		$instances = $db->getInstances();
		
		foreach($instances as $instance)
		{
			if($instance['id'] < 11)
				continue;
			
			//get all drivers from DB
			$drivers = $db->getDrivers($instance['id'],'','id ASC');
			
			foreach($drivers as $driver)
			{
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
				$rand_gender = rand(0,9);	//0..female, other..male
				$firstnames = $db->getFirstnames($country['language'], $rand_gender);
				$lastnames = $db->getLastnames($country['language']);
				
				$image_folder = "1/";
				if($country['language'] == 1)
					$image_folder = "3/";
				if($country['language'] == 3 || $country['language'] == 4 || $country['language'] == 5 || $country['language'] == 22 || $country['language'] == 27 || 
				   $country['language'] == 31 || $country['language'] == 32 || $country['language'] == 34 || $country['language'] == 40 || $country['language'] == 41 ||
				   $country['language'] == 54 || $country['language'] == 55 || $country['language'] == 57)
					$image_folder = "2/";
				
				//gender (female 1 of 10) 
				if($rand_gender == 0)
				{
					//max. number of files for male and female driver images
					$female_files_count = new FilesystemIterator("./content/img/driver/female/".$image_folder, FilesystemIterator::SKIP_DOTS);
					$firstname = $firstnames[rand(0, count($firstnames) - 1)]['name'];
					$gender = 1;
					$number = iterator_count($female_files_count);
					//copy file with driver id as filename
					$dirname = "./content/img/driver/".$instance['id'];
					if(!is_dir($dirname))
						mkdir($dirname);
					$picture = $instance['id']."/".$driver['id'].".svg";
					copy("./content/img/driver/female/".$image_folder.str_pad(rand(1,$number), 3, '0', STR_PAD_LEFT).".svg", "./content/img/driver/".$picture);
				}
				else
				{
					//max. number of files for male and female driver images
					$male_files_count = new FilesystemIterator("./content/img/driver/male/".$image_folder, FilesystemIterator::SKIP_DOTS);
					$firstname = $firstnames[rand(0, count($firstnames) - 1)]['name'];
					$gender = 0;
					$number = iterator_count($male_files_count);
					//copy file with driver id as filename
					$dirname = "./content/img/driver/".$instance['id'];
					if(!is_dir($dirname))
						mkdir($dirname);
					$picture = $instance['id']."/".$driver['id'].".svg";
					copy("./content/img/driver/male/".$image_folder.str_pad(rand(1,$number), 3, '0', STR_PAD_LEFT).".svg", "./content/img/driver/".$picture);
				}
				
				$lastname = $lastnames[rand(0, count($lastnames) - 1)]['name'];
				$shortname = strtoupper(substr(uml_replace($lastname), 0, 2) . substr(uml_replace($firstname), 0, 1));

				//birthday
				$datestart = strtotime((date("Y") - 45).'-01-01');//you can change it to your timestamp;
				$dateend = strtotime((date("Y") - 16).'-12-31');//you can change it to your timestamp;
				$daystep = 86400;
				$datebetween = abs(($dateend - $datestart) / $daystep);
				$randomday = rand(0, $datebetween);
				$birthday = date("Y-m-d", $datestart + ($randomday * $daystep));
				
				$db->updateRandomDriverAttributes($driver['id'], $firstname, $lastname, $shortname, $gender, $birthday, $country['id'], $picture);
			}//foreach
		}//foreach
	}//randomize_drivers
	
	/*
	 * Function that generates random setup values for all tracks
	 */
	function randomize_track($db)
	{
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			$tracks = $db->getAllTracks($instance['id']);
			foreach($tracks as $track)
			{
				$array = array();
				$array['front_wing'] = rand(0,90);
				$array['rear_wing'] = rand(0,90);
				$array['front_suspension'] = rand(0,100);
				$array['rear_suspension'] = rand(0,100);
				$array['tire_pressure'] = rand(0,100);
				$array['brake_balance'] = rand(0,100);
				$array['gear_ratio'] = rand(0,100);
				$array['weather'] = rand(1,100);
						
				$db->updateTrack($track['id'], $array);
			}
		}
	}//randomize_track
	
	/*
	 * Function that generates a new season calendar
	 * with new dates and new tracks
	 */
	function generate_track_calendar($db)
	{
		//get all instances
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			$params = $db->getParams($instance['id']);
			$race_days = explode(",", $params['race_days']);
			$race_time = explode(",", $params['race_time']);
			$startdate = time();
			$hours_to_add = floor(($instance['id'] - 1) / 5);
			//move to date to start saison
			while(date("N", $startdate) != $race_days[0])
			{
				$startdate = strtotime("+1 day", $startdate);
			}
			$startdate = strtotime("+".$params['pre_saison']." weeks", $startdate);
			$tracks = $db->getTrackCalendar($instance['id']);
			$all_tracks = $db->getAllTracks($instance['id']);
			foreach($tracks as $track)
			{
				$training = date("Y-m-d", $startdate)." ".$race_time[0];
				while(date("N", $startdate) != $race_days[1])
				{
					$startdate = strtotime("+1 day", $startdate);
				}
				$quali = date("Y-m-d", $startdate)." ".$race_time[1];
				$quali = new DateTime($quali);
				$quali = $quali->format("U");
				$quali+= $hours_to_add * 3600;
				$quali = date("Y-m-d H:i:s", $quali);
				while(date("N", $startdate) != $race_days[2])
				{
					$startdate = strtotime("+1 day", $startdate);
				}
				$race = date("Y-m-d", $startdate)." ".$race_time[2];
				$race = new DateTime($race);
				$race = $race->format("U");
				$race+= $hours_to_add * 3600;
				$race = date("Y-m-d H:i:s", $race);
				//get random track id
				$index = rand(0, count($all_tracks) - 1);
				$tra_id = -1;
				$tmp_array = array();
				$array_size = count($all_tracks);
				for($i = 0; $i < $array_size; ++$i)
				{
					if($i == $index)
					{
						$tra_id = $all_tracks[$i]['id'];
					}
					else
					{
						$tmp_array[] = $all_tracks[$i];
					}
				}
				$all_tracks = $tmp_array;
				$db->updateTrackCalendar($track['id'], $tra_id, $training, $quali, $race);
				while(date("N", $startdate) != $race_days[0])				
				{
					$startdate = strtotime("+1 day", $startdate);
				}
			}//foreach
		}//foreach
	}//generate_track_calendar
	
	/*
	 * ascenders and descenders to new league
	 */
	function compute_ascender_descender($db)
	{
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			//league 1
			$teams_l1 = $db->getTeamsOfLeague($instance['id'], 1, 'points DESC, placement DESC');
			//league 2
			$teams_l2 = $db->getTeamsOfLeague($instance['id'], 2, 'points DESC, placement DESC');
			//league 3
			$teams_l3 = $db->getTeamsOfLeague($instance['id'], 3, 'points DESC, placement DESC');
			
			//league 1
			$db->updateTeamLeague($teams_l1[count($teams_l1) - 1]['id'], 2);
			//league 2
			$db->updateTeamLeague($teams_l2[0]['id'], 1);
			$db->updateTeamLeague($teams_l2[count($teams_l2) - 1]['id'], 3);
			//league 3
			$db->updateTeamLeague($teams_l3[0]['id'], 2);
		}
	}//compute_ascender_descender
	
	/*
	 * changes team class based on position after season
	 */
	function compute_new_team_class($db)
	{
		$leagues_array = get_leagues_array();
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			//leagues
			for($l = 1; $l < 4; ++$l)
			{
				$teams = $db->getTeamsOfLeague($instance['id'], $l, 'points DESC, placement DESC');
				$i = 0;
				foreach($teams as $team)
				{
					compute_new_team_class_for_team($db,$team,$i,$leagues_array);
					++$i;
				}
			}
		}//foreach
	}//compute_new_team_class
	
	function compute_new_team_class_for_team($db, $team, $i, $leagues_array)
	{
		//			League 1		League 2		League 3
		//1-3		1				3				5
		//4-6		2				4				6
		//7-10		3				5				7
		//11-x		4				6				8
		$index = -1;
		if($i < 4)
		{
			$index = 0;
		}
		if($i > 3 && $i < 7)
		{
			$index = 1;
		}
		if($i > 6 && $i < 11)
		{
			$index = 2;
		}
		if($i > 10)
		{
			$index = 3;
		}
		
		if($index != -1)
		{
			//good
			if($leagues_array[$team['league'] - 1][$index] < $team['class'])
			{
				$team['class'] = $team['class'] - 1;
				if($team['class'] < 1)
					$team['class'] = 1;
				$db->updateTeamClass($team['id'], $team['class']);
			}
			//bad
			if($leagues_array[$team['league'] - 1][$index] > $team['class'])
			{
				$team['class'] = $team['class'] + 1;
				if($team['class'] > 10)
					$team['class'] = 10;
				$db->updateTeamClass($team['id'], $team['class']);
			}
		}
	}//compute_new_team_class_for_team
	
	/*
	 * gets the champions of leagues and set statistic values
	 */
	function compute_world_champion_statistic($db)
	{
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			for($l = 1; $l < 4; ++$l)
			{
				//constructor
				$teams = $db->getTeamsOfLeague($instance['id'], $l, 'points DESC, placement DESC');
				$db->setWorldChampionTeam($teams[0]['id'], $l);
				
				//driver
				$drivers = $db->getDriversOfLeague($instance['id'], $l, '', 'points DESC, placement DESC');
				$db->setWorldChampionDriver($drivers[0]['id'], $l);
			}//for
		}//foreach
	}
	
	/*
	 * team gets money for titles (constructor and driver)
	 */
	function compute_team_finance($db)
	{
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			$bonus = $db->getBonus();
			
			
			for($l = 1; $l < 4; ++$l)
			{
				switch($l)
				{
					case 1: $constructor_bonus = explode(" ", $bonus['f1_constructor']);
							$driver_bonus = explode(" ", $bonus['f1_driver']);
							break;
					case 2: $constructor_bonus = explode(" ", $bonus['f2_constructor']);
							$driver_bonus = explode(" ", $bonus['f2_driver']);
							break;
					case 3: $constructor_bonus = explode(" ", $bonus['f3_constructor']);
							$driver_bonus = explode(" ", $bonus['f3_driver']);
							break;
				}
				//constructor
				$teams = $db->getTeamsOfLeague($instance['id'], $l, 'points DESC, placement DESC');
				$array_size = count($teams);
				$array_size1 = count($constructor_bonus);
				for($i = 0; $i < $array_size; ++$i)
				{
					//only for human players
					if($db->isManagedTeam($teams[$i]['id']))
					{
						$index = ($i < $array_size1)?$i:($array_size1 - 1);
						$db->getBonusPoints($instance['id'], $teams[$i]['id'], $constructor_bonus[$index]);
					}
				}//for
				
				//driver
				$drivers = $db->getDriversOfLeague($instance['id'], $l, '', 'points DESC, placement DESC');
				$array_size = count($drivers);
				$array_size1 = count($driver_bonus);
				for($i = 0; $i < $array_size; ++$i)
				{
					//only for human players
					if($drivers[$i]['tea_id'] != null)
					{
						$index = ($i < $array_size1)?$i:($array_size1 - 1);
						$db->getBonusPoints($instance['id'], $drivers[$i]['tea_id'], $driver_bonus[$index]);
					}
				}//for
			}//for
		}//foreach
	}//compute_team_finance
	
	/*
	 * Functions for season events
	 */
	 
	/*
	 * function computes AI training
	 */
	function cron_compute_training($db, $ins_id)
	{
		user_helper($ins_id, $db);
		
		ai_update_drivers($ins_id, $db);
		ai_update_parts($ins_id, $db);
		ai_compute_training($ins_id, $db);
	}//cron_compute_training
	
	/*
	 * function computes AI quali setups and qualification
	 */
	function cron_compute_qualification($db, $ins_id)
	{
		ai_update_drivers($ins_id, $db);
		ai_update_parts($ins_id, $db);
		ai_compute_qualification($ins_id, $db);
	    
        include_once('classes/F1Cron.class.php');
        $f1cron = new F1Cron($db);
        $f1cron->compute_qualification($ins_id);
	}//cron_compute_qualification
	
	/*
	 * function computes AI race setups, race
	 * and all after race events (points, finance, statistic, driver training)
	 */
	function cron_compute_race($db, $ins_id)
	{
		ai_update_drivers($ins_id, $db);
		ai_update_parts($ins_id, $db);
		ai_compute_race($ins_id, $db);
		
		include_once('classes/F1Cron.class.php');
		$f1cron = new F1Cron($db);
		$f1cron->compute_race($ins_id);
		$f1cron->compute_points($ins_id);
		$f1cron->compute_finance($ins_id);
		$f1cron->compute_statistic($ins_id);
		$f1cron->compute_training($ins_id);
		$f1cron->change_mechanic_values($ins_id);
	}//cron_compute_race
	
	/*
	 * function that jumps to next race and opens training
	 * it also generates new tires and makes morale update based on
	 * last race result
	 */
	function cron_compute_next_race($db, $ins_id)
	{
		include_once('classes/F1Cron.class.php');
		$f1cron = new F1Cron($db);
		//morale computation
		$f1cron->compute_morale($ins_id);
		//move to next race
		$f1cron->move_to_next_race($ins_id);
		generate_new_tire_set($ins_id, $db);
		
		$_SESSION = array();	//delete all sessions
	}//cron_compute_next_race
	
	/*
	 * function that computes driver bids so that a driver
	 * automatically accepts the best offer
	 */
	function cron_compute_driver_bids($db, $ins_id)
	{
		$params = $db->getParams($ins_id);
		//get all bids (ordered by dri_id, created)
		$bids = $db->getDriverBids($ins_id);
		$bids_array = array();
		//get bids arrays for driver
		$array_size = count($bids);
		for($i = 0; $i < $array_size; ++$i)
		{
			$bids_array[$bids[$i]['dri_id']][] = $bids[$i];
		}
		$time = time();
		foreach($bids_array as $driver_array)
		{
			$bid_time = strtotime($driver_array[0]['created']);
			$bid_time = strtotime("+".$params['bid_time']." hours", $bid_time);
			$bid_time = roundToNextHour(date('Y-m-d H:i:s', $bid_time));
			$bid_time = strtotime($bid_time);
			
			//if bid time is over -> driver need to make his decision 
			if($bid_time <= $time)
			{
				$driver_bids = $db->getDriverBidsDriver($ins_id, $driver_array[0]['dri_id']);
				$best = -1;
				$array_size = count($driver_array);
				for($j = 0; $j < $array_size; ++$j)
				{
					//calculate max
					foreach($driver_bids as $d_b)
					{
						$value = $d_b['wage'] + ($d_b['bonus'] * 100);
						if($value > $best)
							$best = $value;
					}
					$current = $driver_array[$j]['wage'] + ($driver_array[$j]['bonus'] * 100);

					if($current > $best)
						$driver_array[$j]['chance'] = 100;
					else
						if($best > 0)
							$driver_array[$j]['chance'] = number_format($current * 100 / $best, 2);
						else
							$driver_array[$j]['chance'] = 100;
				}
				//acknowledge bid
				$array_size = count($driver_array);
				for($j=0; $j < $array_size; ++$j)
				{
					if($driver_array[$j]['chance'] == 100)
					{
						change_driver_cloth($driver_array[$j]['id'], $db);
						$db->buyDriverFromBid($driver_array[$j]['id']);
						break;
					}
				}
				//remove drivers with silly bids -> 0 chance
				for($j=0; $j < $array_size; ++$j)
				{
					if($driver_array[$j]['chance'] == 0)
					{
						$db->removeDriverFromBid($driver_array[$j]['id']);
						break;
					}
				}
			}//if
		}//foreach
		
		user_helper($ins_id, $db);
	}//cron_compute_driver_bids
	
	function change_driver_cloth($id, $db)
	{
		$bid = $db->getDriverBid($id);
		change_youth_driver_cloth($bid['tea_id'], $bid['dri_id'], $db);
	}
	
	function change_youth_driver_cloth($tea_id, $dri_id, $db)
	{
		$team = $db->getTeam($tea_id);
		$color1 = $team['color1'];
		$color2 = $team['color2'];
		$driver = $db->getDriver($dri_id);
		$filename = "./content/img/driver/".$driver['picture'];
		$svg = new SimpleXMLElement( file_get_contents($filename) );
		$svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
		$svg->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');
		for($i = 0; $i < count($svg->g); ++$i)
		{
			if($svg->g[$i]['id'] == "svga-group-wrapper")
			{
				for($j = 0; $j < count($svg->g[$i]->g); ++$j)
				{
					if($svg->g[$i]->g[$j]['id'] == "svga-group-subwrapper")
					{
						for($x = 0; $x < count($svg->g[$i]->g[$j]->g); ++$x)
						{
							if($svg->g[$i]->g[$j]->g[$x]['id'] == "svga-group-clothes-single")
							{
								for($y = 0; $y < count($svg->g[$i]->g[$j]->g[$x]->path); ++$y)
								{
									if($y == 0)
										$svg->g[$i]->g[$j]->g[$x]->path[$y]['fill'] = "#".$color1;
									else if($y == 3)
										$svg->g[$i]->g[$j]->g[$x]->path[$y]['fill'] = "#".$color2;
									else
										$svg->g[$i]->g[$j]->g[$x]->path[$y]['fill'] = "#000000";
								}
								break;
							}
						}
						break;
					}
				}
				break;
			}
		}
		file_put_contents($filename, str_replace('<?xml version="1.0"?>','', $svg->asXML()));
	}
	
	function export_manager_image_to_forum($id, $email)
	{
		global $phpbb_root_path, $phpbb_db_server, $phpbb_db_database, $phpbb_db_password, $phpbb_db_user, $phpbb_db_port;
		
		if($phpbb_root_path == "")
			return;

		$con = new PDO("mysql:host=$phpbb_db_server;dbname=$phpbb_db_database", $phpbb_db_user, $phpbb_db_password, array(PDO::ATTR_PERSISTENT => true));
        $con->exec("SET CHARACTER SET utf8");
        
        //get avatar salt from database
        $sql = "SELECT config_value FROM phpbb_config WHERE config_name = :config_name";
		$ps = $con->prepare($sql);
		$ps->bindValue('config_name', "avatar_salt");
		$ps->execute();
		$row = $ps->fetchAll();
		$avatar_salt = null;
		if(count($row) > 0)
		{
			$avatar_salt = $row[0]['config_value'];
		}
		if($avatar_salt == null)
			return;
		
		//get forum user id
		$sql = "SELECT user_id FROM phpbb_users WHERE user_email = :user_email";
		$ps = $con->prepare($sql);
		$ps->bindValue('user_email', $email);
		$ps->execute();
		$row = $ps->fetchAll();
		$forum_user_id = null;
		if(count($row) > 0)
		{
			$forum_user_id = $row[0]['user_id'];
		}
		if($forum_user_id == null)
			return;
		
		$filename = "./content/img/manager/".$id.".png";
		
		//fix eye error from svg
		/*7$svg = new SimpleXMLElement( file_get_contents($filename) );
		$svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');
		$svg->registerXPathNamespace('xlink', 'http://www.w3.org/1999/xlink');
		for($i = 0; $i < count($svg->g); ++$i)
		{
			if($svg->g[$i]['id'] == "svga-group-wrapper")
			{
				for($j = 0; $j < count($svg->g[$i]->g); ++$j)
				{
					if($svg->g[$i]->g[$j]['id'] == "svga-group-subwrapper")
					{
						for($x = 0; $x < count($svg->g[$i]->g[$j]->g); ++$x)
						{
							if($svg->g[$i]->g[$j]->g[$x]['id'] == "svga-group-head")
							{
								for($y = 0; $y < count($svg->g[$i]->g[$j]->g[$x]->g); ++$y)
								{
									if($svg->g[$i]->g[$j]->g[$x]->g[$y]['id'] == "svga-group-eyes-left")
									{
										for($z = 0; $z < count($svg->g[$i]->g[$j]->g[$x]->g[$y]->g); ++$z)
										{
											if($svg->g[$i]->g[$j]->g[$x]->g[$y]->g[$z]['id'] == "svga-group-eyesback-left")
											{
												for($k = 0; $k < count($svg->g[$i]->g[$j]->g[$x]->g[$y]->g[$z]->path); ++$k)
												{
													$svg->g[$i]->g[$j]->g[$x]->g[$y]->g[$z]->path[$k]['fill'] = "#ffffff";
												}
												break;
											}
										}
									}
									if($svg->g[$i]->g[$j]->g[$x]->g[$y]['id'] == "svga-group-eyes-right")
									{
										for($z = 0; $z < count($svg->g[$i]->g[$j]->g[$x]->g[$y]->g); ++$z)
										{
											if($svg->g[$i]->g[$j]->g[$x]->g[$y]->g[$z]['id'] == "svga-group-eyesback-right")
											{
												for($k = 0; $k < count($svg->g[$i]->g[$j]->g[$x]->g[$y]->g[$z]->path); ++$k)
												{
													$svg->g[$i]->g[$j]->g[$x]->g[$y]->g[$z]->path[$k]['fill'] = "#ffffff";
												}
												break;
											}
										}
									}
								}
							}
							
						}
					}
				}
				break;
			}
		}
		file_put_contents($filename, str_replace('<?xml version="1.0"?>','', $svg->asXML()));
		
		//generate png from svg and save to forum
		$im = new Imagick();
		$svg = file_get_contents($filename);
		
		$im->readImageBlob('<?xml version="1.0" encoding="UTF-8" standalone="no"?>'.$svg);
		$im->setImageBackgroundColor(new ImagickPixel('transparent'));
		
		$im->setImageFormat("png24");
		$im->resizeImage(90, 90, imagick::FILTER_LANCZOS, 1);
		
		$im->writeImage($phpbb_root_path."images/avatars/upload/".$avatar_salt."_".$forum_user_id.".png");
		$im->clear();
		$im->destroy();*/
		
		$new_filename = $phpbb_root_path."images/avatars/upload/".$avatar_salt."_".$forum_user_id.".png";
		
		$img = imagecreatefrompng($filename);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		
		$width = 90;
		$height = 90;
		$new_image = imagecreatetruecolor ( $width, $height );

		imagealphablending($new_image , false);
		imagesavealpha($new_image , true);
		imagecopyresampled( $new_image, $img, 0, 0, 0, 0, $width, $height, imagesx ( $img ), imagesy ( $img ) );

		//save image to filesystem
		imagepng($new_image, $new_filename, 9, PNG_ALL_FILTERS);
		
		$sql = "UPDATE phpbb_users SET user_avatar = :user_avatar, user_avatar_type = :user_avatar_type, user_avatar_width = 90, user_avatar_height = 90 WHERE user_id = :user_id";
		$ps = $con->prepare($sql);
		$ps->bindValue('user_avatar', $forum_user_id.".png");
		$ps->bindValue('user_avatar_type', 1); //avatar.driver.upload for phpbb 3.1
		$ps->bindValue('user_id', $forum_user_id);
		$ps->execute();
	}
	
	/*
	 * function that runs throw all drivers from human teams
	 * and decide to leave team based on morale
	 */
	function compute_driver_leave_team($db)
	{
		//get all drivers that are from an human team
		$drivers = $db->getAllDrivers("tea_id IS NOT NULL");
		foreach($drivers as $driver)
		{
			$rnd = rand(1,100);
			$morale = $driver['morale'];
			if($rnd > $morale)
			{
				//driver should leave team
				$sell_price = calculate_sell_price($driver,0);
				$db->sellDriver($driver['id'], $driver['tea_id'], $driver['ins_id'], $sell_price);
			}
		}
	}//compute_driver_leave_team
	
	function deleteAiItems($db)
	{
		$instances = $db->getInstances();
		foreach($instances as $instance)
		{
			$db->deleteAiItems($instance['id']);
		}
	}
	
	/*
	 * function that does all steps to switch to next saison
	 */
	function cron_compute_next_season($db)
	{
		//todo
		//world champion statistic
		compute_world_champion_statistic($db);
		//final finance computation
		compute_team_finance($db);
		//update team class based on position
		compute_new_team_class($db);
		//ascender / descender
		compute_ascender_descender($db);
		//reset placement and points
		$db->resetPlacementAndPoints();
		//reset youth driver max for team
		$db->resetYouthDriver();
		//delete AI items
		deleteAiItems($db);
		//delete AI items
		$db->deleteAiDrivers();
		//clear sponsor and tire sponsor
		$db->deleteSponsors();
		//clear all tires
		$db->deleteRaceTires();
		//delete track saison data
		$db->deleteTrackSeasonData();
		//randomive track values
		randomize_track($db);
		//generates new track calendar
		generate_track_calendar($db);
		//update instance
		$db->updateInstanceNextSaison();
		//remove driver (depends on morale)
		compute_driver_leave_team($db);
		//delete in_out table
		$db->deleteInOut();
		//delete driver_history
		$db->deleteDriverHistory();
		//delete team_history
		$db->deleteTeamHistory();
		//delete Quali and Race data from instance
		$db->deleteQualiAndRaceDataFromInstance();
		//delete setup and setup_setting
		$db->deleteSetupAndSetupSetting();

		//set back training, qualification and race
		$db->resetTQR();

		$_SESSION = array();	//delete all sessions
	}//cron_compute_next_season
	
	function write_text_to_forum($forum_id, $subject, $text)
	{
		global $phpbb_root_path, $phpbb_autopost_username, $phpbb_autopost_password;
        global $phpbb_container;
        global $phpEx, $user, $auth, $cache, $db, $config, $template, $table_prefix;
        global $request;
        global $phpbb_dispatcher;
        global $symfony_request;
        global $phpbb_filesystem;
        global $phpbb_extension_manager;

		if($phpbb_root_path != '')	//path comes from config.inc.php
		{
			define('IN_PHPBB', true);
			$phpEx = substr(strrchr(__FILE__, '.'), 1);
			include_once($phpbb_root_path . 'common.'.$phpEx);
			include_once($phpbb_root_path . 'includes/functions_user.'.$phpEx);
			if($request)
				$request->enable_super_globals(); //for phpbb >= 3.1.x
			
			include_once($phpbb_root_path . 'includes/functions_posting.'.$phpEx);
			$my_subject = $subject;
			$my_text = $text;
			$poll = $uid = $bitfield = $options = "";
			generate_text_for_storage($my_subject, $uid, $bitfield, $options, false, false, false);
			generate_text_for_storage($my_text, $uid, $bitfield, $options, true, true, true);
			
			$user->session_begin();
			$auth->acl($user->data);
			$user->setup();
			//auto login user
			$username_phpbb = $phpbb_autopost_username;
			$password_phpbb = $phpbb_autopost_password;
			$auth->login($username_phpbb, $password_phpbb, true);
			
			$data = array(
				'forum_id' => $forum_id,
				'icon_id' => false,
				'enable_bbcode' => true,
				'enable_smilies' => true,
				'enable_urls' => false,
				'enable_sig' => true,
				'message' => $my_text,
				'message_md5' => md5($my_text),
				'bbcode_bitfield' => $bitfield,
				'bbcode_uid' => $uid,
				'post_edit_locked' => 0,
				'topic_title' => $my_subject,
				'notify_set' => false,
				'notify' => false,
				'post_time' => 0,
				'forum_name' => '',
				'enable_indexing' => true,
				'topic_first_poster_name' => "Admin",
				'force_approved_state' => true,		//3.1
				'force_visibility' => true,			//3.0
			);
			
			submit_post('post', $my_subject, 'admin', POST_NORMAL, $poll, $data);
		}	
	}
	
	function get_phpbbforum_subject($language_id, $type, $track)
	{
		//deutsch
		if($language_id == 0)
		{
			if($type == 0)	//qualification
				return $track['name']." Qualifikation";
			if($type == 1)	//race
				return $track['name']." Rennen";
		}
		//english
		if($language_id == 1)
		{
			if($type == 0)
				return $track['name']." Qualification";
			if($type == 1)
				return $track['name']." Race";
		}
	}
	
	/*
	 * should help dumb users to get a correct setup for first quali
	 * only if user has tire sponsor
	 * driver to car (if > 2)
	 * buy items (cheapest) and move to car
	 */
	function user_helper($instance_id, $db)
	{
		$debug = false;
		$teams = $db->getTeams($instance_id, 'id asc');
		if($debug) echo "Liga: ".$instance_id."<br>";
		$max = 0;
		foreach($teams as $team)
		{
			//remove at max 5 per cron run
			if($max >= 5)
				continue;
			
			$remove = false;
			if($debug) echo "Team: ".$team['name']."<br>";

			//check login
			$user = $db->getUserByTeam($team['id']);
			if($user == null)
				continue;

			$last_login = $user['last_login'];
			if($last_login != null)
			{
				$datetime1 = date_create(date('Y-m-d H:i:s', time()));
				$datetime2 = date_create($last_login);
				$interval = date_diff($datetime1, $datetime2);
				if(abs($interval->format('%R%a')) > 40)
					$remove = true;
			}

			//only if team has tire sponsor
			if($team['tir_id'] != null)
			{
				//drivers
				$drivers = $db->getDriversOfTeam($team['id'], 'id asc');
				if($debug) echo "Fahrer: ".count($drivers)."<br>";
				if(count($drivers) < 2)
				{
					$bidcount = $db->getCountDriverBidsTeam($team['ins_id'], $team['id']);
					if($debug) echo "Bidcount: ".$bidcount."<br>";
					if($bidcount == 0)
					{
						//team has not enough drivers
						$remove = true;
					}
				}
				$driver_of_team = 0;
				if($team['driver1']) ++$driver_of_team;
				if($team['driver2']) ++$driver_of_team;
				if($team['driver3']) ++$driver_of_team;
				
				//if there are more driver than team driver
				if(count($drivers) > $driver_of_team)
				{
					for($i = 0; $i < count($drivers); ++$i)
					{
						if($i < 3)
						{
							$db->setTeamDriver($team['id'], $drivers[$i]['id'], $i + 1);
							if($debug) echo "Fahrer wird gesetzt: ".$drivers[$i]['firstname']." ".$drivers[$i]['lastname']."<br>";
						}
					}
				}
				
				//items
				$items = $db->getItems(2,0);
				//loop all 3 cars
				for($i = 0; $i < 3; ++$i)
				{
					if($debug) echo "Auto: ".$i."<br>";
					//step 1 get items and by all type items that are missing
					$car_old = $db->getItemsFromCar($team['id'], $i + 1);
					if($debug) echo "Teile: ".count($car_old)."<br>";
					for($type = 0; $type < 10; ++$type)
					{
						$has_type = false;
						foreach($car_old as $item)
						{
							if($item['type'] == $type)
							{
								$has_type = true;
								break;
							}
						}//foreach item
						
						//if current car has no item with this type
						if(!$has_type)
						{
							$item_id = null;
							foreach($items as $item)
							{
								if($item['type'] == $type)
								{
									$item_id = $item['id'];
									break;
								}
							}
							if($item_id)
							{
								//by missing item
								$db->buyItem($item_id, $team['id'], $instance_id);
								if($debug) echo "kaufe Item: ".$item_id."<br>";
							}
							
							//get and set item
							$items_old = $db->getItemsFromStock($team['id'], 'id asc');
							for($t = 0; $t < count($items_old); ++$t)
							{
								if($items_old[$t]['car_number'] == null)
								{
									$ite = $db->getItem($items_old[$t]['ite_id']);
									if($ite['type'] == $type)
									{
										$db->setItemCarNumber($i + 1, $items_old[$t]['id']);
										if($debug) echo "setze Item: ".$items_old[$t]['id']."<br>";
										break;
									}
								}
							}
						}
					}//for type
				}//for cars
			}//if
			
			//teams with no tire sponsor --> may user should be banished
			else
			{
				if($debug) echo "Team has not tire sponsor.<br>";
				$bidcount = $db->getCountDriverBidsTeam($team['ins_id'], $team['id']);
				if($debug) echo "Bidcount: ".$bidcount."<br>";
				if($bidcount == 0)
				{
					//remove
					$remove = true;
				}
			}
			
			if($remove)
			{
				//only remove if season race is > 1
				$instance = $db->getInstance($instance_id);
				if($instance['current_race'] <= 1)
					continue;

				++$max;
				$_user = $db->getUserByTeam($team['id']);
				$usercount = $db->getCountUsers();
				if($debug) echo "Usercount: ".$usercount." own id: ".$_user['id']."<br>";
				if($_user['id']/* < $usercount - 60*/)
				{
					if($debug) echo "delete user from team<br>";
					$db->removeUserFromTeam($_user['id']);
					$db->resetTeam($team['id']);

					$email = $_user['email'];
					$admin_mail = "admin@racing-manager.com";
					
					$_language = "de";
					if($_user['language'] != 0)
						$_language = "en";
					Translator::init($_language);
					if($debug) echo "language: ".$_user['language']." - ".$_language."<br>";
					
					$host  = $_SERVER['HTTP_HOST'];
					$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					
					$mail_text_array = array();
					$mail_template = file_get_contents("templates_mail/account_create.htm");
					$mail_text_array[0] = Translator::_translate('email_header_fired');
					$mail_text_array[1] = Translator::_translate('email_text1_fired');
					$mail_text_array[2] = Translator::_translate('email_text2_fired');
					$mail_text_array[3] = 'http://'.$host.$uri.'/?&lang='.$_language;
					$mail_text_array[4] = Translator::_translate('email_link_text_fired');
					$mail_text_array[5] = Translator::_translate('email_contact');
					$mail_text_array[6] = Translator::_translate('email_unsubscribe');
					$mail_text_array[7] = Translator::_translate('email_link_to_game');
					$mail_text_array[8] = Translator::_translate('email_quote_'.rand(0, 10));
					$mail_text_array[9] = 'http://'.$host.$uri.'/?site=unsubscribe&email='.base64_encode($email).'&lang='.$_language;	//unsibscribe link
					$mail_text_array[10] = Translator::_translate('email_link_to_facebook');
					$mail_text_array[11] = Translator::_translate('email_link_to_twitter');
					
					$array_size = count($mail_text_array);
					for($i = 0; $i < $array_size; ++$i)
					{
						$mail_template = str_replace("%".($i + 1)."%", $mail_text_array[$i], $mail_template);
					}
	
					$message = $mail_template;
					
					//send email
					$ch = curl_init("formel.todream.eu/racing_manager_send_email.php");
					$encoded = "from=".urlencode("admin@racing-manager.com")."&";
					$encoded.= "fromname=".urlencode(Translator::_translate('tr_create_account_email_subject'))."&";
					$encoded.= "email=".urlencode($email)."&";
					$encoded.= "bcc=".urlencode($admin_mail)."&";
					$encoded.= "subject=".urlencode(Translator::_translate('tr_remove_user_email_subject'))."&";
					$encoded.= "message=".urlencode($message);
					
					curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$output = curl_exec($ch);
					curl_close($ch);
				}
			}
		}//foreach team
	}
	
	function get_phpbbforum_text($language_id, $type, $league_array, $instance_id, $db)
	{
		$text = "";
		$league_counter = 1;
		foreach($league_array as $league)
		{
			//qualification
			if($type == 0)
			{
				//header
				if($language_id == 0)	//deutsch
					$text.= "[b]Liga ".$league_counter."[/b]";
				if($language_id == 1)	//english
					$text.= "[b]League ".$league_counter."[/b]";
				
				$text.= '[list=1]';
				
				$array = array();
				
				//first 10 (q3)
				$grid_array = $league[2];
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
						case 0: $line = array(); $line['ins_id'] = $instance_id; break;
						case 1: $line['position'] = $grid[$i]; break;
						case 3: $line['name'] = $grid[$i]; break;
						case 4: $line['team'] = $grid[$i];
								$_team = $db->getTeamByName($grid[$i], $instance_id);
								$line['color'] = $_team['color1'];
								$line['highlight'] = 0;
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
					
					$grid_array = $league[$j];
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
							case 0: $line = array(); $line['ins_id'] = $instance_id; break;
							case 1: $line['position'] = $grid[$i]; break;
							case 3: $line['name'] = $grid[$i]; break;
							case 4: $line['team'] = $grid[$i]; 
									$_team = $db->getTeamByName($grid[$i], $instance_id);
									$line['color'] = $_team['color1'];
									$line['highlight'] = 0;
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
				//write to forum with bbcode
				for($i = 0; $i < count($array); ++$i)
				{
					if($language_id == 0)
					{
						$array[$i]['laptime'] = str_replace('Disqualification', 'Disqualifikation', $array[$i]['laptime']);
					}
					$text.= '[*][color=#'.$array[$i]['color'].']'.$array[$i]['laptime'].' '.$array[$i]['name'].' ('.$array[$i]['team'].')[/color]';
				}
				
				$text.= '[/list]';
			}//if qualification
			//race
			if($type == 1)
			{
				//header
				if($language_id == 0)	//deutsch
					$text.= "[b]Liga ".$league_counter."[/b]";
				if($language_id == 1)	//english
					$text.= "[b]League ".$league_counter."[/b]";
				
				$text.= '[list=1]';
				
				$array = array();
				
				$last = count($league) - 1;
				$league = $league[$last];
				
				$league = str_replace("</tr>", "<td>###</td></tr>", $league);
				$league = str_replace("&#9650;", "", $league);
				$league = str_replace("&#9660;", "", $league);
				
				$splits = explode("</tr>", $league);
				$j = 1;
				foreach($splits as $split)
				{	
					if(strlen($split) > 1)
					{
						$cols = explode("</td>", $split);
						$team_name = strip_tags($cols[4]);
						$driver_name = strip_tags($cols[3]);
						$_team = $db->getTeamByName($team_name, $instance_id);
			
						$_drivers = $db->getDriversOfTeam($_team['id']);
						if($_drivers == null)
							$_drivers = $db->getAIDriversOfTeam($_team['id']);
						
						foreach($_drivers as $d)
						{
							if($d['firstname'].' '.$d['lastname'] == $driver_name)
							{
								$car_number = ($_team['driver1'] == $d['id'])?1:2;
								$_driver = $db->getDriver($car_number==1?$_team['driver1']:$_team['driver2']);
								$array[] = array(
									'tea_id' => $_team['id'],
									'ins_id' => $_team['ins_id'],
									'color' => $_team['color1'],
									'team' => $_team['name'],
									'name' => $_driver['firstname']." ".$_driver['lastname'],
									'laptime' => strip_tags($cols[7]),
								);
								break;
							}
						}
						$j++;
					}
				}//foreach
				
				//write to forum with bbcode
				for($i = 0; $i < count($array); ++$i)
				{
					if($language_id == 0)
					{
						$array[$i]['laptime'] = str_replace('Lap', 'Runde', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Broken vehicle body', 'Karosserie defekt', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Brake failure', 'Bremsversagen', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Engine failure', 'Motorschaden', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Aerodynamics failure', 'Aerodynamik defekt', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Electrical failure', 'Elektrik defekt', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Broken suspension', 'Bruch der Aufhängung', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Transmission damage', 'Getriebeschaden', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Hydraulic failure', 'Hydraulik defekt', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Kers suspension', 'Kers defekt', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('DRS damage', 'DRS defekt', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Driver failure', 'Fahrfehler', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Disqualification', 'Disqualifikation', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Crash', 'Unfall', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('No fuel', 'Tank leer', $array[$i]['laptime']);
						$array[$i]['laptime'] = str_replace('Puncture', 'Reifenschaden', $array[$i]['laptime']);
					}
					$text.= '[*][color=#'.$array[$i]['color'].']'.$array[$i]['laptime'].' '.$array[$i]['name'].' ('.$array[$i]['team'].')[/color]';
				}
				
				$text.= '[/list]';
			}//if race
			
			++$league_counter;
		}//foreach league
		
		return $text;
	}
