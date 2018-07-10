<?php
require("datacon.php");

// Use for local logging
function logger2($logline, $logmsg)
	{
		$logger_csv = fopen("logger/logfile.txt","a");
		fwrite($logger_csv, "" . $_SERVER['PHP_SELF'] . "|" . date('M d H:i:s') . "|" . $logline. "|". $logmsg . "\r\n");
		fclose($logger_csv);
	}
		
	
// https://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor
function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}

// Use for remote email logging	
function logger($logline, $msg)
	{
		//Where to send the logger message.
		$logger_email = "LOGVIEWER EMAIL ADDRESS HERE";
		$mail_password = "EMAIL PASSWORD HERE";
		$mail_username = "EMAIL USERNAME HERE";
		$mail_host = "MAIL HOST GOES HERE";
		
		//send email
		include_once "datacon.php";
		include_once "libphp-phpmailer/PHPMailerAutoload.php";
		$mail = new PHPMailer();
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Mailer = "smtp";
		$mail->Host = $mail_host;
		$mail->Username = $mail_username;
		$mail->Password = $mail_password;
		$mail->SMTPAuth = true;
		$mail->Prority = 1;
		$mail->Subject = "EACJR Logger Message";
		$mail->From = $mail_username;
		$mail->FromName = "DO-Touch.NET EAC";
		$mail->AddReplyTo($mail_username,$mail_username);
			$mail->AddAddress($logger_email,$logger_email);
			
		$email_body = "!! " . date('M d H:i:s') . " $logline - $msg;<br /><br />Have a nice day,<br />~DO-Touch.NET<br />";
		$mail->Body = $email_body;
		$mail->AltBody = str_ireplace("<br />","\n",$email_body);
						
			if (!$mail->Send())
				{
					$mailerror = $mail->ErrorInfo;
				}
					else
				{
					$mail->ClearAllRecipients();
					$mail->ClearReplyTos();
				}
	}
?>