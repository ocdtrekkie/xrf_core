<?php
require_once("includes/global.php");
require_once("includes/header.php");
$xrf_auth_version_page = "0.2a";

xrf_check_auth_version($xrf_auth_version_page, $xrf_auth_version_db) or die("Unable to verify authentication version.  Please report to the system administrator.");

$do = $_GET['do'];

if ($do == "auth")
{
	if ($xrf_login_enabled == 1)
	{
		$lemail = xrf_mysql_sanitize_string($_POST['lemail']);
		$lpass = xrf_mysql_sanitize_string($_POST['lpass']);
		if(isset($_POST['remme']))
		{
			$remme = 1;
		}
		else
		{
			$remme = 0;
		}

		$lpass = xrf_encrypt_password($lpass,$xrf_passwordsalt);

		$query="SELECT id, password, username FROM g_users WHERE email='$lemail'";
		$result=mysql_query($query);

		$xrf_myemail=$lemail;
		@$xrf_myid=mysql_result($result,0,"id");
		@$xrf_mypassword=mysql_result($result,0,"password");
		@$xrf_myusername=mysql_result($result,0,"username");

		if ($lpass == $xrf_mypassword)
		{
			$_SESSION['xrf_myemail'] = $xrf_myemail;
			$_SESSION['xrf_mypassword'] = $xrf_mypassword;
			$_SESSION['xrf_myid'] = $xrf_myid;
			$xrf_myip = getenv("REMOTE_ADDR");
			$_SESSION['xrf_myip'] = $xrf_myip;
			$_SESSION['xrf_myagent'] = getenv("HTTP_USER_AGENT");

			$query="UPDATE g_users SET lastlogin = now(), lastip = '$xrf_myip' WHERE id='$xrf_myid'";
			mysql_query($query);
			if ($xrf_vlog_enabled == 1)
			{
				$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Logged in from $xrf_myip.')";
				mysql_query($query);
			}
	
			if ($remme == 1)
			{
				setcookie("cookemail", $xrf_myemail, time()+60*60*24*400, "/", $xrf_dbcookie);
				setcookie("cookpass", $xrf_mypassword, time()+60*60*24*400, "/", $xrf_dbcookie);
				setcookie("cookid", $xrf_myid, time()+60*60*24*400, "/", $xrf_dbcookie);
			}
	
			xrf_go_redir("index.php","Successfully logged in as $xrf_myusername.",2); 
		}
		else
		{
			if ($xrf_vlog_enabled == 1)
			{
				$xrf_myip = getenv("REMOTE_ADDR");
				$query="INSERT INTO g_log (uid, date, event) VALUES ('0',NOW(),'Login attempt from $xrf_myip failed.')";
				mysql_query($query);
			}
			xrf_go_redir("login.php","Login failed.",2); 
		}
	}
	else
	{
		echo "Sorry, login is currently disabled.";
	}
}
else
{
	if ($xrf_login_enabled == 1)
	{
		echo "<form action=\"login.php?do=auth\" method=\"POST\">
		<table style=\"border:0px\" cellspacing=\"0\" width=\"300\">
		<tr><tdcolspan=\"2\" class=\"sp-header\">Log in!</td></tr>
		<tr><td><b>Email:</b></td><td><input type=\"text\" name=\"lemail\"></td></tr>
		<tr><td><b>Password:</b></td><td><input type=\"password\" name=\"lpass\"></td></tr>
		<tr><td></td><td><input type=\"checkbox\" name=\"remme\">Remember Me</td></tr>
		</table><p>
		<input type=\"submit\" value=\"Log in!\"></form><p>
		Forgot password? <a href=\"forgot_password.php\">Reset here</a>.<br>
		Not a member? <a href=\"register.php\">Register here</a>.</p>";
	}
	else
	{
		echo "Sorry, login is currently disabled.";
	}
}

require_once("includes/footer.php");
?>