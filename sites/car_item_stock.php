<?php
    $items_old = $db->getItemsFromStock($user['tea_id'], 'id asc');

    //change filter
    if(!isset($_SESSION['type']))
    {
    	$_SESSION['type'] = -1;
    }
    if(isset($_POST['type']))
    {
        $_SESSION['type'] = $_POST['type'];
    }
    
    if(!isset($_SESSION['car']))
    {
    	$_SESSION['car'] = -1;
    }
    if(isset($_POST['car']))
    {
        $_SESSION['car'] = $_POST['car'];
    }

    $car1_items = $db->getItemsFromCar($user['tea_id'], 1);
    $car1_types = array();
    foreach($car1_items as $car_item)
	{
		$car1_types[$car_item['type']] = $car_item['type'];
	}
    $car2_items = $db->getItemsFromCar($user['tea_id'], 2);
    $car2_types = array();
    foreach($car2_items as $car_item)
	{
		$car2_types[$car_item['type']] = $car_item['type'];
	}
    $car3_items = $db->getItemsFromCar($user['tea_id'], 3);
    $car3_types = array();
    foreach($car3_items as $car_item)
	{
		$car3_types[$car_item['type']] = $car_item['type'];
	}
    $items = array();
    $repair_all = 0;
    $repair_all_notavailable = true;
    foreach($items_old as $item)
    {
        $ite = $db->getItem($item['ite_id']);

        //skip all items that are not in item filter
        if(isset($_SESSION['type']))
        {
            if($_SESSION['type'] != -1)
                if($_SESSION['type'] != $ite['type'])
                    continue;
        }
        else{
            $_SESSION['type'] = -1;
        }
        
        //skip all items that are not in car filter
        if(isset($_SESSION['car']))
        {
            if($_SESSION['car'] != -1)
            {
                if($_SESSION['car'] == 1)
                	if($item['car_number'] != 1)
                    	continue;
                if($_SESSION['car'] == 2)
                	if($item['car_number'] != 2)
                    	continue;
                if($_SESSION['car'] == 3)
                	if($item['car_number'] != 3)
                    	continue;
            }
        }
        else{
            $_SESSION['car'] = -1;
        }

        $item['name'] = translate_item($ite['name']);
        $item['skill'] = $ite['skill'];
        $item['skill_max'] = $ite['skill_max'];
        $item['value'] = $ite['value'];
        $item['type'] = $ite['type'];
        $item['class'] = $ite['class'];
        $item['car1'] = false;
        if(in_array($ite['type'], $car1_types))
        	$item['car1'] = true;
        $item['car2'] = false;
        if(in_array($ite['type'], $car2_types))
        	$item['car2'] = true;
        $item['car3'] = false;
        if(in_array($ite['type'], $car3_types))
        	$item['car3'] = true;
        $item['sell_value'] = compute_item_value($item);
        $item['repair_value'] = compute_item_repair_value($item);
        $repair_all+= $item['repair_value'];
        $item['notrepairable'] = true;
        if($item['repair_value'] < $team['value'])
        	$item['notrepairable'] = false;
        $item = number_format_Tablerow($item);
        
        $items[] = $item;
    }
    if($repair_all < $team['value'])
    	$repair_all_notavailable = false;
    $repair_all = number_format($repair_all, 0, ",", ".");

    //item to car
    if(isset($_POST['car_number']) && isset($_POST['item_id']))
    {
        $db->setItemCarNumber($_POST['car_number'], $_POST['item_id']);

        unset($_POST['car_number']);
        unset($_POST['item_id']);
        header('Location: ?site=car_item_stock');
    }

    //item sell
    if(isset($_POST['item_sell']))
    {
        $price = null;
        foreach($items as $item)
        {
            if($item['id'] == $_POST['item_id'])
            {
                $price = str_replace(".","",compute_item_value($item));
                break;
            }
        }
        if($price != null)
            $db->sellItem($user['tea_id'], $_POST['item_id'], $price);

        unset($_POST['item_sell']);
        unset($_POST['item_id']);
        header('Location: ?site=car_item_stock');
    }

    //item repair
    if(isset($_POST['item_repair']))
    {
        $price = null;
        foreach($items as $item)
        {
            if($item['id'] == $_POST['item_id'])
            {
                $price = compute_item_repair_value(str_replace(".","",$item));
                break;
            }
        }
        if($price != null)
            $db->repairItem($user['tea_id'], $_POST['item_id'], $price);

        unset($_POST['item_repair']);
        unset($_POST['item_id']);
        header('Location: ?site=car_item_stock');
    }
    
    //item repair all
    if(isset($_POST['item_repair_all']))
    {
    	foreach($items as $item)
        {
        	$price = compute_item_repair_value(str_replace(".","",$item));
        	if($price != null)
        	{
        		if($price > 0)
        		{
        			$db->repairItem($user['tea_id'], $item['id'], $price);
        		}
        	}
        }
        header('Location: ?site=car_item_stock');
    }
        
    //item tuneup
    if(isset($_POST['item_tune']))
    {
        $db->changeItemTuneup($_POST['item_id'], $_POST['item_tune']);

        unset($_POST['item_tune']);
        header('Location: ?site=car_item_stock');
    }
    
    //items and risk are only editable before qualification
    $not_editable = false;
    //if(count($db->isQualificationOrRace($user['ins_id'], 1)) != 0)
    //    $not_editable = true;
    
    $smarty->assign('repair_all', $repair_all);
    $smarty->assign('repair_all_notavailable', $repair_all_notavailable);
    $smarty->assign('not_editable', $not_editable);
    $smarty->assign('items', $items);
    $smarty->assign('item_list', $item_list);
    $smarty->assign('car', $_SESSION['car']);
    $smarty->assign('type', $_SESSION['type']);
    $smarty->assign('ins_id',$user['ins_id']);
    $smarty->assign('content', 'car_item_stock.tpl');
