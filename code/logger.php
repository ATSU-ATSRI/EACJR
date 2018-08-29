<?php
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}
date_default_timezone_set('America/Chicago');

	function logger_local($logline, $logmsg)
		{
			$logger_csv = fopen("logfile.txt","a");
			fwrite($logger_csv, "" . $_SERVER['PHP_SELF'] . "|" . date('M d H:i:s') . "|" . $logline. "|". $logmsg . "\r\n");
			fclose($logger_csv);
		}
	
	function recordError($errno,$errstr,$error_file,$error_line)
		{
			$logger_csv = fopen("logfile.txt","a");
			fwrite($logger_csv, "\r\nError --> [ " . $errno . " ] " . $errstr . "  on line: " . $error_line . "\r\n -- File: " . $error_file . "\r\n\r\n");
			fclose($logger_csv);
		}

	function logger($logline, $logmsg)
		{
			openlog("EACJR", LOG_PID | LOG_PERROR, LOG_LOCAL0);
			syslog(LOG_INFO, $_SERVER['PHP_SELF'] . "[$logline] $logmsg");
			closelog();
		}
	
?>