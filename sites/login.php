<?php
	$db_ftd = clone $db;	//phpbb also uses $db so we ned to clone this object
	if($phpbb_root_path != '')	//path comes from config.inc.php
	{
		define('IN_PHPBB', true);
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include_once($phpbb_root_path . 'common.'.$phpEx);
		include_once($phpbb_root_path . 'includes/functions_user.'.$phpEx);
		if($request)
			$request->enable_super_globals(); //for phpbb >= 3.1.x
	}
	
	//default variables
	$username = null;
	$password = null;
	$instance = 0;
	
	$error = null;

	//process form
	if(isset($_POST['username']) && strcmp($_POST['username'],'') != 0)
	{
        $username = $_POST['username'];
		if(isset($_POST['password']) && strcmp($_POST['password'],'') != 0)
		{
			$user_ftd = $db_ftd->checkLogin($_POST['username'],$_POST['password']);
            if($user_ftd != 0)
            {
                //successful login
                //store user_id
                $_SESSION['user'] = $user_ftd;
                
                //set last login
                $db_ftd->updateLoginTime($user_ftd['id']);
                
                //email was acknowledged
                if($user_ftd['active'] == 1)
                {
                	//phpbb login start
                	if($phpbb_root_path != '')
                	{
						// Start session management
						$user->session_begin();
						$auth->acl($user->data);
						$user->setup();
					
						$username_phpbb = request_var('username', $username);
						$password_phpbb = request_var('password', $_POST['password']);
					
						if(isset($username_phpbb) && isset($password_phpbb))
						{
						  $result=$auth->login($username_phpbb, $password_phpbb, true);
						  /*if ($result['status'] == LOGIN_SUCCESS) {
							  echo "You're logged in";
						  } else {
							  echo $user->lang[$result['error_msg']];
						  }*/
						}
					}
					//phpbb login end
                	
					//if form was processed without error redirect
					if($user_ftd != 0 && $user_ftd['ins_id'] != null && $user_ftd['tea_id'] != null)
					{
						if($user_ftd['tea_id_ok'] == 1)
						{
							//store login Cookies for one week
							setcookie("fastlogin_username",$_POST['username'],time()+(3600*168));
							setcookie("fastlogin_password",$_POST['password'],time()+(3600*168));
							
							//to dashboard if user has already an instance and a team
							header('Location: ?site=dashboard');
							die();
						}
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
						//or to select an instance and team
						header('Location: ?site=select_instance_and_team');
						die();
					}
                }
                else
                {
                	$error = Translator::_translate('tr_login_email_not_acknowledged');
                }
            }
            else
            {
                //login incorrect
                $error = Translator::_translate('tr_login_login_incorrect');
            }
		}
        else
        {
            //password not set
            $error = Translator::_translate('tr_login_password_not_set');
        }
	}
	
	if(isset($_POST['user_language']))
    {
    	$elements = explode(" ", $_POST['user_language']);
    	setcookie("fastlogin_language",$elements[0], time() + (10 * 365 * 24 * 60 * 60));
    	
	 	header('Location: ?site=login');
	 	die();
    }
    
    $db = $db_ftd;
	
	$head = '<style type="text/css">
		body { background: url(./content/img/bg-login.jpg) !important; }
	</style>';
	
	//set variables to display form
	$smarty->assign('head', $head);			//for layout.html
	
	if(isset($_COOKIE["fastlogin_username"]))
		$username = $_COOKIE["fastlogin_username"];
	if(isset($_COOKIE["fastlogin_password"]))
		$password = $_COOKIE["fastlogin_password"];
	if(!isset($_GET["lang"]))
	{
		if(isset($_COOKIE["fastlogin_language"]))
			$language_id = $_COOKIE["fastlogin_language"];
		
		if(!isset($language_id))
			$language_id = 1;
	}
	
	$smarty->assign('version', $version);
	$smarty->assign('username', $username);
	$smarty->assign('password', $password);
	$smarty->assign('instance', $instance);
	$smarty->assign('language_id', $language_id);
	$smarty->assign('language_values', $languages);
    $smarty->assign('error', $error);
	$smarty->assign('content', 'login.tpl');
