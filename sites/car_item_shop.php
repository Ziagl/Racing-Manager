<?php
    //change filter
    if(isset($_POST['type']))
    {
        $_SESSION['type'] = $_POST['type'];
    }

    if(isset($_POST['item_id']))
    {
        $db->buyItem($_POST['item_id'], $user['tea_id'], $user['ins_id']);

        unset($_POST['item_id']);
        header('Location: ?site=car_item_shop');
    }
    else
    {
    	$team_value = $team['value'];
    	if($team_value < 1)
    		$team_value = 1;
        $items_old = $db->getItems(13-$team['class'],$team_value,'type asc, name asc');

        $items = array();
        foreach($items_old as $item)
        {
        	$item['name'] = translate_item($item['name']);
            $item['in_stock'] = $db->getItemStockCountOfTeam($item['id'], $user['tea_id']);
            $item['not_buyable'] = false;
            if($team_value < $item['value'])
            		$item['not_buyable'] = true;

            //skip all items that are not in filter
            if(isset($_SESSION['type']))
            {
                if($_SESSION['type'] != -1)
                    if($_SESSION['type'] != $item['type'])
                        continue;
            }
            else{
                $_SESSION['type'] = -1;
            }

            $item = number_format_Tablerow($item);
            $items[] = $item;
        }
    }

    $smarty->assign('items', $items);
    $smarty->assign('item_list', $item_list);
    $smarty->assign('type', isset($_SESSION['type'])?$_SESSION['type']:-1);
    $smarty->assign('ins_id',$user['ins_id']);
    $smarty->assign('content', 'car_item_shop.tpl');