<?
#################################################################
## PHP Pro Bid v6.06															##
##-------------------------------------------------------------##
## Copyright ©2007 PHP Pro Software LTD. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

function smtp_mailer($from, $from_name, $to, $subject, $message, $reply_to = null)
{
	global $db, $setts;
	
	$output = null;
	
	$set_sendmail = ini_set("sendmail_from", $from); 

	if (!empty($setts['smtp_host']))
	{
		ini_set("SMTP", $setts['smtp_host']);		
	}
	if (!empty($setts['smtp_port']))
	{
		ini_set("smtp_port", $setts['smtp_port']);		
	}
	
	$connect = @fsockopen(ini_get("SMTP"), ini_get("smtp_port"), $errno, $errstr, 30);

	// for debugging purposes
	$output[] = ($connect) ? 'Successfully connected to SMTP server.' : '<b>Fatal Error</b>: Connection to SMTP server failed'; 
	
	if ($connect)
	{	
		$rcv = fgets($connect, 1024); 
	
		// HELO server
		fputs($connect, "HELO {$_SERVER['SERVER_NAME']}\r\n"); 
		$output[] = '<b>Command</b>: HELO {' . $_SERVER['SERVER_NAME'] . '} => <b>Result</b>: ' . fgets($connect, 1024); 
	
		if ($setts['smtp_username'] && $setts['smtp_password'])
		{
			// authentication 
			fputs($connect, "auth login\r\n"); 
			$output[] = '<b>Command</b>: auth login => <b>Result</b>: ' . fgets($connect, 256); 
		   
			// set username
			fputs($connect, base64_encode($setts['smtp_username'])."\r\n"); 
			$output[] = '<b>Command</b>: get username => <b>Result</b>: ' . fgets($connect, 256);       
		       
			// set password
			fputs($connect, base64_encode($setts['smtp_password'])."\r\n"); 
			$output[] = '<b>Command</b>: get password => <b>Result</b>: ' . fgets($connect, 256);  	  
		}
		
		// set mail from
		fputs($connect, "MAIL FROM:$from\r\n");
		$output[] = '<b>Command</b>: MAIL FROM:' . $from . ' => <b>Result</b>: ' . fgets($connect, 1024);
	
		// set recipient(s)
		fputs($connect, "RCPT TO:<$to>\r\n");
		$output[] = '<b>Command</b>: RCPT TO:' . $to . ' => <b>Result</b>: ' . fgets($connect, 1024);
	
		// now set email data (additional headers and mail content)
		fputs($connect, "DATA\r\n");
		$output[] = '<b>Command</b>: DATA => <b>Result</b>: ' . fgets($connect, 1024);
	
		fputs($connect, "Subject: $subject\r\n");
		fputs($connect, "From: $from_name <$from>\r\n");
		fputs($connect, "To: $to \r\n");
		if (!empty($reply_to))
		{
			fputs($connect, "Reply-to: $reply_to \r\n");			
		}
		fputs($connect, "X-Sender: <$from>\r\n");
		fputs($connect, "Return-Path: <$from>\r\n");
		fputs($connect, "Errors-To: <$from>\r\n");
		fputs($connect, "X-Mailer: PHP Pro Bid/SMTP\r\n");
		fputs($connect, "X-Priority: 3\r\n");
		fputs($connect, "Content-Type: text/html; charset=iso-8859-1\r\n");
		fputs($connect, "\r\n");
		fputs($connect, stripslashes($message)." \r\n");
		fputs($connect, ".\r\n");
	
		fputs($connect, "RSET\r\n");
		$output[] = '<b>Command</b>: RSET => <b>Result</b>: ' . fgets($connect, 1024);
	
		fputs ($connect, "QUIT\r\n");
		$output[] = '<b>Command</b>: QUIT => <b>Result</b>: ' . fgets ($connect, 1024);
	
		fclose($connect);
		ini_restore("sendmail_from");
	}
	
	return $output;
}

?>