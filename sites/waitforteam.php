<?php
	$track['weather'] = 100;

    $smarty->assign('track', $track);
    //set variables to display form
    $smarty->assign('title', $_SESSION['dialog_title']);
    $smarty->assign('text', $_SESSION['dialog_text']);
	$smarty->assign('content', 'waitforteam.tpl');