<?php
	ini_set('memory_limit', '1024M');
	ini_set('display_errors', 'On');
    error_reporting(E_ERROR);
    set_time_limit(3600);

	set_include_path(dirname(__FILE__));
	include_once 'bootstrap.php';

	chdir(dirname(__FILE__));

	//run Cron Script
	//ideal for hourly crons

	$debug = true;
	$cron_db = clone $db;

	//get current date
	$time = time();
	$date = date('Y-m-d H:i:s', $time);

	$instances = $cron_db->getInstances();
	foreach($instances as $instance)
	{
		$params = $cron_db->getParams($instance['id']);

		$current_race = $instance['current_race'];
		$current_day = $instance['current_day'];

		$races = $cron_db->getTrackCalendar($instance['id']);
		$track = $cron_db->getTrack($instance['id']);
		$calendar = $races[$current_race-1];

		//detect which type of event this is
		$date_training = strtotime($calendar['training_date']);
		$date_qualification = strtotime($calendar['qualification_date']);
		$date_race = strtotime($calendar['race_date']);
		$date_training_next = -1;
		if($debug) echo "current_race: ".$current_race." count(races): ".count($races)."\n";
		if($current_race < count($races))
		{
			$calendar_next = $races[$current_race];
			$date_training_next = strtotime($calendar_next['training_date']);
		}

		if($debug)
		{
			echo "current_day:   ".$current_day."\n";
			echo "now:           ".$time." - ".date("d.m.Y H:i", $time)."\n";
			echo "training:      ".$date_training." - ".date("d.m.Y H:i", $date_training)."\n";
			echo "quali:         ".$date_qualification." - ".date("d.m.Y H:i", $date_qualification)."\n";
			echo "race:          ".$date_race." - ".date("d.m.Y H:i", $date_race)."\n";
			echo "next training: ".$date_training_next." - ".date("d.m.Y H:i", $date_training_next)."\n";
			echo "start: ".date("H:i:s")."\n";
		}

		if($time >= $date_training && $time < $date_qualification)	//changed for fast season
		{
			if($current_day == 3 || $current_day == 0)
			{
				if($debug) echo "cron_compute_training\n";
				cron_compute_training($cron_db, $instance['id']);			//computes ai driver training for all instances
				$cron_db->updateInstanceCurrentDay($instance['id'], 1);
			}
		}//training
		else
		{
			//decide which event should be computed
			if($time >= $date_qualification && $time < $date_race)
			{
				if($current_day == 1)
				{
					if($debug) echo "cron_compute_qualification\n";
					cron_compute_qualification($cron_db, $instance['id']);	//computes qualification for all instances
					$cron_db->updateInstanceCurrentDay($instance['id'], 2);
				}
			}//qualification
			else
			{
				if($time >= $date_race)
				{
					//compute race
					if($current_day == 2)
					{
						if($debug) echo "cron_compute_race\n";
						cron_compute_race($cron_db, $instance['id']);		//computes race for all instances
						$cron_db->updateInstanceCurrentDay($instance['id'], 3);
					}//race
					else
					{
						//next race?
						if($current_day == 3)
						{
							if($date_training_next != -1)
							{
								if($time >= $date_training_next)
								{
									if($debug) echo "cron_compute_next_race\n";
									cron_compute_next_race($cron_db, $instance['id']);
								}
							}
							//saison change ($date_training_next == -1) there is no next race
							else
							{
								$params = $cron_db->getParams($instance['id']);
								if($time >= $date_race + ($params['post_saison'] * 604800) ) //7 * 24 * 60 * 60
								{
									if($debug) echo "cron_compute_next_saison\n";
									cron_compute_next_season($cron_db);
								}
							}
						}
					}
				}//race / next day / next season
			}
		}

		if($debug)
		{
			echo "stop: ".date("H:i:s")."\n";
		}

		//driver bids
		//should run every hour
		if($params['driver_bid_type'] == 1)
		{
			if($debug) echo "cron_compute_driver_bids\n";
			cron_compute_driver_bids($cron_db, $instance['id']);
			if($debug) echo "cron_check_mechanics\n";
			$mechanics_old = $cron_db->getFreeMechanics('id asc');
			$count = count($mechanics_old);
			if($count < 50)
			{
				include_once('classes/F1Cron.class.php');
				$f1cron = new F1Cron($cron_db);
				$f1cron->create_new_mechanics();
			}
		}
	}
