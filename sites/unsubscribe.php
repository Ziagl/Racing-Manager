<?php
	$email = base64_decode($_GET['email']);
	
	$db->unsubscribe($email);

	$track['weather'] = 100;

    $smarty->assign('track', $track);
	$smarty->assign('title', Translator::_translate('unsubscribe_title'));
	$smarty->assign('text', Translator::_translate('unsubscribe_text1').$email.Translator::_translate('unsubscribe_text2'));
    $smarty->assign('email', $email);
	$smarty->assign('content', 'unsubscribe.tpl');
