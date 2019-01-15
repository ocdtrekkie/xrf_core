<?php
require_once("includes/global.php");
require_once("includes/header.php");

session_destroy();

if(isset($_COOKIE['cookid']) && isset($_COOKIE['cookemail']) && isset($_COOKIE['cookpass'])){
   setcookie("cookemail", "", time()-60*60*24*400, "/", $xrf_dbcookie);
   setcookie("cookpass", "", time()-60*60*24*400, "/", $xrf_dbcookie);
   setcookie("cookid", "", time()-60*60*24*400, "/", $xrf_dbcookie);
}

xrf_go_redir("index.php","Logout successful.",2);

require_once("includes/footer.php");
?>