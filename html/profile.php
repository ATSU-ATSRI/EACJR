<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("menu_item.php");

	include("datacon.php");
	$user_QUERY = mysqli_prepare($dblink, "SELECT * FROM jury_room.logins WHERE user_id = ?");
		mysqli_stmt_bind_param($user_QUERY, 's', $id);
		if (mysqli_stmt_execute($user_QUERY))
			{
				mysqli_stmt_bind_result($user_QUERY, $id, $email, $pass, $pass_date, $rank, $name, $initials, $study);
				mysqli_stmt_fetch($user_QUERY);
					if (strlen($id) > 0)
						{
							$name = isset($name) ? $name : '';
							$initials = isset($initials) ? $initials : '';
							
							echo "
							<div class=\"main\">";
							
							if (isset($_SESSION['pass_fail']))
								{
									echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
									unset($_SESSION['pass_fail']);
								}
							/* echo "<form name=\"profile\" action=\"\" method=\"POST\">
									<span class=\"left-box\">
										<table border=\"0\">
											<TR><TD COLSPAN=\"2\" width=\"100%\">Current Profile Settings</TD></TR>
											<TR><TD COLSPAN=\"2\" width=\"100%\"><br /></TD></TR>
											<TR>
												<TD width=\"40%\">Your name:</TD>
												<TD width=\"60%\"><INPUT type=\"text\" name=\"name\" value=\"$name\" size=\"30\"></TD>
											</TR><TR>
												<TD width=\"40%\">Your initials:</TD>
												<TD width=\"60%\"><INPUT type=\"text\" name=\"initials\" value=\"$initials\" size=\"5\"></TD>
											</TR><TR>
												<TD width=\"40%\">Your email:</TD>
												<TD width=\"60%\"><INPUT type=\"text\" name=\"email\" value=\"$email\" size=\"30\"></TD>
											</TR><TR>
												<TD colspan=\"2\" width=\"100%\"><INPUT type=\"submit\" name=\"submit\" value=\"Change profile\"></TD>
											</TR>
										</table>
									</span>
									
									<span class=\"left-box\">";*/
									
								echo "<form name=\"profile\" action=\"\" method=\"POST\">
									<span class=\"left-box\">
										
										<div class=\"ft-head\"><br />Current Profile Settings<br /><br /></div>
										<div class=\"ft\">
											<div>Your name:</div>
											<div><INPUT type=\"text\" name=\"name\" value=\"$name\" size=\"30\"></div>
											<div>Your initials:</div>
											<div><INPUT type=\"text\" name=\"initials\" value=\"$initials\" size=\"5\"></div>
											<div>Your email:</div>
											<div><INPUT type=\"text\" name=\"email\" value=\"$email\" size=\"30\"></div>
										</div>
										<div class=\"ft-head\"><br /><INPUT type=\"submit\" name=\"submit\" value=\"Change profile\"><br /><br /></div>
										
									</span>
									
									<span class=\"left-box\">";
									
									echo "<div class=\"ft-head\"><br />Do you want to change your password?<br /><br /></div>
											<div class=\"ft\">
												<div> Pasword rules: </div>
												<div>	Password length must be greater than six digits.<br />
														Password must contain at least one capital letter.<br />
														Password must contain at least one lowercase letter.<br />
														Password must contain at least one number.<br />
														Password must contain at least one of the following: !, @, #, $, %, ^, &, *, (, ), +, -, ?, ~, _, =, >, <.<br />
												</div>
												<div>Enter current Password</div>
												<div><INPUT type=\"password\" name=\"curr_pass\" size=\"30\"></div>
												<div>Enter new Password</div>
												<div><INPUT type=\"password\" name=\"new_pass1\" size=\"30\"></div>
												<div>Enter new Password again</div>
												<div><INPUT type=\"password\" name=\"new_pass2\" size=\"30\"></div>
											</div>
											<div class=\"ft-head\"><br /><INPUT type=\"submit\" name=\"submit\" value=\"Change password\"><br /><br /></div>
										</span>
								</form>";
						}
					mysqli_stmt_close($user_QUERY);
					//mysqli_close($dblink);
					
				if (isset($_POST['submit']))
					{
						if ($_POST['name'] !== $name) 
							{
								$name = $_POST['name'];
								$set = 1;
							}
						if ($_POST['initials'] !== $initials)
							{
								$initials = $_POST['initials'];
								$set = 1;
							}
						if ($_POST['email'] !== $email)
							{
								$email = $_POST['email'];
								$set = 1;
							}
						
						$pass_fail = " ";
						if (isset($_POST['curr_pass']))
							{
								if (($_POST['curr_pass']) == $pass)
									{
										if ($_POST['new_pass1'] == $_POST['new_pass2'])
										{
											if ($_POST['new_pass1'] == $pass)
												{
													$pass_fail = "Your new password can not be the same as the current password.";
												}
												else
												{
													if (strlen($_POST['new_pass1']) < 6) {$pass_fail .= "Password length must be greater than six digits.<br/ >";}
													if (strpbrk($_POST['new_pass1'], 'abcdefghijklmnopqrstuvwxyz') == FALSE) {$pass_fail .= "Password must contain at least one lowercase letter.<br />";}
													if (strpbrk($_POST['new_pass1'], 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') == FALSE) {$pass_fail .= "Password must contain at least one capital letter.<br />";}
													if (strpbrk($_POST['new_pass1'], '1234567890') == FALSE) {$pass_fail .= "Password must contain at least one number.<br />";}
													if (strpbrk($_POST['new_pass1'], '!@#$%^&*()+-?~_=><') == FALSE) {$pass_fail .= "Password must contain at least one of the following: !, @, #, $, %, ^, &, *, (, ), +, -, ?, ~, _, =, >, <.<br />";}
											
													if (strlen($pass_fail) < 2)
														{
															$pass = $_POST['new_pass1'];
															$pass_date = date('Y-m-d');
															$set = 1;
														}
												}
										}
										else
										{
											$pass_fail = "New passwords do no match.";
										}
									}
									else
									{
										$pass_fail = "Current password is incorrect.";
									}
							}
						
						if (($set == 1) && (strlen($pass_fail < 2)))
							{
								if (!($update_QUERY = $dblink->prepare("UPDATE jury_room.logins SET email=?, pass=?, pass_date=?, name=?, initials=? WHERE user_id=?"))) {logger("SQLi Prepare: $update_QUERY->error");}
								if (!($update_QUERY->bind_param('ssssss', $email, $pass, $pass_date, $name, $initials, $id))) { logger("SQLi Bind Error: $update_QUERY->error"); }
								if (!($update_QUERY->execute())) { logger("SQLi execute: $update_QUERY->error"); }
								$update_QUERY->close();
								$dblink->close();
								$_SESSION['pass_fail'] = "Your settings have been changed.";
								$_SESSION['redirect'] = "profile.php";
								header('Location: pause.php');
							}
							else
							{
								$_SESSION['pass_fail'] = $pass_fail;
								header('Location: profile.php');
							}
					}
			}
			else
			{
				echo "<meta http-equiv=\"Refresh\" content=\"5; url=index.php\">";
				logger("---DB LOOKUP FAILURE : " . $id . " ---");
				session_unset();
				$_SESSION["failed"] = "User ID or Password Failure.";
			}
			
	include("footer.php");
}
?>