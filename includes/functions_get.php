<?php

//Function xrf_get_fname
//Use: Gets first name from a user id
function xrf_get_fname($xrf_db, $uid)
{
$query="SELECT fname FROM g_users WHERE id='$uid'";
$result=mysqli_query($xrf_db, $query);
$fname=xrf_mysql_result($result,0,"fname");
return ($fname);
}

//Function xrf_get_lname
//Use: Gets last name from a user id
function xrf_get_lname($xrf_db, $uid)
{
$query="SELECT lname FROM g_users WHERE id='$uid'";
$result=mysqli_query($xrf_db, $query);
$lname=xrf_mysql_result($result,0,"lname");
return ($lname);
}

//Function xrf_get_profilepic
//Use: Gets profile picture URL from a user id
function xrf_get_profilepic($xrf_db, $uid)
{
$query="SELECT profilepic FROM g_users WHERE id='$uid'";
$result=mysqli_query($xrf_db, $query);
$profilepic=xrf_mysql_result($result,0,"profilepic");
return ($profilepic);
}

//Function xrf_get_username
//Use: Gets username from a user id
function xrf_get_username($xrf_db, $uid)
{
$query="SELECT username FROM g_users WHERE id='$uid'";
$result=mysqli_query($xrf_db, $query);
$username=xrf_mysql_result($result,0,"username");
return ($username);
}

?>