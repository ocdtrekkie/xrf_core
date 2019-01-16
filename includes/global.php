<?php
require_once("includes/variables.php");
require_once("includes/functions_auth.php");
require_once("includes/functions_db.php");
require_once("includes/functions_redir.php");
require_once("includes/functions_sec.php");
$xrf_auth_version_page = "0.3a";

// Guest settings
$xrf_myid = 0;
$xrf_myusername = "";
$xrf_myuclass = "";
$xrf_myulevel = 1;

$xrf_db = @mysqli_connect($xrf_dbserver, $xrf_dbusername, $xrf_dbpassword, $xrf_dbname) or die(mysqli_connect_error());

ob_start();
session_set_cookie_params(3600*24,'/',$xrf_dbcookie);
session_start();

$xrf_config_query="SELECT * FROM g_config";
$xrf_config_result=mysqli_query($xrf_db, $xrf_config_query);

$xrf_site_name=xrf_mysql_result($xrf_config_result,0,"site_name");
$xrf_site_url=xrf_mysql_result($xrf_config_result,0,"site_url");
$xrf_site_key=xrf_mysql_result($xrf_config_result,0,"site_key");
$xrf_active=xrf_mysql_result($xrf_config_result,0,"active");
$xrf_auth_version_db=xrf_mysql_result($xrf_config_result,0,"auth_version");
$xrf_passwordsalt=xrf_mysql_result($xrf_config_result,0,"salt");
$xrf_server_name=xrf_mysql_result($xrf_config_result,0,"server_name");
$xrf_admin_email=xrf_mysql_result($xrf_config_result,0,"admin_email");
$xrf_admin_id=xrf_mysql_result($xrf_config_result,0,"admin_id");
$xrf_reg_enabled=xrf_mysql_result($xrf_config_result,0,"reg_enabled");
$xrf_login_enabled=xrf_mysql_result($xrf_config_result,0,"login_enabled");
$xrf_vlog_enabled=xrf_mysql_result($xrf_config_result,0,"vlog_enabled");
$xrf_style_default=xrf_mysql_result($xrf_config_result,0,"style_default");

// Check active
if ($xrf_active == 0)
{
	die("This site is disabled.  Please report to the system administrator.");
}

xrf_check_auth_version($xrf_auth_version_page, $xrf_auth_version_db) or die("Unable to verify authentication version.  Please report to the system administrator.");

// Check for remembered login if not logged in
if($xrf_myid == 0 && isset($_COOKIE['cookid']) && isset($_COOKIE['cookemail']) && isset($_COOKIE['cookpass'])){
    $xrf_cookid = $_COOKIE['cookid'];
    $xrf_cookemail = $_COOKIE['cookemail'];
    $xrf_cookpass = $_COOKIE['cookpass'];
	$xrf_cookemail = mysqli_real_escape_string($xrf_db, $xrf_cookemail);

	$xrf_cookie_query="SELECT * FROM g_users WHERE email='$xrf_cookemail'";
	$xrf_cookie_result=mysqli_query($xrf_db, $xrf_cookie_query);

	@$xrf_testid=xrf_mysql_result($xrf_cookie_result,0,"id");
	@$xrf_testemail=xrf_mysql_result($xrf_cookie_result,0,"email");
	@$xrf_testpass=xrf_mysql_result($xrf_cookie_result,0,"password");

	if ($xrf_testpass == $xrf_cookpass && $xrf_testid == $xrf_cookid)
	{
		$_SESSION['xrf_myid'] = $xrf_cookid;
		$_SESSION['xrf_myemail'] = $xrf_cookemail;
		$_SESSION['xrf_mypassword'] = $xrf_cookpass;
		$xrf_myip = getenv("REMOTE_ADDR");
		$_SESSION['xrf_myip'] = $xrf_myip;
		$_SESSION['xrf_myagent'] = getenv("HTTP_USER_AGENT");
		$xrf_myid = $xrf_cookid;
		$xrf_myemail = $xrf_cookemail;
		$xrf_mypassword = $xrf_cookpass;
		
		$xrf_lastlogin_query="UPDATE g_users SET lastlogin = now(), lastip = '$xrf_myip' WHERE id='$xrf_myid'";
		mysqli_query($xrf_db, $xrf_lastlogin_query);
	}
}

xrf_secure_session($xrf_dbcookie) or die("Unable to verify session security.  Please report to the system administrator.");

// Get user info if logged in
if ($xrf_myid != 0)
{
	$xrf_userdata_query="SELECT * FROM g_users WHERE id='$xrf_myid'";
	$xrf_userdata_result=mysqli_query($xrf_db, $xrf_userdata_query);
	
	@$xrf_myusername=xrf_mysql_result($xrf_userdata_result,0,"username");
	@$xrf_myprofilepic=xrf_mysql_result($xrf_userdata_result,0,"profilepic");
	@$xrf_mylname=xrf_mysql_result($xrf_userdata_result,0,"lname");
	@$xrf_myfname=xrf_mysql_result($xrf_userdata_result,0,"fname");
	@$xrf_mymname=xrf_mysql_result($xrf_userdata_result,0,"mname");
	@$xrf_mytitle=xrf_mysql_result($xrf_userdata_result,0,"title");
	@$xrf_mycompany=xrf_mysql_result($xrf_userdata_result,0,"company");
	@$xrf_mybirthdate=xrf_mysql_result($xrf_userdata_result,0,"birthdate");
	@$xrf_mygender=xrf_mysql_result($xrf_userdata_result,0,"gender");
	@$xrf_myaddress=xrf_mysql_result($xrf_userdata_result,0,"address");
	@$xrf_mycity=xrf_mysql_result($xrf_userdata_result,0,"city");
	@$xrf_mystate=xrf_mysql_result($xrf_userdata_result,0,"state");
	@$xrf_mypostal=xrf_mysql_result($xrf_userdata_result,0,"postal");
	@$xrf_mycountry=xrf_mysql_result($xrf_userdata_result,0,"country");
	@$xrf_myhphone=xrf_mysql_result($xrf_userdata_result,0,"hphone");
	@$xrf_mycphone=xrf_mysql_result($xrf_userdata_result,0,"cphone");
	@$xrf_mywphone=xrf_mysql_result($xrf_userdata_result,0,"wphone");
	@$xrf_mydatereg=xrf_mysql_result($xrf_userdata_result,0,"datereg");
	@$xrf_mylastlogin=xrf_mysql_result($xrf_userdata_result,0,"lastlogin");
	@$xrf_myuclass=xrf_mysql_result($xrf_userdata_result,0,"uclass");
	@$xrf_myulevel=xrf_mysql_result($xrf_userdata_result,0,"ulevel");
	@$xrf_mygetmail=xrf_mysql_result($xrf_userdata_result,0,"getmail");
	@$xrf_mystylepref=xrf_mysql_result($xrf_userdata_result,0,"style_pref");
}
?>
