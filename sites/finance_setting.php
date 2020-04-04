<?php
    $out_driver_fix = 0;
    $out_mechanic_fix = 0;
    $out_items_fix = 0;
    $out_other_fix = 0;

    $in_driver_fix = 0;
    $in_mechanic_fix = 0;
    $in_items_fix = 0;
    $in_sponsor_fix = 0;
    $in_price_fix = 0;
    $in_other_fix = 0;

    $out_driver_var = 0;
    $out_mechanic_var = 0;
    $out_other_var = 0;

    $in_sponsor_var = 0;
    $in_price_var = 0;
    $in_other_var = 0;

    $inout = $db->getInoutOfTeam($user['tea_id']);

    foreach($inout as $row)
    {
        switch($row['type'])
        {
            //fix out
            case 0: $out_driver_fix += $row['out_value']; break;
            case 1: $out_mechanic_fix += $row['out_value']; break;
            case 2: $out_items_fix += $row['out_value']; break;
            case 3: $out_other_fix += $row['out_value']; break;
            //fix in
            case 4: $in_driver_fix += $row['in_value']; break;
            case 5: $in_mechanic_fix += $row['in_value']; break;
            case 6: $in_items_fix += $row['in_value']; break;
            case 7: $in_sponsor_fix += $row['in_value']; break;
            case 8: $in_price_fix += $row['in_value']; break;
            case 9: $in_other_fix += $row['in_value']; break;
            //var out
            case 10: $out_driver_var += $row['out_value']; break;
            case 11: $out_mechanic_var += $row['out_value']; break;
            case 12: $out_other_var += $row['out_value']; break;
            //var in
            case 13: $in_sponsor_var += $row['in_value']; break;
            case 14: $in_price_var += $row['in_value']; break;
            case 15: $in_other_var += $row['in_value']; break;
        }
    }

    $in_fix = $in_driver_fix + $in_mechanic_fix + $in_items_fix + $in_sponsor_fix + $in_price_fix + $in_other_fix;
    $out_fix = $out_driver_fix + $out_mechanic_fix + $out_items_fix + $out_other_fix;
    $in_var = $in_sponsor_var + $in_price_var + $in_other_var;
    $out_var = $out_driver_var + $out_mechanic_var + $out_other_var;

    $sum_in = $in_fix + $in_var;
    $sum_out = $out_fix + $out_var;

    $smarty->assign('out_driver_fix', number_format_Tablerow($out_driver_fix));
    $smarty->assign('out_mechanic_fix', number_format_Tablerow($out_mechanic_fix));
    $smarty->assign('out_items_fix', number_format_Tablerow($out_items_fix));
    $smarty->assign('out_other_fix', number_format_Tablerow($out_other_fix));
    $smarty->assign('in_driver_fix', number_format_Tablerow( $in_driver_fix));
    $smarty->assign('in_mechanic_fix', number_format_Tablerow($in_mechanic_fix));
    $smarty->assign('in_items_fix', number_format_Tablerow($in_items_fix));
    $smarty->assign('in_sponsor_fix', number_format_Tablerow($in_sponsor_fix));
    $smarty->assign('in_price_fix', number_format_Tablerow($in_price_fix));
    $smarty->assign('in_other_fix', number_format_Tablerow($in_other_fix));
    $smarty->assign('out_driver_var', number_format_Tablerow($out_driver_var));
    $smarty->assign('out_mechanic_var', number_format_Tablerow($out_mechanic_var));
    $smarty->assign('out_other_var', number_format_Tablerow($out_other_var));
    $smarty->assign('in_sponsor_var', number_format_Tablerow($in_sponsor_var));
    $smarty->assign('in_price_var', number_format_Tablerow($in_price_var));
    $smarty->assign('in_other_var', number_format_Tablerow($in_other_var));
    $smarty->assign('in_fix', number_format_Tablerow($in_fix));
    $smarty->assign('out_fix', number_format_Tablerow($out_fix));
    $smarty->assign('in_var', number_format_Tablerow($in_var));
    $smarty->assign('out_var', number_format_Tablerow($out_var));
    $smarty->assign('sum_in', number_format_Tablerow($sum_in));
    $smarty->assign('sum_out', number_format_Tablerow($sum_out));
    $smarty->assign('sum', number_format_Tablerow($sum_in - $sum_out));
    $smarty->assign('content', 'finance_setting.tpl');

/*
 * Transaction types
 *
 * menu in/out type subtype label
 *
 * fix:
 * driver out 0 0 buy new driver
 * mechanic out 1 0 buy new mechanic
 * item out 2 0 buy new item
 * item out 2 1 repair item
 * other out 3 0
 *
 * driver in 4 0 sell a driver
 * mechanic in 5 0 sell a mechanic
 * item in 6 0 sell an item
 * sponsor in 7 0 main sponsor money
 * sponsor in 7 1 tire sponsor money
 * price in 8 0
 * other in 9 0
 *
 * var:
 * driver out 10 0 bonus of driver
 * mechanic out 11 0 bonus of mechanic
 * other out 12 0
 *
 * sponsor in 13 0 main sponsor bonus
 * sponsor in 13 1 tire sponsor bonus
 * price in 14 0
 * other in 15 0
 */