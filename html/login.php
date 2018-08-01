<?php
require("commonfunctions.php");
session_start();
$user_ip = getUserIP();

echo "<title>DO-Touch.NET - EAC</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
			<meta http-equiv=\"PRAGMA\" content=\"NO-CACHE\">
			<meta http-equiv=\"Expires\" content=\"Tue, 01 Jan 2000 00:00:00 GMT\">
			<meta http-equiv=\"Last-Modified\" content=\" " . gmdate("D, d M Y H:i:s") . " GMT\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-CACHE\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"NO-STORE\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"MUST-REVALIDATE\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"MAX-AGE=0\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"POST-CHECK=0\">
			<meta http-equiv=\"CACHE-CONTROL\" content=\"PRE-CHECK=0\">
			<link rel=\"shortcut icon\ href=\"favicon.ico\">
			<link rel=\"stylesheet\" href=\"styles.css\">
		</head>
		<body>
		<div class=\"base\">
		<center>
		<div class=\"main\">
";

$response = isset($_SESSION['g-recaptcha-response']) ? $_SESSION['g-recaptcha-response'] : '';
$reCAPTCHA = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $response ."";
$verify = file_get_contents($reCAPTCHA);
$captcha_success = json_decode($verify, true);

if ($captcha_success["success"] == true) 
		{
			$user_id =  isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : '';
			$password = isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : '';
			
			$user_QUERY = mysqli_prepare($dblink, "SELECT user_id, name, pass_date, rank, email, initials, study, pass FROM jury_room.logins WHERE (email = ?);");
			mysqli_stmt_bind_param($user_QUERY, 's', $user_id);
				if (mysqli_stmt_execute($user_QUERY))
					{
						mysqli_stmt_bind_result($user_QUERY, $id, $name, $pass_date, $rank, $email, $initials, $study, $passDB);
						mysqli_stmt_fetch($user_QUERY);
						mysqli_stmt_close($user_QUERY);
						if ((strlen($id) > 0) && (password_verify($password, $passDB)))
							{
								$_SESSION["id"] = $id;
								$_SESSION["rank"] = $rank;
								$_SESSION["name"] = $name;
								$_SESSION["email"] = $email;
								$_SESSION["initials"] = $initials;
								$_SESSION["study"] = $study;
								$_SESSION["failed"] = "ALL_IS_PERFECT";
																
								if (!($login_QUERY = $dblink->prepare("INSERT INTO login_history (id, login) VALUES (?, NOW())"))) {logger(__LINE__, "SQLi Prepare: $dblink->error");}
								if (!($login_QUERY->bind_param('s', $id))) {logger(__LINE__, "SQLi Bind Error: $login_QUERY->error");}
								if (!($login_QUERY->execute())) {logger(__LINE__, "SQLi execute: $login_QUERY->error");}
								$login_QUERY->close();
								$dblink->close();
							
								$password_date = date('Y-m-d', strtotime($pass_date));
								$interval = date_diff(date_create(date('Y-m-d')), date_create($password_date));
								
								if ($interval->format('%a') > 90)
									{
										echo "<meta http-equiv=\"Refresh\" content=\"5; url=profile.php\">";
										$_SESSION['pass_fail'] = "Password Expired";
										logger(__LINE__, "--- DB LOOKUP GOOD - Password Expired : " . $user_id . " from " . $user_ip . " ---");
									}
									else
									{
										echo "<meta http-equiv=\"Refresh\" content=\"5; url=main.php\">";
										logger(__LINE__, "--- DB LOOKUP GOOD - PASSWORD GOOD : " . $user_id . " from " . $user_ip . " ---");
									}
							}
						else
							{
								echo "<meta http-equiv=\"Refresh\" content=\"5; url=index.php\">";
								logger(__LINE__, "---DB LOOKUP FAILURE : " . $user_id . " from " . $user_ip . "  ---");
								session_unset();
								$_SESSION["failed"] = "User ID or Password Failure.";
							}
					}
		}
		else
		{
		  echo "<meta http-equiv=\"Refresh\" content=\"5; url=index.php\">";
		  session_unset();
		  $_SESSION["failed"] = "reCAPTCHA Failure.";
		  logger(__LINE__, "---reCAPTCHA FAILURE from " . $user_ip . " ---");
        }

unset($_SESSION['user_id']);
unset($_SESSION['password']);

echo "
	<span class=\"left-box\">
		<center>
		<img src=\"images/updating.gif\"> 
		</center>
	</span>
	<span class=\"left-box\">
		<font size=\"+2\">Processing Request, please wait.</font>
	</span>
";

		
include("footer.php"); 
?>