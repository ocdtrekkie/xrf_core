<?php
$filter = $_GET['filter'];
$condition="";
$cndlbl="";
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

if ($filter == "banned")
{
	$condition = " WHERE ulevel = '0'";
	$cndlbl = "Banned";
}
if ($filter == "inactive")
{
	$condition = " WHERE ulevel = '1'";
	$cndlbl = "Inactive";
}
if ($cndlbl == "")
	$cndlbl = "All";

echo "<b>$cndlbl User Accounts</b><p>";

$query="SELECT * FROM g_users$condition ORDER BY lname, fname ASC";
$result=mysqli_query($xrf_db, $query);

$num=mysqli_num_rows($result);

echo "<table>";
$qq=0;
while ($qq < $num) {

$id=xrf_mysql_result($result,$qq,"id");
$username=xrf_mysql_result($result,$qq,"username");
$lname=xrf_mysql_result($result,$qq,"lname");
$fname=xrf_mysql_result($result,$qq,"fname");
$email=xrf_mysql_result($result,$qq,"email");

echo "<tr><td width=200><a href=\"acp_view_user.php?id=$id\">$username</a> ($id)</td><td width=200>$lname, $fname</td><td width=200>$email</td></tr>";
$qq++;
}

echo "</table>";
}

require_once("includes/footer.php");
?>