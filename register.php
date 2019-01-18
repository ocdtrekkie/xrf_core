<?php
require_once("includes/global.php");
require_once("includes/header.php");

?>
<script>
function validate(form) {
fail  = validateEmail(form.remail.value)
fail += validateEmail2(form.remail.value, form.remail2.value)
fail += validateUsername(form.rusername.value)
// fail += validateLname(form.rlname.value)
// fail += validateFname(form.rfname.value)
if (fail == "") return true
else { alert(fail); return false }
}
</script><script src="includes/functions_validate.js"></script>
<?php

if ($xrf_reg_enabled == 1)
{
	if ($do == "register")
	{
		$remail = mysqli_real_escape_string($xrf_db, $_POST['remail']);
		$remail2 = mysqli_real_escape_string($xrf_db, $_POST['remail2']);
		$rusername = mysqli_real_escape_string($xrf_db, $_POST['rusername']);
		$rlname = mysqli_real_escape_string($xrf_db, $_POST['rlname']);
		$rfname = mysqli_real_escape_string($xrf_db, $_POST['rfname']);
		$rcompany = mysqli_real_escape_string($xrf_db, $_POST['rcompany']);
		$rmonth = mysqli_real_escape_string($xrf_db, $_POST['rmonth']);
		$rday = mysqli_real_escape_string($xrf_db, $_POST['rday']);
		$ryear = mysqli_real_escape_string($xrf_db, $_POST['ryear']);
		$rbirthdate = $ryear . "-" . $rmonth . "-" . $rday;
		$rgender = mysqli_real_escape_string($xrf_db, $_POST['rgender']);
		$raddress = mysqli_real_escape_string($xrf_db, $_POST['raddress']);
		$rcity = mysqli_real_escape_string($xrf_db, $_POST['rcity']);
		$rstate = mysqli_real_escape_string($xrf_db, $_POST['rstate']);
		$rpostal = mysqli_real_escape_string($xrf_db, $_POST['rpostal']);
		$rcountry = mysqli_real_escape_string($xrf_db, $_POST['rcountry']);
		$rhphone = mysqli_real_escape_string($xrf_db, $_POST['rhphone']);
		$rcphone = mysqli_real_escape_string($xrf_db, $_POST['rcphone']);
		$rwphone = mysqli_real_escape_string($xrf_db, $_POST['rwphone']);
		if(isset($_POST['rgetmail']))
		{
		$rgetmail = 1;
		}
		else
		{
		$rgetmail = 0;
		}
		$rpass = xrf_generate_password(12);
		$rpassword = xrf_encrypt_password($rpass, $passwordsalt);

		if ($remail != $remail2)
		$regfail = 1;
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
			mysqli_query($xrf_db, "INSERT INTO g_users (email, username, password, lname, fname, company, birthdate, gender, address, city, state, postal, country, hphone, cphone, wphone, datereg, getmail) VALUES('$remail','$rusername', '$rpassword','$rlname','$rfname','$rcompany','$rbirthdate','$rgender','$raddress','$rcity','$rstate','$rpostal','$rcountry','$rhphone','$rcphone','$rwphone',now(),'$rgetmail')") or die(mysqli_error($xrf_db));

			$from = "From: $xrf_admin_email \r\n";
			mail($remail, "$xrf_site_name Registration Information", "Your account, $rusername is registered and awaiting activation.  Your password is $rpass.  Go to $xrf_site_url to log in.", $from);

			$from = "From: $xrf_admin_email \r\n";
			mail($xrf_admin_email, "$xrf_site_name Registration Alert", "A new account, $rusername has been registered.", $from);

			xrf_go_redir("login.php","Registered.  Your temporary password has been emailed to you.",2);
		}
		else
		{
			echo "Registration failed.  Please ensure you are using the proper registration form.";
		}
	}
	else
	{
		echo "<form action=\"register.php?do=register\" method=\"POST\" onSubmit=\"return validate(this)\">
		<table style=\"border:0px\" cellspacing=\"0\" width=\"500\">
		<tr><tdcolspan=\"2\" class=\"sp-header\">* Required Fields</td></tr>
		<tr><td><b>Email*:</b></td><td><input type=\"text\" name=\"remail\" maxlength=\"128\"></td></tr>
		<tr><td><b>Confirm Email*:</b></td><td><input type=\"text\" name=\"remail2\" maxlength=\"128\"></td></tr>
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
		</table><p>
		<input type=\"submit\" value=\"Register\"></form>";
	}
}
else
{
	echo "Sorry, registration is currently disabled.";
}

require_once("includes/footer.php");
?>