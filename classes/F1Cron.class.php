<?php
    class F1Cron 
    {
        //vars
        private $db = null;

        private $min_mechanics = 20;        //min number of mechanics of instance tolerable
        private $create_mechanics = 5;      //number of mechanics to create for next week

		private $safety_car_flag = false;
		private $safety_car_round = 0;
		private $safety_car_round_max = 0;
		
		private $max_number_pitstop = 10;

        /*
         * Constructor initializes RandomNumberGenerator
         * and sets db Variable
         */
        function __construct($db){
        	RandomNumberGenerator::init();	//initialize RandomNumberGenerator
            $this->db = $db;
        }

		/*
		 * get a random float number
		 */
        function get_rand_float()
        {
            return mt_rand() / mt_getrandmax();
        }
        
        /*
         * this function switches marker of current race displayed to users
         * this should be called some days after computation of race
         */
        public function move_to_next_race($ins_id)
        {
			$this->db->updateInstanceToNextRace($ins_id);
			$users = $this->db->getUsers($ins_id);
			foreach($users as $user)
			{
				$this->db->randomizeUserTrackSettings($user['id']);
			}
        }//move_to_next_rave
        
        /*
         * generates history tables for teams and drivers
         * params: no
         * return: nothing - see db
         */
        public function compute_statistic($ins_id)
        {
			//get all users
			$user_array = $this->db->getUsers($ins_id);
			foreach($user_array as $user)
			{
				//save user history
				$this->db->saveUserHistory($user['id'], $ins_id, date('Y-m-d H:i:s'));
			}//foreach user
			
			//get all teams
			$team_array = $this->db->getTeams($ins_id, 'points desc');
			foreach($team_array as $_team)
			{
				//save team history
				$this->db->saveTeamHistory($_team['id'], $_team['league'], $ins_id, date('Y-m-d H:i:s'));
				
				//save driver hostory
				$drivers = $this->db->getDriversOfTeam($_team['id']);
				$league = $_team['league'];
				if(!empty($drivers))
				{
					foreach($drivers as $driver)
						$this->db->saveDriverHistory($driver['id'], $_team['league'], $ins_id, date('Y-m-d H:i:s'));
				}//if
				
				//save AI driver hostory
				$drivers = $this->db->getAIDriversOfTeam($_team['id']);
				$league = $_team['league'];
				if(!empty($drivers))
				{
					foreach($drivers as $driver)
						$this->db->saveDriverHistory($driver['id'], $_team['league'], $ins_id, date('Y-m-d H:i:s'));
				}//if
			}//foreach team
		}//compute statistic
        
        /*
         * computes points after race and stores them into database
         * params: no
         * return: nothing - everything is stored to db
         */
        public function compute_points($ins_id)
        {
			$track = $this->db->getTrack($ins_id);
			$winners = array();		//winner driver ids of each league
			
			for($league = 1; $league < 4; ++$league)
			{
				$result = $this->db->getRaceResult($ins_id, $league, 2, -1, $track['rounds']);
				$points = $this->db->getPoints($ins_id);
				
				$sum_points = array(); 	//sum points for team
				
				//save driver points
				$array_size = count($points);
				for($i = 0; $i < $array_size; ++$i)
				{
					if(count($result) > $i)
					{
						$tea_id = $result[$i]['tea_id'];
						$car = $result[$i]['car_number'];
						$team = $this->db->getTeam($tea_id);
						$driver_id = ($car==1)?$team['driver1']:$team['driver2'];
						
						//remember dri_id of winner
						if($i == 0)
						{
							$winners[$league-1] = $driver_id;
						}
						
						//points to driver
						$this->db->addDriverPoints($driver_id, $points[$i]['points']);

						if(isset($sum_points[$tea_id]))
							$sum_points[$tea_id] += $points[$i]['points'];
						else
							$sum_points[$tea_id] = $points[$i]['points'];
					}
				}
				
				$_teams = array();
				
				//statistic
				$array_size = count($result);
				for($i = 0; $i < $array_size; ++$i)
				{
					$tea_id = $result[$i]['tea_id'];
					$car = $result[$i]['car_number'];
					$team = $this->db->getTeam($tea_id);
					$driver_id = ($car==1)?$team['driver1']:$team['driver2'];
					
					//winner
					if($i == 0)
					{
						$this->db->addDriverWinner($driver_id, $league-1);		//count wins to driver
						$this->db->addTeamWinner($tea_id, $league-1);			//count wins to team
					}
					//podium
					if($i < 3)
					{
						$this->db->addDriverPodium($driver_id, $league-1);		//count podium to driver
						$this->db->addTeamPodium($tea_id, $league-1);			//count podium to team
					}
					//out, disqualification
					if($result[$i]['disqualified'] != 0)
					{
						$this->db->addDriverOut($driver_id, $league-1);			//count disqualifiction to driver
						$this->db->addTeamOut($tea_id, $league-1);				//count disqualifiction to team
					}
					//f1 gps
					$this->db->addDriverGp($driver_id, $league-1);				//count gps to driver
					if(!in_array($tea_id, $_teams))
					{
						$this->db->addTeamGp($tea_id, $league-1);				//count gps to team
						$_teams[] = $tea_id;
					}
				}
				
				//save team and manager points
				foreach($sum_points as $key=>$value)
				{
					//points to team
					$this->db->addTeamPoints($key, $value);
					
					$user = $this->db->getUserByTeam($key);
					//points to manager
					$this->db->addUserPoints($user['id'], $value);
				}
				
				//save driver places to db for same points sorting
				$array_size = count($result);
				for($i = 0; $i < $array_size; ++$i)
				{
					$tea_id = $result[$i]['tea_id'];
					$car = $result[$i]['car_number'];
					$team = $this->db->getTeam($tea_id);
					$driver_id = ($car==1)?$team['driver1']:$team['driver2'];
					
					$this->db->addDriverPlacement($driver_id, $i);
					$this->db->addTeamPlacement($tea_id, $i);
					$manager = $this->db->getUserByTeam($tea_id);
					$this->db->addManagerPlacement($manager['id'], $i);
				}
			}//for each league
			
			//store all 3 winners (for each league) to track
			$this->db->updateTrackWinner($track['id'], $winners);
        }//compute points
        
        /*
         * computes the changes of morale of driver and mechanics after race is done
         * params: no
         * return: nothing - all changes are done to db with log
         */
        public function compute_morale($ins_id)
        {
        	$leagues_array = array(array(1,2,3,4), array(3,4,5,6), array(5,6,7,8));

			$track = $this->db->getTrack($ins_id);
			for($league = 1; $league < 4; ++$league)
			{
				$result = $this->db->getRaceResult($ins_id, $league, 2, -1, $track['rounds']);
				
				$array_size = count($result);
				for($i = 0; $i < $array_size; ++$i)
				{
					$tea_id = $result[$i]['tea_id'];
					$car = $result[$i]['car_number'];
					$team = $this->db->getTeam($tea_id);
					$driver_id = ($car==1)?$team['driver1']:$team['driver2'];
					
					//			League 1		League 2		League 3
					//1-5		1				3				5
					//6-10		2				4				6
					//11-15		3				5				7
					//16-x		4				6				8
					$index = -1;
					if($i < 6)
					{
						$index = 0;
					}
					if($i > 5 && $i < 11)
					{
						$index = 1;
					}
					if($i > 10 && $i < 16)
					{
						$index = 2;
					}
					if($i > 15)
					{
						$index = 3;
					}
					
					if($index != -1)
					{
						$driver = $this->db->getDriver($driver_id);
						$mechanics = $this->db->getMechanicsOfTeam($tea_id);
						
						//good
						if($leagues_array[$team['league']-1][$index] <= $team['class'])
						{
							//driver
							$driver['morale'] = $driver['morale'] + rand(0,3);
							if($driver['morale'] > 100)
								$driver['morale'] = 100;
							$this->db->updateDriverMorale($driver['id'], $driver['morale']);

							//mechanic
							foreach($mechanics as $mechanic)
							{
								$mechanic['morale'] = $mechanic['morale'] + rand(0,1);
								if($mechanic['morale'] > 100)
									$mechanic['morale'] = 100;
								$this->db->updateMechanicMorale($mechanic['id'], $mechanic['morale']);
							}
						}
						//bad
						if($leagues_array[$team['league']-1][$index] > $team['class'] + rand(0,1))
						{
							//driver
							$driver['morale'] = $driver['morale'] - rand(0,3);
							if($driver['morale'] < 0)
								$driver['morale'] = 0;
							$this->db->updateDriverMorale($driver['id'], $driver['morale']);									
							
							//mechanic
							foreach($mechanics as $mechanic)
							{
								$mechanic['morale'] = $mechanic['morale'] - rand(0,1);
								if($mechanic['morale'] < 0)
									$mechanic['morale'] = 0;
								$this->db->updateMechanicMorale($mechanic['id'], $mechanic['morale']);
							}
						}
					}
				}//for
			}//for
        }//compute_morale
        
        /*
         * computes the changes of finance after race is done
         * params: no
         * return: nothing - all changes are done to db with log
         */
        public function compute_finance($ins_id)
        {
			$track = $this->db->getTrack($ins_id);
			$points = $this->db->getPoints($ins_id);
			$bonus = $this->db->getBonus();
			
			for($league = 1; $league < 4; ++$league)
			{
				switch($league)
				{
					case 1: $bonus_race = explode(' ', $bonus['f1_race']); break;
					case 2: $bonus_race = explode(' ', $bonus['f2_race']); break;
					case 3: $bonus_race = explode(' ', $bonus['f3_race']); break;
				}
				
				$result = $this->db->getRaceResult($ins_id, $league, 2, -1, $track['rounds']);
				$bonus_race_index = 0;
				
				$sum_points = array();		//sum of points per team
				
				$array_size = count($points);
				for($i = 0; $i < $array_size; ++$i)
				{
					if(count($result) > $i)
					{
						//driver points --> driver out bonus
						$tea_id = $result[$i]['tea_id'];
						$car = $result[$i]['car_number'];
						$team = $this->db->getTeam($tea_id);
						$driver_id = ($car==1)?$team['driver1']:$team['driver2'];
						
						//only for human players
						if($this->db->isManagedTeam($tea_id))
						{
							$this->db->payDriverBonus($driver_id, $tea_id, $points[$i]['points']);
						}
						
						if(isset($sum_points[$tea_id]))
							$sum_points[$tea_id] += $points[$i]['points'];
						else
							$sum_points[$tea_id] = $points[$i]['points'];
					}//if
				}//for
				
				foreach($sum_points as $key=>$value)
				{
					//points --> mechanic out bonus
					$mechanics = $this->db->getMechanicsOfTeam($key);
					foreach($mechanics as $mechanic)
					{
						$this->db->payMechanicBonus($mechanic['id'], $key, $value);
					}
					
					$team = $this->db->getTeam($key);
					//only for human players
					if($this->db->isManagedTeam($team['id']))
					{
						//points --> sponsor in bonus
						if(isset($team['spo_id']))
							$this->db->getSponsorBonus($team['spo_id'], $key, $value);
						if(isset($team['tir_id']))
							$this->db->getTireBonus($team['tir_id'], $key, $value);
					}
				}//foreach
				
				$array_size = count($result);
				$array_size1 = count($bonus_race);
				for($i = 0; $i < $array_size; ++$i)
				{
					//points --> in bonus
					if($bonus_race_index < $array_size1)
					{
						//only for human players
						if($this->db->isManagedTeam($result[$i]['tea_id']))
						{
							$this->db->getBonusPoints($ins_id, $result[$i]['tea_id'], $bonus_race[$bonus_race_index]);
						}
					}
					$bonus_race_index++;
				}//for
			}//for each league
        }//compute_finance

		/*
         * computes the qualification for each league, then generates a html table for fast display to user
         * params: no
         * return: nothing - everything is stored into db
         */
        function compute_qualification($ins_id)
        {
			//load things for this instance
			$params = $this->db->getParams($ins_id);
			$track = $this->db->getTrack($ins_id);
			
			//first compute points of youth league
			$laps_all_old = $this->db->getSetupOfType($ins_id,null,0);
			$laps_all = array();
			foreach($laps_all_old as $lap)
			{
				$_team = $this->db->getTeam($lap['tea_id']);
				
				//youth league
				if($_team['driver3'] == $lap['dri_id'])
				{
					$laps_all[] = $lap;
				}
			}//foreach

			//now set youth points for the first ones
			$points = $this->db->getYouthPoints();

			//save driver points
			$array_size = count($points);
			for($i = 0; $i < $array_size; ++$i)
			{
				if(count($laps_all) > $i)
				{
					$tea_id = $laps_all[$i]['tea_id'];
					$driver_id = $laps_all[$i]['dri_id'];
					
					//points to driver and money to team
					$this->db->addDriverYouthPoints($driver_id, $tea_id, $points[$i]['points'], $points[$i]['bonus']);
					$this->db->addTeamYouthPoints($tea_id, $points[$i]['points']);
				}
			}
				
			$league_array = array();

			//for each leage compute a seperate qualification
			for($league = 1; $league < 4; ++$league)
			{
				//Q1
				//get all settings for Q1 order by team and car of instance
				$setup_settings = $this->db->getAllSetupSetting(1, 0, $ins_id, $league);
				$this->compute_rounds_for_settings($setup_settings, $track, $params, 0, $league);

				//Q2
				//Q1 is now finished --> get best drivers and do cut
				//get the best drivers
				$laps_all_old = $this->db->getSetupOfType($ins_id, $league, 1, 0);

				//we only need the best x from them
				$laps_all = array();
				foreach($laps_all_old as $laps)
				{
					$laps_all[] = $laps;

					if(count($laps_all) + 1 == $params['qualification_cut1'])
						break;
				}
				
				//get settings for Q2 and delete all that are not from best drivers
				$setup_settings = $this->db->getAllSetupSetting(1, 1, $ins_id, $league);
				$setup_settings_new = array();
				foreach($setup_settings as $setting)
				{
					foreach($laps_all as $lap)
					{
						if($setting['tea_id'] == $lap['tea_id'])
							if($setting['car_number'] == $lap['car_number'])
								$setup_settings_new[] =  $setting;
					}
				}
				$setup_settings = null;

				$this->compute_rounds_for_settings($setup_settings_new, $track, $params, 1, $league);

				//Q3
				//get the best drivers
				$laps_all_old = $this->db->getSetupOfType($ins_id, $league, 1, 1);
				//we only need the best x from them
				$laps_all = array();
				foreach($laps_all_old as $laps)
				{
					$laps_all[] = $laps;

					if(count($laps_all) + 1 == $params['qualification_cut2'])
						break;
				}
				//get settings for Q2 and delete all that are not from best drivers
				$setup_settings = $this->db->getAllSetupSetting(1, 2, $ins_id, $league);
				$setup_settings_new = array();
				foreach($setup_settings as $setting)
				{
					foreach($laps_all as $lap)
					{
						if($setting['tea_id'] == $lap['tea_id'])
							if($setting['car_number'] == $lap['car_number'])
								$setup_settings_new[] =  $setting;
					}
				}
				$setup_settings = null;

				$this->compute_rounds_for_settings($setup_settings_new, $track, $params, 2, $league);
				
				//done computing qualification! now get it in a table form and store it to db
				
				$params = $this->db->getParams($ins_id);
				$result = array();
				//for each session
				for($i = 0; $i < 3; ++$i)
				{
					$result[$i] = array();
		
					//for each round
					for($x = 1; $x <= $params['qualification_max_rounds']; ++$x)
					{
						//get data from db (already sorted by fastesttime)
						$laps = $this->db->getSetupOfType($ins_id, $league, 1, $i, $x);
		
						$position = 0;
						$s = '';
						$best_fastest_lap = -1;
						$diff = '';
						foreach($laps as $l)
						{
							//set team and driver
							$_team = $this->db->getTeam($l['tea_id']);
							$_user = $this->db->getUserByTeam($l['tea_id']);
							$driver = $this->db->getDriver($_team['driver'.$l['car_number']]);
		
							$l['team_name'] = $_team['name'];
							$l['driver_firstname'] = $driver['firstname'];
							$l['driver_lastname'] = $driver['lastname'];

							$position++;
							if($l['fastest_time'] > $best_fastest_lap && $best_fastest_lap > 0)
							{
								$diff = "+".time_to_string($l['fastest_time'] - $best_fastest_lap);
							}
							
							//disqualification
							if($l['fastest_time'] >= 99999999.999)
							{
								$diff = "";
								$l['round_time_string'] = "Disqualification";
							}
							
							//if roundtime is too big, driver stays in box
							if($l['round_time'] >= 99999999.999)
							{
								$l['round_time_string'] = '';
							}
							$manager_name = $_team['manager'];
							if($_user != null)
							{
								$manager_name = $_user['name'];
							}
							
							$img = "<div class='desktop_slider'><div style='position: relative;'><div style='position:absolute; width:100px; z-index:1'><img src='content/img/car/team/".$_team['id'].".png' width='100%'/></div>";
							$img.= "<div style='z-index:99; width:100px;'><img src='content/img/driver/helmet/".$driver['cou_id'].".png' width='100%'></div></div></div>";
							$img.= "<div class='mobile_slider'><div style='position: relative;'><div style='position:absolute; width:50px; z-index:1'><img src='content/img/car/team/".$_team['id'].".png' width='100%'/></div>";
							$img.= "<div style='z-index:99; width:50px;'><img src='content/img/driver/helmet/".$driver['cou_id'].".png' width='100%'></div></div></div>";

							$s .= "<tr class='line-".$_team['id']."' style='color:#".$_team['color1'].";font-weight:bold'><td>".$position."</td><td>".$img."</td><td>".$driver['firstname']." ".$driver['lastname']."</td><td class='mobile_invisible_low'>".$_team['name']."</td><td class='mobile_invisible_low'>".$manager_name."</td><td class='mobile_invisible_high'>".(($l['tire_type']==0)?'tr_race_training_setup_hard':'tr_race_training_setup_soft')."</td><td class='mobile_invisible_low' align='right'>".$l['round_time_string']."</td><td align='right'>".$l['fastest_time_string']."</td><td align='right'><span class='nowrapping'>".$diff."</span></td></tr>";
							
							if($best_fastest_lap < 0)
								$best_fastest_lap = $l['fastest_time'];
						}
		
						$result[$i][$x-1] = $s;
					}//for
				}//for
				
				$league_array[$league-1] = $result;
			}//for league
			
			$quali_data = serialize($league_array);
			$this->db->setInstanceQualification($ins_id, $quali_data);
			
			//pole statistic
			for($league = 1; $league < 4; ++$league)
			{
				$starting_grid = $this->get_starting_grid($ins_id, $params, $league, 0);
				$_team = $this->db->getTeam($starting_grid[0]['tea_id']);
				$driver = $this->db->getDriver($_team['driver'.$starting_grid[0]['car_number']]);
				
				$this->db->addDriverPole($driver['id'], $league-1);
				$this->db->addTeamPole($starting_grid[0]['tea_id'], $league-1);
			}
			
			$instance = $this->db->getInstance($ins_id);
			//get forum id from instance de and en
			if($instance['phpbb_forum_id_de'])
			{
				$subject = get_phpbbforum_subject(0, 0, $track);
				$text = get_phpbbforum_text(0, 0, $league_array, $ins_id, $this->db);
				write_text_to_forum($instance['phpbb_forum_id_de'], $subject, $text);
			}
			if($instance['phpbb_forum_id_en'])
			{
				$subject = get_phpbbforum_subject(1, 0, $track);
				$text = get_phpbbforum_text(1, 0, $league_array, $ins_id, $this->db);
				write_text_to_forum($instance['phpbb_forum_id_en'], $subject, $text);
			}
        }//compute_qualification

		/*
		 * computes the race. first compute race into db for each league, then generate a html table for fast display to user.
		 * params: no
		 * return: nothing - everything is stored into db
		 */
        function compute_race($ins_id)
        {
        	$time_start = microtime_float();
        	$caching = true;		//cache teams and drivers in arrays so they are only fetched once from db!
        
			//load things for this instance
			$params = $this->db->getParams($ins_id);
			$track = $this->db->getTrack($ins_id);
				
			$league_array = array();

			//for each leage compute a seperate qualification
			for($league = 1; $league < 4; ++$league)
			{

				$starting_grid = $this->get_starting_grid($ins_id, $params, $league, 1);
				$this->compute_rounds_for_race($ins_id, $starting_grid, $track, $params, $league);
				
				//done computing race! now get it in a table form and store it to db
				
				//store race data as serialized object to db for fast loading
				//all lines have class with team id -> will be string replaced to class with mark for own team
				$track = $this->db->getTrack($ins_id);
				$result = array();
				$last_lap = array();
				$last_place = array();
				$start_position_driver = array();	//remember starting position by driver
				
				if($caching)
				{
					$team_array = array();
					$driver_array = array();
				}
				
				//add starting grid
				$s = '';
				$position = 0;
				$array_size = count($starting_grid);
				for($j = 0; $j < $array_size; ++$j)
				{
					$position++;
					if($caching)
					{
						$team_id = $starting_grid[$j]['tea_id'];
						if(!array_key_exists($team_id, $team_array))
							$team_array[$team_id] = $this->db->getTeam($team_id);
						$_team = $team_array[$team_id];
						$driver_id = $_team['driver'.$starting_grid[$j]['car_number']];
						if(!array_key_exists($driver_id, $driver_array))
							$driver_array[$driver_id] = $this->db->getDriver($driver_id);
						$driver = $driver_array[$driver_id];
					}
					else{
						$_team = $this->db->getTeam($starting_grid[$j]['tea_id']);
						$driver = $this->db->getDriver($_team['driver'.$starting_grid[$j]['car_number']]);
					}
					$start_position_driver[$driver['id']] = $position;	//store start position
					$laps = $this->db->getSetupOfType($ins_id, $league, 2, -1, 1);
					$tire_type = 0;
					foreach($laps as $l)
					{
						if($l['tea_id'] == $starting_grid[$j]['tea_id'])
						{
							if($l['car_number'] == $starting_grid[$j]['car_number'])
							{
								$tire_type = $l['tire_type'];
								break;
							}//if
						}//if
					}//foreach
					$last_place[$driver['id']] = $position;
					
					$img = "<div class='desktop_slider'><div style='position: relative;'><div style='position:absolute; width:100px; z-index:1'><img src='content/img/car/team/".$_team['id'].".png' width='100%'/></div>";
				$img.= "<div style='z-index:99; width:100px;'><img src='content/img/driver/helmet/".$driver['cou_id'].".png' width='100%'></div></div></div>";
				$img.= "<div class='mobile_slider'><div style='position: relative;'><div style='position:absolute; width:50px; z-index:1'><img src='content/img/car/team/".$_team['id'].".png' width='100%'/></div>";
				$img.= "<div style='z-index:99; width:50px;'><img src='content/img/driver/helmet/".$driver['cou_id'].".png' width='100%'></div></div></div>";
				  
						
					$s.= "<tr class='line-".$starting_grid[$j]['tea_id']."' style='color:#".$_team['color1'].";font-weight:bold'><td>".$position."</td><td class='mobile_invisible_low'>".$position."</td><td>".$img."</td><td>".$driver['firstname']." ".$driver['lastname']."</td><td class='mobile_invisible_low'>".$_team['name']."</td><td class='mobile_invisible_low manager_race'></td><td class='mobile_invisible_high'>".(($tire_type==0)?'tr_race_training_setup_hard':'tr_race_training_setup_soft')."</td>";
					$s.= "<td class='mobile_invisible_high'></td><td class='mobile_invisible_high'></td><td class='mobile_invisible_low'></td><td></td><td class='mobile_invisible_low'></td><td></td></tr>";
				}//for
				$result[0] = $s;
	
				//for each round
				for($x = 1; $x <= $track['rounds']; ++$x)
				{
					//get data from db (already sorted by fastesttime)
					$laps = $this->db->getSetupOfTypeForRace($ins_id, $league, 2, -1, $x);
					$position = 0;
					$s = '';
					$best_fastest_lap = -1;
					$driver_ahead_round_time = -1;
					$diff = '';
					$diff_ahead = '';
					
					$fastest_time_marker = array(0, -1);
					$index = 0;
					foreach($laps as $l)
					{
						//set team and driver
						if($caching)
						{
							$team_id = $l['tea_id'];
							if(!array_key_exists($team_id, $team_array))
								$team_array[$team_id] = $this->db->getTeam($team_id);
							$_team = $team_array[$team_id];
							$driver_id = $_team['driver'.$l['car_number']];
							if(!array_key_exists($driver_id, $driver_array))
								$driver_array[$driver_id] = $this->db->getDriver($driver_id);
							$driver = $driver_array[$driver_id];
						}
						else{
							$_team = $this->db->getTeam($l['tea_id']);
							$driver = $this->db->getDriver($_team['driver'.$l['car_number']]);
						}
						$_user = $this->db->getUserByTeam($l['tea_id']);
		
						$l['team_name'] = $_team['name'];
						$l['driver_firstname'] = $driver['firstname'];
						$l['driver_lastname'] = $driver['lastname'];
		
						$position++;
						//compute diff to first
						if($l['round_time'] > $best_fastest_lap && $best_fastest_lap > 0)
						{
							$diff = "+".time_to_string($l['round_time'] - $best_fastest_lap);
						}
						//compute diff to ahead
						if($l['round_time'] > $driver_ahead_round_time && $driver_ahead_round_time > 0)
						{
							$diff_ahead = "+".time_to_string($l['round_time'] - $driver_ahead_round_time);
						}
						$driver_ahead_round_time = $l['round_time'];
						$last_lap_string = "";
						if(isset($last_lap[$driver['id']]))
						{
							$last_lap_string = time_to_string($l['round_time'] - $last_lap[$driver['id']]);
						}
						$last_lap[$driver['id']] = $l['round_time'];
						$place_diff = "";
						if(isset($last_place[$driver['id']]))
						{
							if($last_place[$driver['id']] > $position)
								$place_diff = "<span style='color: green'>&#9650; +".($last_place[$driver['id']] - $position)."</span>";//▲
							if($last_place[$driver['id']] < $position)
								$place_diff = "<span style='color: red'>&#9660; -".($position - $last_place[$driver['id']])."</span>";//▼
						}
						$last_place[$driver['id']] = $position;
						
						if($fastest_time_marker[1] == -1 || $fastest_time_marker[1] > $l['fastest_time'])
						{
							$fastest_time_marker[1] = $l['fastest_time'];
							$fastest_time_marker[0] = $index;
						}
						
						$safety_car_class = '';
						if($l['safetycar'] == 1)
							$safety_car_class = ' safetycar';
						
						$manager_name = $_team['manager'];
						if($_user != null)
						{
							$manager_name = $_user['name'];
						}
				
				$img = "<div class='desktop_slider'><div style='position: relative;'><div style='position:absolute; width:100px; z-index:1'><img src='content/img/car/team/".$_team['id'].".png' width='100%'/></div>";
				$img.= "<div style='z-index:99; width:100px;'><img src='content/img/driver/helmet/".$driver['cou_id'].".png' width='100%'></div></div></div>";
				$img.= "<div class='mobile_slider'><div style='position: relative;'><div style='position:absolute; width:50px; z-index:1'><img src='content/img/car/team/".$_team['id'].".png' width='100%'/></div>";
				$img.= "<div style='z-index:99; width:50px;'><img src='content/img/driver/helmet/".$driver['cou_id'].".png' width='100%'></div></div></div>";
							
						$s.= "<tr class='line-".$_team['id'].$safety_car_class."' style='color:#".$_team['color1'].";font-weight:bold'><td>".$position." ".$place_diff."</td><td class='mobile_invisible_low'>".$start_position_driver[$driver['id']]."</td><td>".$img."</td><td>".$driver['firstname']." ".$driver['lastname']."</td><td class='mobile_invisible_low'>".$_team['name']."</td><td class='mobile_invisible_low manager_race'>".$manager_name."</td><td class='mobile_invisible_high'>".(($l['tire_type']==0)?'tr_race_training_setup_hard':'tr_race_training_setup_soft')."</td>";
						
						if($l['disqualified'] > 0)
						{
							if($l['fastest_time'] < 99 && $l['fastest_time'] > 0)
								$s.="<td class='mobile_invisible_high' colspan='3'>".$this->getReasonOfStop($l['reason'], $l['disqualified'])."</td><td class='mobile_visible'>".$this->getReasonOfStop($l['reason'], $l['disqualified'])."</td><td class='mobile_invisible_low'></td>";
							else
								$s.="<td class='mobile_invisible_high'>".$this->getReasonOfStop($l['reason'], $l['disqualified'])."</td><td class='mobile_invisible_high'></td><td class='mobile_visible'>".$this->getReasonOfStop($l['reason'], $l['disqualified'])."</td><td class='mobile_invisible_low'></td>";
						}
						else
						{
							$s.="<td class='mobile_invisible_high' align='right'>".$l['round_time_string']."</td><td class='mobile_invisible_high fastest_time".$index."x' align='right'>".$l['fastest_time_string']."</td><td class='mobile_invisible_low' align='right'>".$last_lap_string."</td>";
							if($diff == '')	//first
								$s.="<td class='mobile_visible' align='right'>".$l['round_time_string']."</td><td class='mobile_invisible_low'></td>";
							else
								$s.="<td align='right'><span class='nowrapping'>".$diff_ahead."</span></td><td class='mobile_invisible_low' align='right' align='right'><span class='nowrapping'>".$diff."</span></td>";
						}
						$s.="<td align='right'>".($l['pit_stop']>0?$l['pit_stop']:'')."</td></tr>";
						
						if($best_fastest_lap < 0)
							$best_fastest_lap = $l['round_time'];
						   
						$index++;
					}
		
					$s = str_replace('fastest_time'.$fastest_time_marker[0].'x', 'fastest_time_marker', $s);
					$result[$x] = $s;
				}//for each round
				
				$league_array[$league-1] = $result;
			}//for league
			
			$race_data = serialize($league_array);
			$this->db->setInstanceRace($ins_id, $race_data);
			$this->db->setTrackRace($track['id'], $race_data);
			
			$time_end = microtime_float();
			$time = $time_end - $time_start;
			$sec = $time / 60;
			
			//echo "race computed in ".number_format($sec,2)." mintues\n";
			$instance = $this->db->getInstance($ins_id);
			
			//get forum id from instance de and en
			if($instance['phpbb_forum_id_de'])
			{
				$subject = get_phpbbforum_subject(0, 1, $track);
				$text = get_phpbbforum_text(0, 1, $league_array, $ins_id, $this->db);
				write_text_to_forum($instance['phpbb_forum_id_de'], $subject, $text);
			}
			if($instance['phpbb_forum_id_en'])
			{
				$subject = get_phpbbforum_subject(1, 1, $track);
				$text = get_phpbbforum_text(1, 1, $league_array, $ins_id, $this->db);
				write_text_to_forum($instance['phpbb_forum_id_en'], $subject, $text);
			}
        }//compute_race

		/*
		 * get the starting grid as array based on already computed qualification
		 * params: instance id, global params, league number
		 * return: starting grid array
		 */
        private function get_starting_grid($ins_id, $params, $league, $race)
        {
            $starting_grid = array();
            $start_distance_min = 1;    //distance between driver in starting grid
            $start_distance_max = 5;    //min and max values in 0.01 seconds
            //get current weather
            $track = $this->db->getTrack($ins_id);
            $weather = $track['weather'];

            //add to 10 driver
            $top10 = $this->db->getSetupOfType($ins_id, $league, 1, 2, $params['qualification_max_rounds']);
            $count = 0;
            $last_time = 0;
            foreach($top10 as $driver)
            {
                $time = $count * (rand($start_distance_min, $start_distance_max) * 0.1);    //###IMPORTANT - Start time is 0,5 to 2 secounds for each place. This is RANDOM - change it with driver and car values for start
                $time = ($time / 60) / 60;
                $time = $time + $last_time;
                $starting_grid[] = array(
                    'tea_id' => $driver['tea_id'],
                    'car_number' => $driver['car_number'],
                    'round_time' => $time,
                    'fastest_time' => 0,
                    'pit_stop' => 0,
                    'out' => 0,
                    'out_type' => -1,
                    'last_round' => 0,
                    'weather' => $weather
                );
                $last_time = $time;
                $count++;
            }
            //add next ones
            $topmid = $this->db->getSetupOfType($ins_id, $league, 1, 1, $params['qualification_max_rounds']);
            $count1 = 0;
            $top10count = count($starting_grid);
            foreach($topmid as $driver)
            {
                if($count1 >= $top10count)
                {
                    $time = $count * (rand($start_distance_min, $start_distance_max) * 0.01);    //###IMPORTANT - Start time is 0,5 to 2 secounds for each place. This is RANDOM - change it with driver and car values for start
                    $time = ($time / 60) / 60;
                    $time = $time + $last_time;
                    $starting_grid[] = array(
                        'tea_id' => $driver['tea_id'],
                        'car_number' => $driver['car_number'],
                        'round_time' => $time,
                        'fastest_time' => 0,
                        'pit_stop' => 0,
                        'out' => 0,
                        'out_type' => -1,
                        'last_round' => 0,
                        'weather' => $weather
                    );
                    $last_time = $time;
                    $count++;
                }

                $count1++;
            }
            //add next ones
            $toplast = $this->db->getSetupOfType($ins_id, $league, 1, 0, $params['qualification_max_rounds']);
            $count2 = 0;
            $topmidcount = count($starting_grid);
            foreach($toplast as $driver)
            {
                if($count2 >= $topmidcount)
                {
                    $time = $count * (rand($start_distance_min, $start_distance_max) * 0.01);    //Start time is 1 to 5 secounds for each place. This is RANDOM - change it with driver and car values for start
                    $time = ($time / 60) / 60;
                    $time = $time + $last_time;
                    $starting_grid[] = array(
                        'tea_id' => $driver['tea_id'],
                        'car_number' => $driver['car_number'],
                        'round_time' => $time,
                        'fastest_time' => 0,
                        'pit_stop' => 0,
                        'out' => 0,
                        'out_type' => -1,
                        'last_round' => 0,
                        'weather' => $weather
                    );
                    $last_time = $time;
                    $count++;
                }

                $count2++;
            }

            return $starting_grid;
        }//get_starting_grid

		/*
         * computes whole race
         * params: instance id, starting grid, track information, global params, rain flag, league number
         * return: nothing - stores solution into db
         */
        private function compute_rounds_for_race($ins_id, $grid, $track, $params, $league)
        {
        	//$log = false;
        	
        	/*if($log)
        	{
				if (!$handle = fopen(__DIR__."/../log/race.log", "a")) {
					$content = "start race";
					fwrite($handle, $content);
					fclose($handle);
				}
			}*/
        	
        	usort($grid, function($a, $b) {
			    $a = floatval($a['round_time']);
            	$b = floatval($b['round_time']);
            	if($a == $b)
            		return 0;
			    return ($a < $b) ? -1 : 1;
			});
			
			$safetycar_flag = false;
			$first = -1;
			$first_pitstop = -1;
			$debug = false;
        	
            //compute all laps
            for($r = 1; $r <= $track['rounds']; ++$r)
            {
            	if($debug) echo "Round: ".$r."<br>";
            	$first = -1;
            	$array_size = count($grid);
                for($i = 0; $i < $array_size; ++$i)
                {
                	//set current setup
                	$old_tire_type = null;
                	if(isset($grid[$i]['tire_type']))
                		$old_tire_type = $grid[$i]['tire_type']; //needed that crashed driver tire does not flip
	                
                	$grid[$i] = $this->getCurrentSetup($r, $grid[$i], $ins_id);
	                
	                if($old_tire_type == null)
	                    $old_tire_type = $grid[$i]['tire_type'];
	                    	
                	//in case of disqualification
                	if($r > 1 && $grid[$i]['out'] > 0)
                	{
                		$grid[$i]['tire_type'] = $old_tire_type; //needed that crasehd driver tire does not flip
	                    
	                    $settings = array(
	                        'front_wing' => $grid[$i]['front_wing'],
	                        'rear_wing' => $grid[$i]['rear_wing'],
	                        'front_suspension' => $grid[$i]['front_suspension'],
	                        'rear_suspension' => $grid[$i]['rear_suspension'],
	                        'tire_pressure' => $grid[$i]['tire_pressure'],
	                        'brake_balance' => $grid[$i]['brake_balance'],
	                        'gear_ratio' => $grid[$i]['gear_ratio'],
	                        'power1' => $grid[$i]['power1'],
	                        'power2' => $grid[$i]['power2'],
	                        'power3' => $grid[$i]['power3'],
	                        'power4' => $grid[$i]['power4'],
	                        'power5' => $grid[$i]['power5'],
	                        'power6' => $grid[$i]['power6']
	                    );
	                    
	                	$round_data = array(
	                        $r,
	                        $grid[$i]['last_round'],
	                        99,
	                        "",
	                        $grid[$i]['fastest_time'],
	                        time_to_string($grid[$i]['fastest_time']),
	                        $grid[$i]['pit_stop'],
	                        $grid[$i]['out'],
	                        $grid[$i]['out_type'],
	                        $grid[$i]['tire_type'],
	                        $safetycar_flag?1:0
	                    );
	                    $grid[$i]['round_data'][] = $round_data;
	                    $grid[$i]['settings'][] = $settings;
                	}//if
                	else
                	{
                		$disqualified = false;
                		
                		//only check tire disqualification at first round
                		if($r == 1)
                		{
	                		//compute disqualification (because of wrong tires)
							if($params['race_diff_tires'] == 1)
							{
								$hard = 0;
							    $soft = 0;
	
							    $setups = $this->db->getSetupSettingAll($grid[$i]['car_number'], $grid[$i]['tea_id'], $ins_id, 2);
							    
							    if(isset($setups))
								    foreach($setups as $setup)
								    {
									    if($setup['tire_type'] == 0)
									    	$hard++;
									    if($setup['tire_type'] == 1)
									    	$soft++;
								    }
							    if($hard == 0 || $soft == 0)
							    	$disqualified = true;
						    }//if
					    }//if
					    
						if($first < 0)
                			$first = $i;
                		
	                    //if there was a pit stop add time to laptime
	                    //$pitstop_time = 0;
	                    //if($grid[$i]['pitstop'])
	                    //{
	                    //    $pitstop_time += $grid[$i]['mechanic_pitstop'] + (((rand(200, 400) *0.01) / 60) / 60);
	                    //    $grid[$i]['pit_stop'] += 1;
	                    //}
	
	                    //compute laptime
	                    $mechanic = array('setup' => $grid[$i]['mechanic_setup'], 'tires' => $grid[$i]['mechanic_tires']);
	
	                    //tires
	                    $tire = $this->db->getRaceTire($grid[$i]['race_tire_id']);
	                    $tire_type = $tire['tire_type'];
	
	                    $settings = array(
	                        'front_wing' => $grid[$i]['front_wing'],
	                        'rear_wing' => $grid[$i]['rear_wing'],
	                        'front_suspension' => $grid[$i]['front_suspension'],
	                        'rear_suspension' => $grid[$i]['rear_suspension'],
	                        'tire_pressure' => $grid[$i]['tire_pressure'],
	                        'brake_balance' => $grid[$i]['brake_balance'],
	                        'gear_ratio' => $grid[$i]['gear_ratio'],
	                        'power1' => $grid[$i]['power1'],
	                        'power2' => $grid[$i]['power2'],
	                        'power3' => $grid[$i]['power3'],
	                        'power4' => $grid[$i]['power4'],
	                        'power5' => $grid[$i]['power5'],
	                        'power6' => $grid[$i]['power6']
	                    );
	
	                    $driver = $grid[$i]['driver'];
	
	                    //car items reload (they are changing during race!)
	                    $car_old = $this->db->getItemsFromCar($grid[$i]['tea_id'],$grid[$i]['car_number']);
	                    $car = array();
	                    foreach($car_old as $c)
	                    {
	                        $item = $this->db->getItem($c['ite_id']);
	                        $c['name'] = $item['name'];
	                        //Formular for car values:
	                        //skill + (skill_max - skill) * tuneup in %
	                        $c['value'] = $item['skill'] + (($item['skill_max'] - $item['skill']) * ($c['tuneup'] * 0.01));
	                        //car part value changes by condition
	                        $c['value'] *= $c['condition'] * 0.01;
	                        $c['type'] = $item['type'];
	                        $car[] = $c;
	                    }
	                    
						if($disqualified)
						{
							/*if($log)
							{
								if (!$handle = fopen(__DIR__."/../log/race.log", "a")) {
									$content = "Fahrer: ".$grid[$i]['lastname']." wurde disqualifiziert in Runde: ".$r;
									fwrite($handle, $content);
									fclose($handle);
								}
							}*/
                    		$data = array($r, 99, "");
                    		$out = array(1, 11);
                    		$grid[$i]['round_time'] += $data[1];
                    	}
						else
						{
							$data = array($r, 99, "");
							
							if($grid[$i]['out'] == 0)
							{
								$data = compute_training($grid[$i]['user'],$settings, $driver, $car, $tire, $mechanic, $track, $r, $params, $grid[$i]['current_round_of_setup'] - 1);
								$out = $this->computeFailure($car, $driver, $params, $r, $grid[$i]['mechanic_repair'], $tire, $grid[$i]['weather']);
								
								//save new distance for tire (and active flag)
								$this->db->setRaceTireDistance($tire['id'], $tire['distance']);
								
								if($first_pitstop >= 0)
								{
									$first = $first_pitstop;
									$first_pitstop = -1;
								}
								
								//stay behind driver in front if it is safety car
								if($safetycar_flag)
								{
									if($i == $first)
									{
										//round time behind safety car is slower
										$data[1] *= 1.3;
									}
									else
									{
										if($r > 1 && $i > $first && $first > -1)
										{
											$j = $i;
										
											//for each driver in front of current driver
											while($j > $first)
											{
												//driver is only allowed to take over cars with pitstop
												if($grid[$j-1]['pitstop'] == false)
												{
													if($grid[$j-1]['round_time'] - $grid[$i]['round_time'] > $data[1])
													{
														//pitstop and safety car
														$data[1] = ($grid[$j-1]['round_time'] - $grid[$i]['round_time']) + (((rand(10,500) * 0.001) / 60) / 60);
														break;
													}
												}
												
												--$j;
											}//while
										}
									}
								}//if safetycar
								else
								{
									//check if there was an overtaking
									if($r > 1 && $i > $first && $first > -1)
									{
										$j = $i;
									
										//for each driver in front of current driver
										while($j > $first)
										{
											//if so look if this was possible by driver experience
											if($grid[$j-1]['out'] == 0)
											{
												if($grid[$i]['pitstop'] == false)   //problem with pitstop + blocking drivers solved?
												{
													//time_diff < 0 if driver was slower than driver before -> do nothing
													//time_diff > 0 && abs < 3 seconds choose
													//time_diff > 0 && abs > 3 far better overtake
													$time_diff = $grid[$j-1]['round_time'] - ($grid[$i]['round_time'] + $data[1]);
													
													//as discribed
													if($time_diff < 0)
														break;
													if($time_diff > 0 && abs($time_diff) < 0.0006)	//2,1 sekunden
													{
														$overtake_value = rand(0,100);
														//overtaking was not possible
														if(/*rand(0, 100 * ($track['rounds'] - ($r -1))) > $params['overtake'] && */$overtake_value < $track['overtake_propability'])
														{
															if($grid[$j-1]['round_time'] - $grid[$i]['round_time'] > $data[1])
															{
																$data[1] = ($grid[$j-1]['round_time'] - $grid[$i]['round_time']) + (((rand(10,500) * 0.001) / 60) / 60);
																break;
															}
														}
														else
														{
															$driver_ahead = $grid[$j-1]['driver'];
															if(($driver['experience'] + $driver['speed'] + rand(0,200)) < 
															   ($driver_ahead['experience'] + $driver_ahead['speed'] + rand(0,200)))
															{
																if($grid[$j-1]['round_time'] - $grid[$i]['round_time'] > $data[1])
																{
																	//get round time of driver ahead and add 0.01 to 0.5 seconds
																	$data[1] = ($grid[$j-1]['round_time'] - $grid[$i]['round_time']) + (((rand(10,500) * 0.001) / 60) / 60);
																	break;
																}
															}
														}
													}
                                                }//if pitstop
											}//if out
											
											--$j;
										}//while
									}
								}//else safetycar
							}//if out == 0
						}
						
						//if there was a pit stop add time to laptime
	                    $pitstop_time = 0;
	                    if($grid[$i]['pitstop'])
	                    {
	                        $pitstop_time += $grid[$i]['mechanic_pitstop'] + (((rand(200, 400) *0.01) / 60) / 60);
	                        $grid[$i]['pit_stop'] += 1;
	                    }
	                    
						//if there was a pitstop add its time
						if($grid[$i]['pitstop'] == true)
						{
							$data[1] += $pitstop_time;
						}
						//$grid[$i]['pitstop'] = false;
						$grid[$i]['out'] = $out[0];
						$grid[$i]['out_type'] = $out[1];
						$grid[$i]['round_time'] += $data[1];
	                    //in first round fastest lap is first round (+ starting grid time)
	                    if($r == 1)
	                    {
		                    $grid[$i]['fastest_time'] = $grid[$i]['round_time'];
		                }
		                //all other rounds only use laptime
	                    else
	                    {
		                    if($grid[$i]['fastest_time'] > $data[1])
		                    	$grid[$i]['fastest_time'] = $data[1];
		                }
	
						$grid[$i]['last_round'] = $r;
	                    $round_data = array(
	                        $r,
	                        $r,
	                        $grid[$i]['round_time'],
	                        time_to_string($grid[$i]['round_time']),
	                        $grid[$i]['fastest_time'],
	                        time_to_string($grid[$i]['fastest_time']),
	                        $grid[$i]['pit_stop'],
	                        $out[0],
	                        $out[1],
	                        $grid[$i]['tire_type'],
	                        $safetycar_flag?1:0
	                    );

	                    $grid[$i]['round_data'][] = $round_data;
	                    $grid[$i]['settings'][] = $settings;
                    }//else
                }//for
                
                //reset pitstop flags for all drivers
                for($i = 0; $i < $array_size; ++$i)
                	$grid[$i]['pitstop'] = false;
                
                if($this->safety_car_flag)
                {
                	$safetycar_flag = true;
	                if($this->safety_car_round > $this->safety_car_round_max)
	                {
		                $this->safety_car_round = 0;
		                $this->safety_car_round_max = 0;
		                $this->safety_car_flag = false;
	                }
	                $this->safety_car_round++;
				}
				else
				{
					$safetycar_flag = false;
				}
				
				if($debug) echo "vor: 1: ".$grid[0]['driver']['lastname']." 2: ".$grid[1]['driver']['lastname']." 3: ".$grid[2]['driver']['lastname']." 4: ".$grid[3]['driver']['lastname']."<br>";
                
                usort($grid, function($a, $b) {
                	$a_out = $a['out'];
                	$b_out = $b['out'];
                	
                	if($a_out == $b_out)
                	{
                		$a = floatval($a['round_time']);
						$b = floatval($b['round_time']);
	                	if($a == $b)
	                	{
	                		$a_fastest = floatval($a['fastest_time']);
	                		$b_fastest = floatval($b['fastest_time']);
	                		if($a_fastest == $b_fastest)
	                			return 0;
	                		return $a_fastest < $b_fastest ? -1 : 1;
	                	}
					    return ($a < $b) ? -1 : 1;
				    }
				    else
				    {
					    if($a_out == 0)
					    	return 1;
					    else
					    	return -1;
				    }
				});
				
				if($debug) echo "nach: 1: ".$grid[0]['driver']['lastname']." 2: ".$grid[1]['driver']['lastname']." 3: ".$grid[2]['driver']['lastname']." 4: ".$grid[3]['driver']['lastname']."<br>";
            }//for
            
            //store computed race to database
            $array_size = count($grid);
            for($i = 0; $i < $array_size; ++$i)
            {
                //store to db
                $this->db->insertSetup($grid[$i]['car_number'], $grid[$i]['tea_id'], null, $ins_id, $league, $grid[$i]['settings'], $grid[$i]['tire_type'], $grid[$i]['round_data'], 2);
            }
        }//compute_rounds_for_race

		/*
		 * get the setup of current round of race. This function also detects pit stops
		 * params: round number, array for settings, instance id
		 * return: array of setting (tire, parts, pit stop,...)
		 */
        private function getCurrentSetup($round, $array, $ins_id)
        {
            $setup = $this->db->getSetupSetting($array['car_number'],$array['tea_id'],$ins_id,2,0);
            $user = $this->db->getUserByTeam($array['tea_id']);
            $array['user'] = $user;
            $pitstop = false;
            $rounds = $setup['rounds'];
            for($i = 1; $i < $this->max_number_pitstop; ++$i)
            {
                if($round > $rounds)
                {
                    $setup = $this->db->getSetupSetting($array['car_number'],$array['tea_id'],$ins_id,2,$i);
                    $rounds+=$setup['rounds'];
                }
                if($i == $this->max_number_pitstop - 1 && $round > $rounds)
                {
                	$array['out'] = 1;
                	$array['out_type'] = 13;	//no fuel
				}
            }
            if($round == $rounds)
            {
                $pitstop = true;
            }

            //driver related info
            if($round == 1)
            {
                $team = $this->db->getTeam($array['tea_id']);            //PERFORMANCE ISSUE
                $driver = $this->db->getDriver($team['driver'.$array['car_number']]);
                $array['driver'] = $driver;
                $array['tir_id'] = $team['tir_id'];

                //get pitstop time from mechanics
                $mechanics_old = $this->db->getMechanicsOfTeam($array['tea_id']);
                $return = get_mechanic_values($mechanics_old);

                $array['mechanic_pitstop'] = (compute_pitstop_time($return[1] * 0.01) / 60) /60;
                $array['mechanic_setup'] = compute_setup_bonus($return[2]);
                $array['mechanic_tires'] = compute_tire_bonus($return[3]);
                $array['mechanic_repair'] = compute_repair_bonus($return[4]);
            }

            //setting related info
            $array['front_wing'] = $setup['front_wing'];
            $array['rear_wing'] = $setup['rear_wing'];
            $array['front_suspension'] = $setup['front_suspension'];
            $array['rear_suspension'] = $setup['rear_suspension'];
            $array['tire_pressure'] = $setup['tire_pressure'];
            $array['brake_balance'] = $setup['brake_balance'];
            $array['gear_ratio'] = $setup['gear_ratio'];
            //engine power values
            $array['power1'] = $setup['power1'];
            $array['power2'] = $setup['power2'];
            $array['power3'] = $setup['power3'];
            $array['power4'] = $setup['power4'];
            $array['power5'] = $setup['power5'];
            $array['power6'] = $setup['power6'];
            $array['tire_type'] = $setup['tire_type'];
            $array['current_round_of_setup'] = $round - ($rounds - $setup['rounds']);	//the current number of rounds after last pit stop
            $array['pitstop'] = false;
            $array['race_tire_id'] = $setup['race_tire_id'];

            //detect pit stop
            if($round > 0)
            {
                $array['pitstop'] = $pitstop;
            }

            return $array;
        }//getCurrentSetup

		/*
         * computes one qualifying session based on the given settings
         * params: array of settings, track information, global params, rain flag, number of session, number of current league
         * return: nothing - solution is stored in db
         */
        private function compute_rounds_for_settings($setup_settings, $track, $params, $session, $league)
        {
            //compute rounds for all these settings
            foreach($setup_settings as $setting)
            {
                $team = $this->db->getTeam($setting['tea_id']);            //PERFORMANCE ISSUE
                $user = $this->db->getUserByTeam($setting['tea_id']);
                $driver = $this->db->getDriver($team['driver'.$setting['car_number']]);

				//compute disqualification
				$disqualified = false;
				if($params['qualification_diff_tires'] == 1)
				{
					$hard = 0;
				    $soft = 0;
				    
				    $setups = $this->db->getSetupSettingAll($setting['car_number'], $setting['tea_id'], $setting['ins_id'], 1, -1);
				    
				    if(isset($setups))
					    foreach($setups as $setup)
					    {
						    if($setup['tire_type'] == 0)
						    	$hard++;
						    if($setup['tire_type'] == 1)
						    	$soft++;
					    }
				    if($hard == 0 || $soft == 0)
				    	$disqualified = true;
			    }

                $car_old = $this->db->getItemsFromCar($setting['tea_id'],$setting['car_number']);
                $car = array();
                foreach($car_old as $c)
                {
                    $item = $this->db->getItem($c['ite_id']);
                    $c['name'] = $item['name'];
                    //Formular for car values:
                    //skill + (skill_max - skill) * tuneup in %
                    $c['value'] = $item['skill'] + (($item['skill_max'] - $item['skill']) * ($c['tuneup'] * 0.01));
                    //car part value changes by condition
	                $c['value'] *= $c['condition'] * 0.01;
                    $c['type'] = $item['type'];
                    $car[] = $c;
                }

                $mechanics_old = $this->db->getMechanicsOfTeam($setting['tea_id']);     //PERFORMANCE ISSUE
                $return = get_mechanic_values($mechanics_old);
                $setup = $return[2];
                $tires = $return[3];
                $setup = number_format_Tablerow(compute_setup_bonus($setup),1);
                $tires = number_format_Tablerow(compute_tire_bonus($tires),1);

                $settings = array(
                    'front_wing' => $setting['front_wing'],
                    'rear_wing' => $setting['rear_wing'],
                    'front_suspension' => $setting['front_suspension'],
                    'rear_suspension' => $setting['rear_suspension'],
                    'tire_pressure' => $setting['tire_pressure'],
                    'brake_balance' => $setting['brake_balance'],
                    'gear_ratio' => $setting['gear_ratio']
                );
                $rounds = $setting['rounds'];
                //$tire_type = $setting['tire_type'];
                $mechanic = array('setup' => $setup, 'tires' => $tires);

                //tires
                $tire = $this->db->getRaceTire($setting['race_tire_id']);
                $tire_type = $tire['tire_type'];

                $round_data = array();
                $fastest_time = 99999999.999;
                $fastest_time_string = '';
                for($i = 0; $i < $params['qualification_max_rounds']/*$rounds*/; ++$i)
                {
                    if(count($car)<10)
                    {
                        //echo "skip team: ".$team['name']."<br>";            //######not a good solution
                        continue;
                    }
                    //if driver drive rounds
                    if($rounds < $i + 1)
                    {
	                    $data = array($i+1, 99999999.999, '');
                    }
                    else
                    {
	                    if($disqualified)
	                    	$data = array($i+1, $fastest_time, $fastest_time_string);
	                    else
	                    	$data = compute_training($user, $settings, $driver, $car, $tire, $mechanic, $track, $i+1, $params, $i);
                    }
                    //$this->computeFailure($car, $driver, $params);
                    if($data[1] < $fastest_time)
                    {
                        $fastest_time = $data[1];
                        $fastest_time_string = $data[2];
                    }
                    $data[3] = $data[2];
                    $data[4] = $fastest_time;
                    $data[5] = $fastest_time_string;
                    $data[6] = 0;	//pitstop
                    $data[7] = 0;	//disqualified
                    $data[8] = 0;	//reason
                    $data[9] = $tire_type;
                    $data[10] = 0;
                    $round_data[] = $data;
                }
                //save new distance for tire (and active flag)
                $this->db->setRaceTireDistance($tire['id'], $tire['distance']);

                //store to db
                $this->db->insertSetup($setting['car_number'], $setting['tea_id'], null, $setting['ins_id'], $league, $settings, $tire_type, $round_data, 1, $session);
            }
        }//compute_rounds_for_settings

		/*
         * creates new mechanics for instances, which have less or no free mechanics
         */
        public function create_new_mechanics()
        {
        	$countries = $this->db->getCountries();
			$maxCountries = 0;
	
			foreach($countries as $c)
			{
				$maxCountries+= $c['relevance'];
			}
        	
            //if there are too less mechanics for an instance available
            $instances = $this->db->getInstances();
            foreach($instances as $instance)
            {
                $count = $this->db->countFreeMechanics($instance['id']);
                if($count < $this->min_mechanics)
                {
                    //echo "create ".$this->create_mechanics." new mechanics for instance ".$instance['id']."\n";
                    for($i = 0; $i < $this->create_mechanics; ++$i)
                    {
                    	//mechanic country
						$country_relevance = rand(1,$maxCountries);
						$country = null;
						foreach($countries as $c)
						{
							$country_relevance-= $c['relevance'];
							if($country_relevance <= 0)
							{
								$country = $c;
								break;
							}
						}
                    	$rand_gender = rand(0,9);	//0..female, other..male
						$firstnames = $this->db->getFirstnames($country['language'], $rand_gender);
						$lastnames = $this->db->getLastnames($country['language']);
                    	
                        $firstname = $firstnames[rand(0, count($firstnames) - 1)]['name'];
                        $lastname = $lastnames[rand(0, count($lastnames) - 1)]['name'];

                        $pitstop = rand(0, 100);
                        $development = rand(0, 100);
                        $morale = 90;
                        $tires = rand(0, 100);
                        $setup = rand(0, 100);
                        $repair = rand(0, 100);

                        $value = ($pitstop + $development + $morale + $tires + $setup + $repair) / 6;
                        $wage = $this->getWage($value);
                        $bonus = $this->getBonus($value);

                        if($this->db->insertMechanic($firstname, $lastname, $pitstop, $development, $morale, $tires, $setup, $repair, $wage, $bonus, $instance['id']) != 1)
                            echo "error could not create mechanic for instance ".$instance['id']."\n";
                    }//for
                }//if
            }//foreach
        }//create_new_mechanics
        
        /*
         * this function returns mechanic wage based on its average strength
         * all values are from sql/set_mechanic_wage_bonus.sql
         */
        private function getWage($val)
        {
        	if($val > 94) return 312500;
        	if($val > 89) return 281250;
        	if($val > 84) return 250000;
        	if($val > 79) return 218750;
        	if($val > 74) return 187500;
        	if($val > 69) return 156250;
        	if($val > 64) return 125000;
        	if($val > 59) return 93750;
        	if($val > 54) return 62500;
        	if($val > 49) return 31250;
        	return 0;
        }//getWage
        
        /*
         * this function returns mechanic bonus based on its average strength
         * all values are from sql/set_mechanic_wage_bonus.sql
         */
        private function getBonus($val)
        {
        	if($val > 94) return 3000;
        	if($val > 89) return 2700;
        	if($val > 84) return 2400;
        	if($val > 79) return 2100;
        	if($val > 74) return 1800;
        	if($val > 69) return 1500;
        	if($val > 64) return 1200;
        	if($val > 59) return 900;
        	if($val > 54) return 600;
        	if($val > 49) return 300;
        	return 0;
        }//getBonus
        
        /*
         * changes values of all free mechanics
         */
        public function change_mechanic_values($ins_id)
        {
			//get all free mechanics
			$mechanics_old = $this->db->getFreeMechanics('id asc');
			
			//and change values for all of them
			foreach($mechanics_old as $mechanic)
			{
				$pitstop = rand(0, 100);
				$development = rand(0, 100);
				$morale = rand(0, 100);
				$tires = rand(0, 100);
				$setup = rand(0, 100);
				$repair = rand(0, 100);
				
				$value = ($pitstop + $development + $morale + $tires + $setup + $repair) / 6;
				$wage = $this->getWage($value);
				$bonus = $this->getBonus($value);
				
				$this->db->updateMechanic($mechanic['id'], $pitstop, $development, $morale, $tires, $setup, $repair, $wage, $bonus, $ins_id);
			}
        }//update_mechanic_values

		/*
         * computes the training of drivers
         * this is fix for no training or based on training setting of day
         */
        public function compute_training($ins_id)
        {
            $dri_tra = $this->db->getDriTras();
            
            //anti training...if player did not set training --> driver looses skill
            for($i = 0; $i < 7 - count($dri_tra); ++$i)
            {	
				$drivers = $this->db->getDrivers($ins_id, '', 'id');
				foreach($drivers as $driver)
				{
					//ai teams do not need training
					if($driver['ai_tea_id'] == null)
					{
						$dri_tra = $this->db->getDriTras($driver['id']);
						//this driver has no training --> loose points
						if($dri_tra == null)
						{
							$rnd = rand(0, 11);
							if($rnd == 0)
							{
								$driver['speed']-=1;
								if($driver['speed'] < 0) $driver['speed'] = 0;
							}
							$rnd = rand(0, 11);
							if($rnd == 0)
							{
								$driver['persistence']-=1;
								if($driver['persistence'] < 0) $driver['persistence'] = 0;
							}
							/*$rnd = rand(0, 11);
							if($rnd == 0)
							{
								$driver['experience']-=1;
								if($driver['experience'] < 0) $driver['experience'] = 0;
							}*/
							$rnd = rand(0, 6);
							if($rnd == 0)
							{
								$driver['stamina']-= 1;
								if($driver['stamina'] < 0) $driver['stamina'] = 0;
							}
							$rnd = rand(0, 6);
							if($rnd == 0)
							{
								$driver['freshness']-= 1;
								if($driver['freshness'] < 0) $driver['freshness'] = 0;
							}
							$rnd = rand(0, 6);
							if($rnd == 0)
							{
								$driver['morale']+=1;
								if($driver['morale'] > 100) $driver['morale'] = 100;
							}
							$this->db->updateDriverSkills($driver);
						}//if
					}//if
				}//foreach
        	}//for
        
            $driver = null;
            //loop through all training settings for drivers
            foreach($dri_tra as $obj)
            {
                //get the driver for the record (only once for each new driver)
                if($driver == null || $driver['id'] != $obj['dri_id'])
                {
                    //save new values to driver
                    if($driver != null)
                        $this->db->updateDriverSkills($driver);
                    $driver = $this->db->getDriver($obj['dri_id']);
		    //only for this instance
                    if($driver['ins_id'] != $ins_id)
                    	$driver = null;
                }
                
                //if this happens --> delete training for non existing drivers
                //###
                if(!$driver)
                    continue;
                
                //doubled bad things for weekend
                $factor = -1;
                if($obj['day'] >= 5)
                	$factor = -2;

                //change driver values
                $rnd = rand(1, 100);
                if($rnd <= abs($obj['speed']) && $obj['speed'] != 0)
                {
                    $driver['speed']+=($obj['speed']>0)?1:$factor;
                    if($driver['speed'] > 100) $driver['speed'] = 100;
                    if($driver['speed'] < 0) $driver['speed'] = 0;
                }
                $rnd = rand(1, 100);
                if($rnd <= abs($obj['persistence']) && $obj['persistence'] != 0)
                {
                    $driver['persistence']+=($obj['persistence']>0)?1:$factor;
                    if($driver['persistence'] > 100) $driver['persistence'] = 100;
                    if($driver['persistence'] < 0) $driver['persistence'] = 0;
                }
                $rnd = rand(1, 100);
                if($rnd <= abs($obj['experience']) && $obj['experience'] != 0)
                {
                    $driver['experience']+=($obj['experience']>0)?1:$factor;
                    if($driver['experience'] > 100) $driver['experience'] = 100;
                    if($driver['experience'] < 0) $driver['experience'] = 0;
                }
                $rnd = rand(1, 100);
                if($rnd <= abs($obj['stamina']) && $obj['stamina'] != 0)
                {
                    $driver['stamina']+=($obj['stamina']>0)?1:$factor;
                    if($driver['stamina'] > 100) $driver['stamina'] = 100;
                    if($driver['stamina'] < 0) $driver['stamina'] = 0;
                }
                $rnd = rand(1, 100);
                if($rnd <= abs($obj['freshness']) && $obj['freshness'] != 0)
                {
                    $driver['freshness']+=($obj['freshness']>0)?1:$factor;
                    if($driver['freshness'] > 100) $driver['freshness'] = 100;
                    if($driver['freshness'] < 0) $driver['freshness'] = 0;
                }
                $rnd = rand(1, 100);
                if($rnd <= abs($obj['morale']) && $obj['morale'] != 0)
                {
                    $driver['morale']+=($obj['morale']>0)?1:$factor;
                    if($driver['morale'] > 100) $driver['morale'] = 100;
                    if($driver['morale'] < 0) $driver['morale'] = 0;
                }

                //finance
                if($obj['cost'] > 0)
	                $this->db->buyTraining($driver, $obj['cost']);
            }//foreach
            
            //save new values to driver
            if($driver != null)
                $this->db->updateDriverSkills($driver);
        }//compute_training
        
        /*
         * used to detect a failure and also kind of failure (based on driver or car)
         * param: car array, driver array, global params
         * return: array with 0 - no failure, 1 - failure and failure type number
         */
        private function computeFailure($car, $driver, $params, $round, $repair, $tire, $weather)
		{
			//the more rain the more crashes!
			$weather_factor = 1;
			if($weather < 31)
				$weather_factor = 1.5;
			if($weather < 20)
				$weather_factor = 2;
			if($weather < 10)
				$weather_factor = 3;
			
			//driver failure?
			$rnd = rand(1, 10000);
			if($rnd < $params['drop_out'] * $weather_factor)
			{
				$rnd = rand(1, 600);
				if($rnd > (400 + (($driver['persistence'] + $driver['experience'] + $driver['morale']) / 3)))
				{
					if(rand(0,9) < 2)
					{
						return array($round, 10);		//driver fault
					}
					else
					{
						//start a safety car phase
	                	if(rand(0,2) == 0 && $this->safety_car_flag == false)
	                	{
	                		$this->safety_car_flag = true;
	                		$this->safety_car_round_max = rand(3,5);	//how long should it last
	                	}
						return array($round, 12);		//crash
					}
				}
			}
		
			//change parts/compute defect
			foreach($car as $c)
			{
			    $rnd = rand(1, 170);
			    if($rnd > (($driver['persistence'] + $driver['experience'] + $driver['morale']) / 3))
			    {
			    	$rnd = rand(1, 180);
			    	if($rnd > (170 - $c['tuneup']))			//changed 16.10.2015 for less repair costs from 150 to 170
			    	{
			        	$c['condition']-= 1;
			        	if($c['condition'] < 0)
			        	{
			        		$c['condition'] = 0;
			        		return array($round, $c['type']);
			        	}
			        	else
			        	{
			        		$rnd = rand(1, 100);
			        		if($rnd > $repair)
			        		{
			        			$this->db->changeTeaIteCondition($c['id'], $c['condition']);
			        		}
			        	}
			        }
			    }
			}
			
			//tire failure
			$condition = explode(",",$params['tire_condition']);
			$distance = intval($tire['distance'] * 0.001);
			
			//orange
			if($distance > $condition[count($condition) - 2] && $distance < $condition[count($condition) - 1])
				if(rand(1, 250) == 1)
					return array($round, 14);
			//red
			if($distance > $condition[count($condition) - 1])
				if(rand(1, 35) == 1)
					return array($round, 14);
			
			return array(0, 0);
		}//computeFailure
		
		/*
		 * gets a string of given failure type and round of failure
		 * param: type of failure
		 * return: failure as String
		 */
		private function getReasonOfStop($type, $x)
		{	
			$str = "";
			switch($type)
			{
				case 0: $str = 'Broken vehicle body'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 1:	$str = 'Brake failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 2: $str = 'Engine failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 3: $str = 'Aerodynamics failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 4: $str = 'Electrical failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 5: $str = 'Broken suspension'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 6: $str = 'Transmission damage'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 7: $str = 'Hydraulic failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 8: $str = 'Kers failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 9: $str = 'DRS failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 10: $str = 'Driver failure'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 11: $str = 'Disqualification'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 12: $str = 'Crash'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 13: $str = 'No fuel'; if($x > 0) $str.= " (Lap ".$x.")"; break;
				case 14: $str = 'Puncture'; if($x > 0) $str.= " (Lap ".$x.")"; break;
			}
			return $str;
		}//getReasonOfStop
    }
