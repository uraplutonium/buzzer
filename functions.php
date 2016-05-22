<?php
	/**
	* This is the php file that provides all functions the website requires.
	* All functions works with five variables in $_SESSION, which are also
	* used to generate html page dynamically by php.
	* 
	* Candidate number:Y7759874
	*/

	/**
	* Initialisation of $_SESSION in index.php
	*/
	function InitIndexSession()
	{
		if(!isset($_SESSION['page']))
			$_SESSION['page'] = "INDEX";
		if(!isset($_SESSION['status']))
			$_SESSION['status'] = "NORMAL";
		if(!isset($_SESSION['sidebar']))
			$_SESSION['sidebar'] = "FOLLOWING";
		if(!isset($_SESSION['currentUser']))
			$_SESSION['currentUser'] = null;
	}

	/**
	* Initialisation of $_SESSION in buzzer.php
	*/
	function InitBuzzerSession()
	{
		if($_SESSION['page'] != "BUZZER")
		{
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = "NOT_AVALIABLE";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;
		}
	}

	/**
	* Login
	*/	
	function LoginUser()
	{
		$loginHandle = $_POST['LoginHandle'];
		$loginPassword = $_POST['LoginPassword'];		
		$encryptedPwd = md5($loginPassword);
		
		if($loginHandle == "" || $loginPassword == "")	// uncompleted forms
		{
			//echo "uncompleted forms<br>";
			
			// set next page
			$_SESSION['page'] = "INDEX";
			$_SESSION['status'] = "NOT_COMPLETED_LOGIN";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;
			
			// do nothing about the database
		}
		else	// handle and password forms are not empty
		{				
			$sql_check_login = "SELECT userID FROM users WHERE handle='$loginHandle' AND password='$encryptedPwd'";
			
			$database_id = connectdb_read();
			$results = mysql_query($sql_check_login);
			mysql_close($database_id);
		
			if(!$results)	// query database failed
			{
				error("query database failed");
				return;
			}
			
			$count = 0;
			while($record = mysql_fetch_array($results))
			{
				$userID = $record['userID'];
				$count++;
			}
			
			if($count < 1)	// wrong handle or password
			{
				//echo "wrong handle or password";
				
				// set next page
				$_SESSION['page'] = "INDEX";
				$_SESSION['status'] = "WRONG_LOGIN_HANDLE_PWD";
				$_SESSION['sidebar'] = "FOLLOWING";
				$_SESSION['currentUser'] = null;
				
				// do nothing about the database
			}
			else	// correct handle and password
			{
				//echo "login success!<br>";
				//echo "correct handle and password<br>";
				
				// get the current server time to set as thisLogin time
				$currentTime = date("Y-m-d H:i:s", time());
				
				$sql_update_thisLogin = "UPDATE users SET thisLogin='$currentTime' WHERE userID='$userID'";
				
				$database_id = connectdb_rw();
				$results = mysql_query($sql_update_thisLogin);
				mysql_close($database_id);
				
				if(!$results)
				{
					// update this login time failed
					error("update this login time failed!");
					return;
				}
				
				// set next page
				$_SESSION['page'] = "BUZZER";
				$_SESSION['status'] = "NORMAL";
				$_SESSION['sidebar'] = "FOLLOWING";
				$_SESSION['currentUser'] = $userID;
			}
		}
	}

	/**
	* Register new user
	*/	
	function RegisterUser()
	{	
		// get register information from form
		$registerHandle = $_POST['RegisterHandle'];
		$registerPassword1 = $_POST['RegisterPassword1'];
		$registerPassword2 = $_POST['RegisterPassword2'];
		$registerProfile = $_POST['RegisterProfile'];
		
		// check duplication of handle
		$sql_check_handle = "SELECT handle FROM users WHERE handle='$registerHandle'";
		
		$database_id = connectdb_read();
		$results = mysql_query($sql_check_handle);
		mysql_close($database_id);
			
		$count = 0;
		while($record = mysql_fetch_array($results))
			$count++;
		
		if($registerHandle == "" || $registerPassword1 == "" || $registerPassword2 == "" || $registerProfile == "")	// uncompleted forms
		{
			echo "uncompleted forms<br>";
			
			// set next page
			$_SESSION['page'] = "INDEX";
			$_SESSION['status'] = "NOT_COMPLETED_REGISTER";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;
			
			// do nothing about the database		
		}
		else if($count > 0)	// there already exist a user with same handle
		{
			echo "there already exist a user with same handle<br>";
		
			// set next page
			$_SESSION['page'] = "INDEX";
			$_SESSION['status'] = "UNAVALIBALE_REGISTER_HANDLE";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;
			
			// do nothing about the database			
		}
		else if($registerPassword1 != $registerPassword2)	// avalibale handle but unavalibale password
		{			
			echo "avalibale handle but unavalibale password<br>";

			// set next page
			$_SESSION['page'] = "INDEX";
			$_SESSION['status'] = "UNAVALIBALE_REGISTER_PASSWORD";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;

		}
		else	// this handle and password are all avalibale
		{	
			//echo "register success!<br>";
			//echo "this handle and password are all avalibale<br>";

			// set next page
			$currentTime = date("Y-m-d H:i:s", time());

			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = "NORMAL";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;
			
			$encryptedPwd = md5($registerPassword1);
						
			// insert a new user to the database
			$sql_insert_user = "INSERT INTO users (handle, password, profile, thisLogin) VALUES ('$registerHandle', '$encryptedPwd', '$registerProfile', '$currentTime')";			
			
			$database_id = connectdb_rw();
			$results=mysql_query($sql_insert_user);
			mysql_close($database_id);
			
			if(!$results)
			{
				// insert a new user to database failed
				error("Register Failed!");
				return;
			}

			// get new user's userID
			$sql_get_userid = "SELECT userID FROM users WHERE handle='$registerHandle'";
			
			$database_id = connectdb_read();
			$results = mysql_query($sql_get_userid);
			mysql_close($database_id);
			
			if(!$results)
			{
				// get userID of the new registered user failed
				error("Get userID failed!");
				return;
			}

			$record = mysql_fetch_array($results);
			$_SESSION['currentUser'] = $record['userID'];
			
			$currentUser = $_SESSION['currentUser'];
			
			// make new user follows himself
			$database_id = connectdb_rw();
			$result = follow($currentUser, $currentUser);
			//mysql_close($database_id);
			
			if($result == 0)
			{
				//echo "new user follows himself successfully";
			}
			else
			{
				error("follow user himself failed");
				return;
			}

			// make admin follow the new user
			$database_id = connectdb_rw();
			$result = follow(0, $currentUser);
			//mysql_close($database_id);

			if($result == 0)
			{
				//echo "admin follow new user successfully";
			}
			else
			{
				error("admin follow new user failed");
				return;
			}

		}
	}

	/**
	* Logout
	*/	
	function LogoutUser()
	{
		// update lastLogin as thisLogin, and set thisLogin as null
		$userID = $_SESSION['currentUser'];
				
		$sql_get_thisLogin = "SELECT thisLogin FROM users WHERE userID='$userID'";
		
		$database_id = connectdb_read();
		$results = mysql_query($sql_get_thisLogin);
		mysql_close($database_id);
		
		if(!$results)
		{
			// get current user's thisLogin time failed
			error("get current user's thisLogin time failed");
		}
		
		// set lastLogin time as thisLogin time, and then set thisLogin time as null
		$record = mysql_fetch_array($results);		
		$thisLogin = $record['thisLogin'];

		$sql_get_thisLogin = "UPDATE users SET lastLogin='$thisLogin', thisLogin='' WHERE userID='$userID'";
		
		$database_id = connectdb_rw();
		$results = mysql_query($sql_get_thisLogin);
		mysql_close($database_id);
		
		if(!$results)
		{
			// get current user's thisLogin time failed
			error("Update last login time failed!");
			return;
		}
		
		// set next page
		$_SESSION['page'] = "INDEX";
		$_SESSION['status'] = "NORMAL";
		$_SESSION['sidebar'] = "FOLLOWING";
		//$_SESSION['currentUser'] = null;
	}

	/**
	* Find People
	*/	
	function FindPeople()
	{
		$pattern = $_POST['Pattern'];
		
		if($pattern == "")	// uncompleted form
		{
			//echo "find people textbox should not be empty";
			
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = $_SESSION['status'];
			$_SESSION['sidebar'] = "FORM_NOT_COMPLETED";
			$_SESSION['currentUser'] = $_SESSION['currentUser'];
		}
		else	// valid input pattern
		{
			// find any user whose handle contains pattern
			$sql_pattern = "SELECT userID FROM users WHERE handle LIKE '%$pattern%'";
			
			$database_id = connectdb_read();
			$results = mysql_query($sql_pattern);
			mysql_close($database_id);
			
			if(!$results)
			{
				// find people failed
				error("Find people failed!");
				return;
			}
			
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = $_SESSION['status'];
			$_SESSION['sidebar'] = "FOUND";
			$_SESSION['currentUser'] = $_SESSION['currentUser'];

			return $results;
		}
	}

	/**
	* Follow
	* 
	* @see follow($userID, $preID)
	*/	
	function FollowPeople()
	{
		$currentUser = $_SESSION['currentUser'];
		$followedUser = $_POST['userID'];
		
		$database_id = connectdb_rw();
		$result = follow($currentUser, $followedUser);
		//mysql_close($database_id);

		if($result == 0)
		{
			//echo handle($currentUser) . " now is following " . handle($followedUser);
		
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = $_SESSION['status'];
			$_SESSION['sidebar'] = "FINISH_FOLLOW";
			$_SESSION['currentUser'] = $_SESSION['currentUser'];
			
			$_SESSION['buffer'] = $followedUser;
		}
		else
		{
			error("follow people failed");
		}
	}

	/**
	* Unfollow
	*/	
	function UnfollowPeople()
	{
		$currentUser = $_SESSION['currentUser'];
		$followedUser = $_POST['userID'];

		$sql_unfollow = "DELETE FROM followers WHERE follower='$currentUser' AND followed='$followedUser'";
		
		$database_id = connectdb_rw();
		$results = mysql_query($sql_unfollow);
		mysql_close($database_id);
		
		if(!$results)
		{
			// delete following relationship failed
			error("delete following relationship failed!");
			return;
		}
		else
		{
			//echo handle($currentUser) . " now is NOT following " . handle($followedUser) . " any longer";
			
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = $_SESSION['status'];
			$_SESSION['sidebar'] = "FINISH_UNFOLLOW";
			$_SESSION['currentUser'] = $_SESSION['currentUser'];
			
			$_SESSION['buffer'] = $followedUser;
		}
	}

	/**
	* Get current user's buzzes amount
	* 
	* This function is not used by the website of current version
	*/
	function GetMyBuzzesAmount()
	{		
		$currentUser = $_SESSION['currentUser'];

		$sql_get_buzzes = "SELECT buzz FROM buzzes WHERE userID='$currentUser'";
		
		$database_id = connectdb_read();
		$results = mysql_query($sql_get_buzzes);
		mysql_close($database_id);
		
		if(!$results)
		{
			// get buzzes from database failed
			error("get buzzes from database failed!");
			return;
		}
		else
		{
			//echo "get buzzes success";			
		
			$count = 0;
			while($record = mysql_fetch_array($results))
				$count++;
		}

		return $count;
	}

	/**
	* Get records of users that are followed by the current user
	*/		
	function GetFollowing()
	{
		$currentUser = $_SESSION['currentUser'];

		$sql_get_buzzes = "SELECT followed FROM followers WHERE follower='$currentUser'";
		
		$database_id = connectdb_read();
		$results = mysql_query($sql_get_buzzes);
		mysql_close($database_id);
		
		if(!$results)
		{
			// get followed users from database failed
			error("get followed users from database failed!");
			return;
		}
		else
		{
			//echo "get followed users success";
					
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = $_SESSION['status'];
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = $_SESSION['currentUser'];

			return $results;
		}
	}

	/**
	* Get amount of users that are followed by the current user
	*/	
	function GetFollowingAmount()
	{
		$buf_page = $_SESSION['page'];
		$buf_status = $_SESSION['status'];
		$buf_sidebar = $_SESSION['sidebar'];
		$buf_currentUser = $_SESSION['currentUser'];
		
		$following = GetFollowing();
		
		$_SESSION['page'] = $buf_page;
		$_SESSION['status'] = $buf_status;
		$_SESSION['sidebar'] = $buf_sidebar;
		$_SESSION['currentUser'] = $buf_currentUser;
		
		$count = 0;
		while($record = mysql_fetch_array($following))
			$count++;
		
		return $count;
	}

	/**
	* Get records of users that are following the current user
	*/	
	function GetFollowers()
	{
		$currentUser = $_SESSION['currentUser'];

		$sql_get_buzzes = "SELECT follower FROM followers WHERE followed='$currentUser'";
		
		$database_id = connectdb_read();
		$results = mysql_query($sql_get_buzzes);
		mysql_close($database_id);
		
		if(!$results)
		{
			// get followers from database failed
			error("get followers from database failed!");
			return;
		}
		else
		{
			//echo "get followers success";
					
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = $_SESSION['status'];
			$_SESSION['sidebar'] = "FOLLOWERS";
			$_SESSION['currentUser'] = $_SESSION['currentUser'];

			return $results;
		}
	}

	/**
	* Get amount of users that are following the current user
	*/	
	function GetFollowersAmount()
	{
		$buf_page = $_SESSION['page'];
		$buf_status = $_SESSION['status'];
		$buf_sidebar = $_SESSION['sidebar'];
		$buf_currentUser = $_SESSION['currentUser'];
		
		$followers = GetFollowers();
		
		$_SESSION['page'] = $buf_page;
		$_SESSION['status'] = $buf_status;
		$_SESSION['sidebar'] = $buf_sidebar;
		$_SESSION['currentUser'] = $buf_currentUser;
		
		$count = 0;
		while($record = mysql_fetch_array($followers))
			$count++;
		
		return $count;
	}

	/**
	* Publish a new buzz
	*/	
	function PublishBuzz()
	{
		$currentUser = $_SESSION['currentUser'];
		$currentTime = date("Y-m-d H:i:s", time());
		$newBuzz = $_POST['BuzzText'];
		
		$sql_insert_buzz = "INSERT INTO buzzes (userID, timestamp, buzz) VALUES ('$currentUser', '$currentTime', '$newBuzz')";			

		$database_id = connectdb_rw();
		$results = mysql_query($sql_insert_buzz);
		mysql_close($database_id);
		
		if(!$results)
		{
			// insert new buzz failed
			error("insert new buzz failed!");
			return;
		}
		else
		{
			//echo "publish new buzz success";
					
			// set next page
			$_SESSION['page'] = "BUZZER";
			$_SESSION['status'] = "FINISH_BUZZ";
			$_SESSION['sidebar'] = $_SESSION['sidebar'];
			$_SESSION['currentUser'] = $_SESSION['currentUser'];

			return $results;
		}
	}

	/**
	* Get new buzzes
	*
	* @see catchup($userrID)
	*/	
	function GetNewBuzzes()
	{
		$database_id = connectdb_read();
		$results = catchup($_SESSION['currentUser']);
		mysql_close($database_id);
		
		//echo "get new buzzes success";
		return $results;
	}

	/**
	* Deregister the currrent user
	*
	* @see deregister($userID)
	*/	
	function DeregisterCurrentUser()
	{
		$database_id = connectdb_rw();
		$results = deregister($_SESSION['currentUser']);
		mysql_close($database_id);
		
		if($results == 0)
		{
			//echo "deregister success";
			
			// set next page
			$_SESSION['page'] = "INDEX";
			$_SESSION['status'] = "NORMAL";
			$_SESSION['sidebar'] = "FOLLOWING";
			$_SESSION['currentUser'] = null;
		}
		else if(results == -1)
		{
			error("userID should not be null");
		}
		else if(results == -2)
		{
			error("can not deregister admin!");
		}
		else
		{
			error("unkonwn error when deregister");
		}
	}
	
?>
