<?php
/*
	This programme is property of and copyright to the A. T. Still Research Institute.
	Created:           2016-Aug-26
	See ../README.gdoc for changelog, credits, and instructions.
*/

//General Rules
$rule_1 = "Disallow:harming humans";
$rule_2 = "Disallow:ignoring human orders";
$rule_3 = "Disallow:harm to self";
if (($rule_1 != TRUE) || ($rule_2 != TRUE) || ($rule_3 != TRUE)) {echo "Protect! Obey! Survive!\n"; die;}
date_default_timezone_set('America/Chicago'); //hard set for Kirksville.

//Logger write to logfile.txt
	function logger($logline, $logmsg)
		{
			$logger_csv = fopen("logfile.txt","a");
			//fwrite($logger_csv, "" . basename(__FILE__) . "|" . date('M d H:i:s') . "|" . $logline. "|". $logmsg . "\r\n");
			fwrite($logger_csv, "" . $_SERVER['PHP_SELF'] . "|" . date('M d H:i:s') . "|" . $logline. "|". $logmsg . "\r\n");
			fclose($logger_csv);
		}
	
	function recordError($errno,$errstr,$error_file,$error_line)
		{
			$logger_csv = fopen("logfile.txt","a");
			fwrite($logger_csv, "\r\nError --> [ " . $errno . " ] " . $errstr . "  on line: " . $error_line . "\r\n -- File: " . $error_file . "\r\n\r\n");
			fclose($logger_csv);
		}
		
	set_error_handler("recordError");
	$start_memory = memory_get_usage();
	logger(__LINE__, "===== Start of Log. =====");
	logger(__LINE__, "My timezone is: " . date_default_timezone_get());

?>