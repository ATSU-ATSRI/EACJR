<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	require("PHPMailerAutoload.php");
	
	
	echo "
		<div class=\"main\">
		
		<span class=\"left-col\">
			
			<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View Admin Messages</button></a><br />
			<br />
			
		</span>
		
		<span class=\"right-col\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
			}
		
		echo "
		<form name=\"new\" action=\"\" method=\"POST\">
			<table border=\"0\">
			<TR><TD COLSPAN=\"2\">Enter information for the new user.</TD></TR>
			<TR>
				<TD>New user's name:</TD>
					<TD><INPUT type=\"text\" name=\"new_name\" value=\"\" size=\"30\"></TD>
					</TR><TR>
				<TD>New user's initials:</TD>
					<TD><INPUT type=\"text\" name=\"new_initials\" value=\"\" size=\"5\"></TD>
					</TR><TR>
				<TD>New user's email:</TD>
					<TD><INPUT type=\"text\" name=\"new_email\" value=\"\" size=\"30\"></TD>
					</TR><TR>
				<TD colspan=\"2\"><INPUT type=\"submit\" name=\"submit\" value=\"Create user\"></TD>
					</TR>
			</table>
			</form>
			</center>
			</span>
	";

	if (isset($_POST['submit']))
		{
			if (isset($_POST['new_name']) && isset($_POST['new_initials']) && isset($_POST['new_email']))
				{
					$new_name = $_POST['new_name'];
					$new_initials = $_POST['new_initials'];
					$new_email = $_POST['new_email'];					
					
					if (!($check_QUERY = $dblink->prepare("SELECT email FROM logins WHERE email=?"))) { logger("SQLi Prepare: $check_QUERY->error"); }
					if (!($check_QUERY->bind_param('s', $new_email))) { logger("SQLi pBind: $check_QUERY->error"); }
					if (!($check_QUERY->execute())) { logger("SQLi execute: $check_QUERY->error"); }
					if (!($check_QUERY->bind_result($check_user))) { logger("SQLi rBind: $check_QUERY->error"); }
					$check_QUERY->store_result();
					
					if ($check_QUERY->num_rows() < 1)
						{
							$check_QUERY->close();
							
							$pwords1 = array ("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
							$pwords2 = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
							$pwords3 = array ("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
							$pwords4 = Array ("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "-", "?", "~", "_", "=", ">", "<");
							$i = 0;
							$l = 7; //this is how many chars you want MAX
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
							$bypassdate = "1900-01-01";		// used to set the new user's password as expired for first login.
							
							if (!($adduser_QUERY = $dblink->prepare("INSERT INTO jury_room.logins (name, initials, email, pass, pass_date, rank) VALUES (?, ?, ?, ?, ?, 1)"))) { logger("SQLi Prepare: $adduser_QUERY->error"); }
							if (!($adduser_QUERY->bind_param('sssss', $new_name, $new_initials, $new_email, $passer, $bypassdate))) { logger("SQLi pBind: $adduser_QUERY->error"); }
							if (!($adduser_QUERY->execute())) { logger("SQLi execute: $adduser_QUERY->error"); }
							$adduser_QUERY->close();
							
							$admin_name = $_SESSION["name"];
							$admin_email = $_SESSION["email"];
							//send email
							$mail = new PHPMailer();
							$mail->WordWrap = 50;
							$mail->IsHTML(true);
							$mail->Mailer = "smtp";
							$mail->Host = "smtp.gmail.com:587";
							$mail->Username = $mail_username;
							$mail->Password = $mail_password;
							$mail->SMTPAuth = true;
							$mail->Prority = 1;
							$mail->Subject = "DO-Touch.net EAC Portal User created.";
							$mail->From = $mail_username;
							$mail->FromName = "DO-Touch.net EAC";
							$mail->AddReplyTo($mail_username,$mail_username);
							$mail->AddAddress($new_email,$new_email);
							$mail->AddBCC($admin_name,$admin_email);
							
							$email_body = "
								Greetings, $new_name.<br />
								<br />
								A user account has been created for you by $admin_name, in the EAC Portal. <br />
								URL: https://this.website.not.ready <br />
								<br />
								User name: $new_email<br />
								Single use password: $passer<br />
								<br />
								Have a nice day,<br />
								~DO-Touch.net<br />
								";
							$mail->Body = $email_body;
							$mail->AltBody = str_ireplace("<br />","\n",$email_body);
							
							if (!$mail->Send())
								{
									$mailerror = $mail->ErrorInfo;
									logger("PHPMailer Error: $mailerror");
								}
								else
								{
									$mail->ClearAllRecipients();
									$mail->ClearReplyTos();
								}
								
							$dblink->close();
							$_SESSION['pass_fail'] = "User added.";
							$_SESSION['redirect'] = "admin.php";
							header('Location: pause.php');
						}
						else
						{
							$_SESSION['pass_fail'] = "User already exists.";
							$_SESSION['redirect'] = "admin-new.php";
							header('Location: pause.php');
						}
				}
		}
	include("footer.php");
}
?>