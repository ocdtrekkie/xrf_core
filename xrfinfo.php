<?php
require_once("includes/global.php");
require_once("includes/header.php");

echo "<p><b>begin XRFinfo</b><br>
SITEname: $xrf_site_name<br>
SITEurl: $xrf_site_url<br>
SITEcontact: $xrf_admin_email<br>
XRFserver: $xrf_server_name<br>
XRFversion: $xrf_auth_version_db<br>
XRFlicense: $xrf_site_key<br>
<b>end XRFinfo</b></p>";

require_once("includes/footer.php"); ?>