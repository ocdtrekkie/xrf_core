<?php

//Function xrf_get_fname
//Use: Gets first name from a user id
function xrf_get_fname($uid)
{
$query="SELECT fname FROM g_users WHERE id='$uid'";
$result=mysql_query($query);
$fname=mysql_result($result,$qq,"fname");
return ($fname);
}

//Function xrf_get_lname
//Use: Gets last name from a user id
function xrf_get_lname($uid)
{
$query="SELECT lname FROM g_users WHERE id='$uid'";
$result=mysql_query($query);
$lname=mysql_result($result,$qq,"lname");
return ($lname);
}

//Function xrf_get_profilepic
//Use: Gets profile picture URL from a user id
function xrf_get_profilepic($uid)
{
$query="SELECT profilepic FROM g_users WHERE id='$uid'";
$result=mysql_query($query);
$profilepic=mysql_result($result,$qq,"profilepic");
return ($profilepic);
}

//Function xrf_get_username
//Use: Gets username from a user id
function xrf_get_username($uid)
{
$query="SELECT username FROM g_users WHERE id='$uid'";
$result=mysql_query($query);
$username=mysql_result($result,$qq,"username");
return ($username);
}

?>