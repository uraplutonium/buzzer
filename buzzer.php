<?php
	/**
	* This is the homepage page of Buzzer website after user login.
	* It provides the following nine functionalities:
	*
	* 1. Logout
	* 2. Search other user by handle, and view handle and profile of users in searching results
	* 3. View current user's handle and profile
	* 4. View handle and profile of users that is followed by the current user
	* 5. View handle and profile of users that is following the current user
	* 6. Follow or unfollow other users that listed on the page
	* 7. Publish a new buzz to share with current user's followers
	* 8. View recent buzzes published by users that is followed by the current user
	* 9. Deregister the current user
	* 
	* Candidate number:Y7759874
	*/

	//initialisation of session and import requied php functions
	session_start();
	require_once('/n/www/student/projects/dweb-shared/DWEBfunctions.php');
	require_once('functions.php');
	InitBuzzerSession();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<?php
	/**
	* Responses for page jumps.
	* Php functions will be called according to $_POST['buttonName']
	* when a form is submited to this buzzer.php.
	* All the information about how the following part of this page looks like
	* will be generated and saved in five variables in $_SESSION['keyName']
	*/
	
	// Variable necessary to display default page
	$following = GetFollowing();	// $following is necessary to display the users followed by current user
	$newBuzzes = GetNewBuzzes();	// $newBuzzes is necessary to display new buzzes

	if($_SESSION['page'] == "BUZZER" && $_SESSION['status'] == "NOT_AVALIABLE")
	{
		//echo "unavaliable";
		$_SESSION['page'] = "INDEX";
		$_SESSION['status'] = "NORMAL";
		$_SESSION['sidebar'] = "FOLLOWING";
		$_SESSION['currentUser'] = null;
	}
	else if($_POST['Logout'])
	{
		//echo "Logout";			
		LogoutUser();
	}
	else if($_POST['Find'])
	{
		//echo "Find people";
		$found = FindPeople();	// searching results is saved in $found
	}
	else if($_POST['Follow'])
	{
		//echo "Follow him/her";
		FollowPeople();
	}
	else if($_POST['Unfollow'])
	{
		//echo "Unfollow him/her";
		UnfollowPeople();
	}
	else if($_POST['Following'])
	{
		//echo "List following user";
		$following = GetFollowing();	// following people list is saved in $following
	}
	else if($_POST['Followers'])
	{
		//echo "List followers";
		$followers = GetFollowers();	// followers people liest is saved in $followers
	}
	else if($_POST['PublishBuzz'])
	{
		//echo "Publish Buzz";
		PublishBuzz();
	}
	else if($_POST['Deregister'])
	{
		/*
		* Whether deregister should be done is according to the value of $_POST['deregister_flag'].
		* $_POST['deregister_flag'] is set true as default, which means the deregister button will
		* work even if javascipt is disabled. And when javascript works, there will show a confirm
		* message box.
		*/
		if($_POST['deregister_flag'] == "true")
		{
			//echo "Deregister";
			DeregisterCurrentUser();
		}
		else
		{
			//echo "Deregister canceled";
		}		
	}

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<?php
		/**
		* Generate a meta to jump to buzzer.php according to value of $_SESSION['page']
		*/

		if($_SESSION['page'] == "INDEX" || ($_SESSION['page'] == "BUZZER" && $_SESSION['status'] == "NOT_AVALIABLE"))
		{
			echo chr(9) . "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />" . chr(13).chr(10);
		}
		else if($_SESSION['page'] != "BUZZER")
		{
			error("_SESSION['page'] error!");
		}
	?>
	
	<!-- Link css file -->
	<link rel="stylesheet" type="text/css" href="style.css" />

	<title>Buzzer - Welcome! <?php echo handle($_SESSION['currentUser']);?></title>
</head>

<body>
	<!-- Display nothing if not open this page via index.php -->
	<?php if($_SESSION['page'] == "BUZZER") { ?>

	<!--=START javascript functions -->
	<script type='text/javascript'>
	
		/**
		* Check and limit the length of textArea in 141 characters
		*/
		function checkCharLength()
		{
			var buzzArea = document.getElementById('BuzzArea');
			var textAera = buzzArea.BuzzText;
						
			if(textAera.value.length >= 140)
			{
				textAera.value = textAera.value.substring(0, 140);
			}
		}
		
		/**
		* Get the left length of textArea and display it on the buzz button
		*/
		function displayCharLength()
		{
			var buzzArea = document.getElementById('BuzzArea');
			var textAera = buzzArea.BuzzText;
			var leftLength = 141 - textAera.value.length;
			buzzArea.PublishBuzz.value = "Buzz!\n" + leftLength;
		}
		
		/**
		* Show a confirm message box, and set the value of hidden form "deregister_flag" as false
		*/
		function confirmDeregister()
		{
			var topBarForm = document.getElementById('topBarForm');
			if(!confirm("Are You Sure to Delete the Current Buzzer Account?"))
				topBarForm.deregister_flag.value = "false";
		}
	</script>
	<!--=END javascript functions -->

	<!--=START TopBar Div -->
	<div id="topBarDiv">
		<h1 style="float:left"> <a id="homeLink" href="buzzer.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buzzer</a> </h1>	
		
		<form id="topBarForm" method="post" action="buzzer.php">
		<div style="float:right">
			<input name="deregister_flag" type="hidden" value="true" alt="deregister flag of hidden form"/>
			<input name="Logout" type="submit" value="Logout" class="topButton" alt="Logout button"/>
			<input name="Deregister" type="submit" value="Deregister" class="topButton" onclick="confirmDeregister()" alt="Deregister button"/>
			<p id="welcomeText"> Welcome! <?php echo handle($_SESSION['currentUser']); ?> </p>
		</div>
		</form>	
	</div>
	<!--=END TopBar Div -->
	
	<!--=START TopWedge Div -->
	<div id="topWedgeDiv">
		<pre> </pre>
	</div>
	<!--=END TopWedge Div -->
	
	<!--=START LeftWedge Div -->
	<div class="verticalWedgeDiv">
		<pre> </pre>
	</div>
	<!--=END LeftWedge Div -->
		
	<!--=START Sidebar Div -->
	<div id="sidebarDiv">
			
		<!--==START Profile Div -->
		<div class="green" id="profileDiv">
			<?php
				/**
				* Generate current user's avatar and handle
				*/
				
				$avatar = $_SESSION['currentUser'] % 10;
				$img = "<div style=\"float:left;\"> <img src=\"avatar/avatar" . $avatar . ".png\" alt=\"avatar\" /> </div>";
				echo chr(9).chr(9).chr(9) . $img . chr(13).chr(10);				
				
				$userHandle = handle($_SESSION['currentUser']);
				$handle = "<div id=\"userHandle\">" . $userHandle . "</div>";
				echo chr(9).chr(9).chr(9) . $handle . chr(13).chr(10);
			?>
			
			<div id="profileText">	
				<?php			
					$profile = profile($_SESSION['currentUser']);
					if($profile == null)
					{
						error("get current user's profile failed");
					}
					
					echo chr(9).chr(9).chr(9).chr(9) . "<p>" . $profile . "</p>" . chr(13).chr(10);
				?>
			</div>
		</div>
		<!--==END Profile Div -->
		
		<!--==START People Div -->
		<div class="green" id="peopleDiv">
						
			<!--===START Searching, following and followers buttons -->
			<form method="post" action="buzzer.php">
			<div>
				<div id="formDiv">
				<input name="Pattern" type="text" size="30" maxlength="255" id="patternInput" alt="Pattern textbox input form"/>
				</div>
				
				<?php
					/**
					* Generate Searching, following and followers buttons
					*/
					
					$findButton = "<input name=\"Find\" type=\"submit\" value=\"  Find &#13;&#10; People\" class=\"squareButton\" style=\"border-left-width:2px; ";
					if($_SESSION['sidebar'] == "FOUND")
						$findButton = $findButton . "background:#CCCCCC; font-weight:800;";
					$findButton = $findButton . "\" alt=\"Find people button\"/> ";
					
					$followingButton = "<input name=\"Following\" type=\"submit\" value=\"  " . GetFollowingAmount() . "&#13;&#10; Following\" class=\"squareButton\" ";
					if($_SESSION['sidebar'] == "FOLLOWING")
						$followingButton = $followingButton . "style=\"background:#CCCCCC; font-weight:700;\" ";					
					$followingButton = $followingButton . "alt=\"Following button\"/> ";
					
					$followersButton = "<input name=\"Followers\" type=\"submit\" value=\"  " . GetFollowersAmount() . "&#13;&#10; Followers\" class=\"squareButton\" style=\"border-right-width:2px; ";
					if($_SESSION['sidebar'] == "FOLLOWERS")
						$followersButton = $followersButton . " background:#CCCCCC; font-weight:800; ";					
					$followersButton = $followersButton . "\" alt=\"Followers button\"/> ";
					
					echo chr(9).chr(9).chr(9).chr(9).chr(9) . $findButton . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9).chr(9) . $followingButton . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9).chr(9) . $followersButton . chr(13).chr(10);
				?>
				
				</div>
			</form>
			<!--===END Searching, following and followers buttons -->
						
			<!--===START PeopleList Div  -->
			<?php
				/**
				* Generate the people list, that contains avatar, handle and profile for each user
				*/
				
				/*
				* Initialise variables of $peopleList, $key and $img according to $_SESSION['sidebar']
				*/
				$key = "";
				switch($_SESSION['sidebar'])
				{
					case "FOUND":
					{
						$peopleList = $found;
						$key = "userID";
						$img = "1";
						break;
					}
					case "FOLLOWING":
					{
						$peopleList = $following;
						$key = "followed";
						$img = "2";
						break;
					}
					case "FOLLOWERS":
					{
						$peopleList = $followers;
						$img = "3";
						$key = "follower";
						break;
					}
					case "FINISH_FOLLOW":
					{
						$img = "0";
						break;
					}
					case "FINISH_UNFOLLOW":
					{
						$img = "0";
						break;
					}
					default:
					{
						$img = "0";
						error("invalid value of _SESSION['sidebar']!");
					}
				}
			
				/*
				* Generate the arrow image according to $img
				*/
				$div = "<div id=\"peoplelistDiv\"  style=\"background-image:url('background/arrow" . $img . ".png'); ";
				if($_SESSION['sidebar'] == "FINISH_FOLLOW" || $_SESSION['sidebar'] == "FINISH_UNFOLLOW" || $_SESSION['sidebar'] == "FORM_NOT_COMPLETED")
					$div = $div . "min-height:150px; text-align:center;";
				$div = $div . "\" >";
				
				echo $div . chr(13).chr(10);
				
				/*
				* Generate the people list according to $peopleList and $key
				*/
				if($key != "")	// generate people list only when to display $found or $following or $followers
				{
					$index = 1;
				
					while($people = mysql_fetch_array($peopleList))
					{
						$peopleID = $people[$key];
						$avatar = $peopleID % 10;
										
						// generate a form		
						echo chr(9).chr(9).chr(9).chr(9) . "<form method=\"post\" action=\"buzzer.php\">" . chr(13).chr(10);
						echo chr(9).chr(9).chr(9).chr(9) . "<div class=\"peopleDiv\">" . chr(13).chr(10);
						
						// generate avata
						echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<div style=\"float:left;\"> <img src=\"avatar/avatar" . $avatar . ".png\" alt=\"avatar\" /> </div>" . chr(13).chr(10);
			
						// generate user handle and userID in hidden form
						echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<div class=\"peopleText\">" . $index . ". " . handle($peopleID) . "</div>" . chr(13).chr(10);
						echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<input name=\"userID\" type=\"hidden\" value=\"" . $peopleID . "\" alt=\"hidden form of userID\"/>" . chr(13).chr(10);
						
						// generate follow or unfollow button, except for admin or current user
						if($peopleID == $_SESSION['currentUser'])
						{
							echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<input name=\"Unavaliable\" type=\"button\" value=\"Must Follow\" class=\"button\" style=\"float:right; padding-left:2px; padding-right:2px;\" alt=\"Must follow button\"/>" . chr(13).chr(10);
						}
						else if($peopleID == 0)
						{
							echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<input name=\"Unavaliable\" type=\"button\" value=\"Cannot Follow\" class=\"button\" style=\"float:right; padding-left:2px; padding-right:2px;\" alt=\"Cannot follow button\"/>" . chr(13).chr(10);
						}
						else
						{
							$isFollowed = follows($_SESSION['currentUser'], $peopleID);
							
							if($isFollowed == 0)
								echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<input name=\"Follow\" type=\"submit\" value=\"Follow\" class=\"button\" style=\"float:right;\" alt=\"Follow button\"/>" . chr(13).chr(10);
							else if($isFollowed == 1)
								echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<input name=\"Unfollow\" type=\"submit\" value=\"Unfollow\" class=\"button\" style=\"float:right;\" alt=\"Unfollow button\"/>" . chr(13).chr(10);
							else
							{
								error("check follow relationship failed");
							}
						}
						
						// generate profile	
						echo chr(9).chr(9).chr(9).chr(9).chr(9) . "<p style=\"clear:both; display:block;\">" . profile($peopleID) . "</p>" . chr(13).chr(10);
						echo chr(9).chr(9).chr(9).chr(9) . "</div>" . chr(13).chr(10);
						echo chr(9).chr(9).chr(9).chr(9) . "</form>" . chr(13).chr(10);
						
						$index++;
					}
				}
				else if($_SESSION['sidebar'] == "FINISH_FOLLOW")	// generate notification when finish following
				{
					echo chr(9).chr(9).chr(9).chr(9) . "<p class=\"notifyText\">You are now following " . handle($_SESSION['buffer']) . "</p>" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9) . "<form method=\"post\" action=\"buzzer.php\"><div><input name=\"Following\" type=\"submit\" value=\"OK\" class=\"okButton\" alt=\"OK button\"/></div></form>" . chr(13).chr(10);
				}
				else if($_SESSION['sidebar'] == "FINISH_UNFOLLOW")	// generate notification when finish unfollowing
				{
					echo chr(9).chr(9).chr(9).chr(9) . "<p class=\"notifyText\">You are no longer following " . handle($_SESSION['buffer']) . "</p>" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9) . "<form method=\"post\" action=\"buzzer.php\"><div><input name=\"Following\" type=\"submit\" value=\"OK\" class=\"okButton\" alt=\"OK button\"/></div></form>" . chr(13).chr(10);
				}
				else if($_SESSION['sidebar'] == "FORM_NOT_COMPLETED")	// generate notification when try to search with uncompleted form
				{
					echo chr(9).chr(9).chr(9).chr(9) . "<p class=\"notifyText\">Please Enter Something to &nbsp; Find People to Follow</p>" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9) . "<form method=\"post\" action=\"buzzer.php\"><div><input name=\"Following\" type=\"submit\" value=\"OK\" class=\"okButton\" alt=\"OK button\"/></div></form>" . chr(13).chr(10);
				}
				
				echo chr(9).chr(9).chr(9) . "</div>" . chr(13).chr(10);
			?>
			<!--===END PeopleList Div  -->
		</div>
		<!--==END People Div -->
	</div>
	<!--=END Sidebar Div -->
		
	<!--=START MiddleWedgeDiv Div -->
	<div class="verticalWedgeDiv">
		<pre> </pre>
	</div>
	<!--=END MiddleWedgeDiv Div -->

	<!--=START Main Div -->
	<div id="mainDiv">
		
		<!--==START Publish Div -->
		<div class="green" id="publishDiv">
			<h2 style="margin-bottom:15px;">Share What's Interesting to You</h2>			
			
			<form id="BuzzArea" method="post" action="buzzer.php">
			<div>
				<textarea name="BuzzText" cols="50" rows="3" onkeyup="displayCharLength()" onkeydown="checkCharLength()" id="buzzTextArea"></textarea>
				<input name="PublishBuzz" type="submit" value="Buzz!&#13;&#10;141" id="buzzButton" alt="Publish buzz input form"/>
			</div>
			</form>
			
			<div style="clear:both; display:block;"><pre> </pre></div>
		</div>
		<!--==END Publish Div -->

		<!--==START Buzzes Div -->
		<div class="green" id="buzzesDiv">
			<h2>Recent Buzzes</h2>
						
			<?php
				/**
				* Generate recent buzzes list, which contains
				* user avatar, handle and buzz content.
				*/
				
				$index = 0;
				foreach($newBuzzes as $record)
				{
					$index++;
					
					$userID = $record['userID'];
					$userHandle = $record['handle'];
					$userBuzz = $record['buzz'];
											
					$avatar = $userID % 10;		// avatar is according to the last digit of userID
					
					echo chr(9).chr(9).chr(9) . "<div class=\"buzzDiv\">" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9) . "<div style=\"float:left;\"> <img src=\"avatar/avatar" . $avatar . ".png\" alt=\"avatar\" /> </div>" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9) . "<div class=\"buzzHandle\"><p style=\"float:left;\">" . $userHandle . "</p> <p style=\"float:left; font-size :12pt; font-weight:500; margin-top:5px;\">&nbsp; said:</p></div>" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9).chr(9) . "<div id=\"buzzText\"> <p style=\"clear:both; display:block;\">" . $userBuzz . "</p> </div>" . chr(13).chr(10);
					echo chr(9).chr(9).chr(9) . "</div>";			
				}
								
				if($index == 0)	// display notity when no new buzzes
				{
					echo chr(9).chr(9).chr(9) . "<p id=\"noBuzzesText\">There are no new Buzzes from people you follow. </p>" . chr(13).chr(10);
				}
			?>
		</div>
		<!--==END Buzzes Div -->
	</div>
	<!--=END Main Div -->
	
	<!--=START RightWedge Div -->
	<div class="verticalWedgeDiv">
		<pre> </pre>
	</div>
	<!--=END RightWedge Div -->
	
	<!--=START Validation Div -->
	<div style="clear:both; display:block;padding-top:30px; margin-top:15px; padding-bottom:10px;">
		<p>
		<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
		<a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a>
		</p>
	</div>
	<!--=END Validation Div -->
	
	<?php } ?>
</body>
</html>
