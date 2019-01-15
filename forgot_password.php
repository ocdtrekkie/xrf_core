<?php
require_once("includes/global.php");
require_once("includes/header.php");

$do = $_GET['do'];

if ($do == "reset")
{
	$femail=xrf_mysql_sanitize_string($_POST['femail']);
	$fbirthdate=xrf_mysql_sanitize_string($_POST['fbirthdate']);

	$newpassraw = xrf_generate_password(16);
	$newpass = xrf_encrypt_password($newpassraw,$xrf_passwordsalt);

	$query="SELECT * FROM g_users WHERE email='$femail'";
	$result=mysql_query($query);
	$tbirthdate=mysql_result($result,$qq,"birthdate");
	if ($fbirthdate == $tbirthdate)
	{
		$from = "From: $xrf_admin_email \r\n";
		$mesg = "Your password has been reset to a temporary password. It is now $newpassraw. Please change it as soon as possible.";
		mail($femail, "$xrf_site_name Password Reset", $mesg, $from);
		
		$query="UPDATE g_users SET password='$newpass' WHERE email='$femail'";
		mysql_query($query);
		
		if ($xrf_vlog_enabled == 1)
		{
			$xrf_myip = getenv("REMOTE_ADDR");
			$query="INSERT INTO g_log (uid, date, event) VALUES ('0',NOW(),'Password reset for $femail by $xrf_myip.')";
			mysql_query($query);
		}
		xrf_go_redir("index.php","Password reset. Check your email. You may now log in.",4);
	}
	else
	{
		if ($xrf_vlog_enabled == 1)
		{
			$xrf_myip = getenv("REMOTE_ADDR");
			$query="INSERT INTO g_log (uid, date, event) VALUES ('0',NOW(),'Password reset attempt for $femail from $xrf_myip failed.')";
			mysql_query($query);
		}
		xrf_go_redir("forgot_password.php","Invalid reset attempt.",2);
	}
}
else
{
	echo "<form action=\"forgot_password.php?do=reset\" method=\"POST\">
	<table style=\"border:0px\" cellspacing=\"0\" width=\"400\">
	<tr><tdcolspan=\"2\" class=\"sp-header\">Reset Password</td></tr>
	<tr><td><b>Email:</b></td><td><input type=\"text\" name=\"femail\"></td></tr>
	<tr><td><b>Birthdate:</b></td><td><input type=\"text\" name=\"fbirthdate\"> (yyyy-mm-dd)</td></tr>
	</table><p>
	<input type=\"submit\" value=\"Reset Password\"></form>";
}

require_once("includes/footer.php");
?>