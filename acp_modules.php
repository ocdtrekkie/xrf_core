<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

echo "<b>Module Manager</b><p>";

$query="SELECT * FROM g_modules ORDER BY ord ASC";
$result=mysqli_query($xrf_db, $query);

$num=mysqli_num_rows($result);

echo "<table>
<tr><td width=\"30\"><b>ID</b></td><td width=\"150\"><b>Name</b></td><td width=\"75\"><b>Prefix</b></td><td width=\"100\"><b>Folder</b></td><td width=\"75\"><b>Order</b></td><td width=\"50\"><b>Status</b></td><td></td></tr>";
$qq=0;
while ($qq < $num) {

$modid=xrf_mysql_result($result,$qq,"id");
$modname=xrf_mysql_result($result,$qq,"name");
$modprefix=xrf_mysql_result($result,$qq,"prefix");
$modfolder=xrf_mysql_result($result,$qq,"folder");
$modord=xrf_mysql_result($result,$qq,"ord");
$modactive=xrf_mysql_result($result,$qq,"active");

if ($modactive == 1)
$modstatus = "Active</td><td><font size=\"2\"><a href=\"acp_flip_module.php?id=$modid\">[Deactivate]</a></font>";
else
$modstatus = "Inactive</td><td><font size=\"2\"><a href=\"acp_flip_module.php?id=$modid\">[Activate]</a></font>";

echo "<tr><td>$modid</td><td>$modname</td><td>$modprefix</td><td>$modfolder</td><td>$modord</td><td>$modstatus</td></tr>";
$qq++;
}

echo "</table>";
}

require_once("includes/footer.php");
?>