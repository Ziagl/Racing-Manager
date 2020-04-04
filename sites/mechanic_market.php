<?php
    $message = null;
    $count_mechanics = 0;

    if(isset($_POST['mechanic_id']))
    {
        //form action
        $ret = $db->buyMechanic($_POST['mechanic_id'], $user['tea_id']);
        if($ret != 0)
        {
            $message = Translator::_translate('tr_mechanic_market_success');
        }
        else
        {
            $message = Translator::_translate('tr_mechanic_market_error');
        }

        unset($_POST['mechanic_id']);
        header("Location: ?site=mechanic_market");
		die();
    }
    else
    {
        $count_mechanics = $db->getCountMechanicsOfTeam($user['tea_id']);
        $mechanics_old = $db->getFreeMechanics('lastname asc');

        $mechanics = array();
        foreach($mechanics_old as $mechanic)
        {
        	$mechanic = add_color_class_mechanic($mechanic);	//adds CSS color class for driver values
            $mechanics[] = number_format_Tablerow($mechanic);
        }

        $smarty->assign('mechanics', $mechanics);
    }

    $smarty->assign('count_mechanics', $count_mechanics);
    $smarty->assign('message', $message);
    $smarty->assign('content', 'mechanic_market.tpl');