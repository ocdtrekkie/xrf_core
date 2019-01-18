<?php
require_once("includes/global.php");
require_once("includes/header.php");
$unsubmail = mysqli_real_escape_string($xrf_db, $email);

$query = "UPDATE g_users SET getmail = '0' WHERE email = '$unsubmail'";
mysqli_query($xrf_db, $query);
echo "$unsubmail has been unsubscribed.";

require_once("includes/footer.php");
?>