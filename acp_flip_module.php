<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{
$id=(int)$id;
$query="SELECT * FROM g_modules WHERE id='$id'";
$result=mysql_query($query);

$active=mysql_result($result,$qq,"active");
if ($active == '1')
{
$newset = '0';
$resultmsg = "deactivated";
}
else
{
$newset = '1';
$resultmsg = "activated";
}

$query="UPDATE g_modules SET active=$newset WHERE id='$id'";
mysql_query($query);
xrf_go_redir("acp_modules.php","Module $resultmsg.",2);

}
require_once("includes/footer.php");
?>