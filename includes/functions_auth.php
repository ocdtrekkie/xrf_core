<?php

//Function xrf_check_auth_version
//Use: Checks authorization version.
function xrf_check_auth_version($xrf_auth_version_page, $xrf_auth_version_db)
{
	if (strpos($xrf_auth_version_db, $xrf_auth_version_page) === false)
	{
		die("The authentication version for this module is outdated.  Please report to the system administrator.");
	}
	else
		return true;
}

//Function xrf_encrypt_password
//Use: Encrypts and salts a password.
function xrf_encrypt_password($rawpass,$passwordsalt)
{
$newpass = sha1(md5($rawpass).$passwordsalt);
return ($newpass);
}

//Function xrf_generate_password
//Use: Generates a random password.
function xrf_generate_password($length)
{
	$password = "";
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ"; // Possible characters
	$maxlength = strlen($possible);
	$i = 0;
	while ($i < $length) {
		$char = substr($possible, mt_rand(0, $maxlength-1), 1);
		$password .= $char;
		$i++;
	}
	return ($password);
}

//Function xrf_secure_session
//Use: Ensures a session is being used by the proper owner.
function xrf_secure_session($xrf_dbcookie)
{
	$ipnum = getenv("REMOTE_ADDR");
	$agent = getenv("HTTP_USER_AGENT");
	
	if (isset($_SESSION['myip']))
	{
		if ($ipnum != $_SESSION['myip'] || $agent != $_SESSION['myagent'])
		{
			session_destroy();

			if(isset($_COOKIE['cookid']) && isset($_COOKIE['cookemail']) && isset($_COOKIE['cookpass'])){
				setcookie("cookemail", "", time()-60*60*24*400, "/", $xrf_dbcookie);
				setcookie("cookpass", "", time()-60*60*24*400, "/", $xrf_dbcookie);
				setcookie("cookid", "", time()-60*60*24*400, "/", $xrf_dbcookie);
			}
			// return false;
		}
		// else return true;
	}
	// else return false;
	
	return true;
}

?>