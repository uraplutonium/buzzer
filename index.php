<?php
	/**
	* This is the index page of Buzzer website.
	* It provides functionality of login and register.
	* 
	* Candidate number:Y7759874
	*/
	
	//initialisation of session and import requied php functions
	session_start();
	require_once('/n/www/student/projects/dweb-shared/DWEBfunctions.php');
	require_once('functions.php');
	InitIndexSession();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<?php
	/**
	* Responses for page jumps.
	* Php functions will be called according to $_POST['buttonName']
	* when a form is submited to this index.php.
	* All the information about how the following part of this page looks like
	* will be generated and saved in five variables in $_SESSION['keyName']
	*/

	// response php codes must be before the hidden form or any other php using $_SESSION
	if($_POST['Login'])
	{
		//echo "Login";
		LoginUser();
	}
	else if($_POST['Register'])
	{
		//echo "Register";
		RegisterUser();
	}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	
	<?php
		/**
		* Generate a meta to jump to buzzer.php according to value of $_SESSION['page']
		*/
		
		if($_SESSION['page'] == "BUZZER")
		{
			echo chr(9) . "<meta http-equiv=\"refresh\" content=\"0; url=buzzer.php\"/>" . chr(13).chr(10);
		}
		else if($_SESSION['page'] != "INDEX")
		{
			error("_SESSION['page'] error!");
		}
	?>
	
	<!-- Link css file -->
	<link rel="stylesheet" type="text/css" href="style.css" />
	
	<title>Buzzer - Login</title>
</head>

<body>
	<!--=START TopBar Div -->
	<div id="topBarDiv">
		<h1> <a id="homeLink" href="index.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		Buzzer</a> </h1>	
	</div>
	<!--=END TopBar Div -->
	
	<!--=START Wedge Div -->
	<div id="wedgeDiv">
		<pre> </pre>
	</div>
	<!--=END Wedge Div -->
	
	<!--=START Center Div -->
	<div id="centerDiv">
		
		<!--==START Left Div -->
		<div id="leftDiv">
		
			<!--===START Login Div -->
			<div class="green" id="loginDiv">
				<form method="post" action="index.php">
					<div>
						<h2>Login</h2>
						<h3>Username</h3>
						<input name="LoginHandle" type="text" size="25" maxlength="255" alt="Login handle input form"/>
						<h3>Password</h3>
						<input name="LoginPassword" type="password" size="25" maxlength="255" alt="Login password input form"/>
						<br/>
												
						<?php
							/**
							* Generate a line of warning about invalid input from the form
							* according to value of $_SESSION['status'].
							*/
							
							switch($_SESSION['status'])
							{
								case "NOT_COMPLETED_LOGIN":
								{
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\">Please enter username and password</p>" . chr(13).chr(10);
									break;
								}
								case "WRONG_LOGIN_HANDLE_PWD":
								{
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\">Wrong Username or Password</p>" . chr(13).chr(10);
									break;
								}
								case "NORMAL":
								{
									// A normal situation, print a <br/>
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\"><br/></p>" . chr(13).chr(10);
									break;
								}
								default:
								{
									// This branch should not be executed. Put debug codes here.
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\"><br/></p>" . chr(13).chr(10);
								}
							}	
						?>

						<input name="Login" type="submit" value="Login" class="button" alt="Login button"/>
					</div>
				</form>
			</div>
			<!--===END Login Div -->
			
			<!--===START Register Div -->
			<div class="green" id="registerDiv">
				<form method="post" action="index.php">
					<div>
						<h2>Register</h2>
						<h3>New Username</h3>
						<input name="RegisterHandle" type="text" size="25" maxlength="255" alt="Register handle input form"/>
						<h3>Password</h3>
						<input name="RegisterPassword1" type="password" size="25" maxlength="255" alt="Register password1 input form"/>
						<h3>Comfirm Password</h3>
						<input name="RegisterPassword2" type="password" size="25" maxlength="255" alt="Register password2 input form"/>
						<h3>New Profile</h3>
						<input name="RegisterProfile" type="text" size="25" maxlength="4096" alt="Register profile input form"/>
						<br/>
						
						<?php
							/**
							* Generate a line of warning about invalid input from the form
							* according to value of $_SESSION['status'].
							*/

							switch($_SESSION['status'])
							{
								case "NOT_COMPLETED_REGISTER":
								{
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\">Please enter all register details</p>" . chr(13).chr(10);
									break;
								}
								case "UNAVALIBALE_REGISTER_HANDLE":
								{
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\">This username has been registered</p>" . chr(13).chr(10);
									break;
								}
								case "UNAVALIBALE_REGISTER_PASSWORD":
								{
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\">Passwords do not match</p>" . chr(13).chr(10);
									break;
								}
								case "NORMAL":
								{
									// A normal situation, print a <br/>
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\"><br/></p>" . chr(13).chr(10);
									break;
								}
								default:
								{
									// This branch should not be executed. Put debug codes here.
									echo chr(9).chr(9).chr(9).chr(9).chr(9).chr(9) . "<p class=\"alertText\"><br/></p>" . chr(13).chr(10);
								}
							}	
						?>
						
						<input name="Register" type="submit" value="Register" class="button" alt="Register button"/>
					</div>
				</form>
			</div>
			<!--===END Register Div -->
		</div>
		<!--==END Left Div -->
	
		<!--==START Logo Div -->
		<div class="white" id="logoDiv">
			<h2>
				<input name="WelcomeImg" type="image" alt="Welcome to Buzzer! Buzz Your Life to... Share with Friend, Share with Lover, Share with Family." src="welcome.png"/>
			</h2>
		</div>
		<!--==END Logo Div -->
	
	</div>
	<!--=END Center Div -->

	<!--=START Validation Div -->
	<div style="clear:both; display:block;padding-top:30px; margin-top:15px; padding-bottom:10px;">
		<p>
		<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
		<a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a>
		</p>
	</div>
	<!--=END Validation Div -->
		
</body>
</html>
