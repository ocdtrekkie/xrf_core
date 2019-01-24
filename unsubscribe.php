<?php
require_once("includes/global.php");
require_once("includes/header.php");
$email = $_GET['email'];
$unsubmail = mysqli_real_escape_string($xrf_db, $email);

$query = "UPDATE g_users SET getmail = '0' WHERE email = '$unsubmail'";
mysqli_query($xrf_db, $query);
xrf_go_redir("index.php","$unsubmail has been unsubscribed.",4);

require_once("includes/footer.php");
?>