<?php
if ($failed == "ALL_IS_PERFECT")
{
	include_once("datacon.php");
	
	if (!($message_display_QUERY = $dblink->prepare("SELECT `subject`, `text` FROM jury_room.message WHERE (active = '1');"))) { logger("SQLi Prepare: $message_display_QUERY->error"); }
	if (!($message_display_QUERY->execute())) { logger("SQLi execute: $message_display_QUERY->error"); }
	if (!($message_display_QUERY->bind_result($motd_subject, $motd_text))) { logger("SQLi rBind: $message_display_QUERY->error"); }
	$message_display_QUERY->store_result();
	
	if ($message_display_QUERY->num_rows > 0)
		{
			echo "	<center>
					<div class=\"main\">
					<table name=\"message-display\" width=\"50%\" border=\"0\">
						<TR><TH><center><b> System Message </b></center></TH></TR>";
			while ($message_display_QUERY->fetch())
				{
					echo "	<TR>
								<TH> $motd_subject </TH>
							</TR><TR>
								<TD> $motd_text </TD>
							</TR>";
				}
			echo "	<TR>
						<TH> &nbsp; </TH>
					</TR>
				</table>
			</div>
		</center>";
		}
	$message_display_QUERY->close();
}
?>