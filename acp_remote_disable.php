<?php
require_once("includes/global.php");
require_once("includes/functions_auth.php");

$xrf_access_key=xrf_mysql_result($xrf_config_result,0,"access_key");

if ($auth == $xrf_access_key)
{
	$remoteip = $_SERVER['REMOTE_ADDR'];

	$query="UPDATE g_config SET active='0'";
	mysqli_query($xrf_db, $query);
	$query="INSERT INTO g_log (uid, date, event) VALUES ('0',NOW(),'Disabled the site by remote key from $remoteip.')";
	mysqli_query($xrf_db, $query);

	$from = "From: $xrf_admin_email \r\n";
	$mesg = "The site has been disabled by remote key from $remoteip.";
	mail($xrf_admin_email, "$xrf_site_name System Alert", $mesg, $from);
}
else
{
echo "Unauthorized!";
}

require_once("includes/footer.php");
?>