<?php
	$selected_item = -1;
	$selected_type = -1;
	$color1 = "#".$team['color1'];
	$color2 = "#".$team['color2'];
	$changed = false;
	//save method
    if(isset($_POST['item']))
    {
        $selected_item = $_POST['item'];
        $selected_type = $_POST['type'];
        $color1 = $_POST['color1'];
        $color2 = $_POST['color2'];
        $design = $_SESSION['design'];
        //load old settings
        if($_SESSION['selected_item'] != $selected_item)
        {
        	$_SESSION['selected_item'] = $selected_item;
        	switch($selected_item)
			{
				case 0: $selected_type = $design['body'][0]; $color1 = $design['body'][1]; $color2 = $design['body'][2]; break;
				case 1: $selected_type = $design['front'][0]; $color1 = $design['front'][1]; $color2 = $design['front'][2]; break;
				case 2: $selected_type = $design['frontbox'][0]; $color1 = $design['frontbox'][1]; $color2 = $design['frontbox'][2]; break;
				case 3: $selected_type = $design['frontwing'][0]; $color1 = $design['frontwing'][1]; $color2 = $design['frontwing'][2]; break;
				case 4: $selected_type = $design['mirror'][0]; $color1 = $design['mirror'][1]; $color2 = $design['mirror'][2]; break;
				case 5: $selected_type = $design['rearbox'][0]; $color1 = $design['rearbox'][1]; $color2 = $design['rearbox'][2]; break;
				case 6: $selected_type = $design['rearwing'][0]; $color1 = $design['rearwing'][1]; $color2 = $design['rearwing'][2]; break;
				case 7: $selected_type = $design['top'][0]; $color1 = $design['top'][1]; $color2 = $design['top'][2]; break;
			}
        }
        //or save new ones
        else
        {
			if($selected_item >= 0 && $selected_type >= 0 && $selected_item != "" && $selected_type != "")
			{
				switch($selected_item)
				{
					case 0: $design['body'] = array($selected_type, $color1, $color2); break;
					case 1: $design['front'] = array($selected_type, $color1, $color2); break;
					case 2: $design['frontbox'] = array($selected_type, $color1, $color2); break;
					case 3: $design['frontwing'] = array($selected_type, $color1, $color2); break;
					case 4: $design['mirror'] = array($selected_type, $color1, $color2); break;
					case 5: $design['rearbox'] = array($selected_type, $color1, $color2); break;
					case 6: $design['rearwing'] = array($selected_type, $color1, $color2); break;
					case 7: $design['top'] = array($selected_type, $color1, $color2); break;
				}
				$serialized = serialize($design);
				$db->updateTeamCarDesign($team['id'], $serialized);
				$team['car_design'] = $serialized;
				$changed = true;
			}
        }
    }
    
    $items = array("body_item", "front_item", "frontbox_item", "frontwing_item", "mirror_item", "rearbox_item", "rearwing_item", "top_item");
    $random_color_list = color_palette();
    $top_max = 4;
	$body_max = 12;
	$front_max = 8;
	$frontwing_max = 8;
	$rearwing_max = 10;
	$frontbox_max = 9;
	$rearbox_max = 11;
	$mirror_max = 1;
    
	//load design from db
	$design = $team['car_design'];
	//if no design is stored in DB - create random one
	if($design == null)
	{
		$design = random_design($random_color_list);
		$changed = true;
	}
	else
	{
		$design = unserialize($design);
		switch($selected_item)
		{
			case 0: $selected_type = $design['body'][0]; break;
			case 1: $selected_type = $design['front'][0]; break;
			case 2: $selected_type = $design['frontbox'][0]; break;
			case 3: $selected_type = $design['frontwing'][0]; break;
			case 4: $selected_type = $design['mirror'][0]; break;
			case 5: $selected_type = $design['rearbox'][0]; break;
			case 6: $selected_type = $design['rearwing'][0]; break;
			case 7: $selected_type = $design['top'][0]; break;
		}
	}
	
	$types = array();
	switch($selected_item)
	{
		case 0: $types = create_type_array($body_max); break;
		case 1: $types = create_type_array($front_max); break;
		case 2: $types = create_type_array($frontbox_max); break;
		case 3: $types = create_type_array($frontwing_max); break;
		case 4: $types = create_type_array($mirror_max); break;
		case 5: $types = create_type_array($rearbox_max); break;
		case 6: $types = create_type_array($rearwing_max); break;
		case 7: $types = create_type_array($top_max); break;
	}
	
	$_SESSION['design'] = $design;
	if($changed)
	{
		$tir_id = $team['tir_id'];
		$tire_filename = "tire8_dry_hard.png";
		if($tir_id)
		{
			$tire = $db->getTire($team['tir_id']);
			$tire_filename = $tire['picture_dry_hard'];
		}
		construct_car($team['id'], $tire_filename, $design);
	}
	
	$smarty->assign('rand', rand(0,9999999));
	$smarty->assign('tea_id', $team['id']);
	$smarty->assign('items', $items);
	$smarty->assign('types', $types);
	$smarty->assign('design', $design);
	$smarty->assign('selected_item', $selected_item);
	$smarty->assign('selected_type', $selected_type);
	$smarty->assign('color1', $color1);
	$smarty->assign('color2', $color2);
	$smarty->assign('content', 'car_construct.tpl');
