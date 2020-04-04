<?php
    class F1Database{
        private $con;
      
        function __construct($server, $database, $password, $user, $port)
        {
            $this->con = new PDO("mysql:host=$server;dbname=$database", $user, $password, array(
			  PDO::ATTR_PERSISTENT => true
			));
            $this->con->exec("SET CHARACTER SET utf8");
        }
        
        //user
        public function checkLogin($email, $password)
        {
            try{
                $sql = "SELECT * FROM user WHERE email = :email AND password = :password";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('email', $email);
                $ps->bindValue('password', md5($password));
                $ps->execute();
                $row = $ps->fetchAll();
                if(count($row) > 0)
                {
                	return $row[0];
                }
                else
                {
                	$sql = "SELECT * FROM user WHERE name = :name AND password = :password";
					$ps = $this->con->prepare($sql);
					$ps->bindValue('name', $email);
					$ps->bindValue('password', md5($password));
					$ps->execute();
					$row = $ps->fetchAll();
					if(count($row) > 0)
					{
						return $row[0];
					}
					else
						return null;
                }
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function checkUsernameDuplicate($username)
        {
	        try{
                $sql = "SELECT * FROM user WHERE name = :name";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('name', $username);
                $ps->execute();
                $row = $ps->fetchAll();
                if(count($row) > 0)
                {
                	return false;
                }
                else
                {
	                return true;
                }
			}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function checkEmailDuplicate($email)
        {
	        try{
                $sql = "SELECT * FROM user WHERE email = :email";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('email', $email);
                $ps->execute();
                $row = $ps->fetchAll();
                if(count($row) > 0)
                {
                	return false;
                }
                else
                {
	                return true;
                }
			}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getUser($id)
        {
            try{
                $sql = "SELECT * FROM user WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getUserByEmail($email)
        {
        	try{
                $sql = "SELECT * FROM user WHERE email = :email";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('email', $email);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteUser($user)
        {
        	try{
        		//drivers of team get ai drivers
        		$sql = "UPDATE driver SET ai_tea_id = :tea_id, tea_id = NULL WHERE tea_id = :tea_id";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $user['tea_id']);
                $ps->execute();
        		
        		//delete user entry
                $sql = "DELETE FROM user WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $user['id']);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getUserByTeam($tea_id)
        {
	        try{
                $sql = "SELECT * FROM user WHERE tea_id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function removeUserFromTeam($id)
        {
        	try{
        		$sql = "UPDATE user SET ins_id = NULL, tea_id = NULL WHERE id = :id";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
        		if($db_debug) {echo $e; die();}
                return array();
        	}
        }
        public function getUsers($ins_id, $order = 'name ASC')
        {
            try{
                $sql = "SELECT * FROM user WHERE ins_id = :ins_id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getCountUsers($ins_id = 0)
        {
            try{
            	if($ins_id == 0)
            		$sql = "SELECT COUNT(*) as count FROM user";
            	else
                	$sql = "SELECT COUNT(*) as count FROM user WHERE ins_id = :ins_id";
                $ps = $this->con->prepare($sql);
                if($ins_id > 0)
                	$ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['count'];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function setUserRefreshtime($id, $refreshtime)
        {
	        try{
                $sql = "UPDATE user SET refreshtime = :refreshtime WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('refreshtime', $refreshtime);
                $ps->bindValue('id', $id);
                return $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return false;
            }
        }
        public function setUserLanguage($id, $language)
        {
	        try{
                $sql = "UPDATE user SET language = :language WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('language', $language);
                $ps->bindValue('id', $id);
                return $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return false;
            }
        }
        public function saveUserHistory($id, $ins_id, $date)
        {
	        try{
                //compute rank
                $sql = "SELECT * FROM user WHERE ins_id = :ins_id ORDER BY points DESC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $user = null;
                $i = 1;
                $rank = -1;
                foreach($rows as $row)
                {
                	if($row['id'] == $id)
                	{
                		$user = $row;
                		break;
                	}
                	$i++;
                }
                $rank = $i;
                
                //is there already an entry for that day?
                $sql = "SELECT * FROM user_history WHERE use_id = :id AND date = :date";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('date', $date);
                $ps->execute();
                $rows = $ps->fetchAll();
                //yes make update
                if(count($rows) > 0)
                {
	                /*$sql = "UPDATE user_history SET points = :points WHERE id = :id";
	                $ps = $this->con->prepare($sql);
	                $ps->bindValue('points', $user['points']);
	                $ps->bindValue('id', $user[0]['id']);
	                $ps->execute();*/
	                return 1;
                }
                //no make insert
                else{
	                $sql = "INSERT INTO user_history (use_id, date, points, ranking) VALUES (:use_id, :date, :points, :ranking)";
	                $ps = $this->con->prepare($sql);
	                $ps->bindValue('ranking', $rank);
	                $ps->bindValue('points', $user['points']);
	                $ps->bindValue('date', $date);
	                $ps->bindValue('use_id', $user['id']);
	                $ps->execute();
	                return 1;
                }
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function addUserPoints($id, $points)
        {
	        try{
                $sql = "UPDATE user SET points = points + :points WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('points', $points);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function checkEmail($email)
        {
            try{
                $sql = "SELECT id FROM user WHERE email = :email";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('email', $email);
                $ps->execute();
                $row = $ps->fetchAll();
                return count($row);
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function changePassword($email, $password)
        {
            try{
                $sql = "UPDATE user SET password = :password WHERE email = :email";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('email', $email);
                $ps->bindValue('password', md5($password));
                return $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return false;
            }
        }
        public function updateLoginTime($id)
        {
            try{
                $sql = "UPDATE user SET last_last_login = last_login WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();

                $sql = "UPDATE user SET last_login = NOW() WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function createAccount($email, $password, $username, $id_code, $phpbb_user_id)
        {
            try{
                //check if email is unique
                $sql = "SELECT * FROM user WHERE email = :email";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('email', $email);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows)>0)
                {
                    return -2;  //email not unique
                }
                else
                {
                    $sql = "INSERT INTO user (active, email, password, name, id_code, front_wing, rear_wing, front_suspension, rear_suspension, tire_pressure, brake_balance, gear_ratio, phpbb_user_id) VALUES (1, :email, :password, :username, :id_code, :front_wing, :rear_wing, :front_suspension, :rear_suspension, :tire_pressure, :brake_balance, :gear_ratio, :phpbb_user_id)";
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('email', $email);
                    $ps->bindValue('password', md5($password));
                    $ps->bindValue('username', $username);
                    $ps->bindValue('id_code', $id_code);
                    $ps->bindValue('phpbb_user_id', $phpbb_user_id);
                    $ps->bindValue('front_wing', rand(0,90));
                    $ps->bindValue('rear_wing', rand(0,90));
                    $ps->bindValue('front_suspension', rand(0,100));
                    $ps->bindValue('rear_suspension', rand(0,100));
                    $ps->bindValue('tire_pressure', rand(0,100));
                    $ps->bindValue('brake_balance', rand(0,100));
                    $ps->bindValue('gear_ratio', rand(0,100));
                    $ps->execute();
                    return 0;
                }
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;  //insert failed
            }
        }
        public function randomizeUserTrackSettings($id)
        {
        	try{
        		$sql = "UPDATE user SET front_wing = :front_wing, rear_wing = :rear_wing, front_suspension = :front_suspension, rear_suspension = :rear_suspension, tire_pressure = :tire_pressure, brake_balance = :brake_balance, gear_ratio = :gear_ratio WHERE id = :id";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('id', $id);
        		$ps->bindValue('front_wing', rand(0,90));
				$ps->bindValue('rear_wing', rand(0,90));
				$ps->bindValue('front_suspension', rand(0,100));
				$ps->bindValue('rear_suspension', rand(0,100));
				$ps->bindValue('tire_pressure', rand(0,100));
				$ps->bindValue('brake_balance', rand(0,100));
				$ps->bindValue('gear_ratio', rand(0,100));
				$ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;  //insert failed
            }
        }
        public function updatePassword($user_id, $password)
        {
        	try{
        		$sql = "UPDATE user SET password = :password WHERE id = :id";
				$ps = $this->con->prepare($sql);
				$ps->bindValue('id', $user_id);
				$ps->bindValue('password', md5($password));
				$ps->execute();
				return 0;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;  //insert failed
            }
        }
        public function activateAccount($id_code)
        {
	        try{
		        $sql = "SELECT * FROM user WHERE id_code = :id_code";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id_code', $id_code);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
				{
					$sql = "UPDATE user SET active = 1 WHERE id_code = :id_code";
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('id_code', $id_code);
                    $ps->execute();
                    return true;
				}
				else
				{
					return false;
				}
	        }catch(Exception $e)
	        {
		        if($db_debug) {echo $e; die();}
		        return false;
	        }
        }
        public function setInstanceRace($id, $data)
        {
        	try{
                $sql = "UPDATE instance SET last_race = :last_race WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('last_race', $data);
                $ps->bindValue('id', $id);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
		}
		public function getInstanceRace($id)
        {
        	try{
                $sql = "SELECT last_race FROM instance WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $row = $ps->fetchAll();
                return $row[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
		}
		public function updateInstanceToNextRace($id)
		{
			try{
                $sql = "UPDATE instance SET last_race = null, last_qualification = null, current_race = current_race + 1 WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                
                $sql = "TRUNCATE setup; ALTER TABLE setup AUTO_INCREMENT = 1; TRUNCATE setup_setting; ALTER TABLE setup_setting AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
		}
		public function setInstanceQualification($id, $data)
        {
        	try{
                $sql = "UPDATE instance SET last_qualification = :last_qualification WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('last_qualification', $data);
                $ps->bindValue('id', $id);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
		}
		public function getInstanceQualification($id)
        {
        	try{
                $sql = "SELECT last_qualification FROM instance WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $row = $ps->fetchAll();
                return $row[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
		}
        public function setInstanceAndTeam($ins_id, $tea_id, $id)
        {
            try{
                $sql = "UPDATE user SET ins_id = :ins_id, tea_id = :tea_id WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('id', $id);
                $ps->execute();

                //now return User Data
                $sql = "SELECT * FROM user WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $row = $ps->fetchAll();
                return $row[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function setInstanceAndTeamAcknowledged($ins_id, $tea_id, $id)
        {
            try{
                $sql = "UPDATE user SET ins_id = :ins_id, tea_id = :tea_id, tea_id_ok = 1 WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('id', $id);
                $ps->execute();
                
                //update driver if there were ai drivers of former humen drivers for that team
                $sql = "UPDATE driver SET ai_tea_id = NULL WHERE ai_tea_id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $sql = "UPDATE driver SET tea_id = NULL WHERE tea_id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $sql = "UPDATE team SET driver1 = NULL, driver2 = NULL, driver3 = NULL WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                
                //remove item parts from car
                $sql = "DELETE FROM tea_ite WHERE tea_id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();

                //now return User Data
                $sql = "SELECT * FROM user WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $row = $ps->fetchAll();
                return $row[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //instance
        public function getInstance($id)
        {
            try{
                $sql = "SELECT * FROM instance WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getInstances()
        {
            try{
                $sql = "SELECT * FROM instance";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getVisibleInstances()
        {
            try{
                $sql = "SELECT * FROM instance WHERE visible > 0";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
		public function getPoints($ins_id)
		{
			try{
                //$sql = "SELECT * FROM points where ins_id = :ins_id ORDER BY rank ASC";
                $sql = "SELECT * FROM points ORDER BY rank ASC";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }	
		}
		public function getYouthPoints()
		{
			try{
                $sql = "SELECT * FROM youth_points ORDER BY rank ASC";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }	
		}
		
        //team
        public function getTeam($id)
        {
            try{
                $sql = "SELECT * FROM team WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e;die();}
                return array();
            }
        }
        public function getTeamsWithoutCarDesign()
        {
        	 try{
                $sql = "SELECT * FROM team WHERE car_design is null";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows;
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeamByName($name, $ins_id)
        {
            try{
                $sql = "SELECT * FROM team WHERE name LIKE :name AND ins_id = :ins_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('name', $name);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getManagedTeams($ins_id)
        {
            try{
                //$sql = "SELECT * FROM team WHERE ins_id = :ins_id and id not in (select tea_id from user where ins_id = team.ins_id)";
                $sql = "SELECT * FROM team t WHERE t.ins_id = :ins_id AND EXISTS (SELECT 1 FROM user u WHERE u.tea_id = t.id)";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getFreeTeams($ins_id)
        {
            try{
                //$sql = "SELECT * FROM team WHERE ins_id = :ins_id and id not in (select tea_id from user where ins_id = team.ins_id)";
                $sql = "SELECT * FROM team t WHERE t.ins_id = :ins_id AND NOT EXISTS (SELECT 1 FROM user u WHERE u.tea_id = t.id)";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeams($ins_id, $order = '')
        {
            try{
                $sql = "SELECT * FROM team WHERE ins_id = :ins_id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeamsOfLeague($ins_id, $league, $order = '')
        {
            try{
                $sql = "SELECT * FROM team WHERE ins_id = :ins_id and league = :league ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('league', $league);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateTeamCarDesign($id, $design)
        {
        	try{
                $sql = "UPDATE team SET car_design = :car_design WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('car_design', $design);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateTeamLeague($id, $league)
        {
        	try{
                $sql = "UPDATE team SET league = :league WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('league', $league);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateTeamClass($id, $class)
        {
        	try{
                $sql = "UPDATE team SET class = :class WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('class', $class);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function saveTeamHistory($id, $league, $ins_id, $date)
        {
	        try{
                //get team
                $sql = "SELECT * FROM team WHERE ins_id = :ins_id AND league = :league ORDER BY points DESC, placement DESC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('league', $league);
                $ps->execute();
                $rows = $ps->fetchAll();
                
                $team = null;
                $rank = -1;
                $i = 1;
                foreach($rows as $row)
                {
                	if($row['id'] == $id)
                	{
                		$team = $row;
                		break;
                	}
                	$i++;
                }
                $rank = $i;
                
                //is there already an entry for that day?
                $sql = "SELECT * FROM team_history WHERE tea_id = :id AND date = :date";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('date', $date);
                $ps->execute();
                $rows = $ps->fetchAll();
                //yes make update
                if(count($rows) > 0)
                {
	                /*$sql = "UPDATE team_history SET points = :points, value = :value WHERE id = :id";
	                $ps = $this->con->prepare($sql);
	                $ps->bindValue('points', $team['points']);
	                $ps->bindValue('value', $team['value']);
	                $ps->bindValue('id', $rows[0]['id']);
	                $ps->execute();*/
	                return 1;
                }
                //no make insert
                else{
	                $sql = "INSERT INTO team_history (tea_id, date, points, value, ranking) VALUES (:tea_id, :date, :points, :value, :ranking)";
	                $ps = $this->con->prepare($sql);
	                $ps->bindValue('ranking', $rank);	
	                $ps->bindValue('points', $team['points']);
	                $ps->bindValue('value', $team['value']);
	                $ps->bindValue('date', $date);
	                $ps->bindValue('tea_id', $team['id']);
	                $ps->execute();
	                return 1;
                } 
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function addTeamPoints($id, $points)
        {
	        try{
                $sql = "UPDATE team SET points = points + :points WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('points', $points);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function addTeamYouthPoints($id, $points)
        {
	        try{
                $sql = "UPDATE team SET youth_points = youth_points + :points WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('points', $points);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function setTeamDriver($tea_id, $dri_id, $type)
        {
            try{
                //update
                if($type == 1)
                    $sql = "UPDATE team SET driver1 = :dri_id WHERE id = :tea_id";
                if($type == 2)
                    $sql = "UPDATE team SET driver2 = :dri_id WHERE id = :tea_id";
                if($type == 3)
                    $sql = "UPDATE team SET driver3 = :dri_id WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                
                if($type == 1)
                {
                    $sql = "UPDATE team SET driver2 = null WHERE driver2 = :dri_id AND id = :tea_id;";
                    $sql.= "UPDATE team SET driver3 = null WHERE driver3 = :dri_id AND id = :tea_id;";
                }
                if($type == 2)
                {
                    $sql = "UPDATE team SET driver1 = null WHERE driver1 = :dri_id AND id = :tea_id;";
                    $sql.= "UPDATE team SET driver3 = null WHERE driver3 = :dri_id AND id = :tea_id;";
                }
                if($type == 3)
                {
                    $sql = "UPDATE team SET driver1 = null WHERE driver1 = :dri_id AND id = :tea_id;";
                    $sql.= "UPDATE team SET driver2 = null WHERE driver2 = :dri_id AND id = :tea_id;";
                }
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function changeTeamValue($tea_id, $value)
        {
            try{
                $sql = "UPDATE team SET value = value + :wage WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $value);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function addTeamWinner($id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE team SET f1_wins = f1_wins + 1 WHERE id = :id"; break;
        			case 1: $sql = "UPDATE team SET f2_wins = f2_wins + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE team SET f3_wins = f3_wins + 1 WHERE id = :id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addTeamPodium($id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE team SET f1_podium = f1_podium + 1 WHERE id = :id"; break;
        			case 1: $sql = "UPDATE team SET f2_podium = f2_podium + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE team SET f3_podium = f3_podium + 1 WHERE id = :id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addTeamOut($id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE team SET f1_out = f1_out + 1 WHERE id = :id"; break;
        			case 1: $sql = "UPDATE team SET f2_out = f2_out + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE team SET f3_out = f3_out + 1 WHERE id = :id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addTeamGp($id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE team SET f1_gps = f1_gps + 1 WHERE id = :id"; break;
        			case 1: $sql = "UPDATE team SET f2_gps = f2_gps + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE team SET f3_gps = f3_gps + 1 WHERE id = :id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addTeamPole($id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE team SET f1_pole = f1_pole + 1 WHERE id = :id"; break;
        			case 1: $sql = "UPDATE team SET f2_pole = f2_pole + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE team SET f3_pole = f3_pole + 1 WHERE id = :id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        //mechanic
        public function getCountMechanicsOfTeam($tea_id)
        {
            try{
                $sql = "SELECT COUNT(*) FROM mechanic WHERE tea_id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getMechanic($id)
        {
        	try{
                $sql = "SELECT * FROM mechanic WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
		}
        public function getMechanicsOfTeam($tea_id, $order = 'id asc')
        {
            try{
                $sql = "SELECT * FROM mechanic WHERE tea_id = :tea_id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateMechanicMorale($id, $morale)
        {
        	try{
                $sql = "UPDATE mechanic SET morale = :morale WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('morale', $morale);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getFreeMechanics($order = '')
        {
            try{
                //$sql = "SELECT * FROM mechanic WHERE ins_id = :ins_id AND tea_id is null AND wage < :budget ORDER BY ".$order;
                $sql = "SELECT * FROM mechanic WHERE tea_id is null ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function buyMechanic($id, $tea_id)
        {
            try{
                //get wage from driver
                $sql = "SELECT wage FROM mechanic WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 1, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 1, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." buys mechanic ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $row['wage']);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['wage'] * -1);

                //set new team
                $sql = "UPDATE mechanic SET tea_id = :tea_id WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function payMechanicBonus($id, $tea_id, $points)
        {
            try{
                //get bonus from mechanic
                //$sql = "SELECT bonus, ins_id FROM mechanic WHERE id = :id";
                $sql = "SELECT bonus FROM mechanic WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 11, 0, :bonus, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 11, 0, :bonus, NOW(), :label)";
                $label = "team ".$tea_id." pays mechanic ".$id." bonus for ".$points." points";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('bonus', $row['bonus'] * $points);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['bonus'] * $points * -1);
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function changeMechanicJob($id, $job)
        {
            try{
                $sql = "UPDATE mechanic SET job = :job WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('job', $job);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //driver
        public function getCountDriversOfTeam($tea_id)
        {
            try{
                $sql = "SELECT COUNT(*) FROM driver WHERE tea_id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getDriver($id)
        {
            try{
                $sql = "SELECT * FROM driver WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
               		return $rows[0];
               	else
               		return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getDrivers($ins_id, $where = '', $order = '')
        {
            try{
                $sql = "SELECT * FROM driver WHERE ins_id = :ins_id ".$where." ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getAllDrivers($where = "")
        {
            try{
                $sql = "SELECT * FROM driver ";
                if($where != "")
                	$sql.= "WHERE ".$where;
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateDriverMorale($id, $morale)
        {
        	try{
                $sql = "UPDATE driver SET morale = :morale WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('morale', $morale);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateRandomDriverAttributes($id, $firstname, $lastname, $shortname, $gender, $birthday, $country_id, $picture)
        {
        	try{
        		$sql = "UPDATE driver SET firstname = :firstname, lastname = :lastname, shortname = :shortname, gender = :gender, birthday = :birthday, cou_id = :country_id, picture = :picture WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('firstname', $firstname);
                $ps->bindValue('lastname', $lastname);
                $ps->bindValue('shortname', $shortname);
                $ps->bindValue('gender', $gender);
                $ps->bindValue('birthday', $birthday);
                $ps->bindValue('country_id', $country_id);
                $ps->bindValue('picture', $picture);
                $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getDriversOfTeam($tea_id, $order = 'id asc')
        {
            try{
                $sql = "SELECT * FROM driver WHERE tea_id = :tea_id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getAIDriversOfTeam($tea_id, $order = 'id asc')
        {
            try{
                $sql = "SELECT * FROM driver WHERE ai_tea_id = :tea_id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getDriversOfLeague($ins_id, $league, $where = '', $order = '')
        {
        	try{
                $sql = "SELECT d.* FROM driver d, team t WHERE d.ins_id = :ins_id AND t.league = :league AND (t.id = d.tea_id OR t.id = d.ai_tea_id) ".$where." ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('league', $league);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getFreeDrivers($ins_id, $budget, $order = '')
        {
            try{
                //$sql = "SELECT * FROM driver WHERE ins_id = :ins_id AND tea_id is null and wage < :budget ORDER BY '".$order."'";
                $sql = "SELECT * FROM driver WHERE ins_id = :ins_id AND tea_id is null ORDER BY '".$order."'";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                //$ps->bindValue('budget', $budget);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getAIDrivers($ins_id, $order = '')
        {
            try{
                $sql = "SELECT * FROM driver WHERE ins_id = :ins_id AND tea_id is null AND ai_tea_id is not null ORDER BY '".$order."'";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getAIFreeDrivers($ins_id, $budget, $order = '')
        {
            try{
                $sql = "SELECT * FROM driver WHERE ins_id = :ins_id AND tea_id is null AND ai_tea_id is null AND wage < :budget ORDER BY '".$order."'";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('budget', $budget);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function sellDriver($id, $tea_id, $ins_id, $sell_price)
        {
	        try{
		        //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 0, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 0, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." sells driver ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $sell_price);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $sell_price);
                
				$sql = "UPDATE team SET driver1 = null WHERE driver1 = :id";
				$ps = $this->con->prepare($sql);
				$ps->bindValue('id', $id);
				$ps->execute();
				
				$sql = "UPDATE team SET driver2 = null WHERE driver2 = :id";
				$ps = $this->con->prepare($sql);
				$ps->bindValue('id', $id);
				$ps->execute();
				
				//set new team
				$sql = "UPDATE driver SET tea_id = null WHERE id = :id";
				$ps = $this->con->prepare($sql);
				$ps->bindValue('id', $id);
				$ps->execute();

                return 1;
	        }catch(Exception $e){
		        if($db_debug) {echo $e; die();}
                return 0;
	        }
        }
        public function deleteDriver($id)
        {
        	try{
        		$sql = "DELETE FROM driver WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
        		return 1;
        	}catch(Exception $e){
		        if($db_debug) {echo $e; die();}
                return 0;
	        }
        }
        public function buyDriver($id, $tea_id)
        {
            try{
                //get wage from driver
                $sql = "SELECT wage FROM driver WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 0, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 0, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." buys driver ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $row['wage']);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['wage'] * -1);

                //set new team
                $sql = "UPDATE driver SET tea_id = :tea_id, ai_tea_id = null WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function buyAIDriver($id, $tea_id)
        {
            try{
                //set new team
                $sql = "UPDATE driver SET ai_tea_id = :tea_id WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function payDriverBonus($id, $tea_id, $points)
        {
            try{
                //get wage from driver
                $sql = "SELECT bonus FROM driver WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 10, 0, :bonus, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 10, 0, :bonus, NOW(), :label)";
                $label = "team ".$tea_id." pays driver ".$id." bonus for ".$points." points";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('bonus', $row['bonus'] * $points);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['bonus'] * $points * -1);
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function buyYouthDriver($gender, $picture, $birthday, $values, $cou_id, $firstname, $lastname, $shortname, $tea_id, $ins_id)
        {
	        try{
                $sql = "INSERT INTO driver (gender, picture, firstname, lastname, shortname, cou_id, speed, persistence, experience, stamina, freshness, morale, points, ins_id, birthday, wage, bonus, tea_id) VALUES (:gender, :picture, :firstname, :lastname, :shortname, :cou_id, :speed, :persistence, :experience, :stamina, 100, 100, 0, :ins_id, :birthday, 0, 0, :tea_id)";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('gender', $gender);
                $ps->bindValue('picture', $picture);
                $ps->bindValue('firstname', $firstname);
                $ps->bindValue('lastname', $lastname);
                $ps->bindValue('shortname', $shortname);
                $ps->bindValue('cou_id', $cou_id);
                $ps->bindValue('speed', $values['0']);
                $ps->bindValue('persistence', $values['1']);
                $ps->bindValue('experience', $values['2']);
                $ps->bindValue('stamina', $values['3']);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('birthday', $birthday);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $ret = $this->con->lastInsertId();
				
                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 0, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 0, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." buys youthdriver";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', 0);
                $ps->bindValue('label', $label);
                $ps->execute();
                
                //update team youthdriver
                $sql = "UPDATE team SET youthdriver = youthdriver + 1 WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();

                return $ret;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function updateDriverSkills($driver)
        {
            try{
                $sql = "UPDATE driver SET speed = :speed, persistence = :persistence, experience = :experience, stamina = :stamina, freshness = :freshness, morale = :morale WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('speed', $driver['speed']);
                $ps->bindValue('persistence', $driver['persistence']);
                $ps->bindValue('experience', $driver['experience']);
                $ps->bindValue('stamina', $driver['stamina']);
                $ps->bindValue('freshness', $driver['freshness']);
                $ps->bindValue('morale', $driver['morale']);
                $ps->bindValue('id', $driver['id']);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //driverhistory
        public function getDriverHistory($id, $order = 'date DESC', $limit = null)
        {
            try{
            	if($limit != null)
            		$sql = "SELECT * FROM driver_history WHERE dri_id = :id ORDER BY ".$order." LIMIT ".$limit;
            	else
            		$sql = "SELECT * FROM driver_history WHERE dri_id = :id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function saveDriverHistory($id, $league, $ins_id, $date)
        {
	        try{
                //get driver
                $sql = "SELECT d.* FROM driver d, team t WHERE (d.tea_id = t.id OR d.ai_tea_id = t.id) AND t.league = :league AND d.ins_id = :ins_id ORDER BY d.points DESC, d.placement DESC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('league', $league);
                $ps->execute();
                $rows = $ps->fetchAll();
                
                $driver = null;
                $rank = -1;
                $i = 1;
                foreach($rows as $row)
                {
                	if($row['id'] == $id)
                	{
                		$driver = $row;
                		break;
                	}
                	$i++;
                }
                $rank = $i;
                
                //is there already an entry for that day?
                $sql = "SELECT * FROM driver_history WHERE dri_id = :id AND date = :date";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('date', $date);
                $ps->execute();
                $rows = $ps->fetchAll();
                //yes make update
                if(count($rows) > 0)
                {
	                /*$sql = "UPDATE driver_history SET speed = :speed, persistence = :persistence, experience = :experience, stamina = :stamina, freshness = :freshness, morale = :morale, points = :points WHERE id = :id";
	                $ps = $this->con->prepare($sql);
	                $ps->bindValue('speed', $driver['speed']);
	                $ps->bindValue('persistence', $driver['persistence']);
	                $ps->bindValue('experience', $driver['experience']);
	                $ps->bindValue('stamina', $driver['stamina']);
	                $ps->bindValue('freshness', $driver['freshness']);
	                $ps->bindValue('morale', $driver['morale']);
	                $ps->bindValue('points', $driver['points']);
	                $ps->bindValue('id', $rows[0]['id']);
	                $ps->execute();*/
	                return 1;
                }
                //no make insert
                else{
	                $sql = "INSERT INTO driver_history (dri_id, date, speed, persistence, experience, stamina, freshness, morale, points, ranking) VALUES (:dri_id, :date, :speed, :persistence, :experience, :stamina, :freshness, :morale, :points, :ranking)";
	                $ps = $this->con->prepare($sql);
	                $ps->bindValue('speed', $driver['speed']);
	                $ps->bindValue('persistence', $driver['persistence']);
	                $ps->bindValue('experience', $driver['experience']);
	                $ps->bindValue('stamina', $driver['stamina']);
	                $ps->bindValue('freshness', $driver['freshness']);
	                $ps->bindValue('morale', $driver['morale']);
	                $ps->bindValue('ranking', $rank);
	                $ps->bindValue('points', $driver['points']);
	                $ps->bindValue('date', $date);
	                $ps->bindValue('dri_id', $driver['id']);
	                $ps->execute();
	                return 1;
                } 
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function addDriverPoints($id, $points)
        {
	        try{
                $sql = "UPDATE driver SET points = points + :points WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('points', $points);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function addDriverYouthPoints($id, $tea_id, $points, $bonus)
        {
	        try{
                $sql = "UPDATE driver SET youth_points = youth_points + :points WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('points', $points);
                $ps->bindValue('id', $id);
                $ps->execute();
                
                //transaction
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 14, 0, :bonus, NOW(), :label)";
                $label = "bonus for position";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('bonus', $bonus);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $bonus);
                
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //sponsor
        public function getSponsor($id)
        {
            try{
                $sql = "SELECT * FROM sponsor WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getSponsorBonus($id, $tea_id, $points)
        {
            try{
                //get bonus from sponsor
                //$sql = "SELECT bonus, id FROM sponsor WHERE id = :id";
                $sql = "SELECT s.bonus, s.id FROM sponsor s, team t WHERE t.id = :tea_id AND t.spo_id = s.id";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('id', $id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 13, 0, :bonus, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 13, 0, :bonus, NOW(), :label)";
                $label = "main sponsor "./*$row['id']*/$id." pays bonus for ".$points." points";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('bonus', $row['bonus'] * $points);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['bonus'] * $points);
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getSponsors($class)
        {
            try{
                $sql = "SELECT * FROM sponsor WHERE class < :max_class AND class > :min_class";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('max_class', $class + 1);
                $ps->bindValue('min_class', $class - 4);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function acceptSponsor($id, $tea_id)
        {
            try{
                //get value from sponsor
                $sql = "SELECT value FROM sponsor WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 7, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 7, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." get money from main sponsor ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $row['value']);
                $ps->bindValue('label', $label);
                $ps->execute();

                //higher team value
                $sql = "UPDATE team SET value = value + :value, spo_id = :spo_id WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('spo_id', $id);
                $ps->bindValue('value', $row['value']);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //tire
        public function getTire($id)
        {
            try{
                $sql = "SELECT * FROM tire WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTireBonus($id, $tea_id, $points)
        {
            try{
                //get bonus from sponsor
                $sql = "SELECT bonus, id FROM tire WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 13, 1, :bonus, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 13, 1, :bonus, NOW(), :label)";
                $label = "tire sponsor ".$row['id']." pays bonus for ".$points." points";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('bonus', $row['bonus'] * $points);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['bonus'] * $points);
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getTires()
        {
            try{
                $sql = "SELECT * FROM tire";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function acceptTire($id, $tea_id)
        {
            try{
                //get value from sponsor
                $sql = "SELECT value FROM tire WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 7, 1, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 7, 1, :wage, NOW(), :label)";
                $label = "team ".$tea_id." get money from tire sponsor ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $row['value']);
                $ps->bindValue('label', $label);
                $ps->execute();

                //higher team value
                $sql = "UPDATE team SET value = value + :value, tir_id = :tir_id WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('tir_id', $id);
                $ps->bindValue('value', $row['value']);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function acceptAITire($id, $tea_id)
        {
            try{
                //higher team value
                $sql = "UPDATE team SET tir_id = :tir_id WHERE id = :tea_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('tir_id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //item
        public function getItem($id)
        {
            try{
                $sql = "SELECT * FROM item WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getItems($class, $budget, $order = '')
        {
            try{
            	if($order == '')
            		//$sql = "SELECT * FROM item WHERE class < :class AND value < :budget";
            		$sql = "SELECT * FROM item WHERE class < :class";
            	else
                	//$sql = "SELECT * FROM item WHERE class < :class AND value < :budget ORDER BY ".$order;
                	$sql = "SELECT * FROM item WHERE class < :class ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('class', $class - 1);
                //$ps->bindValue('budget', $budget);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getItemsMinMax($class_min, $class_max, $budget, $order = '')
        {
            try{
            	if($order == '')
            		$sql = "SELECT * FROM item WHERE class < :class_max AND class > :class_min AND value < :budget";
            	else
                	$sql = "SELECT * FROM item WHERE class < :class_max AND class > :class_min AND value < :budget ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('class_max', $class_max + 1);
                $ps->bindValue('class_min', $class_min - 1);
                $ps->bindValue('budget', $budget);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getItemStockCountOfTeam($ite_id, $tea_id)
        {
            try{
                $sql = "SELECT COUNT(*) FROM tea_ite WHERE tea_id = :tea_id AND ite_id = :ite_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('ite_id', $ite_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function buyItem($id, $tea_id, $ins_id)
        {
            try{
                //get value from item
                //$sql = "SELECT value, ins_id FROM item WHERE id = :id";
                $sql = "SELECT value FROM item WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 2, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 2, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." buys item ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $row['value']);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $row['value'] * -1);

                //add new iteam
                //$sql = "INSERT INTO tea_ite (tea_id, ite_id, ins_id) VALUES (:tea_id, :ite_id, :ins_id)";
                $sql = "INSERT INTO tea_ite (tea_id, ite_id) VALUES (:tea_id, :ite_id)";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('ite_id', $id);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function buyAIItem($id, $tea_id, $ins_id, $car_number)
        {
	        try{
                //add new iteam
                //$sql = "INSERT INTO tea_ite (tea_id, ite_id, ins_id, car_number) VALUES (:tea_id, :ite_id, :ins_id, :car_number)";
                $sql = "INSERT INTO tea_ite (tea_id, ite_id, car_number) VALUES (:tea_id, :ite_id, :car_number)";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('ite_id', $id);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('car_number', $car_number);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function sellItem($tea_id, $id, $price)
        {
            try{
                $sql = "SELECT ite_id FROM tea_ite WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 6, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 6, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." sells item ".$row['ite_id'];
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $price);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $price);

                $sql = "DELETE FROM tea_ite WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function repairItem($tea_id, $id, $price)
        {
            try{
                $sql = "SELECT ite_id FROM tea_ite WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                $row = $rows[0];

                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 2, 1, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 2, 1, :wage, NOW(), :label)";
                $label = "team ".$tea_id." repairs item ".$row['ite_id'];
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $row['ins_id']);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $price);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $price * -1);

                $sql = "UPDATE tea_ite SET tea_ite.condition = '100' WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //tea_ite
        public function getItemsFromStock($tea_id, $order = '')
        {
            try{
                $sql = "SELECT * FROM tea_ite WHERE tea_id = :tea_id ORDER BY '".$order."'";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function setItemCarNumber($car_number, $id)
        {
            try{
                if($car_number == 1 || $car_number == 2 || $car_number == 3)
                {
                    $sql = "UPDATE tea_ite SET car_number = :car_number WHERE id = :id";
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('car_number', $car_number);
                }
                else
                {
                    $sql = "UPDATE tea_ite SET car_number = NULL WHERE id = :id";
                    $ps = $this->con->prepare($sql);
                }
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getItemsFromCar($tea_id, $car_number)
        {
            try{
                $sql = "SELECT ti.*, i.name, i.type, i.value, i.skill, i.skill_max FROM tea_ite ti, item i WHERE ti.tea_id = :tea_id AND ti.car_number = :car_number AND i.id = ti.ite_id ORDER BY i.type ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function changeItemTuneup($id, $tuneup)
        {
            try{
                $sql = "UPDATE tea_ite SET tuneup = :tuneup WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tuneup', $tuneup);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function changeTeaIteCondition($id, $condition)
        {
	        try{
                $sql = "UPDATE tea_ite SET `condition` = :condition WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('condition', $condition);
                $ps->bindValue('id', $id);
                $ps->execute();
				
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //track
        public function getTrackById($id)
        {
            try{
                $sql = "SELECT * FROM track WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTrack($ins_id)
        {
            try{
                $sql = "SELECT t.* FROM track t, track_calendar c, instance i WHERE t.id = c.tra_id AND c.ins_id = i.id AND c.rank = i.current_race AND i.id = :ins_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTracks($ins_id)
        {
            try{
                $sql = "SELECT * FROM track t, track_calendar c, instance i WHERE t.id = c.tra_id AND c.ins_id = i.id AND c.rank = i.current_race AND i.id = :ins_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTracksOfCalendar($ins_id)
        {
            try{
                $sql = "SELECT t.*, c.race_date FROM track t, track_calendar c WHERE t.id = c.tra_id AND c.ins_id = :ins_id ORDER BY c.rank ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getAllTracks($ins_id)
        {
            try{
                $sql = "SELECT * FROM track where ins_id = :ins_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateTrack($id, $array)
        {
        	try{
                $sql = "UPDATE track SET front_wing = :front_wing, rear_wing = :rear_wing, front_suspension = :front_suspension, rear_suspension = :rear_suspension, tire_pressure = :tire_pressure, brake_balance = :brake_balance, gear_ratio = :gear_ratio, weather = :weather, last_race = NULL WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('front_wing', $array['front_wing']);
                $ps->bindValue('rear_wing', $array['rear_wing']);
                $ps->bindValue('front_suspension', $array['front_suspension']);
                $ps->bindValue('rear_suspension', $array['rear_suspension']);
                $ps->bindValue('tire_pressure', $array['tire_pressure']);
                $ps->bindValue('brake_balance', $array['brake_balance']);
                $ps->bindValue('gear_ratio', $array['gear_ratio']);
                $ps->bindValue('weather', $array['weather']);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateTrackWinner($id, $winners)
        {
        	try{
                $sql = "UPDATE track SET f1_last_winner = :f1_winner, f2_last_winner = :f2_winner, f3_last_winner = :f3_winner WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('f1_winner', $winners[0]);
                $ps->bindValue('f2_winner', $winners[1]);
                $ps->bindValue('f3_winner', $winners[2]);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateTrackCalendar($id, $tra_id, $training, $quali, $race)
        {
        	try{
        		$sql = "UPDATE track_calendar SET tra_id = :tra_id, training_date = :training_date, qualification_date = :qualification_date, race_date = :race_date WHERE id = :id";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->bindValue('tra_id', $tra_id);
                $ps->bindValue('training_date', $training);
                $ps->bindValue('qualification_date', $quali);
                $ps->bindValue('race_date', $race);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteTrackSeasonData()
        {
        	try{
        		$sql = "UPDATE track SET f1_last_winner = NULL, f2_last_winner = NULL, f3_last_winner = NULL, last_race = null";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		return 1;
        	}catch(Exception $e){
        		if($db_debug) {echo $e; die();}
                return array();
        	}
        }
        public function setTrackRace($id, $data)
        {
        	try{
                $sql = "UPDATE track SET last_race = :last_race WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('last_race', $data);
                $ps->bindValue('id', $id);
                $ps->execute();
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //country
        public function getCountry($id)
        {
            try{
                $sql = "SELECT * FROM country WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getCountries()
        {
        	try{
                $sql = "SELECT * FROM country";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        //training
        public function getTrainings()
        {
            try{
                $sql = "SELECT * FROM training";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTraining($id)
        {
            try{
                $sql = "SELECT * FROM training WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        //dri_tra
        public function insertDriTra($dri_id, $tra_id, $day)
        {
            try{
                //is there an entry -> update or insert
                $sql = "SELECT * FROM dri_tra WHERE dri_id = :dri_id AND day = :day";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->bindValue('day', $day);
                $ps->execute();
                $rows = $ps->fetchAll();
                //update
                if(count($rows) > 0)
                {
                    $sql = "UPDATE dri_tra SET tra_id = :tra_id WHERE day = :day AND dri_id = :dri_id";
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('tra_id', $tra_id);
                    $ps->bindValue('dri_id', $dri_id);
                    $ps->bindValue('day', $day);
                    $ps->execute();
                    return 1;
                }
                //insert
                else
                {
                    $sql = "INSERT INTO dri_tra (dri_id, tra_id, day) VALUES (:dri_id, :tra_id, :day)";
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('dri_id', $dri_id);
                    $ps->bindValue('tra_id', $tra_id);
                    $ps->bindValue('day', $day);
                    $ps->execute();
                    return 1;
                }
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteDriTra($dri_id, $day)
        {
	        try{
		        $sql = "DELETE from dri_tra WHERE dri_id = :dri_id AND day = :day";
		        $ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->bindValue('day', $day);
                $ps->execute();
                return 1;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getDriTra($dri_id)
        {
            try{
                //is there an entry -> update or insert
                $sql = "SELECT * FROM dri_tra WHERE dri_id = :dri_id ORDER BY day ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
            return array();
            }
        }
        public function getDriTras()
        {
            try{
                //is there an entry -> update or insert
                $sql = "SELECT dt.*, t.speed, t.persistence, t.experience, t.stamina, t.freshness, t.morale, t.cost FROM dri_tra dt, training t WHERE t.id = dt.tra_id ORDER BY dri_id ASC";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getDriTrasByDriver($dri_id)
        {
            try{
                //is there an entry -> update or insert
                $sql = "SELECT dt.*, t.speed, t.persistence, t.experience, t.stamina, t.freshness, t.morale, t.cost FROM dri_tra dt, training t WHERE t.id = dt.tra_id WHERE dri_id = :dri_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                    return $rows;
                else
                    return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addDriverWinner($dri_id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE driver SET f1_wins = f1_wins + 1 WHERE id = :dri_id"; break;
        			case 1: $sql = "UPDATE driver SET f2_wins = f2_wins + 1 WHERE id = :dri_id"; break;
        			case 2: $sql = "UPDATE driver SET f3_wins = f3_wins + 1 WHERE id = :dri_id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addDriverPodium($dri_id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE driver SET f1_podium = f1_podium + 1 WHERE id = :dri_id"; break;
        			case 1: $sql = "UPDATE driver SET f2_podium = f2_podium + 1 WHERE id = :dri_id"; break;
        			case 2: $sql = "UPDATE driver SET f3_podium = f3_podium + 1 WHERE id = :dri_id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addDriverOut($dri_id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE driver SET f1_out = f1_out + 1 WHERE id = :dri_id"; break;
        			case 1: $sql = "UPDATE driver SET f2_out = f2_out + 1 WHERE id = :dri_id"; break;
        			case 2: $sql = "UPDATE driver SET f3_out = f3_out + 1 WHERE id = :dri_id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addDriverGp($dri_id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE driver SET f1_gps = f1_gps + 1 WHERE id = :dri_id"; break;
        			case 1: $sql = "UPDATE driver SET f2_gps = f2_gps + 1 WHERE id = :dri_id"; break;
        			case 2: $sql = "UPDATE driver SET f3_gps = f3_gps + 1 WHERE id = :dri_id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addDriverPole($dri_id, $league)
        {
        	try{
        		switch($league)
        		{
        			case 0: $sql = "UPDATE driver SET f1_pole = f1_pole + 1 WHERE id = :dri_id"; break;
        			case 1: $sql = "UPDATE driver SET f2_pole = f2_pole + 1 WHERE id = :dri_id"; break;
        			case 2: $sql = "UPDATE driver SET f3_pole = f3_pole + 1 WHERE id = :dri_id"; break;
                }
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        //mechanics
        public function sellMechanic($id, $tea_id, $ins_id, $sell_price)
        {
	        try{
		        //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 0, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 0, 0, :wage, NOW(), :label)";
                $label = "team ".$tea_id." sells mechanic ".$id;
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $sell_price);
                $ps->bindValue('label', $label);
                $ps->execute();
                
                $this->changeTeamValue($tea_id, $sell_price);
		        
		        //set new team
                $sql = "UPDATE mechanic SET tea_id = null WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();

                return 1;
	        }catch(Exception $e){
		        if($db_debug) {echo $e; die();}
                return 0;
	        }
        }
        public function countFreeMechanics($ins_id)
        {
            try{
                $sql = "SELECT COUNT(*) FROM mechanic WHERE ins_id = :ins_id AND tea_id IS NULL";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function insertMechanic($firstname, $lastname, $pitstop, $development, $morale, $tires, $setup, $repair, $wage, $bonus, $ins_id)
        {
            try{
                //$sql = "INSERT INTO mechanic (firstname, lastname, wage, bonus, ins_id, pit_stop, development, morale, tires, setup, repair) VALUES (:firstname, :lastname, :wage, :bonus, :ins_id, :pit_stop, :development, :morale, :tires, :setup, :repair)";
                $sql = "INSERT INTO mechanic (firstname, lastname, wage, bonus, pit_stop, development, morale, tires, setup, repair) VALUES (:firstname, :lastname, :wage, :bonus, :pit_stop, :development, :morale, :tires, :setup, :repair)";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('firstname', $firstname);
                $ps->bindValue('lastname', $lastname);
                $ps->bindValue('wage', $wage);
                $ps->bindValue('bonus', $bonus);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('pit_stop', $pitstop);
                $ps->bindValue('development', $development);
                $ps->bindValue('morale', $morale);
                $ps->bindValue('tires', $tires);
                $ps->bindValue('setup', $setup);
                $ps->bindValue('repair', $repair);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function updateMechanic($id, $pitstop, $development, $morale, $tires, $setup, $repair, $wage, $bonus, $ins_id)
        {
        	try{
                $sql = "UPDATE mechanic SET wage = :wage, bonus = :bonus, pit_stop = :pit_stop, development = :development, morale = :morale, tires = :tires, setup = :setup, repair = :repair WHERE id = :id AND ins_id = :ins_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('wage', $wage);
                $ps->bindValue('bonus', $bonus);
                $ps->bindValue('pit_stop', $pitstop);
                $ps->bindValue('development', $development);
                $ps->bindValue('morale', $morale);
                $ps->bindValue('tires', $tires);
                $ps->bindValue('setup', $setup);
                $ps->bindValue('repair', $repair);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('id', $id);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function updateMechanicSkills($mechanic)
        {
        	try{
                $sql = "UPDATE mechanic SET development = :development, morale = :morale, tires = :tires, setup = :setup, repair = :repair, pit_stop = :pit_stop WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('development', $mechanic['development']);
                $ps->bindValue('morale', $mechanic['morale']);
                $ps->bindValue('tires', $mechanic['tires']);
                $ps->bindValue('setup', $mechanic['setup']);
                $ps->bindValue('repair', $mechanic['repair']);
                $ps->bindValue('pit_stop', $mechanic['pit_stop']);
                $ps->bindValue('id', $mechanic['id']);
                $ps->execute();
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        //firstnames_female
        /*public function getFirstnamesFemale()
        {
            try{
                $sql = "SELECT * FROM firstnames_female";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        //firstnames_male
        public function getFirstnamesMale()
        {
            try{
                $sql = "SELECT * FROM firstnames_male";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }*/
        public function getFirstnames($language, $gender)
        {
            try{
            	if($gender == 0)
            		$sql = "SELECT * FROM firstnames WHERE language = :language AND female = 1";
            	else
                	$sql = "SELECT * FROM firstnames WHERE language = :language AND male = 1";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('language', $language);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        //lastnames
        public function getLastnames($language)
        {
            try{
                $sql = "SELECT * FROM lastnames WHERE language = :language";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('language', $language);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //in_out
        public function getInoutOfTeam($tea_id, $order = 'type ASC, subtype ASC')
        {
            try{
                $sql = "SELECT * FROM in_out WHERE tea_id = :tea_id ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        //track_calendar
        public function getTrackCalendarNumberRaces($ins_id)
        {
            try{
                $sql = "SELECT COUNT(*) FROM track_calendar WHERE ins_id = :ins_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function getTrackCalendar($ins_id)
        {
            try{
                $sql = "SELECT * FROM track_calendar WHERE ins_id = :ins_id ORDER BY rank ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function saveTrackCalendar($ins_id, $tracks)
        {
	        try{
		        foreach($tracks as $key=>$value)
		        {
			        $sql = "UPDATE track_calendar SET tra_id = :tra_id, rank = :rank WHERE ins_id = :ins_id AND id = :id";
			        $ps = $this->con->prepare($sql);
                	$ps->bindValue('ins_id', $ins_id);
                	$ps->bindValue('rank', $value['rank']);
                	$ps->bindValue('id', $key);
                	$ps->bindValue('tra_id', $value['tra_id']);
					$ps->execute();
		        }
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function addRace($ins_id, $tra_id)
        {
	        try{
	        	$sql = "SELECT * FROM track_calendar WHERE ins_id = :ins_id ORDER BY rank DESC";
	        	$ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
				$rows = $ps->fetchAll();
                if($rows > 0)
                {
			        $sql = "INSERT INTO track_calendar (tra_id, ins_id, rank) VALUES (:tra_id, :ins_id, :rank)";
			        $ps = $this->con->prepare($sql);
	                $ps->bindValue('ins_id', $ins_id);
	                $ps->bindValue('tra_id', $tra_id);
	                $ps->bindValue('rank', $rows[0]['rank'] + 1);
	                $ps->execute();
                }
                return 1;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function delLastRace($ins_id)
        {
	        try{
	        	$sql = "SELECT * FROM track_calendar WHERE ins_id = :ins_id ORDER BY rank DESC";
	        	$ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
				$rows = $ps->fetchAll();
                if($rows > 0)
                {
					$sql = "DELETE FROM track_calendar WHERE id = :id";
					$ps = $this->con->prepare($sql);
	                $ps->bindValue('id', $rows[0]['id']);
	                $ps->execute();
		        }
                return 1;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //params
        public function getParams($ins_id)
        {
            try{
                //$sql = "SELECT * FROM params WHERE ins_id = :ins_id LIMIT 1";
                $sql = "SELECT * FROM params LIMIT 1";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function changeParams($ins_id, $training_max_rounds, $qualification_max_rounds, $qualification_cut1, $qualification_cut2, $drop_out, $random, $time_change, $straight, $curve, $item_value, $setup_value, $driver_value, $tire_value, $speed, $driver_bid_type, $driver_bid_visible, $qualification_race_tires, $race_diff_tires, $qualification_diff_tires, $ai_strength1, $ai_strength2, $ai_strength3, $round_factor, $overtake, $hard_tires_per_weekend, $soft_tires_per_weekend, $meter_to_round, $tire_condition, $engine_power)
        {
            try{
                /*$sql = "UPDATE params SET training_max_rounds = :training_max_rounds,
                                          qualification_max_rounds = :qualification_max_rounds,
                                          qualification_cut1 = :qualification_cut1,
                                          qualification_cut2 = :qualification_cut2,
                                          drop_out = :drop_out,
                                          random = :random,
                                          time_change = :time_change,
                                          straight = :straight,
                                          curve = :curve,
                                          item_value = :item_value,
                                          setup_value = :setup_value,
                                          driver_value = :driver_value,
                                          tire_value = :tire_value,
                                          speed = :speed,
                                          driver_bid_type = :driver_bid_type,
                                          driver_bid_visible = :driver_bid_visible,
                                          qualification_race_tires = :qualification_race_tires,
                                          race_diff_tires = :race_diff_tires,
                                          qualification_diff_tires = :qualification_diff_tires,
                                          ai_strength1 = :ai_strength1,
                                          ai_strength2 = :ai_strength2,
                                          ai_strength3 = :ai_strength3,
                                          round_factor = :round_factor, 
                                          overtake = :overtake,
                                          hard_tires_per_weekend = :hard_tires_per_weekend,
                                          soft_tires_per_weekend = :soft_tires_per_weekend,
                                          meter_to_round = :meter_to_round,
                                          tire_condition = :tire_condition WHERE ins_id = :ins_id";*/
                $sql = "UPDATE params SET training_max_rounds = :training_max_rounds,
                                          qualification_max_rounds = :qualification_max_rounds,
                                          qualification_cut1 = :qualification_cut1,
                                          qualification_cut2 = :qualification_cut2,
                                          drop_out = :drop_out,
                                          random = :random,
                                          time_change = :time_change,
                                          straight = :straight,
                                          curve = :curve,
                                          item_value = :item_value,
                                          setup_value = :setup_value,
                                          driver_value = :driver_value,
                                          tire_value = :tire_value,
                                          speed = :speed,
                                          driver_bid_type = :driver_bid_type,
                                          driver_bid_visible = :driver_bid_visible,
                                          qualification_race_tires = :qualification_race_tires,
                                          race_diff_tires = :race_diff_tires,
                                          qualification_diff_tires = :qualification_diff_tires,
                                          ai_strength1 = :ai_strength1,
                                          ai_strength2 = :ai_strength2,
                                          ai_strength3 = :ai_strength3,
                                          round_factor = :round_factor, 
                                          overtake = :overtake,
                                          hard_tires_per_weekend = :hard_tires_per_weekend,
                                          soft_tires_per_weekend = :soft_tires_per_weekend,
                                          meter_to_round = :meter_to_round,
                                          tire_condition = :tire_condition,
                                          engine_power = :engine_power";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('training_max_rounds', $training_max_rounds);
                $ps->bindValue('qualification_max_rounds', $qualification_max_rounds);
                $ps->bindValue('qualification_cut1', $qualification_cut1);
                $ps->bindValue('qualification_cut2', $qualification_cut2);
                $ps->bindValue('drop_out', $drop_out);
                $ps->bindValue('random', $random);
                $ps->bindValue('time_change', $time_change);
                $ps->bindValue('straight', $straight);
                $ps->bindValue('curve', $curve);
                $ps->bindValue('item_value', $item_value);
                $ps->bindValue('setup_value', $setup_value);
                $ps->bindValue('driver_value', $driver_value);
                $ps->bindValue('tire_value', $tire_value);
                $ps->bindValue('speed', $speed);
                $ps->bindValue('driver_bid_type', $driver_bid_type);
                $ps->bindValue('driver_bid_visible', $driver_bid_visible);
                $ps->bindValue('qualification_race_tires', $qualification_race_tires);
                $ps->bindValue('race_diff_tires', $race_diff_tires);
                $ps->bindValue('qualification_diff_tires', $qualification_diff_tires);
                $ps->bindValue('ai_strength1', $ai_strength1);
                $ps->bindValue('ai_strength2', $ai_strength2);
                $ps->bindValue('ai_strength3', $ai_strength3);
                $ps->bindValue('round_factor', $round_factor);
                $ps->bindValue('overtake', $overtake);
                $ps->bindValue('hard_tires_per_weekend', $hard_tires_per_weekend);
                $ps->bindValue('soft_tires_per_weekend', $soft_tires_per_weekend);
                $ps->bindValue('meter_to_round', $meter_to_round);
                $ps->bindValue('tire_condition', $tire_condition);
                $ps->bindValue('engine_power', $engine_power);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }

        //setup
        public function insertSetup($car_number, $tea_id, $dri_id, $ins_id, $league, $settings, $tire, $round_data, $type, $subtype = null)
        {
            try{
                $count = 0;
                foreach($round_data as $data)
                {
                	//quali and race
                    if(count($data) > 3)
                        $sql = "INSERT INTO setup (car_number, tea_id, dri_id, ins_id, league, front_wing, rear_wing, front_suspension, rear_suspension, tire_pressure, brake_balance, gear_ratio, tire_type, safetycar, rounds, round_time, round_time_string, fastest_time, fastest_time_string, type, subtype, pit_stop, disqualified, last_round, reason) VALUES (:car_number, :tea_id, :dri_id, :ins_id, :league, :front_wing, :rear_wing, :front_suspension, :rear_suspension, :tire_pressure, :brake_balance, :gear_ratio, :tire_type, :safetycar, :rounds, :round_time, :round_time_string, :fastest_time, :fastest_time_string, :type, :subtype, :pit_stop, :disqualified, :last_round, :reason)";
                    //training
                    else
                        $sql = "INSERT INTO setup (car_number, tea_id, dri_id, ins_id, front_wing, rear_wing, front_suspension, rear_suspension, tire_pressure, brake_balance, gear_ratio, tire_type, rounds, round_time, round_time_string, type, subtype) VALUES (:car_number, :tea_id, :dri_id, :ins_id, :front_wing, :rear_wing, :front_suspension, :rear_suspension, :tire_pressure, :brake_balance, :gear_ratio, :tire_type, :rounds, :round_time, :round_time_string, :type, :subtype)";
                    
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('car_number', $car_number);
                    $ps->bindValue('tea_id', $tea_id);
                    $ps->bindValue('dri_id', $dri_id);
                    $ps->bindValue('ins_id', $ins_id);
                    if($type == 2)
                    {
                        $ps->bindValue('front_wing', $settings[$count]['front_wing']);
                        $ps->bindValue('rear_wing', $settings[$count]['rear_wing']);
                        $ps->bindValue('front_suspension', $settings[$count]['front_suspension']);
                        $ps->bindValue('rear_suspension', $settings[$count]['rear_suspension']);
                        $ps->bindValue('tire_pressure', $settings[$count]['tire_pressure']);
                        $ps->bindValue('brake_balance', $settings[$count]['brake_balance']);
                        $ps->bindValue('gear_ratio', $settings[$count]['gear_ratio']);
                    }else{
                        $ps->bindValue('front_wing', $settings['front_wing']);
                        $ps->bindValue('rear_wing', $settings['rear_wing']);
                        $ps->bindValue('front_suspension', $settings['front_suspension']);
                        $ps->bindValue('rear_suspension', $settings['rear_suspension']);
                        $ps->bindValue('tire_pressure', $settings['tire_pressure']);
                        $ps->bindValue('brake_balance', $settings['brake_balance']);
                        $ps->bindValue('gear_ratio', $settings['gear_ratio']);
                    }
                    $ps->bindValue('tire_type', $tire);
                    if(count($data)>3)
                    {
                    	$ps->bindValue('rounds', $data[0]);
	                    $ps->bindValue('last_round', $data[1]);
	                    $ps->bindValue('round_time', $data[2]);
	                    $ps->bindValue('round_time_string', $data[3]);
                        $ps->bindValue('fastest_time', $data[4]);
                        $ps->bindValue('fastest_time_string', $data[5]);
                        $ps->bindValue('pit_stop', $data[6]);
						$ps->bindValue('disqualified', $data[7]);
						$ps->bindValue('reason', $data[8]);
						$ps->bindValue('league', $league);
						$ps->bindValue('tire_type', $data[9]);
						$ps->bindValue('safetycar', $data[10]);
                    }else{
	                    $ps->bindValue('rounds', $data[0]);
	                    $ps->bindValue('round_time', $data[1]);
	                    $ps->bindValue('round_time_string', $data[2]);
                    }
                    $ps->bindValue('type', $type);
                    $ps->bindValue('subtype', $subtype);
                    
                    $ps->execute();
                    $count++;
                }
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        //setup for training
        public function insertTrainingSetup($car_number, $tea_id, $dri_id, $ins_id, $league, $settings, $tire, $round_data, $type, $comment_type, $comment_value)
        {
            try{
                $count = 0;
                foreach($round_data as $data)
                {
                    $sql = "INSERT INTO setup (car_number, tea_id, dri_id, ins_id, front_wing, rear_wing, front_suspension, rear_suspension, tire_pressure, brake_balance, gear_ratio, tire_type, rounds, round_time, round_time_string, type, comment_type, comment_value, league) VALUES (:car_number, :tea_id, :dri_id, :ins_id, :front_wing, :rear_wing, :front_suspension, :rear_suspension, :tire_pressure, :brake_balance, :gear_ratio, :tire_type, :rounds, :round_time, :round_time_string, :type, :comment_type, :comment_value, :league)";
                    
                    $ps = $this->con->prepare($sql);
                    $ps->bindValue('car_number', $car_number);
                    $ps->bindValue('tea_id', $tea_id);
                    $ps->bindValue('dri_id', $dri_id);
                    $ps->bindValue('ins_id', $ins_id);
					$ps->bindValue('front_wing', $settings['front_wing']);
					$ps->bindValue('rear_wing', $settings['rear_wing']);
					$ps->bindValue('front_suspension', $settings['front_suspension']);
					$ps->bindValue('rear_suspension', $settings['rear_suspension']);
					$ps->bindValue('tire_pressure', $settings['tire_pressure']);
					$ps->bindValue('brake_balance', $settings['brake_balance']);
					$ps->bindValue('gear_ratio', $settings['gear_ratio']);
                    $ps->bindValue('tire_type', $tire);
					$ps->bindValue('rounds', $data[0]);
					$ps->bindValue('round_time', $data[1]);
					$ps->bindValue('round_time_string', $data[2]);
                    $ps->bindValue('league', $league);
                    $ps->bindValue('type', $type);
                    $ps->bindValue('comment_type', $comment_type);
                    $ps->bindValue('comment_value', $comment_value);
                    
                    $ps->execute();
                    $count++;
                }
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getSetupOfTypeTrainingTires($ins_id, $type, $tire_type)
        {
        	try{
        		$sql = "SELECT car_number, tea_id, dri_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.dri_id = b.dri_id AND a.tea_id = b.tea_id ORDER BY b.round_time_string) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.dri_id = b.dri_id AND a.tea_id = b.tea_id AND tire_type = :tire_type ORDER BY b.round_time_string LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('type', $type);
                $ps->bindValue('tire_type', $tire_type);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getBestSetupOfTypeTrainingTires($ins_id, $dri_id, $type, $tire_type, $order = '')
        {
        	try{
                $sql = "SELECT * FROM setup WHERE ins_id = :ins_id AND dri_id = :dri_id AND type = :type AND tire_type = :tire_type ORDER BY ".$order." LIMIT 1";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->bindValue('type', $type);
                $ps->bindValue('tire_type', $tire_type);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                    return $rows[0];
                else
                    return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return null;
            }
        }
        public function getSetupForDriver($ins_id, $league, $type, $tea_id, $car_number)
        {
        	 try{
				$sql = "SELECT * FROM setup WHERE ins_id = :ins_id AND type = :type AND league = :league AND tea_id = :tea_id AND car_number = :car_number ORDER BY rounds ASC";
				$ps = $this->con->prepare($sql);
				$ps->bindValue('ins_id', $ins_id);
				$ps->bindValue('type', $type);
				$ps->bindValue('league', $league);
				$ps->bindValue('tea_id', $tea_id);
				$ps->bindValue('car_number', $car_number);
				
				$ps->execute();
				$rows = $ps->fetchAll();
				return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getSetupOfType($ins_id, $league, $type, $subtype = -1, $round = null)
        {
            try{
            	//quali
                if($subtype != -1)
                {
                    if($round == null)
                        //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time_string) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND b.subtype = :subtype AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.round_time_string LIMIT 1) ORDER BY a.fastest_time ASC";
                    	$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND b.subtype = :subtype AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.fastest_time LIMIT 1) ORDER BY a.fastest_time ASC";
                    	//nicht verwenden, da sonst der cut zwischen den qualis nicht passt!
                    	//$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string FROM setup WHERE ins_id = :ins_id AND type = :type AND subtype = :subtype AND league = :league GROUP BY car_number, tea_id ORDER BY fastest_time ASC";
                    else
                        //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time_string) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND b.subtype = :subtype AND rounds = :rounds AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.round_time_string LIMIT 1) ORDER BY a.fastest_time ASC";
                        //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND b.subtype = :subtype AND rounds = :rounds AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.fastest_time LIMIT 1) ORDER BY a.fastest_time ASC";
                        $sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string FROM setup WHERE ins_id = :ins_id AND type = :type AND subtype = :subtype AND league = :league AND rounds = :rounds GROUP BY car_number, tea_id ORDER BY fastest_time ASC";
                        
                //training or race
                }else{
                	//training
                	if($league == null)
					{
						//###
						if($round == null)
	                        #$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time_string) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time_string LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                    	$sql = "SELECT car_number, tea_id, dri_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.dri_id = b.dri_id AND a.tea_id = b.tea_id ORDER BY b.round_time) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.dri_id = b.dri_id AND a.tea_id = b.tea_id ORDER BY b.round_time LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                    else
	                        #$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time_string) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND rounds = :rounds AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time_string LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                        $sql = "SELECT car_number, tea_id, dri_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.dri_id = b.dri_id AND a.tea_id = b.tea_id ORDER BY b.round_time) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND rounds = :rounds AND a.dri_id = b.dri_id AND a.tea_id = b.tea_id ORDER BY b.round_time LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                    //###
	                }
					else
					{
	                    if($round == null)
	                        //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, safetycar, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.round_time LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                    	$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, safetycar, rounds FROM setup a WHERE a.ins_id = :ins_id AND a.type = :type AND a.league = :league GROUP BY a.car_number, a.tea_id ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                    else
	                        //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, safetycar, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND rounds = :rounds AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.round_time LIMIT 1) ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                        $sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, safetycar, rounds FROM setup a WHERE a.ins_id = :ins_id AND a.type = :type AND a.rounds = :rounds AND a.league = :league GROUP BY a.car_number, a.tea_id ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
	                }
                }
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('type', $type);
                $ps->bindValue('league', $league);
                if($subtype != -1)
                {
                    $ps->bindValue('subtype', $subtype);
                }
                if($round != null)
                {
                    $ps->bindValue('rounds', $round);
                }
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getSetupOfTypeForRace($ins_id, $league, $type, $subtype = -1, $round = null)
        {
            try{
	            $sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, safetycar FROM setup WHERE ins_id = :ins_id AND type = :type AND rounds = :rounds AND league = :league GROUP BY car_number, tea_id ORDER BY last_round DESC, disqualified ASC, round_time ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('type', $type);
                $ps->bindValue('league', $league);
                if($subtype != -1)
                {
                    $ps->bindValue('subtype', $subtype);
                }
                if($round != null)
                {
                    $ps->bindValue('rounds', $round);
                }
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getSetupOfTypeAndCar($ins_id, $tea_id, $car_number, $type, $order = "id DESC")
        {
            try{
                $sql = "SELECT * FROM setup WHERE ins_id = :ins_id AND tea_id = :tea_id AND dri_id = :car_number AND type = :type ORDER BY ".$order." LIMIT 1";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->bindValue('type', $type);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                    return $rows[0];
                else
                    return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return null;
            }
        }
        public function getSetupOfTypeAndCarAll($ins_id, $tea_id, $car_number, $type, $order = "id DESC")
        {
            try{
                $sql = "SELECT * FROM setup WHERE ins_id = :ins_id AND tea_id = :tea_id AND dri_id = :car_number AND type = :type ORDER BY ".$order;
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->bindValue('type', $type);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                    return $rows;
                else
                    return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return null;
            }
        }
        public function isQualificationOrRace($ins_id, $type)
        {
            try{
                $sql = "SELECT id FROM setup WHERE ins_id = :ins_id AND type = :type LIMIT 1";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('type', $type);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        //setup_setting
        public function insertSetupSetting($car_number, $tea_id, $league, $ins_id, $settings, $tire_type, $tire_id, $rounds, $type, $subtype)
        {
            try{
                $sql = "SELECT * from setup_setting WHERE type = :type AND subtype = :subtype AND ins_id = :ins_id AND tea_id = :tea_id AND car_number = :car_number";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('type', $type);
                $ps->bindValue('subtype', $subtype);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                {
                    //update
                    if(array_key_exists('power1', $settings))
                    	$sql = "UPDATE setup_setting SET rounds = :rounds, front_wing = :front_wing, rear_wing = :rear_wing, front_suspension = :front_suspension, rear_suspension = :rear_suspension, tire_pressure = :tire_pressure, brake_balance = :brake_balance, gear_ratio = :gear_ratio, power1 = :power1, power2 = :power2, power3 = :power3, power4 = :power4, power5 = :power5, power6 = :power6, tire_type = :tire_type, race_tire_id = :race_tire_id WHERE type = :type AND subtype = :subtype AND ins_id = :ins_id AND tea_id = :tea_id AND league = :league AND car_number = :car_number";
                    else
                    	$sql = "UPDATE setup_setting SET rounds = :rounds, front_wing = :front_wing, rear_wing = :rear_wing, front_suspension = :front_suspension, rear_suspension = :rear_suspension, tire_pressure = :tire_pressure, brake_balance = :brake_balance, gear_ratio = :gear_ratio, tire_type = :tire_type, race_tire_id = :race_tire_id WHERE type = :type AND subtype = :subtype AND ins_id = :ins_id AND tea_id = :tea_id AND league = :league AND car_number = :car_number";
                }else{
                    //insert
                    if(array_key_exists('power1', $settings))
                    	$sql = "INSERT INTO setup_setting (car_number, tea_id, league, ins_id, front_wing, rear_wing, front_suspension, rear_suspension, tire_pressure, brake_balance, gear_ratio, power1, power2, power3, power4, power5, power6, tire_type, race_tire_id, rounds, type, subtype) VALUES (:car_number, :tea_id, :league, :ins_id, :front_wing, :rear_wing, :front_suspension, :rear_suspension, :tire_pressure, :brake_balance, :gear_ratio, :power1, :power2, :power3, :power4, :power5, :power6, :tire_type, :race_tire_id, :rounds, :type, :subtype)";
                    else
                    	$sql = "INSERT INTO setup_setting (car_number, tea_id, league, ins_id, front_wing, rear_wing, front_suspension, rear_suspension, tire_pressure, brake_balance, gear_ratio, tire_type, race_tire_id, rounds, type, subtype) VALUES (:car_number, :tea_id, :league, :ins_id, :front_wing, :rear_wing, :front_suspension, :rear_suspension, :tire_pressure, :brake_balance, :gear_ratio, :tire_type, :race_tire_id, :rounds, :type, :subtype)";
                }
                $ps = $this->con->prepare($sql);
                $ps->bindValue('type', $type);
                $ps->bindValue('subtype', $subtype);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('league', $league);
                $ps->bindValue('car_number', $car_number);
                $ps->bindValue('rounds', $rounds);
                $ps->bindValue('front_wing', $settings['front_wing']);
                $ps->bindValue('rear_wing', $settings['rear_wing']);
                $ps->bindValue('front_suspension', $settings['front_suspension']);
                $ps->bindValue('rear_suspension', $settings['rear_suspension']);
                $ps->bindValue('tire_pressure', $settings['tire_pressure']);
                $ps->bindValue('brake_balance', $settings['brake_balance']);
                $ps->bindValue('gear_ratio', $settings['gear_ratio']);
                if(array_key_exists('power1', $settings))
                {
					$ps->bindValue('power1', $settings['power1']);
					$ps->bindValue('power2', $settings['power2']);
					$ps->bindValue('power3', $settings['power3']);
					$ps->bindValue('power4', $settings['power4']);
					$ps->bindValue('power5', $settings['power5']);
					$ps->bindValue('power6', $settings['power6']);
                }
                $ps->bindValue('tire_type', $tire_type);
                $ps->bindValue('race_tire_id', $tire_id);
                $ps->execute();
                
                //for qualification
                if($type == 1 && $subtype == 2)
                {
                	//update every setting for race with current power setting
					$sql = "SELECT * from setup_setting WHERE type = :type AND ins_id = :ins_id AND tea_id = :tea_id AND car_number = :car_number";
					$ps = $this->con->prepare($sql);
					$ps->bindValue('type', 2);
					$ps->bindValue('ins_id', $ins_id);
					$ps->bindValue('tea_id', $tea_id);
					$ps->bindValue('car_number', $car_number);
					$ps->execute();
					$rows = $ps->fetchAll();
					$array_size = count($rows);
					for($i = 0; $i < $array_size; ++$i)
					{
						//update
						$sql = "UPDATE setup_setting SET front_wing = :front_wing, rear_wing = :rear_wing, front_suspension = :front_suspension, rear_suspension = :rear_suspension, tire_pressure = :tire_pressure, brake_balance = :brake_balance, gear_ratio = :gear_ratio WHERE type = :type AND subtype = :subtype AND ins_id = :ins_id AND tea_id = :tea_id AND league = :league AND car_number = :car_number";
						$ps = $this->con->prepare($sql);
						$ps->bindValue('front_wing', $settings['front_wing']);
						$ps->bindValue('rear_wing', $settings['rear_wing']);
						$ps->bindValue('front_suspension', $settings['front_suspension']);
						$ps->bindValue('rear_suspension', $settings['rear_suspension']);
						$ps->bindValue('tire_pressure', $settings['tire_pressure']);
						$ps->bindValue('brake_balance', $settings['brake_balance']);
						$ps->bindValue('gear_ratio', $settings['gear_ratio']);
						$ps->bindValue('type', $rows[$i]['type']);
						$ps->bindValue('subtype', $rows[$i]['subtype']);
						$ps->bindValue('ins_id', $rows[$i]['ins_id']);
						$ps->bindValue('tea_id', $rows[$i]['tea_id']);
						$ps->bindValue('league', $rows[$i]['league']);
						$ps->bindValue('car_number', $rows[$i]['car_number']);
						$ps->execute();
					}
                }
                
                //for race
                if($type == 2)
                {
					//update every setting for race with current power setting
					$sql = "SELECT * from setup_setting WHERE type = :type AND ins_id = :ins_id AND tea_id = :tea_id AND car_number = :car_number";
					$ps = $this->con->prepare($sql);
					$ps->bindValue('type', $type);
					$ps->bindValue('ins_id', $ins_id);
					$ps->bindValue('tea_id', $tea_id);
					$ps->bindValue('car_number', $car_number);
					$ps->execute();
					$rows = $ps->fetchAll();
					$array_size = count($rows);
					for($i = 0; $i < $array_size; ++$i)
					{
						//update
						$sql = "UPDATE setup_setting SET power1 = :power1, power2 = :power2, power3 = :power3, power4 = :power4, power5 = :power5, power6 = :power6 WHERE type = :type AND subtype = :subtype AND ins_id = :ins_id AND tea_id = :tea_id AND league = :league AND car_number = :car_number";
						$ps = $this->con->prepare($sql);
						$ps->bindValue('power1', array_key_exists('power1',$settings)?$settings['power1']:0);
						$ps->bindValue('power2', array_key_exists('power2',$settings)?$settings['power2']:0);
						$ps->bindValue('power3', array_key_exists('power3',$settings)?$settings['power3']:0);
						$ps->bindValue('power4', array_key_exists('power4',$settings)?$settings['power4']:0);
						$ps->bindValue('power5', array_key_exists('power5',$settings)?$settings['power5']:0);
						$ps->bindValue('power6', array_key_exists('power6',$settings)?$settings['power6']:0);
						$ps->bindValue('type', $rows[$i]['type']);
						$ps->bindValue('subtype', $rows[$i]['subtype']);
						$ps->bindValue('ins_id', $rows[$i]['ins_id']);
						$ps->bindValue('tea_id', $rows[$i]['tea_id']);
						$ps->bindValue('league', $rows[$i]['league']);
						$ps->bindValue('car_number', $rows[$i]['car_number']);
						$ps->execute();
					}
                }
                
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getSetupSetting($car_number, $tea_id, $ins_id, $type, $subtype)
        {
            try{
            	$sql = "SELECT s.*, r.tire_number from setup_setting s join race_tires r on s.race_tire_id = r.id WHERE s.type = :type AND s.subtype = :subtype AND s.ins_id = :ins_id AND s.tea_id = :tea_id AND s.car_number = :car_number";
            	//$sql = "SELECT * from setup_setting WHERE type = :type AND subtype = :subtype AND ins_id = :ins_id AND tea_id = :tea_id AND car_number = :car_number";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('type', $type);
                $ps->bindValue('subtype', $subtype);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                    return $rows[0];
                else
                    return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getSetupSettingAll($car_number, $tea_id, $ins_id, $type)
        {
            try{
            	$sql = "SELECT s.*, r.tire_number from setup_setting s join race_tires r on s.race_tire_id = r.id WHERE s.type = :type AND s.ins_id = :ins_id AND s.tea_id = :tea_id AND s.car_number = :car_number";
            	//$sql = "SELECT * from setup_setting WHERE type = :type AND ins_id = :ins_id AND tea_id = :tea_id AND car_number = :car_number";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('type', $type);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                    return $rows;
                else
                    return null;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getAllSetupSetting($type, $subtype, $ins_id, $league)
        {
            try{
                $sql = "SELECT * from setup_setting WHERE type = :type AND ins_id = :ins_id AND subtype = :subtype AND league = :league ORDER BY tea_id ASC, car_number ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('type', $type);
                $ps->bindValue('subtype', $subtype);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('league', $league);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }

        public function reset()
        {
            try{
            	$sql = "UPDATE instance SET current_race = 1, current_day = 0 WHERE id = 1";
            	$ps = $this->con->prepare($sql);
                $ps->execute();
            
                $sql = "UPDATE driver SET tea_id = NULL, ai_tea_id = NULL, points = 0, youth_points = 0, f1_gps = 0, f1_wins = 0, f1_podium = 0, f1_out = 0, f1_pole = 0, f2_gps=0, f2_wins = 0, f2_podium = 0, f2_out = 0, f2_pole = 0, f3_gps = 0, f3_wins = 0, f3_podium = 0, f3_out = 0, f3_pole = 0, f1_champion = 0, f2_champion = 0, f3_champion = 0";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                $sql = "UPDATE mechanic SET tea_id = NULL";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                $sql = "UPDATE team SET value = 15000000, driver1 = NULL, driver2 = NULL, driver3 = NULL, tir_id = NULL, spo_id = NULL, points = 0, youth_points = 0, f1_gps = 0, f1_wins = 0, f1_podium = 0, f1_out = 0, f1_pole = 0, f2_gps=0, f2_wins = 0, f2_podium = 0, f2_out = 0, f2_pole = 0, f3_gps = 0, f3_wins = 0, f3_podium = 0, f3_out = 0, f3_pole = 0, f1_champion = 0, f2_champion = 0, f3_champion = 0";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "UPDATE team SET value = 25000000 WHERE league = 2";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "UPDATE team SET value = 35000000 WHERE league = 1";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "UPDATE track SET f1_last_winner = NULL, f2_last_winner = NULL, f3_last_winner = NULL, last_race = null";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "UPDATE user SET points = 0";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                $sql = "TRUNCATE setup; ALTER TABLE setup AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                $sql = "TRUNCATE tea_ite; ALTER TABLE tea_ite AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                $sql = "TRUNCATE in_out; ALTER TABLE in_out AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "TRUNCATE dri_tra; ALTER TABLE dri_tra AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "TRUNCATE driver_history; ALTER TABLE driver_history AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "TRUNCATE team_history; ALTER TABLE team_history AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "TRUNCATE user_history; ALTER TABLE user_history AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = file_get_contents("sql/driver_values.sql");
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = file_get_contents("sql/set_driver_wage_bonus.sql");
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = file_get_contents("sql/set_mechanic_wage_bonus.sql");
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = file_get_contents("sql/set_item_costs.sql");
                $ps = $this->con->prepare($sql);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;
            }
        }
        public function resetTQR()
        {
            try{
                $sql = "TRUNCATE setup; ALTER TABLE setup AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "TRUNCATE setup_setting; ALTER TABLE setup_setting AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;
            }
        }
        public function resetQR()
        {
            try{
                $sql = "DELETE FROM setup WHERE type > 0";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "TRUNCATE setup_setting; ALTER TABLE setup_setting AUTO_INCREMENT = 1;";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "UPDATE instance SET last_race = null, last_qualification = null";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;
            }
        }
        public function resetR()
        {
            try{
                $sql = "DELETE FROM setup WHERE type = 2";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                
                $sql = "UPDATE instance SET last_race = null";
                $ps = $this->con->prepare($sql);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return -1;
            }
        }
        public function getBonus()
        {
	        try{
                $sql = "SELECT * FROM bonus";
                $ps = $this->con->prepare($sql);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getBonusPoints($ins_id, $tea_id, $bonus)
        {
	        try{
                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, in_value, date, label) VALUES (:ins_id, :tea_id, 14, 0, :bonus, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 14, 0, :bonus, NOW(), :label)";
                $label = "bonus for position";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('bonus', $bonus);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($tea_id, $bonus);
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function buyTraining($driver, $cost)
        {
        	try{
                //transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 12, 0, :cost, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 12, 0, :cost, NOW(), :label)";
                $label = "team ".$driver['tea_id']." pays training for driver ".$driver['id'];
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $driver['ins_id']);
                $ps->bindValue('tea_id', $driver['tea_id']);
                $ps->bindValue('cost', $cost);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($driver['tea_id'], $cost * -1);
                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function getCountDriverBidsTeam($ins_id, $tea_id)
        {
	        try{
		        $sql = "SELECT COUNT(*) FROM driver_bids WHERE ins_id = :ins_id AND tea_id = :tea_id";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getCountDriverBidsDriver($ins_id, $dri_id)
        {
	        try{
		        $sql = "SELECT COUNT(*) FROM driver_bids WHERE ins_id = :ins_id AND dri_id = :dri_id";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0]['COUNT(*)'];
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getDriverBidsDriver($ins_id, $dri_id)
        {
	        try{
		        $sql = "SELECT * FROM driver_bids WHERE ins_id = :ins_id AND dri_id = :dri_id";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getDriverBidsFirstDriver($ins_id, $dri_id)
        {
        	try{
		        $sql = "SELECT * FROM driver_bids WHERE ins_id = :ins_id AND dri_id = :dri_id ORDER BY created ASC LIMIT 1";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows[0];
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getDriverBids($ins_id)
        {
	        try{
		        $sql = "SELECT * FROM driver_bids WHERE ins_id = :ins_id ORDER BY dri_id ASC, created ASC";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('ins_id', $ins_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows;
                else
                	return array();
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function getDriverBid($id)
        {
	        try{
		        $sql = "SELECT * FROM driver_bids WHERE id = :id";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('id', $id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return $rows[0];
                else
                	return null;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function makeDriverBid($ins_id, $dri_id, $tea_id, $wage, $bonus)
        {
            try{
            	$sql = "SELECT * FROM driver_bids WHERE dri_id = :dri_id AND tea_id = :tea_id";
				$ps = $this->con->prepare($sql);
		        $ps->bindValue('dri_id', $dri_id);
		        $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                $rows = $ps->fetchAll();
                if(count($rows) > 0)
                	return 0;
            
                $sql = "INSERT INTO driver_bids (ins_id, tea_id, dri_id, wage, bonus, created, last_update) VALUES (:ins_id, :tea_id, :dri_id, :wage, :bonus, NOW(), NOW())";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('dri_id', $dri_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $wage);
                $ps->bindValue('bonus', $bonus);
                $ps->execute();

                return 1;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function changeDriverBid($id, $wage, $bonus)
        {
	        try{
		        $sql = "UPDATE driver_bids SET wage = :wage, bonus = :bonus, last_update = NOW() WHERE id = :id";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('id', $id);
		        $ps->bindValue('wage', $wage);
		        $ps->bindValue('bonus', $bonus);
                $ps->execute();
                
                return 1;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function deleteDriverBid($id, $tea_id)
        {
	        try{
		        $sql = "DELETE FROM driver_bids WHERE id = :id AND tea_id = :tea_id";
		        $ps = $this->con->prepare($sql);
		        $ps->bindValue('id', $id);
		        $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
                
                return 1;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        
        public function buyDriverFromBid($id)
        {
	    	try{
	    		//get the bid
		    	$bid = $this->getDriverBid($id);
		    	
		    	//transaction
                //$sql = "INSERT INTO in_out (ins_id, tea_id, type, subtype, out_value, date, label) VALUES (:ins_id, :tea_id, 0, 0, :wage, NOW(), :label)";
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 0, 0, :wage, NOW(), :label)";
                $label = "team ".$bid['tea_id']." buys driver ".$bid['dri_id'];
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $bid['ins_id']);
                $ps->bindValue('tea_id', $bid['tea_id']);
                $ps->bindValue('wage', $bid['wage']);
                $ps->bindValue('label', $label);
                $ps->execute();

                $this->changeTeamValue($bid['tea_id'], $bid['wage'] * -1);

                //set new team
                $sql = "UPDATE driver SET tea_id = :tea_id, wage = :wage, bonus = :bonus, ai_tea_id = NULL WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $bid['tea_id']);
                $ps->bindValue('id', $bid['dri_id']);
                $ps->bindValue('bonus', $bid['bonus']);
                $ps->bindValue('wage', $bid['wage']);
                $ps->execute();
                
                //delete all bids for that driver
                $sql = "DELETE FROM driver_bids WHERE dri_id = :dri_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $bid['dri_id']);
                $ps->execute();

                return 1;
	    	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }  
        }

	public function removeDriverFromBid($id)
        {
        	try{
        	//get the bid
		$bid = $this->getDriverBid($id);

        	//delete all bids for that driver
                $sql = "DELETE FROM driver_bids WHERE dri_id = :dri_id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $bid['dri_id']);
                $ps->execute();

                return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            } 
        }
        
        public function getWinner($ins_id, $league)
        {
	        try{
		        $sql = "SELECT * FROM setup WHERE type = 2 AND ins_id = :ins_id AND league = :league AND disqualified = 0 ORDER BY rounds DESC, round_time ASC LIMIT 3";
		        $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('league', $league);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
	        }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return 0;
            }
        }
        public function getRaceResult($ins_id, $league, $type, $subtype = -1, $round = null)
        {
            try{
	            //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, (SELECT COUNT(*) FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND a.car_number = b.car_number AND a.tea_id = b.tea_id ORDER BY b.round_time) as rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND rounds = :rounds AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.round_time LIMIT 1) ORDER BY a.disqualified ASC, a.round_time ASC";
                //$sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, rounds FROM setup a WHERE id = (SELECT b.id  FROM setup b WHERE b.ins_id = :ins_id AND b.type = :type AND rounds = :rounds AND a.car_number = b.car_number AND a.tea_id = b.tea_id AND b.league = :league ORDER BY b.round_time LIMIT 1) ORDER BY a.disqualified ASC, a.round_time ASC";
	            $sql = "SELECT car_number, tea_id, tire_type, round_time, round_time_string, fastest_time, fastest_time_string, pit_stop, disqualified, reason, safetycar, rounds FROM setup a WHERE a.ins_id = :ins_id AND a.type = :type AND a.rounds = :rounds AND a.league = :league GROUP BY a.car_number, a.tea_id ORDER BY a.last_round DESC, a.disqualified ASC, a.round_time ASC";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('type', $type);
                $ps->bindValue('league', $league);
                $ps->bindValue('rounds', $round);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addDriverPlacement($dri_id, $value)
        {
        	try{
	            $sql = "UPDATE driver SET placement = placement + :value WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $dri_id);
                $ps->bindValue('value', $value);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addTeamPlacement($tea_id, $value)
        {
        	try{
	            $sql = "UPDATE team SET placement = placement + :value WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $tea_id);
                $ps->bindValue('value', $value);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addManagerPlacement($use_id, $value)
        {
        	try{
	            $sql = "UPDATE user SET placement = placement + :value WHERE id = :id";
                $ps = $this->con->prepare($sql);
                $ps->bindValue('id', $use_id);
                $ps->bindValue('value', $value);
                $ps->execute();
                $rows = $ps->fetchAll();
                return $rows;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        
        public function getTrainingUsers()
        {
        	try{
        		$sql = "SELECT * FROM user WHERE tea_id IN (SELECT DISTINCT tea_id FROM setup WHERE type = 0)";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getNoTrainingUsers()
        {
        	try{
        		$sql = "SELECT * FROM user WHERE active = 1 AND id NOT IN (SELECT id FROM user WHERE tea_id IN (SELECT DISTINCT tea_id FROM setup WHERE type = 0))";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getQualificationUsers()
        {
        	try{
        		$sql = "SELECT * FROM user WHERE tea_id IN (SELECT DISTINCT tea_id FROM setup_setting WHERE type = 1)";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getNoQualificationUsers()
        {
        	try{
        		$sql = "SELECT * FROM user WHERE active = 1 AND id NOT IN (SELECT id FROM user WHERE tea_id IN (SELECT DISTINCT tea_id FROM setup_setting WHERE type = 1))";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getGrandprixUsers()
        {
        	try{
        		$sql = "SELECT * FROM user WHERE tea_id IN (SELECT DISTINCT tea_id FROM setup_setting WHERE type = 2)";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getNoGrandprixUsers()
        {
        	try{
        		$sql = "SELECT * FROM user WHERE id NOT IN (SELECT id FROM user WHERE tea_id IN (SELECT DISTINCT tea_id FROM setup_setting WHERE type = 2))";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function repairAiIteams()
        {
        	try{
        		$sql = "UPDATE tea_ite SET tea_ite.condition = 100 WHERE tea_ite.tea_id NOT IN (SELECT tea_id FROM user)";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteAiItems($ins_id)
        {
        	try{
        		//$sql = "DELETE FROM tea_ite WHERE tea_id NOT IN (SELECT tea_id FROM user WHERE ins_id = :ins_id)";
        		$sql = "DELETE FROM tea_ite ti, team t WHERE ti.tea_id NOT IN (SELECT tea_id FROM user) AND t.ins_id = :ins_id AND t.id = ti.tea_id";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('ins_id', $ins_id);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteRaceTires()
        {
        	try{
        		$sql = "TRUNCATE race_tires; ALTER TABLE race_tires AUTO_INCREMENT = 1;";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteSponsors()
        {
        	try{
        		$sql = "UPDATE team SET tir_id = NULL, spo_id = NULL";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function addRaceTire($tea_id, $car_number,/*$dri_id,*/ $tire_type, $tir_id, $tire_number)
        {
        	try{
        		$sql = "INSERT INTO race_tires (tea_id, car_number, tire_type, tir_id, tire_number) VALUES (:tea_id, :car_number, :tire_type, :tir_id, :tire_number)";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('tea_id', $tea_id);
                //$ps->bindValue('dri_id', $dri_id);
                $ps->bindValue('car_number', $car_number);
                $ps->bindValue('tire_type', $tire_type);
                $ps->bindValue('tir_id', $tir_id);
                $ps->bindValue('tire_number', $tire_number);
                $ps->execute();
        		return true;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getRaceTire($id)
        {
        	try{
        		$sql = "SELECT race_tires.*, tire.hard, tire.soft, tire.hard_rain, tire.soft_rain FROM race_tires LEFT JOIN tire ON race_tires.tir_id = tire.id WHERE race_tires.id = :id";
        		//$sql = "SELECT * FROM race_tires WHERE id = :id";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('id', $id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		if(count($rows) > 0)
        			return $rows[0];
        		else
        			return null;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getRaceTiresForDriver($tea_id, $car_number)
        {
        	try{
        		$sql = "SELECT * FROM race_tires WHERE tea_id = :tea_id AND car_number = :car_number";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('car_number', $car_number);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function repairRaceTiresForDriver($tea_id)
        {
        	try{
        		$sql = "UPDATE race_tires SET distance = 0 WHERE tea_id = :tea_id";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
        		return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function setRaceTireDistance($id, $distance)
        {
        	try{
        		$sql = "UPDATE race_tires SET distance = :distance WHERE id = :id";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('distance', $distance);
        		$ps->bindValue('id', $id);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeamHistoryForTeam($tea_id)
        {
        	try{
        		$sql = "SELECT date FROM team_history WHERE tea_id = :tea_id ORDER BY date DESC LIMIT 2";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeamHistory($tea_id, $limit = null)
        {
        	try{
        		if($limit != null)
        			$sql = "SELECT * FROM team_history WHERE tea_id = :tea_id ORDER BY date DESC LIMIT ".$limit;
        		else
        			$sql = "SELECT * FROM team_history WHERE tea_id = :tea_id ORDER BY date DESC";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeamHistoryForLeagueAndDate($league, $date)
        {
        	try{
        		$sql = "SELECT * FROM `team_history` h JOIN team t ON h.tea_id = t.id WHERE t.league = :league AND h.date = :date ORDER BY h.ranking DESC";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('league', $league);
                $ps->bindValue('date', $date);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getTeamHistoryForLeagueAndTeam($league, $tea_id)
        {
        	try{
        		$sql = "SELECT h.* FROM `team_history` h JOIN team t ON h.tea_id = t.id WHERE t.league = :league AND h.tea_id = :tea_id ORDER BY h.date DESC LIMIT 2";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('league', $league);
                $ps->bindValue('tea_id', $tea_id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getDriverHistoryForDriver($dri_id)
        {
        	try{
        		$sql = "SELECT * FROM driver_history WHERE dri_id = :dri_id ORDER BY date DESC LIMIT 2";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('dri_id', $dri_id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getDriverHistoryForLeagueAndDate($league, $date)
        {
        	try{
        		$sql = "SELECT * FROM `driver_history` h JOIN team t ON h.dri_id = t.driver1 OR h.dri_id = t.driver2 WHERE t.league = :league AND h.date = :date ORDER BY h.points DESC, h.ranking DESC";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('league', $league);
                $ps->bindValue('date', $date);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getUserHistory($use_id)
        {
        	try{
        		$sql = "SELECT * FROM user_history WHERE use_id = :use_id ORDER BY date ASC";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('use_id', $use_id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getUserHistoryForUser($use_id)
        {
        	try{
        		$sql = "SELECT * FROM user_history WHERE use_id = :use_id ORDER BY date DESC LIMIT 2";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('use_id', $use_id);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function getUserHistoryForDate($date)
        {
        	try{
        		$sql = "SELECT * FROM `user_history` WHERE date = :date ORDER BY points DESC, ranking DESC";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('date', $date);
                $ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateInstanceCurrentDay($ins_id, $day)
        {
        	try{
        		$sql = "UPDATE instance SET current_day = :day WHERE id = :id";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('day', $day);
        		$ps->bindValue('id', $ins_id);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function resetPlacementAndPoints()
        {
        	try{
        		$sql = "UPDATE team SET placement = 0, points = 0";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		
        		$sql = "UPDATE driver SET placement = 0, points = 0";
        		$ps = $this->con->prepare($sql);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteAiDrivers()
        {
        	try{
        		$sql = "UPDATE driver SET ai_tea_id = NULL";
        		$ps = $this->con->prepare($sql);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function isManagedTeam($id)
        {
        	try{
        		$sql = "SELECT * FROM team WHERE id = :id AND id IN (SELECT tea_id FROM user)";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('id', $id);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		if(count($rows) == 0)
        			return false;
        		else
        			return true;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function updateInstanceNextSaison()
        {
        	try{
        		$sql = "UPDATE instance SET current_race = 1, current_day = 0, season = season + 1";
        		$ps = $this->con->prepare($sql);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function resetYouthDriver()
        {
        	try{
        		$sql = "UPDATE team SET youthdriver = 0";
        		$ps = $this->con->prepare($sql);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function setWorldChampionTeam($id, $league)
        {
        	try{
        		$sql = "";
        		switch($league)
        		{
        			case 1: $sql = "UPDATE team SET f1_champion = f1_champion + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE team SET f2_champion = f2_champion + 1 WHERE id = :id"; break;
        			case 3: $sql = "UPDATE team SET f3_champion = f3_champion + 1 WHERE id = :id"; break;
        		}
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('id', $id);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function setWorldChampionDriver($id, $league)
        {
        	try{
        		$sql = "";
        		switch($league)
        		{
        			case 1: $sql = "UPDATE driver SET f1_champion = f1_champion + 1 WHERE id = :id"; break;
        			case 2: $sql = "UPDATE driver SET f2_champion = f2_champion + 1 WHERE id = :id"; break;
        			case 3: $sql = "UPDATE driver SET f3_champion = f3_champion + 1 WHERE id = :id"; break;
        		}
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('id', $id);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function unsubscribe($email)
        {
        	try{
        		$sql = "UPDATE user SET newsletter = 0 WHERE email = :email";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('email', $email);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function log($user, $type, $message)
        {
        	try{
        		$sql = "INSERT INTO log (user, date, type, message) VALUES (:user, NOW(), :type, :message)";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('user', $user);
                $ps->bindValue('type', $type);
                $ps->bindValue('message', $message);
                $ps->execute();
        		return true;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function randomeventIn($tea_id, $value)
        {
        	try{
        		//transaction
                $sql = "INSERT INTO in_out (tea_id, type, subtype, in_value, date, label) VALUES (:tea_id, 15, 0, :wage, NOW(), :label)";
                $label = "randomevent";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $value);
                $ps->bindValue('label', $label);
                $ps->execute();
                return true;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function randomeventOut($tea_id, $value)
        {
        	try{
        		//transaction
                $sql = "INSERT INTO in_out (tea_id, type, subtype, out_value, date, label) VALUES (:tea_id, 12, 0, :wage, NOW(), :label)";
                $label = "randomevent";
                $ps = $this->con->prepare($sql);
                //$ps->bindValue('ins_id', $ins_id);
                $ps->bindValue('tea_id', $tea_id);
                $ps->bindValue('wage', $value);
                $ps->bindValue('label', $label);
                $ps->execute();
                return true;
            }catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteAllCarDesigns()
        {
        	try{
        		$sql = "update team set car_design = null";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
                return true;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteInOut()
        {
        	try{
        		$sql = "TRUNCATE in_out; ALTER TABLE in_out AUTO_INCREMENT = 1;";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
        public function deleteDriverHistory()
        {
        	try{
        		$sql = "TRUNCATE driver_history; ALTER TABLE driver_history AUTO_INCREMENT = 1;";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
		public function deleteTeamHistory()
		{
			try{
        		$sql = "TRUNCATE team_history; ALTER TABLE team_history AUTO_INCREMENT = 1;";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
		}
		public function deleteQualiAndRaceDataFromInstance()
		{
			try{
        		$sql = "UPDATE instance SET last_race = null, last_qualification = null";
        		$ps = $this->con->prepare($sql);
        		return $ps->execute();
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
		}
		public function deleteSetupAndSetupSetting()
		{
			try{
        		$sql = "TRUNCATE setup; ALTER TABLE setup AUTO_INCREMENT = 1;";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		
        		$sql = "TRUNCATE setup_setting; ALTER TABLE setup_setting AUTO_INCREMENT = 1;";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		return $rows;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
		}
		public function freeTeams()
		{
			try{
        		$sql = "select COUNT(tea_id) as count from user where tea_id is not null";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		$userteams = $rows[0]['count'];
        		
        		$sql = "select COUNT(t.id) as count from team t, instance i where i.visible = 1 and t.ins_id = i.id";
        		$ps = $this->con->prepare($sql);
        		$ps->execute();
        		$rows = $ps->fetchAll();
        		$maxteams = $rows[0]['count'];
        		
        		return $maxteams - $userteams;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
		}
	public function resetTeam($id) {
			try{
				//reset sponsor and tire sponsor
        		$sql = "UPDATE team SET tir_id = NULL, spo_id = NULL WHERE id = :id";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('id', $id);
        		$ps->execute();
        		
        		//drivers of team get ai drivers
        		$sql = "UPDATE driver SET ai_tea_id = :tea_id, tea_id = NULL WHERE tea_id = :tea_id";
        		$ps = $this->con->prepare($sql);
                $ps->bindValue('tea_id', $id);
                $ps->execute();
                
                //reset budget
        		$sql = "UPDATE team SET value = 10000000 WHERE id = :id";
        		$ps = $this->con->prepare($sql);
        		$ps->bindValue('id', $id);
        		$ps->execute();
        	
        		return 1;
        	}catch(Exception $e){
                if($db_debug) {echo $e; die();}
                return array();
            }
        }
    }
    
    $db = new F1Database($db_server, $db_database, $db_password, $db_user, $db_port);
