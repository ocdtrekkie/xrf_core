<?php
require_once("includes/global_req_login.php");
require_once("includes/header.php");

if ($xrf_myulevel < 3)
{
xrf_go_redir("index.php","Invalid permissions.",2);
}
else
{

if ($do == "change")
{
	$new_site_name = xrf_mysql_sanitize_string($_POST['site_name']);
	$new_site_url = xrf_mysql_sanitize_string($_POST['site_url']);
	$new_site_key = xrf_mysql_sanitize_string($_POST['site_key']);
	$new_server_name = xrf_mysql_sanitize_string($_POST['server_name']);
	$new_admin_email = xrf_mysql_sanitize_string($_POST['admin_email']);
	$new_reg_enabled = $_POST['reg_enabled'];
	$new_login_enabled = $_POST['login_enabled'];
	$new_vlog_enabled = $_POST['vlog_enabled'];
	$new_reg_enabled = (int)$new_reg_enabled;
	$new_login_enabled = (int)$new_login_enabled;
	$new_vlog_enabled = (int)$new_vlog_enabled;
	
	if ($new_site_name != $xrf_site_name)
	{
		$query = "UPDATE g_config SET site_name = '$new_site_name'";
		mysql_query($query);
		$xrf_site_name = $new_site_name;
		if ($xrf_vlog_enabled == 1)
		{
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Changed site name to $new_site_name.')";
			mysql_query($query);
		}
	}
	
	if ($new_site_url != $xrf_site_url)
	{
		$query = "UPDATE g_config SET site_url = '$new_site_url'";
		mysql_query($query);
		$xrf_site_url = $new_site_url;
		if ($xrf_vlog_enabled == 1)
		{
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Changed site URL to $new_site_url.')";
			mysql_query($query);
		}
	}
	
	if ($new_site_key != $xrf_site_key)
	{
		$query = "UPDATE g_config SET site_key = '$new_site_key'";
		mysql_query($query);
		$xrf_site_key = $new_site_key;
		if ($xrf_vlog_enabled == 1)
		{
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Changed site license key.')";
			mysql_query($query);
		}
	}
	
	if ($new_server_name != $xrf_server_name)
	{
		$query = "UPDATE g_config SET server_name = '$new_server_name'";
		mysql_query($query);
		$xrf_server_name = $new_server_name;
		if ($xrf_vlog_enabled == 1)
		{
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Changed server name.')";
			mysql_query($query);
		}
	}
	
	if ($new_admin_email != $xrf_admin_email)
	{
		$query = "UPDATE g_config SET admin_email = '$new_admin_email'";
		mysql_query($query);
		$xrf_admin_email = $new_admin_email;
		if ($xrf_vlog_enabled == 1)
		{
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'Changed admin email to $new_admin_email.')";
			mysql_query($query);
		}
	}
	
	if ($new_reg_enabled != $xrf_reg_enabled)
	{
		$query = "UPDATE g_config SET reg_enabled = '$new_reg_enabled'";
		mysql_query($query);
		$xrf_reg_enabled = $new_reg_enabled;
		if ($xrf_vlog_enabled == 1)
		{
			if ($new_reg_enabled == 1)
				$regch = "Enabled";
			else
				$regch = "Disabled";
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'$regch user registration.')";
			mysql_query($query);
		}
	}
	
	if ($new_login_enabled != $xrf_login_enabled)
	{
		$query = "UPDATE g_config SET login_enabled = '$new_login_enabled'";
		mysql_query($query);
		$xrf_login_enabled = $new_login_enabled;
		if ($xrf_vlog_enabled == 1)
		{
			if ($new_login_enabled == 1)
				$loginch = "Enabled";
			else
				$loginch = "Disabled";
			$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'$loginch user login.')";
			mysql_query($query);
		}
	}
	
	if ($new_vlog_enabled != $xrf_vlog_enabled)
	{
		$query = "UPDATE g_config SET vlog_enabled = '$new_vlog_enabled'";
		mysql_query($query);
		$xrf_vlog_enabled = $new_vlog_enabled;
		if ($new_vlog_enabled == 1)
			$vlogch = "Enabled";
		else
			$vlogch = "Disabled";
		$query="INSERT INTO g_log (uid, date, event) VALUES ('$xrf_myid',NOW(),'$vlogch verbose logging.')";
		mysql_query($query);
	}
	
	xrf_go_redir("acp.php","Settings changed.",2); 
}
else
{
	if ($xrf_reg_enabled == 1)
		$regy = " checked";
	else
		$regn = " checked";
	if ($xrf_login_enabled == 1)
		$logy = " checked";
	else
		$logn = " checked";
	if ($xrf_vlog_enabled == 1)
		$vlogy = " checked";
	else
		$vlogn = " checked";
	
	echo "
	<p><b>General Configuration</b></p>
	<form action=\"acp_general.php?do=change\" method=\"POST\">
	<table>
	<tr><td>Site Name:</td><td><input type=\"text\" name=\"site_name\" value=\"$xrf_site_name\" size=\"30\"></td></tr>
	<tr><td>Site URL:</td><td><input type=\"text\" name=\"site_url\" value=\"$xrf_site_url\" size=\"30\"></td></tr>
	<tr><td>Site Key:</td><td><input type=\"text\" name=\"site_key\" value=\"$xrf_site_key\" size=\"30\"></td></tr>
	<tr><td>Server Name:</td><td><input type=\"text\" name=\"server_name\" value=\"$xrf_server_name\" size=\"30\"></td></tr>
	<tr><td>Admin Email:</td><td><input type=\"text\" name=\"admin_email\" value=\"$xrf_admin_email\" size=\"30\"></td></tr>
	<tr><td>Registration Enabled:</td><td><input type=\"radio\" name=\"reg_enabled\" value=1$regy> Yes <input type=\"radio\" name=\"reg_enabled\" value=0$regn> No</td></td>
	<tr><td>Login Enabled:</td><td><input type=\"radio\" name=\"login_enabled\" value=1$logy> Yes <input type=\"radio\" name=\"login_enabled\" value=0$logn> No</td></td>
	<tr><td>Verbose Logging:</td><td><input type=\"radio\" name=\"vlog_enabled\" value=1$vlogy> On <input type=\"radio\" name=\"vlog_enabled\" value=0$vlogn> Off</td></td>
	</table>
	<input type=\"submit\" value=\"Submit!\">
	</form>";
}

}

require_once("includes/footer.php");
?>