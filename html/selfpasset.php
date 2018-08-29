<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

require("commonfunctions.php");
include_once "libphp-phpmailer/PHPMailerAutoload.php";
session_start();
$user_ip = getUserIP();

echo "<title>$mail_sig - EAC</title>
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

	<span class=\"left-box\">
		<center>
		Please check your email in the next few minutes for a password reset email.
		</center>
	</span>
	<span class=\"left-box\">
		<img src=\"images/logo.jpg\" alt=\"Logo for $mail_sig\" width=\"307px\" height=\"141px\">
	</span>
";

$response = isset($_SESSION['g-recaptcha-response']) ? $_SESSION['g-recaptcha-response'] : '';
$reCAPTCHA = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $response ."";
$verify = file_get_contents($reCAPTCHA);
$captcha_success = json_decode($verify, true);

if ($captcha_success["success"] == true) 
		{
			$user_id =  isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : '';
				
			if (!($chkuser_QUERY = $dblink->prepare("SELECT user_id, name FROM jury_room.logins WHERE (email = ?);")));
			if (!($chkuser_QUERY->bind_param('s', $user_id))) { logger(__LINE__, "SQLi pBind: $chkuser_QUERY->error"); }
			if (!($chkuser_QUERY->execute())) { logger(__LINE__, "SQLi execute: $chkuser_QUERY->error"); }
			if (!($chkuser_QUERY->bind_result($new_email, $new_name))) { logger(__LINE__, "SQLi rBind: $chkuser_QUERY->error"); }
			$chkuser_QUERY->store_result();
			$chkuser_count = $chkuser_QUERY->num_rows;
			
			if ($chkuser_count > 0)
				{
					$pwords1 = array ("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
					$pwords2 = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
					$pwords3 = array ("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
					$pwords4 = Array ("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "-", "?", "~", "_", "=");
					$i = 0;
					$l = 7;
					$passer = "";
					$temp = "";

						$block = rand(1,2);
							if ($block == 1)
								{ 
									$temp = array_rand($pwords1, 1);
									$passer .= $pwords1[$temp];
									$i++;
								}
							else
								{ 
									$temp = array_rand($pwords2, 1);
									$passer .= $pwords2[$temp];
									$i++;
								}

							while ($i < $l)
								{
									$block = rand(1,4);
									if ($block == 1)
										{ 
											$temp = array_rand($pwords1, 1);
											$passer .= $pwords1[$temp];
											$i++;
										}
									elseif ($block == 2)
										{ 
											$temp = array_rand($pwords2, 1);
											$passer .= $pwords2[$temp];
											$i++;
										}
									elseif ($block == 3)
										{ 
											$temp = array_rand($pwords3, 1);
											$passer .= $pwords3[$temp];
											$i++;
										}
									else
										{ 
											$temp = array_rand($pwords4, 1);
											$passer .= $pwords4[$temp];
											$i++;
										}
								}
					$bypassdate = "1900-01-01";
					$passerDB = password_hash($passer, PASSWORD_BCRYPT, $options);
					if (!($adduser_QUERY = $dblink->prepare("UPDATE jury_room.logins SET pass=?, pass_date=? WHERE email = ?"))) { logger(__LINE__, "SQLi Prepare: $update_QUERY->error"); }
					if (!($adduser_QUERY->bind_param('sss', $passerDB, $bypassdate, $user_id))) { logger(__LINE__, "SQLi pBind: $adduser_QUERY->error"); }
					if (!($adduser_QUERY->execute())) { logger(__LINE__, "SQLi execute: $adduser_QUERY->error"); }
					$adduser_QUERY->close();
					
					$mail = new PHPMailer();
					$mail->WordWrap = 50;
					$mail->IsHTML(true);
					$mail->Mailer = "smtp";
					$mail->Host = $mail_host;
					$mail->Username = $mail_username;
					$mail->Password = $mail_password;
					$mail->SMTPAuth = true;
					$mail->Prority = 1;
					$mail->Subject = "$mail_sig EAC Portal User updated.";
					$mail->From = $mail_username;
					$mail->FromName = "$mail_sig EAC";
					$mail->AddReplyTo($mail_username,$mail_username);
					$mail->AddAddress($user_id,$user_id);
						$email_body = "
							Greetings, $new_name.<br />
											<br />
												Your user account has been modified in the EAC Portal. <br />
												URL: $host_url <br />
												<br />
												Single use password: $passer<br />
												<br />
												Have a nice day,<br />
												~$mail_sig<br />
												";			
						$mail->Body = $email_body;
						$mail->AltBody = str_ireplace("<br />","\n",$email_body);
									
					if (!$mail->Send())
						{
							$mailerror = $mail->ErrorInfo;
							logger(__LINE__, "PHPMailer Error: $mailerror");
						}
						else
						{
							$mail->ClearAllRecipients();
							$mail->ClearReplyTos();
						}

				}
			logger(__LINE__, "---Password reset requested for $new_name - $user_id from " . $user_ip . " ---");
			$user_QUERY->close();
			$dblink->close();
		}
		else
		{
			  echo "<meta http-equiv=\"Refresh\" content=\"5; url=index.php\">";
			  $_SESSION["failed"] = "reCAPTCHA Failure.";
			  logger(__LINE__, "---reCAPTCHA FAILURE from " . $user_ip . " ---");
        }


unset($_SESSION['user_id']);	
session_unset();	
include("footer.php"); 
?>