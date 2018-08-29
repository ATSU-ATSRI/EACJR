<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}

include("header.php");
if ($failed == "ALL_IS_PERFECT")
{
	include("menu_item.php");
	include_once("datacon.php");

	if (!($msg_QUERY = $dblink->prepare("SELECT id, subject, text, active FROM jury_room.message;"))) {logger(__LINE__, "SQLi Prepare: $msg_QUERY->error");}
		if (!($msg_QUERY->execute())) { logger(__LINE__, "SQLi execute: $msg_QUERY->error"); }
		if (!($msg_QUERY->bind_result($msg_id, $msg_subject, $msg_text, $msg_active))) {logger(__LINE__, "SQLi rBind: $msg_QUERY->error");}
		$msg_QUERY->store_result();
		
	
	echo "
		<div class=\"main\">";
		
		if (isset($_SESSION['pass_fail']))
			{
				echo "<span class=\"alert\">". $_SESSION['pass_fail'] ." </span>";
				unset($_SESSION['pass_fail']);
			}
		
	echo "
			<span class=\"left-col\">
			
			
			<a href=\"admin.php\"><button type=\"button\">View user list</button></a><br />
			<br />
			<a href=\"admin-new.php\"><button type=\"button\">Add a new user</button></a><br />
			<br />
			<a href=\"admin-history.php\"><button type=\"button\">View user history</button></a><br />		
			<br />
			<a href=\"admin-study.php\"><button type=\"button\">View study information</button></a><br /?
			<br />
			
		</span>
		
		<span class=\"right-col\">
		
		<table border=\"1\" width=\"100%\">
			<thead>
			<TR>
				<TH colspan=\"3\" width=\"100%\"> Message List </TH>
			</TR>	
			</thead>
			<tbody>
		<form name=\"display_toggle\" method=\"POST\">			
		";
		
		if (($msg_QUERY->num_rows) > 0)	
			{
				while($msg_QUERY->fetch())
					{
						echo "	<TR><TD colspan=\"2\" width=\"100%\"> $msg_subject </TD></TR>
								<TR><TD colspan=\"2\" width=\"100%\"> $msg_text </TD></TR>
								<TR>
									<TD width=\"50%\"> <a href=\"admin-message-edit.php?tag=$msg_id\"><button type=\"button\"> Edit Message </button></a></TD>
									<TD width=\"50%\">";
										if ($msg_active == 0) { echo "Show"; } else { echo "Hide"; }
										echo " Message, <input type=\"radio\" name=\"display\" value=\"$msg_id\"> Yes?
								</TD>
								</TR>";
					}
			}
			else
			{
				echo "<TR><TD colspan=\"3\" width=\100%\"><center> - - - - > No Messages < - - - -</center></TD></TR>";
			}
	
echo "	<TR><TH width=\"50%\"></TH><TH width=\"50%\"><input type=\"submit\" name=\"submit\" value=\"Toggle Message Display\"></TH></TR>
		</form>
		</tbody>
		</table>
		<br />
		
		<a href=\"admin-message-insert.php\"><button type=\"button\"> New Message </button></a><br />
	</span>";
	$msg_QUERY->close();

	if (isset($_POST['submit']))
		{
			if (isset($_POST['display']))
				{
					$toggle_id = $_POST['display'];
					
					if ($msg_active == 0)
						{
							$msg_toggle = "1";
						} 
						else
						{
							$msg_toggle = "0";
						}
				
					if (!($update_QUERY = $dblink->prepare("UPDATE jury_room.message SET active=? WHERE id=?"))) {logger(__LINE__, "SQLi Prepare: $update_QUERY->error");}
					if (!($update_QUERY->bind_param('ss', $msg_toggle, $toggle_id))) { logger(__LINE__, "SQLi Bind Error: $update_QUERY->error"); }
					if (!($update_QUERY->execute())) { logger(__LINE__, "SQLi execute: $update_QUERY->error"); }
					$update_QUERY->close();
					$dblink->close();
					$_SESSION['pass_fail'] = "Message Updated.";
					$_SESSION['redirect'] = "admin-message.php";
					header('Location: pause.php');
				}
		}
	
	include("footer.php");
}
?>