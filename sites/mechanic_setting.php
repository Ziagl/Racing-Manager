<?php
    $mechanics_old = $db->getMechanicsOfTeam($user['tea_id']);

    if(isset($_POST['sell_mechanic_id']))
	{
		$mechanic = $db->getMechanic($_POST['sell_mechanic_id']);
		if($mechanic['tea_id'] == $user['tea_id'])
		{
			$sell_price = calculate_sell_price_mechanic($mechanic, 0);
			
			//sell and delete mechanic
			$db->sellMechanic($mechanic['id'], $mechanic['tea_id'], /*$mechanic['ins_id']*/1, $sell_price);
		}
		unset($_POST['sell_mechanic_id']);
		header("Location: ?site=mechanic_setting");
		die();
	}
    
    //change mechanic job
    if(isset($_POST['job']))
    {
        $db->changeMechanicJob($_POST['mechanic_id'], $_POST['job']);

        unset($_POST['mechanic_id']);
        unset($_POST['job']);
        header('Location: ?site=mechanic_setting');
    }

    //$development = 0; currently not avaliable
    $pitstop = 0.0;
    $setup = 0.0;
    $repair = 0.0;
    $tires = 0.0;

    $return = get_mechanic_values($mechanics_old);
    $mechanics = $return[0];
    $pitstop = $return[1];
    $setup = $return[2];
    $tires = $return[3];
    $repair = $return[4];

    $pitstop = number_format_Tablerow(compute_pitstop_time($pitstop * 0.01),1);
    $setup = number_format_Tablerow(compute_setup_bonus($setup),1);
    $tires = number_format_Tablerow(compute_tire_bonus($tires),1);
    $repair = number_format_Tablerow(compute_repair_bonus($repair),1);
    
    //mechanic jobs are only editable before qualification
    $not_editable = false;
    //if(count($db->isQualificationOrRace($user['ins_id'], 1)) != 0)
    //    $not_editable = true;

    $smarty->assign('not_editable', $not_editable);
    $smarty->assign('pitstop', $pitstop);
    $smarty->assign('setup', $setup);
    $smarty->assign('repair', $repair);
    $smarty->assign('tires', $tires);
    $smarty->assign('mechanics', $mechanics);
    $smarty->assign('content', 'mechanic_setting.tpl');
