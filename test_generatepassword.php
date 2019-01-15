<?php
require_once("includes/global.php");
require_once("includes/functions_auth.php");

$new = generate_password($length);
echo $new;

require_once("includes/footer.php");
?>