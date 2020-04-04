<?php
    //update User Information
    $_SESSION['user'] = $db->getUser($_SESSION['user']['id']);
    $user = $_SESSION['user'];
    $user['last_last_login'] = date('d.m.Y H:i', strtotime($user['last_last_login']));
    if(isset($_COOKIE["fastlogin_language"]))
    	$user['language'] = $_COOKIE["fastlogin_language"];
    $instance = $db->getInstance($user['ins_id']);
    $message = '';
    $user['picture'] = "/driver/default.jpg";
	$file = './content/img/manager/'.$user['id'].'.svg';
	if(file_exists($file))
	{
		$user['picture'] = "/manager/".$user['id'].'.svg';
		export_manager_image_to_forum($user['id'], $user['email']);
	}
	
	if(isset($_POST['delete_profile']))
	{
		if($_POST['delete_profile'] == $user['id'])
		{
			$db->deleteUser($user);
			
			header('Location: ?site=logout');
			die();
	 	}
	}
    
    if(isset($_POST['new_passwd1']))
    {
    	if(isset($_POST['new_passwd2']))
    	{
    		if($_POST['new_passwd1'] == '' && $_POST['new_passwd2'] == '')
    		{
    			$message = Translator::_translate('tr_login_password_not_set');
    		}
    		else
    		{
    			if($_POST['new_passwd1'] == $_POST['new_passwd2'])
				{
					$db->updatePassword($user['id'], $_POST['new_passwd1']);
					setcookie("fastlogin_password",$_POST['new_passwd1'],time()+(3600*168));
					$message = Translator::_translate('tr_reset_password_success');
				}
				else
				{
					$message = Translator::_translate('tr_create_account_passwords_not_equal');
				}
    		}
    	}
    	else
    	{
    		$message = Translator::_translate('tr_create_account_passwords_not_equal');
    	}
    }
    
    if(isset($_POST['user_refreshtime']))
    {
    	$elements = explode(" ", $_POST['user_refreshtime']);
	 	$db->setUserRefreshtime($user['id'], $elements[0]);
	 	
	 	header('Location: ?site=profile');
	 	die();
    }
    
    if(isset($_POST['user_language']))
    {
    	$elements = explode(" ", $_POST['user_language']);
	 	$db->setUserLanguage($user['id'], $elements[0]);
	 	setcookie("fastlogin_language",$elements[0], time() + (10 * 365 * 24 * 60 * 60));
	 	
	 	header('Location: ?site=profile');
	 	die();
    }

    $smarty->assign('rand', rand(0,9999999));
    $smarty->assign('message', $message);
    $smarty->assign('user', $user);
    $smarty->assign('instance', $instance);
    $smarty->assign('team', $team);
    $smarty->assign('refreshtime_values', array(1,2,3,4,5,10,15,20,25,30));
    $smarty->assign('language_values', $languages);
    $smarty->assign('content', 'profile.tpl');