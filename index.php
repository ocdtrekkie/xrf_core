<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_mygender == "m")
$mygen = "Male";
else
$mygen = "Female";

if ($xrf_mycompany != "")
$mycomp = "$xrf_mycompany<br>";

if ($xrf_myhphone != "" && $xrf_mycphone != "")
$br1 = "<br>";
if ($xrf_mycphone != "" && $xrf_mywphone != "")
$br2 = "<br>";
if ($xrf_myhphone != "" && $xrf_mywphone != "")
$br1 = "<br>";
if ($xrf_myhphone != "")
$myhpl = "Home: ";
if ($xrf_mycphone != "")
$mycpl = "Cell: ";
if ($xrf_mywphone != "")
$mywpl = "Work: ";

if ($xrf_mygetmail == 1)
{
$getsmail = "Yes";
$unsublink = " <font size=\"2\"><a href=\"unsubscribe.php?email=$xrf_myemail\">[Unsubscribe]</a></font>";
}
else
$getsmail = "No";

if ($xrf_mybirthdate != "0000-00-00")
$birthdate = "$xrf_mybirthdate<br>";

if ($xrf_myaddress != "")
$address = "<table><tr><td>$xrf_myaddress<br>$xrf_mycity, $xrf_mystate $xrf_mypostal<br>$xrf_mycountry</td></tr></table><p>";

echo "
<table width=\"100%\"><tr><td width=\"50%\">

<table><tr><td><b>$xrf_mylname, $xrf_myfname $xrf_mymname</b><br>$mycomp$xrf_myemail</td></tr></table><p>
$address
<table><tr><td>$myhpl$xrf_myhphone$br1$mycpl$xrf_mycphone$br2$mywpl$xrf_mywphone</td></tr></table><p>
<table><tr><td>$birthdate
$mygen</td></tr></table><p>
<table><tr><td>Receive Email: $getsmail$unsublink</td></tr></table><p>
<table><tr><td><b>Actions:</b> <font size=\"2\"><a href=\"change_password.php\">[Change Password]</a></font></td></tr></table>

</td><td width=\"50%\">

<table><tr><td>Registered:</td><td align=\"right\">$xrf_mydatereg</td></tr>
<tr><td>Last Visit:</td><td align=\"right\">$xrf_mylastlogin</td></tr></table><p>

<table>";

$query="SELECT * FROM g_modules WHERE active = 1 ORDER BY ord ASC";
$result=mysqli_query($xrf_db, $query);

$num=mysqli_num_rows($result);

$qq=0;
while ($qq < $num) {

$modid=xrf_mysql_result($result,$qq,"id");
$modname=xrf_mysql_result($result,$qq,"name");
$modfolder=xrf_mysql_result($result,$qq,"folder");

include "modules/$modfolder/homepanel.php";
$qq++;
}

echo "</table><p>
<table><tr><td>User Class: $xrf_myuclass</td></tr></table>

</td></tr></table>";

require_once("includes/footer.php");
?>