<?php
	include_once 'bootstrap.php';

	$smarty->debugging = $smarty_debug;

    session_start();
    //session timeout
    if(isset($_SESSION['timeout']))
    {
    	if ($_SESSION['timeout'] + 120 * 60 < time())	//2 h (120 min)
    	{
    		if (ini_get("session.use_cookies")) {
				$p = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
			}
    		session_destroy();
    		header('Location: ?site=logout');
    		die();
    	}
    }
    $_SESSION['timeout'] = time();

    if(!isset($_SESSION['rnd']))
    {
        RandomNumberGenerator::init();
        $_SESSION['rnd'] = 1;
    }
    
    //default site (logged out)
    $sitename = 'login';

    //check if a site was set
    if(isset($_GET['site']))
    {
        //set site only if valid
        foreach($site_list as $key=>$value)
        {
            if(strcmp($value, $_GET['site']) == 0)
            {
                $site = $key;
                $sitename = $value;
                break;
            }
        }
    }

    $language_id = null;
    	if(isset($_COOKIE["fastlogin_language"]))
	{
		$language_id = $_COOKIE["fastlogin_language"];
	}
	else
	{
		if(isset($_GET["lang"]))
		{
			if($_GET["lang"] == 'de')
			{
				$language = 'de';
				$language_id = 0;
			}
			else//if($_GET["lang"] == 'en')
			{
				$language = 'en';
				$language_id = 1;
			}
			setcookie("fastlogin_language",$language_id, time() + (10 * 365 * 24 * 60 * 60));
		}
	}

    //global variable for all sites
    $user = null;
    //user
    if(isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];
        
		if($language_id == null)
			$language_id = $user['language'];
		
        //team
        if(isset($_SESSION['team']))
        {
            $team = $_SESSION['team'];
        }
        if($user['tea_id'])	//used because we do not have tea_id at login time
        {
            $team = $db->getTeam($user['tea_id']);
            $_SESSION['team'] = $team;
        }
        //instance
        if($user['ins_id'])//used because we do not have ins_id at login time
        {
			$instance = $db->getInstance($user['ins_id']);
			$_SESSION['instance'] = $instance;
			$_SESSION['number_races'] = $db->getTrackCalendarNumberRaces($user['ins_id']);
			$_SESSION['race_name'] = $db->getTrack($user['ins_id']);
        }
        //params
        if(isset($_SESSION['params']))
        {
            $params = $_SESSION['params'];
        }
        else
        {
        	if($user['ins_id'])//used because we do not have ins_id at login time
        	{
				$params = $db->getParams($user['ins_id']);
				$_SESSION['params'] = $params;
            }
        }
    }
    
	setLanguage($language_id);

    //if session expired --> show login
    if($user == null && 
       $sitename != 'create_account' && 
       $sitename != 'reset_password' && 
       $sitename != 'select_instance_and_team' && 
       $sitename != 'waitforteam' &&
       $sitename != 'unsubscribe')
    {
        $sitename = 'login';
    }

    //process site
    include('sites/'.$sitename.'.php');

    //global variable
    $smarty->assign('user_name', isset($_SESSION['user'])?$_SESSION['user']['name']:'');
    $smarty->assign('admin', isset($_SESSION['user'])?$_SESSION['user']['admin']:false);
    if(isset($team))
    	$smarty->assign('team', $team);
    if(isset($team))
        $smarty->assign('current_budget', number_format($team['value'], 0, ',', '.'));
    if(isset($instance))
    {
        $smarty->assign('instance', $instance);
        if(isset($_SESSION['number_races']))
            $smarty->assign('number_races', $_SESSION['number_races']);
        if(isset($_SESSION['race_name']))
            $smarty->assign('race_name', $_SESSION['race_name'][1]);
        $track = $db->getTrack($instance['id']);
        $smarty->assign('track', $track);
    }

    //show site
    if(strcmp($sitename,'login') != 0 &&
       strcmp($sitename,'create_account') != 0 &&
       strcmp($sitename,'reset_password') != 0 &&
       strcmp($sitename,'select_instance_and_team') != 0 &&
       strcmp($sitename,'waitforteam') != 0 &&
       strcmp($sitename,'unsubscribe') != 0
    )
    {
    	$smarty->assign('login', 0);
        $smarty->assign('header', 'header.tpl');
        $smarty->assign('menu', 'menu.tpl');
        $smarty->assign('footer', 'footer.tpl');
    }
    else
    {
	    $smarty->assign('login', 1);
    }
    
    $smarty->assign('show_weather', false);
    /* does not work on some android devices
    if($sitename == 'race_training' ||
       $sitename == 'race_qualification' ||
       $sitename == 'race_grandprix' ||
       $sitename == 'race_qualification_grid' ||
       $sitename == 'race_grandprix_ceremony'
       )
    {
    	$smarty->assign('show_weather', true);
    }
    */

    $smarty->display('layout.html');
