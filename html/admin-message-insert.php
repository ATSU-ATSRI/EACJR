<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");

	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
				unset($_SESSION['pass_fail']);
			}
		
	echo "	<span class=\"left-col\">
			
			<a href=\"admin-new.php\"><button type=\"button\">Add new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-message.php\"><button type=\"button\">View Admin Messages</button></a><br />
			<br />
			
		</span>
		
		<span class=\"right-col\">
		
		<table border=\"0\" width=\"100%\">
			<TR>
				<TH> Message </TH>
			</TR>		
			<form name=\"editmsg\" method=\"post\">
			<TR><TD> Subject : <input type=\"text\" size=\"60\" name=\"subject\" value=\"\"></TD></TR>
			<TR><TD><textarea name=\"msg_text\" cols=\"70\" rows=\"4\" wrap=\"physical\"></textarea></TD></TR>
		</table>
	<input type=\"submit\" name=\"submit\" value=\"Save Message\">
	</form>
	</span>";
	
	if (isset($_POST['submit']))
		{
			if (isset($_POST['subject']) && isset($_POST['msg_text']))
				{
					$msg_subject = $_POST['subject'];
					$msg_text = $_POST['msg_text'];
					$msg_text .= " (Posted " . date('Y-m-d Hi') . ")";
					
					if (!($update_QUERY = $dblink->prepare("INSERT INTO jury_room.message (subject, text) VALUES(?, ?)"))) {logger("SQLi Prepare: $update_QUERY->error");}
					if (!($update_QUERY->bind_param('ss', $msg_subject, $msg_text))) { logger("SQLi Bind Error: $update_QUERY->error"); }
					if (!($update_QUERY->execute())) { logger("SQLi execute: $update_QUERY->error"); }
					$update_QUERY->close();
					$dblink->close();
					$_SESSION['pass_fail'] = "Message Added.";
					$_SESSION['redirect'] = "admin-message.php";
					header('Location: pause.php');
				}
				else
				{
					$_SESSION['pass_fail'] = "You have to enter a message to save a message, Duh!";
					header('Location: admin-message-insert.php');
				}
		}
	
	include("footer.php");
}
?>