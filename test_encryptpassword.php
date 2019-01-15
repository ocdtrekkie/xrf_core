<?php
require_once("includes/global.php");
require_once("includes/functions_auth.php");

$new = encrypt_password($encrypt, $passwordsalt);
echo $new;

require_once("includes/footer.php");
?>