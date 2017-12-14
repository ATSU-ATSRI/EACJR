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
			echo "<center>
					<div class=\"alert\">
						<center><b> System Message </b></center><br />";
			while ($message_display_QUERY->fetch())
				{
					echo "<b>$motd_subject:</b><br />
							&nbsp; &nbsp; &nbsp; $motd_text <br />";
				}
			echo "	</div>
				</center>";
		}
	$message_display_QUERY->close();
}
?>