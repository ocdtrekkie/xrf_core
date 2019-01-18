<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{
$id=(int)$_GET['id'];
$query="SELECT * FROM g_modules WHERE id='$id'";
$result=mysqli_query($xrf_db, $query);

$active=xrf_mysql_result($result,0,"active");
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
mysqli_query($xrf_db, $query);
xrf_go_redir("acp_modules.php","Module $resultmsg.",2);

}
require_once("includes/footer.php");
?>