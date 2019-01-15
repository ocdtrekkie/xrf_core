<?php
require_once("includes/global.php");
require_once("includes/header.php");
$unsubmail = xrf_mysql_sanitize_string($email);

$query = "UPDATE g_users SET getmail = '0' WHERE email = '$unsubmail'";
mysql_query($query);
echo "$unsubmail has been unsubscribed.";

require_once("includes/footer.php");
?>