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
$query="SELECT * FROM g_users WHERE id='$id'";
$result=mysql_query($query);
$email=mysql_result($result,$qq,"email");
$username=mysql_result($result,$qq,"username");

$from = "From: $xrf_admin_email \r\n";
mail($email, "$xrf_site_name Ban", "Your account, $username, has been banned by an administrator.", $from);

$query="UPDATE g_users SET ulevel='0' WHERE id='$id'";
mysql_query($query);
xrf_go_redir("acp_view_user.php?id=$id","User banned.",2);

}
require_once("includes/footer.php");
?>