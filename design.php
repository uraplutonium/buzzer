<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<title>Design Report</title>
</head>

<body>

	<h3>Candidate number:Y7759874</h3>
	
	<h1>1.Functionality</h1>
		The Buzzer website has implements all the required functionalities and a bit more functions are also implemented.
		
		<h2>1.index.php</h2>
			<p>User could login and register in the index.php.</p>
			
			<h3>1.Login</h3>
				<p>When login, the website will check whether the input handle and password is null. It will only query the database when both handle and password is entered. A warning will be displayed when the handle does not exist or the password is wrong. And the page will jump to buzzer.php when correct handle and password is entered. When login, thisLogin value in the database will be updated as the current server time.</p>
			
			<h3>2.Register</h3>
				<p>When register a new user, the website will also check whether all forms submited are not empty. And a warning will be displayed when trying to register a user with a handle that already used. When all valid information is submited, register success, the page will jump to the buzzer.php which means now user is login.</p>
			
		<h2>2.buzzer.php</h2>
			<p>buzzer.php is the homepage that provide most of the functionalities.</p>
			
			<h3>1.View current user's handle and profile</h3>
				<p>The current user's handle and profile will be displayed at the left-top part of homepage. The avatar of user will also be displayed there.</p>
			
			<h3>2.Search on handles</h3>
				<p>User could use the search bar on the left sidebar to find people by their handle. By enter the pattern in to the text box and click "Find People" button, or directly press enter key, all searching results will be displayed below the search text box and the "Find People" button in the left sidebar. All user with a handle that contains the pattern will be displayed in the results. In the searching results, handle and profile of each users will be shown. And the current user could choose to follow or unfollow a particular user by click the "Follow" or "Unfollow" button at the right side of each user's handle.</p>
				
			<h3>3.List the people following the current user</h3>
				<p>The people list of those that are following the current user will be shown on the left sidebar. User could view the handle and profile and avatar for each of the people. A "Follow" or "Unfollow" button will be displayed on the right side of each users' handle. The sidebar will only display one of the following: searching results, following people list, followers. User could use the "Followers" button to swith to the people list.</p>
			
			<h3>4.List the people current user are following</h3>
				<p>The people list of those that the current user is following will be shown on the left sidebar. User could view the handle and profile and avatar for each of the people. A "Follow" or "Unfollow" button will be displayed on the right side of each users' handle. The sidebar will only display one of the following: searching results, following people list, followers. User could use the "Following" button to swith to the people list.</p>
			
			<h3>5.Follow a people</h3>
				<p>On the left side bar, one of the people list of searching results, or following, or followers, provides a "Follow" button for each people in the list. User could click the "Follow" button to follow a particular person. Only for people who is not followed by current user will be displayed a "Follow" button. When administrator is displayed, the button is shown as "Cannot Follow", which will do nothing after click it.</p>
			
			<h3>6.Unfollow a people</h3>
				<p>On the left sidebar, one of the poeple list of searching results, or following, or followers, provides a "Unfollow" button for each people in the list. User could click the "Unfollow" button to unfollow a particular person. Only for people who is already followed by the current user will be displayed a "Unfollow" button. When the current user himself is displayed, the button is shown as "Must Follow", which will do nothing after click it.</p>
			
			<h3>7.Publish a buzz</h3>
				<p>User could publish a new buzz by enter content into the textarea at the right-top part of homepage. The limit of length of buzz will be displayed at the "Buzz" button and will update while user is typing. After click the "Buzz" button, new buzz is published successfully.</p>
			
			<h3>8.View recent buzz from people that current user is following</h3>
				<p>All recent buzz from poeple that current user is following will be displayed at the "Recent Buzz" part. These buzzes will be those published between current user's last login and this login. For each recent buzzes, the publisher's handle, avatar, and the buzz content will be shown one by one.</p>	
				
			<h3>9.Deregister</h3>
				<p>User could deregister himself by clicking the "Deregister" button at the most right-top corner of homepage. And a confirm message box will be shown. Only if user click "Yes", will he/she be deregistered.</p>
			
			<h3>10.Logout</h3>
				<p>User could logout by clicking the "Logout" button at the most right-top corner of the homepage. The lastLogin in datebase will be set as thisLogin time, and thisLogin time will be set as null. After that, the login page will be shown.</p>

	<h1>2.Usability</h1>
		<p>The Buzzer website follows 8 of the ten Nielsen's heuristics well as described below.</p>

		<h2>1.Visibility of system status</h2>
			<p>First, after follow or unfollow another user, a notification of completing the operation is displayed on the left sidebar to make user know operation is done successfully.</p>

			<p>Secondly, the number of characters left that could be entered by user is displayed on the publish buzz button, namely 141 minuse the current number of characters in the text area. This function could make users clear about how much more space could use to express their ideas.</p>

			<p>Thirdly, there are three buttons on the left sidebar which are "Find People", "Following" and "Followers". One of the people list accoding to the buttons will be displayed on the left sidebar. To make it clear that which people is currently displayed, the relevant button is dark in color and font is bold. Also there is an arrow below a particular button to show the user which people list is the current sidebar.</p>

		<h2>2.Match between system and the real world</h2>
			<p>First, Show the user's "handle" as "Username". Users may be confused by "handle". So it is better to use "Username" which is easier for user to understand.</p>

			<p>Second, show a word "said" after the users' names in the recent buzz part. Namely, a user called "Username" publish a buzz "This is the buzz", on the recent buzz div it will be displayed as "Username said: This is the buzz". This could make users be clear that the context below username is his/her buzz, not something else, such like profile.</p>

			<p>Thirdly, above the text area to publish a buzz, it is writtern that "Share What's Interesting to You" instead of simply "insert a buzz to database", using words familar to user, </p>

		<h2>3.User control and freedom</h2>
			<p>The logo on the left-top of pages is a link that could make the website jump to the default page. For example, in the buzzer.php, when click the logo, the page will refresh and display default information.</p>

		<h2>4.Consistency and standards</h2>
			<p>The black top bar is kept in all pages, even in the login page the top bar only provides function to refresh. However, this could make users be aware of they are still in the buzzer website.</p>

		<h2>5.Error prevention</h2>
			<p>First, according to the reqirement, users should not follow the administrator, and the website also make user follow him/herself when register. To achieve this, it is better to make user unable to follow administrator or unfollow himself. As a result, when display the people list on the lfet sidebar, the follow/unfollow button will be displayed as "Must Follow" if it is the administrator, and will be displayed as "Cannot Unfollow" if it is the user himself. And no operation to the database will be undertook when clicking such two type of buttons.</p>

			<p>Similarly, it does not make sence to follow a person that user is already following, or unfollow a person that is not following yet. So the follow/unfollow will automatically displayed as the operation that user could do. For instance, when display a person that current user is following in the people list, the button will be displayed as "Unfollow" because this is the only meaningful operation that user could do.</p>

			<p>Secondly, the buzz must be equals to or less than 141 characters. Rather than give users a warning when try to submit a buzz more than 141 characters, it is better to make users unable to enter a buzz longer than 141. By using javascript, the text area will only allow user to enter context equals to or less than 141.</p>
			
			<p>Thirdly, some measures have been token to prevent user go to buzzer.php directly without login. Namely, if user type in buzzer.php in browser, the website will jump back to index.php immediately. As a result, user will not go to uncorrect pages and many other potential errors are avoided.</p>
			
		<h2>6.Recognition rather than recall</h2>
			<p>This is not highlighted in the website.</p>

		<h2>7.Flexibility and efficiency of use</h2>
			<p>The Buzzer website could allow both inexperienced and experienced users.</p>

			<p>For novice users, it is easy to do all operations by click buttons, such like login or show the followers list.</p>

			<p>For experienced users, especially those who are skilled in using keyboard, the website allow them to accelerate operations. All operations in the website could be done by only using keyboard. For example, when login or search people, user only need to enter the required information in textbox, and press enter key directlly instead of click button by mouse.</p>

		<h2>8.Aesthetic and minimalist design</h2>
			<p>The design of website follows the minimalist principle. Related functions have been put together. Such like login and register, because when a user want to use this website, user actually wants to login or register if it is the first time. And also all other functionality have been integrated in one page.</p>

			<p>Also, because the operation of finding people, showing following people list and showing followers list is similar, they are integrated into the left sidebar. One list will be displayed one time and user could choose which to show. Amount of pages has been reduced and distribution of functions has been optimized.</p>

		<h2>9.Help user recognize, diagnose, and recover from errors</h2>
			<p>A number of warning could be given when user enter some invalid input. For instance, when submitting uncompleted form to login or register, on login page a warning of "Please enter username and password" or "Please enter all register details" will be displayed. Also when user trying to login with a wrong username or password, or trying to register with a handle that already been used, warning will be displayed.</p>

		<h2>10.Help and documentation</h2>
			<p>Some warning have been implemented to help user recognize errors as shown in point 9. But no documentation about this website.</p>

	<h1>3.Standard conformance</h1>
		<p>All the two webpages index.php and buzzer.php have been validated and passed as XHTML 1.0 strict and CSS 2. The validation tools used are:</p>
		<a href="http://validator.w3.org/">W3C Markup Validation Service</a>
		<a href="http://jigsaw.w3.org/css-validator/">W3C CSS Validation Service</a>

	<h1>4.Accessibility</h1>

		<p>This Buzzer website has been validated by two tools against WCAG 1.0 A Level and successfully pass.</p>
		<p>The two tools are:</p>
		<a href="http://achecker.ca/checker/index.php">AChecker</a>
		<a href="http://www.cynthiasays.com/">HiSoftware Cynthia</a>

		<p>Besides validating by tools, the website is also check manually against the priority 1 WCAG 1.0 check point one by one. And has been considered pass all the check points.</p>
		 
		<h2>Check Point 1.2</h2>
			<p>Not applicable. Because no active area of image map is used in the website.</p>

		<h2>Check Point 1.3</h2>
			<p>Not applicable. Because no multimedia is used in the website.</p>

		<h2>Check Point 1.4</h2>
			<p>Not applicable. Because no time-based multimedia is used in the website.</p>

		<h2>Check Point 2.1</h2>
			<p>All the two pages have been checked that, the information provided by the webpage could still be read clearly even remove all the colours.</p>

		<h2>Check Point 4.1</h2>
			<p>All "HTML" elements in two pages have been marked "xml:lang='en'".</p>

		<h2>Check Point 5.1</h2>
			<p>Not applicable. Because no TABLE elements are used in the website.</p>

		<h2>Check Point 5.2</h2>
			<p>Not applicable. Because no TABLE elements are used in the website.</p>

		<h2>Check Point 6.1</h2>
			<p>By using firefox plugin "Developer" to disable CSS, all functionality works well and information could be read clealy.</p>

			<p>By remove the style.css, in which most css style is defined, all functionality works well and information could be read clealy.</p>

		<h2>Check Point 6.2</h2>
			<p>Not applicable. Because no FRAME elements are used in the website.</p>

		<h2>Check Point 6.3</h2>
			<p>By using firefox plugin "Developer" to disable JavaScript, all functionality works well, including text area to publish a buzz and the deregister button.</p>

		<h2>Check Point 7.1</h2>
			<p>Not applicable. Because no BLINK or MARQUEE elements are used in the website.</p>

		<h2>Check Point 8.1</h2>
			<p>The website only used JavaScript, but not Applet. After checking, as long as the browser enables JavaScript, the non-functional effects could be achieved, such like display the left buzz length and showing a warning before deregister.</p>

		<h2>Check Point 9.1</h2>
			<p>Not applicable. Because no server-side image map INPUT elements are used in the website.</p>

		<h2>Check Point 11.4</h2>
			<p>Not applicable. Because no external links are used in the website. Only relative url that linking to index.php or buzzer.php are used.</p>

		<h2>Check Point 12.1</h2>
			<p>Not applicable. Because no FRAME elements are used in the website.</p>

		<h2>Check Point 14.1</h2>
			<p>After checking, content in the website has been used as clear and simple as possible.</p>

	<h1>5.Errors</h1>
		<p>The website has been carefully checked and tested. And when user input an invalid information, such like empty password when login, there will be a warning given for the user. When there is any fault on connecting database, an error message will be sent to the "Adim".</p>

	<h1>6.Design</h1>
		<h2>1.Color design</h2>
			<p>Monochromatic color scheme has been used in the website. The main color is light green with simple black, white and grey. Both in the login page and the homepage, several div have been set light green as background. And the top bar is set dark grey as background. By applying Monochromatic color scheme, website could look balance and friendly.</p>

		<h2>2.Three-Click Rule</h2>
			<p>The website has been designed as simple as possible so that users could do any operations within 3 clicks starting from login page.</p>

			<p>For example, to follow a people after serching his username, the current user need to type in his username and password and CLICK login button. Then type in the username in the searching textbox and CLICK find people button. In the end, find the correct people from the searching results list and CLICK follow button.</p>

		<h2>3.Cross-platform design</h2>
			<p>This website is designed as platform independent.</p>

			<p>First, the website is designed and implemented works well in severl popular browsers: IE9, Firefox, Chrome and Opera. There may be slightly difference in styles but all functionalities works well in these four browsers.</p>

			<p>Secondly, the website is designed and implemented works on different operation system. It has been tested in firefox in Ubuntu Linux and firefox in Windows7. There are slightly difference between the lentgh of text box but all functionalities works well.</p>

			<p>Thirdly, the website is designed and implemented works in different resolutions. It has been tested that all functionalities works well from 800*600 resolution to resolution1680*1050. And layout of the website may be effected with resolution smaller than 1280*768, and it displayed well with resolution larger than 1280*768.</p>
			
	<h1>7.Modularity</h1>
		<p>There are two php file for the website to display webpages:</p>
			<a href="index.php">index.php</a>
			<a href="buzzer.php">buzzer.php</a>
		<p>and one php file providing all required functions:</p>
			<a href="function.php">function.php</a>
		<p>and one css file providing most of css styles:</p>
			<a href="style.css">style.css</a>
		<p>To reduce the number of distingct pages, the main functionalities are integrated into the buzzer.php. And all php functions that operating database are all in function.php to make it easier to maintain codes. CSS is separate from the content since styles are saved in a single css file, to make it more flexible to apply other styles.</p>

	<h1>Reference</h1>
		<p>[1] Classic Color Schemes (2012, Apr, 29). Monochromatic color scheme[On-line]. Available at: http://www.color-wheel-pro.com/color-schemes.html#monochromatic</p>
		<p>[2] Web Content Accessibility Guidelines 1.0, W3C Recommendation, 5-May-1999.</p>

	<div style="clear:both; display:block;padding-top:30px; margin-top:15px; padding-bottom:10px;">
		<p>
		<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
		</p>
	</div>
	
</body>
