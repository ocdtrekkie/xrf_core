<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

?>
<script>
function validate(form) {
fail  = validateEmail(form.remail.value)
fail += validateUsername(form.rusername.value)
// fail += validateLname(form.rlname.value)
// fail += validateFname(form.rfname.value)
if (fail == "") return true
else { alert(fail); return false }
}
</script><script src="includes/functions_validate.js"></script>
<?php

if ($do == "register")
{
$remail = xrf_mysql_sanitize_string($_POST['remail']);
$rpassword = xrf_mysql_sanitize_string($_POST['rpassword']);
$rusername = xrf_mysql_sanitize_string($_POST['rusername']);
$rlname = xrf_mysql_sanitize_string($_POST['rlname']);
$rfname = xrf_mysql_sanitize_string($_POST['rfname']);
$rcompany = xrf_mysql_sanitize_string($_POST['rcompany']);
$rmonth = $_POST['rmonth'];
$rday = $_POST['rday'];
$ryear = $_POST['ryear'];
$rbirthdate = $ryear . "-" . $rmonth . "-" . $rday;
$rgender = $_POST['rgender'];
$raddress = xrf_mysql_sanitize_string($_POST['raddress']);
$rcity = xrf_mysql_sanitize_string($_POST['rcity']);
$rstate = xrf_mysql_sanitize_string($_POST['rstate']);
$rpostal = xrf_mysql_sanitize_string($_POST['rpostal']);
$rcountry = xrf_mysql_sanitize_string($_POST['rcountry']);
$rhphone = xrf_mysql_sanitize_string($_POST['rhphone']);
$rcphone = xrf_mysql_sanitize_string($_POST['rcphone']);
$rwphone = xrf_mysql_sanitize_string($_POST['rwphone']);
if(isset($_POST['rgetmail']))
{
$rgetmail = 1;
}
else
{
$rgetmail = 0;
}
$rulevel = $_POST['rulevel'];
$ruclass = xrf_mysql_sanitize_string($_POST['ruclass']);
$rpassword = xrf_encrypt_password($rpassword, $xrf_passwordsalt);

if ($remail == "")
$regfail = 1;
else if (!((strpos($remail, ".") > 0) && (strpos($remail, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $remail))
$regfail = 1;
if ($rusername == "")
$regfail = 1;
else if (strlen($rusername) < 4)
$regfail = 1;
else if (preg_match("/[^a-zA-Z0-9_-]/", $rusername))
$regfail = 1;

if ($regfail != 1)
{
mysql_query("INSERT INTO g_users (email, username, password, lname, fname, company, birthdate, gender, address, city, state, postal, country, hphone, cphone, wphone, datereg, uclass, ulevel, getmail) VALUES('$remail','$rusername', '$rpassword','$rlname','$rfname','$rcompany','$rbirthdate','$rgender','$raddress','$rcity','$rstate','$rpostal','$rcountry','$rhphone','$rcphone','$rwphone',now(), '$ruclass', '$rulevel', '$rgetmail')") or die(mysql_error());

xrf_go_redir("acp.php","User created.",2);
}
else
{
echo "User creation failed.  Please ensure you are using the proper form.";
}
}
else
{
echo "<form action=\"acp_add_user.php?do=register\" method=\"POST\" onSubmit=\"return validate(this)\">
<table style=\"border:0px\" cellspacing=\"0\" width=\"500\">
<tr><tdcolspan=\"2\" class=\"sp-header\">* Required Fields</td></tr>
<tr><td><b>Email*:</b></td><td><input type=\"text\" name=\"remail\" maxlength=\"128\"></td></tr>
<tr><td><b>Password*:</b></td><td><input type=\"password\" name=\"rpassword\" maxlength=\"128\"></td></tr>
<tr><td><b>Username*:</b></td><td><input type=\"text\" name=\"rusername\" maxlength=\"64\"></td></tr>
<tr><td><b>Last Name:</b></td><td><input type=\"text\" name=\"rlname\" maxlength=\"128\"></td></tr>
<tr><td><b>First Name:</b></td><td><input type=\"text\" name=\"rfname\" maxlength=\"128\"></td></tr>
<tr><td><b>Company:</b></td><td><input type=\"text\" name=\"rcompany\" maxlength=\"128\"></td></tr>
<tr><td><b>Birthdate*:</b></td><td><select name=\"rmonth\"><option value=\"00\">Month</option><option value=\"01\">January</option><option value=\"02\">February</option><option value=\"03\">March</option><option value=\"04\">April</option><option value=\"05\">May</option> <option value=\"06\">June</option><option value=\"07\">July</option><option value=\"08\">August</option><option value=\"09\">September</option><option value=\"10\">October</option><option value=\"11\">November</option><option value=\"12\">December</option></select> <select name=\"rday\"><option value=\"00\">Day</option><option value=\"01\">1st</option><option value=\"02\">2nd</option><option value=\"03\">3rd</option><option value=\"04\">4th</option><option value=\"05\">5th</option><option value=\"06\">6th</option><option value=\"07\">7th</option><option value=\"08\">8th</option><option value=\"09\">9th</option><option value=\"10\">10th</option><option value=\"11\">11th</option><option value=\"12\">12th</option><option value=\"13\">13th</option><option value=\"14\">14th</option><option value=\"15\">15th</option><option value=\"16\">16th</option><option value=\"17\">17th</option><option value=\"18\">18th</option><option value=\"19\">19th</option><option value=\"20\">20th</option><option value=\"21\">21st</option><option value=\"22\">22nd</option><option value=\"23\">23rd</option><option value=\"24\">24th</option><option value=\"25\">25th</option><option value=\"26\">26th</option><option value=\"27\">27th</option><option value=\"28\">28th</option><option value=\"29\">29th</option><option value=\"30\">30th</option><option value=\"31\">31st</option></select> <input type=\"text\" name=\"ryear\" value=\"0000\" maxlength=\"4\" size=\"2\"></td></tr>
<tr><td><b>Gender*:</b></td><td><select name=\"rgender\"><option value=\"m\">Male</option><option value=\"f\">Female</option></select></td></tr>
<tr><td><b>Address:</b></td><td><input type=\"text\" name=\"raddress\" size=\"30\" maxlength=\"128\"></tr>
<tr><td><b>City, State, Postal:</b></td><td><input type=\"text\" name=\"rcity\" size=\"15\" maxlength=\"128\"><input type=\"text\" name=\"rstate\" size=\"5\" maxlength=\"64\"><input type=\"text\" name=\"rpostal\" size=\"10\" maxlength=\"16\"></tr>
<tr><td><b>Country:</b></td><td><input type=\"text\" name=\"rcountry\" maxlength=\"128\"></tr>
<tr><td><b>Home Phone:</b></td><td><input type=\"text\" name=\"rhphone\" maxlength=\"32\"></tr>
<tr><td><b>Cell Phone:</b></td><td><input type=\"text\" name=\"rcphone\" maxlength=\"32\"></tr>
<tr><td><b>Work Phone:</b></td><td><input type=\"text\" name=\"rwphone\" maxlength=\"32\"></tr>
<tr><td></td><td><input type=\"checkbox\" name=\"rgetmail\">Receive Mail</td></tr>
<tr><td><b>User Level:</b></td><td><select name=\"rulevel\"><option value=\"0\">0</option><option value=\"1\">1</option><option value=\"2\" selected=\"selected\">2</option><option value=\"3\">3</option><option value=\"4\">4</option></select></td></tr>
<tr><td><b>User Class:</b></td><td><input type=\"text\" name=\"ruclass\" size=\"5\"></td></tr>
</table><p>
<input type=\"submit\" value=\"Register\"></form>";
}

}
require_once("includes/footer.php");
?>