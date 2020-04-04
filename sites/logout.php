<?php
	$db_ftd = clone $db;	//phpbb also uses $db so we ned to clone this object
	if($phpbb_root_path != '')	//path comes from config.inc.php
	{
		define('IN_PHPBB', true);
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include_once($phpbb_root_path . 'common.'.$phpEx);
		include_once($phpbb_root_path . 'includes/functions_user.'.$phpEx);
		
		$user->session_kill();
		$user->session_begin();
	}
    session_destroy();

    $db = $db_ftd;

    //
    header('Location: http://racing-manager.com/live');
