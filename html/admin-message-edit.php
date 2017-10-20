<?php
include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("datacon.php");
	include("menu_item.php");
	$msg_id = $_REQUEST['tag'];
	
	if (!($msg_QUERY = $dblink->prepare("SELECT id, subject, text, active FROM jury_room.message WHERE (id = ?);"))) {logger("SQLi Prepare: $msg_QUERY->error");}
	if (!($msg_QUERY->bind_param('s', $msg_id))) {logger("SQLi pBind: $msg_QUERY->error");}
	if (!($msg_QUERY->execute())) {logger("SQLi execute: $msg_QUERY->error");}
	if (!($msg_QUERY->bind_result($msg_id, $msg_subject, $msg_text, $msg_active))) {logger("SQLi rBind: $msg_QUERY->error");}
	$msg_QUERY->store_result();
		
	
	echo "
		<div class=\"main\">
		
			<span class=\"left-col\">
			
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
				<input type=\"hidden\" value=\"$msg_id\">
		";
		
		if (($msg_QUERY->num_rows) > 0)	
			{
				while($msg_QUERY->fetch())
					{
						echo "	<TR><TD> Subject : <input type=\"text\" size=\"60\" name=\"subject\" value=\"$msg_subject\"> </TD></TR>
								<TR><TD><textarea name=\"msg_text\" cols=\"70\" rows=\"4\" wrap=\"physical\"> $msg_text </textarea></TD></TR>";		
					}
			}
			else
			{
				echo "<TR><TD colspan=\"3\"><center> - - - - > No Messages? < - - - -</center></TD></TR>";
			}
	
echo "	</table>
			<br />
			<input type=\"checkbox\" name=\"del_msg\" value=\"DELETE\"> Check to delete message then ---> 
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			<input type=\"submit\" name=\"submit\" value=\"Update Message\">
			</form>
		<br /><br /><br />
		<a href=\"admin-message-insert.php\"><button type=\"button\"> New Message </button></a><br />
	</span>";
	
	mysqli_stmt_close($msg_QUERY);
	if (isset($_POST['submit']))
		{
			if (isset($_POST['del_msg']))
				{
					if (!($update_QUERY = $dblink->prepare("DELETE FROM `jury_room`.`message` WHERE `id`=?;"))) {logger("SQLi Prepare: $update_QUERY->error");}
					if (!($update_QUERY->bind_param('s', $msg_id))) { logger("SQLi Bind Error: $update_QUERY->error"); }
					if (!($update_QUERY->execute())) { logger("SQLi execute: $update_QUERY->error"); }
					$update_QUERY->close();
					$dblink->close();
					$_SESSION['pass_fail'] = "Message Deleted.";
					$_SESSION['redirect'] = "admin-message.php";
					header('Location: pause.php');
									
				}
				else
				{
					if ($_POST['subject'] !== $msg_subject)
						{
							$msg_subject = $_POST['subject'];
							$set = 1;
						}
						elseif ($_POST['msg_text'] !== substr($msg_text, 0, -16))
						{
							$msg_text = $_POST['msg_text'];
							$msg_text .= " (Posted " . date('Y-m-d Hi') . ")";
							$set = 1;
						}
						else
						{
							$pass_fail = "No changes?";
						}
						
					if ($set == 1)
						{
							if (!($update_QUERY = $dblink->prepare("UPDATE jury_room.message SET subject=?, text=? WHERE id=?"))) {logger("SQLi Prepare: $update_QUERY->error");}
							if (!($update_QUERY->bind_param('sss', $msg_subject, $msg_text, $msg_id))) { logger("SQLi Bind Error: $update_QUERY->error"); }
							if (!($update_QUERY->execute())) { logger("SQLi execute: $update_QUERY->error"); }
							$update_QUERY->close();
							$dblink->close();
							$_SESSION['pass_fail'] = "Message Updated.";
							$_SESSION['redirect'] = "admin-message.php";
							header('Location: pause.php');
									}
									else
									{
										$_SESSION['pass_fail'] = $pass_fail;
										header('Location: admin-message-edit.php');
									}
				}
		}
	include("footer.php");
}
?>