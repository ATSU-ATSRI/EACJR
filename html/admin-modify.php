<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	require("PHPMailerAutoload.php");
	
	$mod_id = $_REQUEST['ici'];
	
	if (!($mod_QUERY = $dblink->prepare("SELECT email, `name`, initials, logins.rank, rank.`desc` FROM jury_room.logins INNER JOIN jury_room.rank ON jury_room.logins.rank = jury_room.rank.rank_id WHERE user_id = ?")))  { logger("SQLi Prepare: $mod_QUERY->error"); }
	if (!($mod_QUERY->bind_param('i', $mod_id)))  { logger("SQLi Prepare: $mod_QUERY->error"); }
	if (!($mod_QUERY->execute())) { logger("SQLi execute: $check_QUERY->error"); }
	if (!($mod_QUERY->bind_result($mod_email, $mod_name, $mod_initials, $mod_rank_id, $mod_rank))) { logger("SQLi rBind: $check_QUERY->error"); }
	$mod_QUERY->store_result();
	$mod_QUERY->fetch();
	
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
		<form name=\"mod\" action=\"\" method=\"POST\">
			<table border=\"0\">
			<TR><TD COLSPAN=\"2\">Modify the user's information below.</TD></TR>
			<TR>
				<TD>User's name:</TD>
					<TD><INPUT type=\"text\" name=\"new_name\" value=\"$mod_name\" size=\"30\"></TD>
					</TR><TR>
				<TD>User's initials:</TD>
					<TD><INPUT type=\"text\" name=\"new_initials\" value=\"$mod_initials\" size=\"5\"></TD>
					</TR><TR>
				<TD>User's email:</TD>
					<TD><INPUT type=\"text\" name=\"new_email\" value=\"$mod_email\" size=\"30\"></TD>
					</TR><TR>
				<TD>User's access level:</TD>
					<TD><SELECT name=\"rank\">";
			
			if (!($rank_QUERY = $dblink->prepare("SELECT rank.rank_id, rank.`desc` FROM jury_room.rank"))) { logger("SQLi Prepare: $rank_QUERY->error"); }
			if (!($rank_QUERY->execute())) { logger("SQLi execute: $rank_QUERY->error"); }
			if (!($rank_QUERY->bind_result($rank_id, $rank_desc))) { logger("SQLi rBind: $rank_QUERY->error"); }
			$rank_QUERY->store_result();
			
			while ($rank_QUERY->fetch())
				{
					if ($mod_rank_id == $rank_id)
						{
							echo "<option value=\"$rank_id\" SELECTED>$rank_desc</option>";
						}
						else
						{
							echo "<option value=\"$rank_id\">$rank_desc</option>";
						}
				}
			$rank_QUERY->close();
				
		echo "		</SELECT>
					</TD></TR>	
				<TD>Reset password?</TD>
					<TD><INPUT type=\"checkbox\" name=\"passreset\" value=\"1\" /></TD>
					</TR><TR>
				<TD>Notify user of changes?</TD>
					<TD><INPUT type=\"checkbox\" name=\"notifyuser\" value=\"1\" CHECKED /></TD>
					</TR><TR>
				<TD colspan=\"2\"><INPUT type=\"submit\" name=\"submit\" value=\"Modify user\" /></TD>
					</TR>
			</table>
			</form>
			</center>
			</span>
	";

	if (isset($_POST['submit']))
		{
			$new_name = isset($_POST['new_name']) ? $_POST['new_name'] : $mod_name;
			$new_initials = isset($_POST['new_initials']) ? $_POST['new_initials'] : $mod_initials;
			$new_email = isset($_POST['new_email']) ? $_POST['new_email'] : $mod_email;
			$new_rank_id = isset($_POST['rank']) ? $_POST['rank'] : $mod_rank_id;
			$passreset = isset($_POST['passreset']) ? $_POST['passreset'] : 0;
			$notifyuser = isset($_POST['notifyuser']) ? $_POST['notifyuser'] : 0;
			
			if (isset($new_name) && isset($new_initials) && isset($new_email) && isset($new_rank_id))
				{
					if ($passreset == 1)
						{
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
						}
											
					if ($notifyuser == 1)
						{	
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
							$mail->Subject = "DO-Touch.net EAC Portal User updated.";
							$mail->From = $mail_username;
							$mail->FromName = "DO-Touch.net EAC";
							$mail->AddReplyTo($mail_username,$mail_username);
							$mail->AddAddress($new_email,$new_email);
							$mail->AddBCC($admin_name,$admin_email);
							
							if ($passreset == 1)
								{
									$email_body = "
										Greetings, $new_name.<br />
										<br />
										Your user account has been modified by $admin_name, in the EAC Portal. <br />
										URL: https://this.website.not.ready <br />
										<br />
										User name: $new_email<br />
										Single use password: $passer<br />
										<br />
										Have a nice day,<br />
										~DO-Touch.net<br />
										";
								}
								else
								{
									$email_body = "
										Greetings, $new_name.<br />
										<br />
										Your user account has been modified by $admin_name, in the EAC Portal. <br />
										URL: https://this.website.not.ready <br />
										<br />
										User name: $new_email<br />
										<br />
										Have a nice day,<br />
										~DO-Touch.net<br />
										";
								}
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
						}
											
					if ($passreset == 1)
						{
							$bypassdate = "1900-01-01";		// used to set the new user's password as expired 
							if (!($adduser_QUERY = $dblink->prepare("UPDATE jury_room.logins SET name=?, initials=?, email=?, pass=?, pass_date=?, rank=? WHERE user_id = ?"))) { logger("SQLi Prepare: $update_QUERY->error"); }
							if (!($adduser_QUERY->bind_param('sssssii', $new_name, $new_initials, $new_email, $passer, $bypassdate, $new_rank_id, $mod_id))) { logger("SQLi pBind: $adduser_QUERY->error"); }
						}
						else
						{
							if (!($adduser_QUERY = $dblink->prepare("UPDATE jury_room.logins SET name=?, initials=?, email=?, rank=? WHERE user_id = ?"))) { logger("SQLi Prepare: $update_QUERY->error"); }
							if (!($adduser_QUERY->bind_param('sssii', $new_name, $new_initials, $new_email, $new_rank_id, $mod_id))) { logger("SQLi pBind: $adduser_QUERY->error"); }
						}
					if (!($adduser_QUERY->execute())) { logger("SQLi execute: $adduser_QUERY->error"); }
					$adduser_QUERY->close();	

					$mod_QUERY->close();
					$dblink->close();
					$_SESSION['pass_fail'] = "User modified.";
					$_SESSION['redirect'] = "admin.php";
					header('Location: pause.php');
				}
		}
	include("footer.php");
}
?>