<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

$do = $_GET['do'];

if ($do == "change")
{
	$curpass=mysqli_real_escape_string($xrf_db, $_POST['curpass']);
	$newpass=mysqli_real_escape_string($xrf_db, $_POST['newpass']);
	$newpass2=mysqli_real_escape_string($xrf_db, $_POST['newpass2']);

	if (password_verify($curpass, $xrf_mypassword) && $newpass == $newpass2)
	{
		$newpass = xrf_encrypt_password($newpass);
		$query="UPDATE g_users SET password='$newpass' WHERE id='$xrf_myid'";
		mysqli_query($xrf_db, $query);
		
		if ($xrf_vlog_enabled == 1)
		{
			$xrf_myip = getenv("REMOTE_ADDR");
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Password changed for $xrf_myusername by $xrf_myip.')";
			mysqli_query($xrf_db, $query);
		}
		xrf_go_redir("index.php","Password changed.",2);

		$xrf_mypassword = $newpass;
		$_SESSION['xrf_mypassword'] = $newpass;
	}
	else
	{
		if ($xrf_vlog_enabled == 1)
		{
			$xrf_myip = getenv("REMOTE_ADDR");
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Password change attempt for $xrf_myusername from $myip failed.')";
			mysqli_query($xrf_db, $query);
		}
		xrf_go_redir("change_password.php","Invalid password change.",2);
	}
}
else
{
	echo "<form action=\"change_password.php?do=change\" method=\"POST\">
	<table style=\"border:0px\" cellspacing=\"0\" width=\"400\">
	<tr><tdcolspan=\"2\" class=\"sp-header\">Change Password</td></tr>
	<tr><td><b>Current Password:</b></td><td><input type=\"password\" name=\"curpass\"></td></tr>
	<tr><td><b>New Password:</b></td><td><input type=\"password\" name=\"newpass\"></td></tr>
	<tr><td><b>New Password (Again):</b></td><td><input type=\"password\" name=\"newpass2\"></td></tr>
	</table><p>
	<input type=\"submit\" value=\"Change Password\"></form>";
}

require_once("includes/footer.php");
?>