<?php
$id=(int)$_GET['id'];
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

echo "<b>View User</b><p>";

$query="SELECT * FROM g_users WHERE id = '$id'";
$result=mysqli_query($xrf_db, $query);

$username=xrf_mysql_result($result,0,"username");
$email=xrf_mysql_result($result,0,"email");
$lname=xrf_mysql_result($result,0,"lname");
$fname=xrf_mysql_result($result,0,"fname");
$mname=xrf_mysql_result($result,0,"mname");
$company=xrf_mysql_result($result,0,"company");
$birthdate=xrf_mysql_result($result,0,"birthdate");
$gender=xrf_mysql_result($result,0,"gender");
$address=xrf_mysql_result($result,0,"address");
$city=xrf_mysql_result($result,0,"city");
$state=xrf_mysql_result($result,0,"state");
$postal=xrf_mysql_result($result,0,"postal");
$country=xrf_mysql_result($result,0,"country");
$hphone=xrf_mysql_result($result,0,"hphone");
$cphone=xrf_mysql_result($result,0,"cphone");
$wphone=xrf_mysql_result($result,0,"wphone");
$datereg=xrf_mysql_result($result,0,"datereg");
$lastlogin=xrf_mysql_result($result,0,"lastlogin");
$lastip=xrf_mysql_result($result,0,"lastip");
$uclass=xrf_mysql_result($result,0,"uclass");
$ulevel=xrf_mysql_result($result,0,"ulevel");
$getmail=xrf_mysql_result($result,0,"getmail");

if ($gender == "m")
$gen = "Male";
else
$gen = "Female";

if ($company != "")
$company = "$company<br>";

if ($hphone != "" && $cphone != "")
$br1 = "<br>";
if ($cphone != "" && $wphone != "")
$br2 = "<br>";
if ($hphone != "" && $wphone != "")
$br1 = "<br>";
if ($hphone != "")
$hpl = "Home: ";
if ($cphone != "")
$cpl = "Cell: ";
if ($wphone != "")
$wpl = "Work: ";

if ($getmail == 1)
$getsmail = "Yes";
else
$getsmail = "No";

if ($birthdate != "0000-00-00")
$birth = "$birthdate<br>";

if ($address != "")
$addr = "<table><tr><td>$address<br>$city, $state $postal<br>$country</td></tr></table><p>";

if ($ulevel == 0)
	$ulev = "Banned (0)";
if ($ulevel == 1)
	$ulev = "Inactive (1)";
if ($ulevel == 2)
	$ulev = "User (2)";
if ($ulevel == 3)
	$ulev = "Moderator (3)";
if ($ulevel == 4)
	$ulev = "Administrator (4)";

echo "
<table width=\"100%\"><tr><td width=\"50%\">

<table><tr><td><b>$lname, $fname $mname</b><br>$company$email</td></tr></table><p>
$addr
<table><tr><td>$hpl$hphone$br1$cpl$cphone$br2$wpl$wphone</td></tr></table><p>
<table><tr><td>$birth
$gen</td></tr></table><p>
<table><tr><td>Receive Email: $getsmail</td></tr></table>

</td><td width=\"50%\">

<table><tr><td>Registered:</td><td align=\"right\">$datereg</td></tr>
<tr><td>Last Visit:</td><td align=\"right\">$lastlogin</td></tr>
<tr><td>Last IP:</td><td align=\"right\">$lastip</td></tr></table><p>
<table><tr><td>User Level: $ulev<br>User Class: $uclass</td></tr></table>

</td></tr></table>

<p align=\"left\"><b>Actions:</b> <font size=\"2\">";
if ($ulevel == 1) { echo " <a href=\"acp_apply_ulevel_2.php?id=$id\">[Activate]</a>"; }
if ($ulevel == 0) { echo " <a href=\"acp_apply_ulevel_2.php?id=$id\">[Unban]</a>"; }
if ($ulevel != 0) { echo " <a href=\"acp_apply_ulevel_0.php?id=$id\">[Ban]</a>"; }
echo "</font></p>";

}

require_once("includes/footer.php");
?>