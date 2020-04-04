<?php
	header('Content-type: text/html; charset=utf-8');
	
	// set these to true if you want to debug the game
	$debug = false;
    	$db_debug = false;
    	$smarty_debug = false;
    	$admin_mail = "admin@racing-manager.com";
	
	if($debug)
	{
		ini_set('display_errors', 'On');
    		error_reporting(E_ALL);
	}
	else
	{
		ini_set('display_errors', 'Off');
    		error_reporting(E_ERROR);
	}
	
	$language = 'en';		//en
	$language_id = 1;
	
	$team_admin_acknowledge = true;	//if admin has to prove team choice of new members
	
	$site_list = array(
	101 => 'login',
	102 => 'dashboard',
	103 => 'logout',
        104 => 'profile',
        105 => 'create_account',
        106 => 'reset_password',
        107 => 'select_instance_and_team',
        108 => 'driver_setting',
        109 => 'finance_setting',
        110 => 'driver_training',
        111 => 'driver_market',
        112 => 'finance_sponsor',
        113 => 'statistic',
        114 => 'car_setting',
        115 => 'car_item_shop',
        116 => 'car_item_stock',
        117 => 'race_info',
        118 => 'race_training',
        119 => 'race_qualification',
        120 => 'race_grandprix',
        121 => 'mechanic_setting',
        122 => 'mechanic_market',
        123 => 'finance_detail',
        124 => 'administration',
        125 => 'statistic_driver',
        126 => 'statistic_team',
        127 => 'statistic_manager',
        128 => 'waitforteam',
        129 => 'race_qualification_grid',
        130 => 'race_grandprix_ceremony',
        131 => 'statistic_teaminfo',
        132 => 'driverinfo',
        133 => 'teaminfo',
        134 => 'userinfo',
        135 => 'statistic_track',
        136 => 'statistic_youthleague',
        137 => 'unsubscribe',
        138 => 'forum',
        139 => 'race_analyze',
        140 => 'car_construct',
        141 => 'statistic_wins',
        142 => 'statistic_podium',
        143 => 'statistic_polepositions',
        144 => 'credits',
        145 => 'statistic_nations',
        146 => 'tutorial',
        147 => ''
	);

    $item_list = array(
    	0 => 'body', 
    	1 => 'brake', 
    	2 => 'engine', 
    	3 => 'aerodynamics', 
    	4 => 'electronics', 
    	5 => 'suspension', 
    	6 => 'gearbox', 
    	7 => 'hydraulics', 
    	8 => 'kers', 
    	9 => 'drs'
    );
    
    //init language
    $languages = array();
    $languages[0] = array('id' => '0', 'name' => 'Deutsch', 'flag' => 'Deutschland');
    $languages[1] = array('id' => '1', 'name' => 'English', 'flag' => 'Grossbritannien');

    include_once 'config/config.inc.php';
    include_once 'classes/RandomNumberGenerator.php';
    include_once 'config/functions.inc.php';
    include_once 'classes/F1Smarty.class.php';
    include_once 'classes/F1Database.class.php';
