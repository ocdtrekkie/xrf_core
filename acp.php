<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

echo "
<table width=\"100%\"><tr><td width=\"50%\">

<!-- left side -->
<p><b>User Management</b></p>
<p><a href=\"acp_users.php\">View All Users</a><br>
<a href=\"acp_users.php?filter=inactive\">View Inactive User List</a><br>
<a href=\"acp_users.php?filter=banned\">View Banned User List</a><br>
<a href=\"acp_add_user.php\">Add New User</a></p>
<p><b>General Management</b></p>
<p><a href=\"acp_general.php\">General Configuration</a><br>
<a href=\"acp_mass_mail.php\">Send Mass Mail</a><br>
<a href=\"acp_disable.php\">Disable Site</a></p>";

if ($xrf_vlog_enabled == 1)
echo "<p><b>Log Management</b></p>
<p>Log Browser Here</p>";

echo "</td><td width=\"50%\">

<!-- right side -->
<a href=\"acp_modules.php\">Module Manager</a><p>";

$query="SELECT * FROM g_modules WHERE active = 1 ORDER BY ord ASC";
$result=mysql_query($query);

$num=mysql_numrows($result);

$qq=0;
while ($qq < $num) {

$modid=mysql_result($result,$qq,"id");
$modname=mysql_result($result,$qq,"name");
$modfolder=mysql_result($result,$qq,"folder");

echo "<p><b>$modname</b></p>";

include "modules/$modfolder/controlpanel.php";
$qq++;
}

echo "</td></tr></table>";

}

require_once("includes/footer.php");
?>