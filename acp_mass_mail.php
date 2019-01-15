<?php
require_once("includes/global_req_login.php");
require_once("includes/functions_bbc.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

if ($do == "send")
{
$scope = xrf_mysql_sanitize_string($_POST['scope']);
$subject = $_POST['subject'];
$messagebody = $_POST['messagebody'];
if(isset($_POST['confirm']))
{
$confirm = 1;
}
else
{
$confirm = 0;
}
if ($confirm == 1)
{

if ($scope == "me")
$queryscope = "id = '$xrf_myid'";
if ($scope == "opt")
$queryscope = "getmail = '1'";

$headers  = "From: $xrf_site_name <$xrf_admin_email>\r\n";
$headers .= "Reply-To: $xrf_admin_email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html\r\n";
$messagebody=xrf_bbcode_format($messagebody);

$query="SELECT * FROM g_users WHERE " . $queryscope;
$result=mysql_query($query);
$num=mysql_num_rows($result);

$qq=0;
while ($qq < $num) {

$toid=mysql_result($result,$qq,"id");
$toemail=mysql_result($result,$qq,"email");
$unsub="<p>You received this email because you opted-in to receive mail from our site. You may unsubscribe at any time, by clicking <a href=\"$xrf_site_url/unsubscribe.php?email=$toemail\">here</a>.</p>";
$message=$messagebody . $unsub;

mail($toemail, $subject, $message, $headers);
echo "$toemail ($toid) emailed.<br>";

sleep(6);
$qq++;
}

echo "Batch operation complete.";

}
}
else
{
	echo "
	<form action=\"acp_mass_mail.php?do=send\" method=\"POST\">
	<table>
	<tr><td>Scope:</td><td><select name=\"scope\">
	<option value=\"me\">Just me</option>
	<option value=\"opt\">Opted in</option>
	</select></td></tr>
	<tr><td>Subject:</td><td><input type=\"text\" name=\"subject\" size=\"30\"></td></tr>
	<tr><td>Message Text:</td><td><textarea name=\"messagebody\" rows=\"10\" cols=\"30\"></textarea></td></tr>
	<tr><td></td><td><input type=\"checkbox\" name=\"confirm\"> Confirm intent to send.<br><input type=\"submit\" value=\"Send!\"></td></tr>
	</table>
	</form>";
}

}

require_once("includes/footer.php");
?>