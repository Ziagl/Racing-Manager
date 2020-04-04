<?php
    $inout_old = $db->getInoutOfTeam($user['tea_id'], 'date ASC');

    $inout = array();
    foreach($inout_old as $row)
    {
        $date = new DateTime($row['date']);
        $row['date'] = $date->format('d.m.Y H:i:s');
        $row = number_format_Tablerow($row);
        $row['label'] = translate_finance_detail($row['label'], $db, $language_id);
        $inout[] = $row;
    }

    $smarty->assign('rows', $inout);
    $smarty->assign('content', 'finance_detail.tpl');
