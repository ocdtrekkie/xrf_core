<?php
$id=(int)$id;
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
$result=mysql_query($query);

$num=mysql_numrows($result);

$username=mysql_result($result,$qq,"username");
$email=mysql_result($result,$qq,"email");
$lname=mysql_result($result,$qq,"lname");
$fname=mysql_result($result,$qq,"fname");
$mname=mysql_result($result,$qq,"mname");
$company=mysql_result($result,$qq,"company");
$birthdate=mysql_result($result,$qq,"birthdate");
$gender=mysql_result($result,$qq,"gender");
$address=mysql_result($result,$qq,"address");
$city=mysql_result($result,$qq,"city");
$state=mysql_result($result,$qq,"state");
$postal=mysql_result($result,$qq,"postal");
$country=mysql_result($result,$qq,"country");
$hphone=mysql_result($result,$qq,"hphone");
$cphone=mysql_result($result,$qq,"cphone");
$wphone=mysql_result($result,$qq,"wphone");
$datereg=mysql_result($result,$qq,"datereg");
$lastlogin=mysql_result($result,$qq,"lastlogin");
$lastip=mysql_result($result,$qq,"lastip");
$uclass=mysql_result($result,$qq,"uclass");
$ulevel=mysql_result($result,$qq,"ulevel");
$getmail=mysql_result($result,$qq,"getmail");

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