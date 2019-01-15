<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

if ($do == "trigger")
{
$query="UPDATE g_config SET active='0'";
mysql_query($query);
$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Disabled the site from $xrf_myip.')";
mysql_query($query);

$from = "From: $xrf_admin_email \r\n";
$mesg = "The site has been disabled by $xrf_myfname $xrf_mylname from $xrf_myip.";
mail($xrf_admin_email, "$xrf_site_name System Alert", $mesg, $from);

echo "Site disabled.";
}
else
{
echo "
<table width=\"100%\"><tr><td width=\"100%\">
<p align=\"center\"><b>This can not be undone!</b></p>
<p align=\"center\"><a href=\"acp_disable.php?do=trigger\">Disable Site</a></p>
</td></tr></table>";
}
}

require_once("includes/footer.php");
?>