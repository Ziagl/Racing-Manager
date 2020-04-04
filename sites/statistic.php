<?php
    $teams = $db->getTeams($user['ins_id'], 'points desc');
    $drivers_old = $db->getDrivers($user['ins_id'], 'and tea_id is not null','points desc');
    $users_old = $db->getUsers($user['ins_id'], 'points desc');

    //get team name for each driver
    $drivers = array();
    foreach($drivers_old as $driver)
    {
        $t = $db->getTeam($driver['tea_id']);
        $driver['team'] = $t['name'];
        $drivers[] = $driver;
    }

    //get team name for each user
    $users = array();
    foreach($users_old as $usr)
    {
        $t = $db->getTeam($usr['tea_id']);
        $usr['team'] = $t['name'];
        $users[] = $usr;
    }

    $smarty->assign('teams', $teams);
    $smarty->assign('drivers', $drivers);
    $smarty->assign('users', $users);
    $smarty->assign('content', 'statistic.tpl');