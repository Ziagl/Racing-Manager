<?php
    $track = $db->getTrack($user['ins_id']);
    $country = $db->getCountry($track['cou_id']);
    $weather = "sun";
    if($track['weather'] < 31)
    {
	    $weather = "rain";
    }
    if($track['weather'] > 30 && $track['weather'] < 71)
    {
	    $weather = "cloudy";
    }

    $smarty->assign('track', $track);
    $smarty->assign('country', $country);
    $smarty->assign('weather', $weather);
    $smarty->assign('content', 'race_info.tpl');