<?php
    $instances = array();
    $teams = array();
    $error = null;

    $instances = $db->getVisibleInstances();
    $array_size = count($instances);
    for($i = 0; $i < $array_size; ++$i)
    {
    	$instances[$i]['users'] = $db->getCountUsers($instances[$i]['id']);
    }

    $instance_id = 1;
    if(isset($_POST['instance_change']))
    {
    	$instance_id = $_POST['instance_change'];
    }
    $teams = $db->getFreeTeams($instance_id);
    $params = $db->getParams($instance_id);
    
    if(isset($_POST['instance']) && isset($_POST['Team']))
    {
    	//if admin acknowledgement is needed
    	if($params['team_admin_acknowledge'] == 1)
        	$user = $db->setInstanceAndTeam($_POST['instance'], $_POST['Team'], $_SESSION['user']['id']);
        else
        	$user = $db->setInstanceAndTeamAcknowledged($_POST['instance'], $_POST['Team'], $_SESSION['user']['id']);
        if($user != 0 && $user['ins_id'] != null && $user['tea_id'] != null)
        {
        	//admin already approved team
        	if($user['tea_id_ok'] == 1)
        	{
	            $_SESSION['user'] = $user;
	            header('Location: ?site=dashboard');
	            die();
            }
            //waiting for admin to approve team
            else
            {
            	$_SESSION['dialog_title'] = "tr_waitforteam_title";
            	$_SESSION['dialog_text'] = "tr_waitforteam_text";
	            header('Location: ?site=waitforteam');
	            die();
            }
        }
        else
        {
            //cannot set instance and team
            $error = Translator::_translate('tr_select_instance_and_team_general_error');
        }
    }
    
    if($user != 0 && $user['ins_id'] != null && $user['tea_id_ok'] == 0)
    {
    	header('Location: ?site=waitforteam');
    	die();
    }

    $track['weather'] = 100;

    $smarty->assign('track', $track);
    $smarty->assign('instances', $instances);
    $smarty->assign('instance_id', $instance_id);
    $smarty->assign('teams', $teams);
    $smarty->assign('error', $error);
    $smarty->assign('content', 'select_instance_and_team.tpl');
