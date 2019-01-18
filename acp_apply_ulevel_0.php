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
$query="SELECT * FROM g_users WHERE id='$id'";
$result=mysqli_query($xrf_db, $query);
$email=xrf_mysql_result($result,0,"email");
$username=xrf_mysql_result($result,0,"username");

$from = "From: $xrf_admin_email \r\n";
mail($email, "$xrf_site_name Ban", "Your account, $username, has been banned by an administrator.", $from);

$query="UPDATE g_users SET ulevel='0' WHERE id='$id'";
mysqli_query($xrf_db, $query);
xrf_go_redir("acp_view_user.php?id=$id","User banned.",2);

}
require_once("includes/footer.php");
?>