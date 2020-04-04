<?php
    $sponsor = null;
    $sponsors = null;
    $tire = null;
    $tires = null;
    $params = $db->getParams($user['ins_id']);

    //form action sponsor
    if(isset($_POST['sponsor_id']))
    {
        $ret = $db->acceptSponsor($_POST['sponsor_id'], $user['tea_id']);

        unset($_POST['sponsor_id']);
        header('Location: ?site=finance_sponsor');
    }

    //form action tire
    if(isset($_POST['tire_id']))
    {
        $ret = $db->acceptTire($_POST['tire_id'], $user['tea_id']);

        unset($_POST['tire_id']);
        header('Location: ?site=finance_sponsor');
    }

    //show sponsor
    if($team['spo_id'] != null)
    {
        $sponsor = $db->getSponsor($team['spo_id']);
    }
    //show sponsor offers
    else
    {
        $instance = $db->getInstance($user['ins_id']);
        $sponsors_old = $db->getSponsors($team['class']);
        //now filter 3 Sponsors
        srand($user['id'] + $instance['season']);    //initialize random generator with user id and number of season
        $min = 0;
        $max = count($sponsors_old)-1;
        $rand1 = $rand2 = $rand3 = 0;
        $rand1 = rand($min,$max);
        if($max > 0)
        {
            do
            {
                $rand2 = rand($min,$max);
            }while($rand1 == $rand2);
        }
        if($max > 1)
        {
            do
            {
                $rand3 = rand($min,$max);
            }while($rand1 == $rand3 || $rand2 == $rand3);
        }

        $sponsors = array();
        $sponsors[] = number_format_Tablerow($sponsors_old[$rand1]);
        $sponsors[] = number_format_Tablerow($sponsors_old[$rand2]);
        $sponsors[] = number_format_Tablerow($sponsors_old[$rand3]);
    }

    //show tire
    if($team['tir_id'] != null)
    {
        $tire = $db->getTire($team['tir_id']);
        $str_array = explode(" ",$tire['hard']);
        $hard = tire_values_to_chart_string($str_array, $params['meter_to_round']);
        $str_array = explode(" ",$tire['soft']);
        $soft = tire_values_to_chart_string($str_array, $params['meter_to_round']);
        $str_array = explode(" ",$tire['hard_rain']);
        $hard_rain = tire_values_to_chart_string($str_array, $params['meter_to_round']);
        $str_array = explode(" ",$tire['soft_rain']);
        $soft_rain = tire_values_to_chart_string($str_array, $params['meter_to_round']);
        
        $tire['hard'] = $hard;
        $tire['soft'] = $soft;
        $tire['hard_rain'] = $hard_rain;
        $tire['soft_rain'] = $soft_rain;
    }
    //show tire offers
    else
    {
        $instance = $db->getInstance($user['ins_id']);
        $tires_old = $db->getTires();
        //now filter 3 tires
        srand($user['id'] + $instance['season']);
        $min = 0;
        $max = count($tires_old)-1;
        $rand1 = $rand2 = $rand3 = 0;
        $rand1 = rand($min,$max);
        if($max > 0)
        {
            do
            {
                $rand2 = rand($min,$max);
            }while($rand1 == $rand2);
        }
        if($max > 1)
        {
            do
            {
                $rand3 = rand($min,$max);
            }while($rand1 == $rand3 || $rand2 == $rand3);
        }

        $tires = array();
        $tires[] = number_format_Tablerow($tires_old[$rand1]);
        $tires[] = number_format_Tablerow($tires_old[$rand2]);
        $tires[] = number_format_Tablerow($tires_old[$rand3]);
        //we need to display all tires
        //$tires = $tires_old;
        
        $array_size = count($tires);
        for($i = 0; $i < $array_size; ++$i)
        {
	        $str_array = explode(" ",$tires[$i]['hard']);
	        $hard = tire_values_to_chart_string($str_array, $params['meter_to_round']);
	        $str_array = explode(" ",$tires[$i]['soft']);
	        $soft = tire_values_to_chart_string($str_array, $params['meter_to_round']);
	        $str_array = explode(" ",$tires[$i]['hard_rain']);
	        $hard_rain = tire_values_to_chart_string($str_array, $params['meter_to_round']);
	        $str_array = explode(" ",$tires[$i]['soft_rain']);
	        $soft_rain = tire_values_to_chart_string($str_array, $params['meter_to_round']);
	        
	        $tires[$i]['hard'] = $hard;
	        $tires[$i]['soft'] = $soft;
	        $tires[$i]['hard_rain'] = $hard_rain;
	        $tires[$i]['soft_rain'] = $soft_rain;
        }
    }
    
    //disable pictures
    $array_size = count($sponsors);
    for($i=0; $i < $array_size; ++$i)
    	$sponsors[$i]['picture'] = null;
    if(isset($sponsor))
    {
		$sponsor['picture'] = null;
		$sponsor['value'] = number_format_Tablerow($sponsor['value']);
		$sponsor['bonus'] = number_format_Tablerow($sponsor['bonus']);
    }
    $array_size = count($tires);
    for($i=0; $i < $array_size; ++$i)
    	$tires[$i]['picture'] = null;
    if(isset($tire))
    {
		$tire['picture'] = null;
		$tire['value'] = number_format_Tablerow($tire['value']);
		$tire['bonus'] = number_format_Tablerow($tire['bonus']);
    }

    $smarty->assign('sponsor', $sponsor);
    $smarty->assign('sponsors', $sponsors);
    $smarty->assign('tire', $tire);
    $smarty->assign('tires', $tires);
    $smarty->assign('content', 'finance_sponsor.tpl');